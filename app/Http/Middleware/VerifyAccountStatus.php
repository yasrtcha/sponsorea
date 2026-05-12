<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyAccountStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip check untuk admin dan unauthenticated users
        if (!auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();
        
        // Admin tidak perlu verifikasi
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Jika user statusnya rejected, langsung logout dan redirect ke login dengan error
        if ($user->verification_status === 'rejected') {
            auth()->logout();
            return redirect()->route('login')->withErrors(['email' => 'Akun Anda telah ditolak oleh admin. Silakan hubungi support untuk informasi lebih lanjut.']);
        }

        // Jika user statusnya pending dan sudah complete profile, arahkan ke waiting verification
        // Tapi ijinkan akses ke profile.waiting_verification, logout, dan profile.edit
        if ($user->verification_status === 'pending' && $user->hasCompletedProfile()) {
            $routeAllowed = ['profile.waiting_verification', 'logout', 'profile.edit'];
            if (!$request->routeIs($routeAllowed)) {
                return redirect()->route('profile.waiting_verification');
            }
        }

        return $next($request);
    }
}
