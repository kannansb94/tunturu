<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureOtpVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && !Auth::user()->hasVerifiedEmail()) {
            // Allow access to logout and otp routes
            if ($request->routeIs('otp.*') || $request->routeIs('logout')) {
                return $next($request);
            }

            return redirect()->route('otp.notice');
        }

        return $next($request);
    }
}
