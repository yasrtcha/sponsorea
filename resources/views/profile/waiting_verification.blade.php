@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-50 flex items-center justify-center px-6">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-10 text-center space-y-6">
            
            @if($rejectionReason)
                <!-- Rejection State -->
                <div class="w-16 h-16 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                
                <h2 class="text-2xl font-bold text-slate-900">Verifikasi Ditolak</h2>
                <p class="text-slate-600">Akun Anda telah ditolak oleh admin. Berikut adalah alasannya:</p>
                
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-left">
                    <p class="text-red-700 text-sm">{{ $rejectionReason }}</p>
                </div>
                
                <p class="text-slate-500 text-sm">Silakan hubungi support untuk informasi lebih lanjut atau coba daftar ulang dengan data yang benar.</p>
                
                <div class="flex gap-3">
                    <a href="{{ route('profile.edit') }}" class="flex-1 px-4 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                        Edit Profil
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2.5 bg-slate-200 text-slate-700 font-semibold rounded-lg hover:bg-slate-300 transition-colors">
                            Logout
                        </button>
                    </form>
                </div>

            @else
                <!-- Pending Verification State -->
                <div class="w-16 h-16 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center mx-auto animate-pulse">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <h2 class="text-2xl font-bold text-slate-900">Menunggu Verifikasi</h2>
                
                <p class="text-slate-600">Profil Anda telah berhasil dilengkapi. Admin kami sedang meninjau data akun Anda.</p>
                
                <div class="bg-teal-50 border border-teal-200 rounded-lg p-4">
                    <p class="text-teal-700 text-sm font-medium">
                        ⏱️ Biasanya proses verifikasi memakan waktu 1-2 hari kerja
                    </p>
                </div>

                <p class="text-slate-500 text-sm">Kami akan mengirimkan notifikasi ke email Anda setelah verifikasi selesai. Silakan tunggu atau kembali login nanti untuk melihat status terbaru.</p>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                        Logout
                    </button>
                </form>
            @endif

        </div>
    </div>
</div>
@endsection
