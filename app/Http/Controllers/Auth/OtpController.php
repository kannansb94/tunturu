<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OTPVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    public function show()
    {
        return view('auth.verify-otp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $user = Auth::user();
        $cachedOtp = Cache::get('email_otp_' . $user->id);

        if (!$cachedOtp || $cachedOtp !== $request->otp) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        // OTP is valid
        $user->forceFill([
            'email_verified_at' => now(),
        ])->save();

        Cache::forget('email_otp_' . $user->id);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function resend()
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        try {
            $otp = rand(100000, 999999);
            Cache::put('email_otp_' . $user->id, (string) $otp, now()->addMinutes(10));

            Mail::to($user->email)->send(new OTPVerification($user, $otp));

            return back()->with('status', 'verification-link-sent');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('OTP Resend Error: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to send OTP. Please try again later.']);
        }
    }
}
