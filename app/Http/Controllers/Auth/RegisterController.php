<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show()
    {
        // Jika user sudah authenticated, check profile completion status
        if (auth()->check()) {
            $user = auth()->user();
            
            // Admin tidak perlu complete profile, langsung ke dashboard
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            
            // Jika belum complete profile (untuk event/company), redirect ke profile.complete
            if (!$user->hasCompletedProfile()) {
                return redirect()->route('profile.complete');
            }
            
            // Jika sudah complete profile, redirect ke dashboard mereka
            if ($user->role === 'event') return redirect()->route('event.dashboard');
            if ($user->role === 'company') return redirect()->route('company.dashboard');
            return redirect()->route('explore.index');
        }
        
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:event,company',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('login')
            ->with('success', 'Account created successfully.');
    }
}