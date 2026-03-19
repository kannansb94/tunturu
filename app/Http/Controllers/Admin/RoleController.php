<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('library.admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Define all available permissions in the system
        $availablePermissions = [
            'manage_users' => 'Manage Users',
            'manage_books' => 'Manage Books',
            'manage_categories' => 'Manage Categories',
            'manage_settings' => 'Manage Settings',
            'manage_rentals' => 'Manage Rentals',
            'manage_sales' => 'Manage Sales',
            'manage_donations' => 'Manage Donations',
            'view_reports' => 'View Reports',
            'browse_library' => 'Browse Library',
            'rent_books' => 'Rent Books',
            'buy_books' => 'Buy Books',
        ];

        return view('library.admin.roles.create', compact('availablePermissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles'],
            'permissions' => ['array'],
        ]);

        Role::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'permissions' => $request->permissions ?? [],
        ]);

        return redirect()->route('library.admin.settings.index')->with('success', 'Role created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $availablePermissions = [
            'manage_users' => 'Manage Users',
            'manage_books' => 'Manage Books',
            'manage_categories' => 'Manage Categories',
            'manage_settings' => 'Manage Settings',
            'manage_rentals' => 'Manage Rentals',
            'manage_sales' => 'Manage Sales',
            'manage_donations' => 'Manage Donations',
            'view_reports' => 'View Reports',
            'browse_library' => 'Browse Library',
            'rent_books' => 'Rent Books',
            'buy_books' => 'Buy Books',
        ];

        return view('library.admin.roles.edit', compact('role', 'availablePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        if (in_array($role->slug, ['admin', 'user']) && $role->slug !== \Illuminate\Support\Str::slug($request->name)) {
            return back()->with('error', 'Cannot change name of core roles.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($role->id)],
            'permissions' => ['array'],
        ]);

        $role->update([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'permissions' => $request->permissions ?? [],
        ]);

        return redirect()->route('library.admin.settings.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if (in_array($role->slug, ['admin', 'user'])) {
            return back()->with('error', 'Cannot delete core roles.');
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', 'Cannot delete role assigned to users.');
        }

        $role->delete();

        return redirect()->route('library.admin.settings.index')->with('success', 'Role deleted successfully.');
    }
}
