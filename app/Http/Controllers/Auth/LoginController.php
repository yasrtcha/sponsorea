<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        // Redirect berdasarkan role dan profile completion status
        $user = Auth::user();
        
        // Jika user status rejected, logout langsung
        if ($user->verification_status === 'rejected') {
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Akun Anda telah ditolak oleh admin.']);
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'event' || $user->role === 'company') {
            // Jika sudah lengkapi profil
            if ($user->hasCompletedProfile()) {
                // Jika pending verification, redirect ke waiting page
                if ($user->verification_status === 'pending') {
                    return redirect()->route('profile.waiting_verification');
                }
                // Jika verified, redirect ke explore
                return redirect()->route('explore.index');
            }
            // Jika belum lengkapi profil, arahkan ke form complete
            return redirect()->route('profile.complete');
        } else {
            return redirect()->route('explore.index');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        // Menghapus data session dan mengamankan token CSRF (Best Practice Laravel)
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan ke halaman login membawa pesan sukses (bukan error)
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }
}