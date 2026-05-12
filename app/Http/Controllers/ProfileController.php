<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;

class ProfileController extends Controller
{
    // 1. Menampilkan form lengkapi profil
    public function create()
    {
        $user = auth()->user();
        
        // Admin tidak perlu complete profile
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Jika user ternyata sudah punya profil, jangan biarkan mereka isi form lagi.
        // Throw 403 exception sehingga browser back tidak bisa akses
        if ($user->hasCompletedProfile()) {
            abort(403, 'Profil Anda sudah dilengkapi. Tidak bisa mengakses halaman ini lagi.');
        }

        return view('profile.complete');
    }

    // 2. Menyimpan data form ke database
    public function store(Request $request)
    {
        $user = auth()->user();

        // Validasi isian form
        $request->validate([
            'phone_number' => 'required|numeric',
            'address' => 'required|string',
            'description' => 'required|string',
        ]);

        // Simpan ke database menggunakan relasi yang sudah kita buat
        $profile = Profile::create([
            'user_id' => $user->id,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'description' => $request->description,
            'instagram' => $request->instagram,
            'tiktok' => $request->tiktok,
            // Simpan data spesifik sesuai role yang sedang login
            'organization_name' => $user->isEvent() ? $request->organization_name : null,
            'company_name' => $user->isCompany() ? $request->company_name : null,
            'company_sector' => $user->isCompany() ? $request->company_sector : null,
        ]);

        // Tandai profile sebagai selesai
        $profile->markAsCompleted();

        // Set verification_status to pending untuk non-admin users yang baru selesai profile
        if ($user->role !== 'admin') {
            $user->update(['verification_status' => 'pending']);
            // Arahkan ke halaman menunggu verifikasi
            return redirect()->route('profile.waiting_verification')->with('success', 'Profil berhasil dilengkapi! Menunggu verifikasi dari admin.');
        }

        // Admin langsung ke explore
        return redirect()->route('explore.index')->with('success', 'Profil berhasil dilengkapi!');
    }

    // app/Http/Controllers/ProfileController.php

    public function edit()
    {
        $user = auth()->user();
        // Pastikan user sudah punya profil sebelum mengedit
        if (!$user->hasCompletedProfile()) {
            return redirect()->route('profile.complete');
        }
    
        $profile = $user->profile;
        return view('profile.edit', compact('profile', 'user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $profile = $user->profile;

        $request->validate([
            'phone_number' => 'required|numeric',
            'address' => 'required|string',
            'description' => 'required|string',
            'organization_name' => 'nullable|string',
            'company_name' => 'nullable|string',
            'company_sector' => 'nullable|string',
        ]);

        $profile->update([
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'description' => $request->description,
            'instagram' => $request->instagram,
            'tiktok' => $request->tiktok,
            'organization_name' => $user->isEvent() ? $request->organization_name : null,
            'company_name' => $user->isCompany() ? $request->company_name : null,
            'company_sector' => $user->isCompany() ? $request->company_sector : null,
        ]);

        // Tandai profile sebagai selesai jika belum
        $profile->markAsCompleted();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    // Menampilkan halaman menunggu verifikasi
    public function waitingVerification()
    {
        $user = auth()->user();
        
        // Jika sudah verified, redirect ke dashboard
        if ($user->isVerified()) {
            if ($user->isEvent()) return redirect()->route('event.dashboard');
            if ($user->isCompany()) return redirect()->route('company.dashboard');
        }

        // Jika di-reject, bisa lihat alasan rejection
        $rejectionReason = $user->rejection_reason;

        return view('profile.waiting_verification', compact('rejectionReason'));
    }

    // 4. Menampilkan profil user secara publik
    public function show($userId, Request $request)
    {
        $user = User::with('profile')->findOrFail($userId);
        
        // Jika user belum melengkapi profil
        if (!$user->hasCompletedProfile()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Profil belum lengkap.'], 404);
            }
            return redirect()->route('explore.index')->with('error', 'Profil pengguna belum lengkap.');
        }

        $profile = $user->profile;

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'display_name' => $user->isEvent() ? $profile->organization_name : $profile->company_name,
                    'initial' => substr($user->isEvent() ? ($profile->organization_name ?? $user->name) : ($profile->company_name ?? $user->name), 0, 1),
                    'sector' => $profile->company_sector ?? '-',
                    'phone' => $profile->phone_number,
                    'address' => $profile->address,
                    'description' => $profile->description,
                    'instagram' => $profile->instagram,
                    'tiktok' => $profile->tiktok,
                ]
            ]);
        }

        return view('profile.show', compact('user', 'profile'));
    }
}