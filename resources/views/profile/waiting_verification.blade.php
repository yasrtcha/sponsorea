@extends('layouts.app')
@section('hide_navbar', true)
@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#d9d3ca] p-4 sm:p-6 lg:p-8 font-sans">
    
    <!-- Outer Container -->
    <div class="w-full max-w-md bg-white rounded-[2rem] flex flex-col shadow-xl overflow-hidden relative">

        <!-- Main Content -->
        <div class="p-8 sm:p-12 md:p-14 relative flex flex-col justify-center items-center text-center">

            @if($rejectionReason)
                <!-- Rejection State -->
                <div class="mb-6 w-full">
                    <div class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-extrabold text-[#3d3d3d] mb-2">Verifikasi Ditolak</h2>
                    <p class="text-sm font-medium text-gray-500 leading-relaxed max-w-md mx-auto">
                        Akun Anda telah ditolak oleh admin. Berikut adalah alasannya:
                    </p>
                </div>

                <div class="bg-[#fcf5f5] p-5 rounded-2xl border border-red-100 mb-6 text-left w-full">
                    <p class="text-sm font-bold text-red-600 leading-relaxed">{{ $rejectionReason }}</p>
                </div>

                <p class="text-xs font-medium text-gray-500 mb-8 leading-relaxed w-full">
                    Silakan hubungi support untuk informasi lebih lanjut atau coba perbaiki data Anda melalui menu edit profil.
                </p>

                <div class="flex gap-4 w-full">
                    <a href="{{ route('profile.edit') }}" class="flex-1 flex justify-center items-center bg-[#f07b32] text-white font-bold py-3.5 px-6 rounded-full hover:bg-[#d96a25] transition-all text-sm">
                        Edit Profil
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-[#f5f4f0] text-[#3d3d3d] font-bold py-3.5 px-6 rounded-full hover:bg-[#e8e7e1] transition-all text-sm">
                            Log out
                        </button>
                    </form>
                </div>

            @else
                <!-- Pending Verification State -->
                <div class="mb-6 w-full">
                    <div class="w-16 h-16 rounded-2xl bg-teal-50 flex items-center justify-center mx-auto mb-6 relative">
                        <span class="absolute inset-0 bg-teal-100 rounded-2xl animate-ping opacity-75"></span>
                        <svg class="w-8 h-8 text-teal-500 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-extrabold text-[#3d3d3d] mb-2">Menunggu Verifikasi</h2>
                    <p class="text-sm font-medium text-gray-500 leading-relaxed max-w-md mx-auto">
                        Profil Anda telah berhasil dilengkapi. Admin kami sedang meninjau data akun Anda.
                    </p>
                </div>

                <div class="bg-[#f0f9f8] p-5 rounded-2xl border border-teal-100 mb-6 w-full">
                    <p class="text-sm font-bold text-teal-700">
                        Proses verifikasi memakan waktu 1-2 hari kerja.
                    </p>
                </div>

                <p class="text-xs font-medium text-gray-500 mb-8 leading-relaxed max-w-sm mx-auto">
                    Silakan login kembali nanti untuk mengecek status verifikasi.
                </p>

                <form action="{{ route('logout') }}" method="POST" class="w-full sm:w-2/3 mx-auto">
                    @csrf
                    <button type="submit" class="w-full bg-[#f07b32] text-white font-bold py-3.5 px-6 rounded-full hover:bg-[#d96a25] transition-all text-sm">
                        Log out
                    </button>
                </form>
            @endif

        </div>
    </div>
</div>
@endsection
