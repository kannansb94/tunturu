<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = User::where('role', '!=', 'admin')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });

        // Group users by KYC status and other states
        $pendingUsers = clone $query;
        $pendingUsers = $pendingUsers->whereNull('banned_at')->where('kyc_status', 'pending')->latest()->get();
        
        $approvedUsers = clone $query;
        $approvedUsers = $approvedUsers->whereNull('banned_at')->where('kyc_status', 'approved')->latest()->get();
        
        $rejectedUsers = clone $query;
        $rejectedUsers = $rejectedUsers->whereNull('banned_at')->where('kyc_status', 'rejected')->latest()->get();

        $bannedUsers = clone $query;
        $bannedUsers = $bannedUsers->whereNotNull('banned_at')->latest()->get();

        $deletedUsers = clone $query;
        $deletedUsers = $deletedUsers->onlyTrashed()->latest()->get();

        return view('library.admin.users.index', compact('pendingUsers', 'approvedUsers', 'rejectedUsers', 'bannedUsers', 'deletedUsers', 'search'));
    }

    /**
     * Display the specified user (KYC & History).
     */
    public function show(User $user)
    {
        $user->load(['rentals.book', 'sales.book']);

        return view('library.admin.users.show', compact('user'));
    }

    /**
     * Approve KYC.
     */
    public function approveKYC(User $user)
    {
        $user->update(['kyc_status' => 'approved']);
        return back()->with('success', 'User KYC approved successfully.');
    }

    /**
     * Reject KYC.
     */
    public function rejectKYC(User $user)
    {
        $user->update(['kyc_status' => 'rejected']);

        // Optionally delete files if rejected? Better to keep for record or until re-upload.

        return back()->with('success', 'User KYC rejected.');
    }

    /**
     * Undo KYC Rejection.
     */
    public function undoRejectKYC(User $user)
    {
        if ($user->kyc_status === 'rejected') {
            $user->update(['kyc_status' => 'pending']);
            return back()->with('success', 'User KYC rejection undone. User moved back to pending state.');
        }

        return back()->with('error', 'Only rejected users can be undone.');
    }

    /**
     * Show a specific KYC document for a user.
     */
    public function showDocument(User $user, $type)
    {
        $pathField = match ($type) {
            'aadhaar' => 'aadhaar_path',
            'pan' => 'pan_path',
            'address_proof' => 'address_proof_path',
            default => null,
        };

        if (!$pathField || !$user->$pathField) {
            abort(404, 'Document not found.');
        }

        if (!\Illuminate\Support\Facades\Storage::disk('local')->exists($user->$pathField)) {
             // Fallback for older documents stored on public disk before the security fix
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($user->$pathField)) {
                return response()->file(\Illuminate\Support\Facades\Storage::disk('public')->path($user->$pathField));
            }
            abort(404, 'File not found on server.');
        }

        return response()->file(\Illuminate\Support\Facades\Storage::disk('local')->path($user->$pathField));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('library.admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,slug'],
        ]);

        $role = \App\Models\Role::where('slug', $request->role)->firstOrFail();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $request->role,
            'role_id' => $role->id,
        ]);

        return redirect()->route('library.admin.users.index')->with('success', 'User created successfully.');
    }
    /**
     * Assign a role to a user.
     */
    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_slug' => 'required|exists:roles,slug',
        ]);

        $user = User::findOrFail($request->user_id);
        $role = \App\Models\Role::where('slug', $request->role_slug)->firstOrFail();

        // Prevent demoting last admin - optional but good safety
        if ($user->role === 'admin' && User::where('role', 'admin')->count() === 1 && $role->slug !== 'admin') {
            return back()->withErrors(['error' => 'Cannot change role of the last admin.']);
        }

        $user->update([
            'role' => $role->slug,
            'role_id' => $role->id,
        ]);

        return back()->with('success', "Role for {$user->name} updated to {$role->name}.");
    }

    /**
     * Ban a user.
     */
    public function ban(User $user)
    {
        $user->update(['banned_at' => now()]);
        return back()->with('success', 'User has been banned.');
    }

    /**
     * Unban a user.
     */
    public function unban($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->update(['banned_at' => null]);
        return back()->with('success', 'User has been unbanned.');
    }

    /**
     * Delete (soft delete) a user.
     */
    public function destroy(User $user)
    {
        // Append a timestamp to the email to free it up for new registrations
        // e.g. "user@example.com" -> "user@example.com_deleted_1710000000"
        $user->update([
            'email' => $user->email . '_deleted_' . time()
        ]);

        $user->delete();
        return back()->with('success', 'User has been deleted.');
    }

    /**
     * Restore a deleted user.
     */
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        
        // Extract original email
        if (str_contains($user->email, '_deleted_')) {
            $originalEmail = explode('_deleted_', $user->email)[0];
            
            // Check if another active user already registered with that email
            if (User::where('email', $originalEmail)->exists()) {
                return back()->withErrors(['error' => 'Cannot restore: Another user has registered with this email address.']);
            }
            
            $user->update(['email' => $originalEmail]);
        }

        $user->restore();
        return back()->with('success', 'User has been restored.');
    }
}
