@extends('layouts.dashboard')

@section('title', 'Dashboard Event')
@section('page_title', 'Overview')

@section('content')
<div class="space-y-6">
    <div class="bg-gradient-to-r from-indigo-600 to-blue-500 rounded-2xl p-8 text-white shadow-lg shadow-indigo-200">
        <h2 class="text-3xl font-extrabold mb-2">
            Selamat Datang, {{ auth()->user()->profile->organization_name ?? 'Panitia' }}!
        </h2>
        <p class="text-indigo-100 font-medium max-w-xl">
            Pantau status proposalmu, kelola event, dan temukan sponsor yang tepat untuk menyukseskan acaramu bulan ini.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-500 mb-1">Total Event Aktif</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $totalEvents ?? 0 }}</h3>
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
            <div class="w-14 h-14 rounded-xl bg-teal-50 text-teal-500 flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-500 mb-1">Proposal Disetujui</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $approvedRequests ?? 0 }}</h3>
            </div>
        </div>
    </div>
</div>
@endsection