<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KYCController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'aadhaar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'pan' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'address_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $user = $request->user();

        // Delete old files if re-uploading
        if ($user->aadhaar_path)
            Storage::delete($user->aadhaar_path);
        if ($user->pan_path)
            Storage::delete($user->pan_path);
        if ($user->address_proof_path)
            Storage::delete($user->address_proof_path);

        $aadhaarPath = $request->file('aadhaar')->store('kyc/aadhaar', 'local');
        $panPath = $request->file('pan')->store('kyc/pan', 'local');
        $addressProofPath = $request->file('address_proof')->store('kyc/address_proof', 'local');

        $user->update([
            'aadhaar_path' => $aadhaarPath,
            'pan_path' => $panPath,
            'address_proof_path' => $addressProofPath,
            'kyc_status' => 'pending', // Reset to pending on new upload
        ]);

        return back()->with('status', 'kyc-uploaded');
    }

    public function showDocument($type)
    {
        $user = auth()->user();

        $pathField = match ($type) {
            'aadhaar' => 'aadhaar_path',
            'pan' => 'pan_path',
            'address_proof' => 'address_proof_path',
            default => null,
        };

        if (!$pathField || !$user->$pathField) {
            abort(404, 'Document not found.');
        }

        if (!Storage::disk('local')->exists($user->$pathField)) {
            // Fallback for older documents stored on public disk before the security fix
            if (Storage::disk('public')->exists($user->$pathField)) {
                return response()->file(Storage::disk('public')->path($user->$pathField));
            }
            abort(404, 'File not found on server.');
        }

        return response()->file(Storage::disk('local')->path($user->$pathField));
    }
}
