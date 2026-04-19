@extends('layouts.dashboard')

@section('title', 'Dashboard Sponsor')
@section('page_title', 'Overview')

@section('content')
<div class="space-y-6">
    <div class="bg-gradient-to-r from-indigo-600 to-blue-500 rounded-2xl p-8 text-white shadow-lg shadow-indigo-200">
        <h2 class="text-3xl font-extrabold mb-2">
            Selamat Datang, {{ auth()->user()->profile->company_name ?? 'Sponsor' }}!
        </h2>
        <p class="text-teal-50 font-medium max-w-xl">
            Kelola program CSR-mu, seleksi proposal yang masuk, dan dukung berbagai event kreatif mahasiswa bulan ini.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-500 mb-1">Total Program Aktif</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $totalOffers ?? 0 }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 rounded-xl bg-red-50 text-red-500 flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-500 mb-1">Pengajuan Ditolak</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $rejectedRequests ?? 0 }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-500 mb-1">Kerjasama Disetujui</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $approvedRequests ?? 0 }}</h3>
            </div>
        </div>
    </div>
</div>
@endsection