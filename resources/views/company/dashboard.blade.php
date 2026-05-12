@extends('layouts.dashboard')

@section('title', 'Dashboard Sponsor')
@section('page_title', 'Overview')

@section('content')
<div class="space-y-8">
    <div class="bg-gradient-to-r from-[#f07b32] to-[#f5a06e] rounded-2xl p-8 text-white shadow-lg shadow-[#f07b32]/20">
        <h2 class="text-3xl font-extrabold mb-2">
            Selamat Datang, {{ auth()->user()->profile->company_name ?? 'Sponsor' }}!
        </h2>
        <p class="text-white/80 font-medium max-w-2xl">
            Kelola program CSR-mu, seleksi proposal yang masuk, dan dukung berbagai event kreatif mahasiswa bulan ini.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 rounded-xl bg-[#fcf5f5] text-[#f07b32] flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500 mb-1">Total Program Aktif</p>
                <h3 class="text-3xl font-black text-[#3d3d3d]">{{ $totalOffers ?? 0 }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 rounded-xl bg-red-50 text-red-500 flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500 mb-1">Pengajuan Ditolak</p>
                <h3 class="text-3xl font-black text-[#3d3d3d]">{{ $rejectedRequests ?? 0 }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 rounded-xl bg-teal-50 text-teal-500 flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500 mb-1">Kerjasama Disetujui</p>
                <h3 class="text-3xl font-black text-[#3d3d3d]">{{ $approvedRequests ?? 0 }}</h3>
            </div>
        </div>
    </div>
</div>
@endsection