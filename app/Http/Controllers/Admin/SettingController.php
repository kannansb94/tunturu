<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = \App\Models\Setting::all()->groupBy('group');
        $users = \App\Models\User::where('id', '!=', auth()->id())->get(); // Exclude current user to prevent locking oneself out
        $roles = \App\Models\Role::all();
        return view('library.admin.settings.index', compact('settings', 'users', 'roles'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token', '_method');

        foreach ($data as $key => $value) {
            $setting = \App\Models\Setting::where('key', $key)->first();
            if ($setting) {
                $setting->update(['value' => $value]);
            }
        }

        if ($request->hasFile('app_logo')) {
            $file = $request->file('app_logo');
            $path = $file->store('settings', 'public');
            \App\Models\Setting::where('key', 'app_logo')->update(['value' => $path]);
        }

        if ($request->hasFile('email_logo')) {
            $file = $request->file('email_logo');
            $path = $file->store('settings', 'public');
            \App\Models\Setting::where('key', 'email_logo')->update(['value' => $path]);
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
