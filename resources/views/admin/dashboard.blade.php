@extends('layouts.dashboard')

@section('title', 'Super Admin Dashboard - Sponsorea')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-12 space-y-12">
    
    <div>
        <h2 class="text-3xl font-extrabold text-slate-900">Dashboard Super Admin</h2>
        <p class="text-slate-500 mt-2">Selamat datang, Admin! Berikut adalah rekapitulasi data Sponsorea hari ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-wider">Total User</p>
                <h3 class="text-3xl font-extrabold text-slate-800">{{ $totalUsers }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-wider">Total Event</p>
                <h3 class="text-3xl font-extrabold text-slate-800">{{ $totalEvents }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-wider">Penawaran</p>
                <h3 class="text-3xl font-extrabold text-slate-800">{{ $totalOffers }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-wider">Transaksi</p>
                <h3 class="text-3xl font-extrabold text-slate-800">{{ $totalTransactions }}</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h3 class="font-extrabold text-slate-800">Pengajuan (Event → Perusahaan)</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-600">Disetujui</span>
                    <span class="text-sm font-bold text-teal-700">{{ $eventRequestsAccepted }}</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2">
                    <div class="bg-teal-500 h-2 rounded-full" style="width: {{ $eventRequestsAccepted + $eventRequestsPending + $eventRequestsRejected > 0 ? ($eventRequestsAccepted / ($eventRequestsAccepted + $eventRequestsPending + $eventRequestsRejected)) * 100 : 0 }}%"></div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-600">Menunggu</span>
                    <span class="text-sm font-bold text-amber-700">{{ $eventRequestsPending }}</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2">
                    <div class="bg-amber-500 h-2 rounded-full" style="width: {{ $eventRequestsAccepted + $eventRequestsPending + $eventRequestsRejected > 0 ? ($eventRequestsPending / ($eventRequestsAccepted + $eventRequestsPending + $eventRequestsRejected)) * 100 : 0 }}%"></div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-600">Ditolak</span>
                    <span class="text-sm font-bold text-red-700">{{ $eventRequestsRejected }}</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2">
                    <div class="bg-red-500 h-2 rounded-full" style="width: {{ $eventRequestsAccepted + $eventRequestsPending + $eventRequestsRejected > 0 ? ($eventRequestsRejected / ($eventRequestsAccepted + $eventRequestsPending + $eventRequestsRejected)) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h3 class="font-extrabold text-slate-800">Penawaran (Perusahaan → Event)</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-600">Disetujui</span>
                    <span class="text-sm font-bold text-teal-700">{{ $companyRequestsAccepted }}</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2">
                    <div class="bg-teal-500 h-2 rounded-full" style="width: {{ $companyRequestsAccepted + $companyRequestsPending + $companyRequestsRejected > 0 ? ($companyRequestsAccepted / ($companyRequestsAccepted + $companyRequestsPending + $companyRequestsRejected)) * 100 : 0 }}%"></div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-600">Menunggu</span>
                    <span class="text-sm font-bold text-amber-700">{{ $companyRequestsPending }}</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2">
                    <div class="bg-amber-500 h-2 rounded-full" style="width: {{ $companyRequestsAccepted + $companyRequestsPending + $companyRequestsRejected > 0 ? ($companyRequestsPending / ($companyRequestsAccepted + $companyRequestsPending + $companyRequestsRejected)) * 100 : 0 }}%"></div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-600">Ditolak</span>
                    <span class="text-sm font-bold text-red-700">{{ $companyRequestsRejected }}</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2">
                    <div class="bg-red-500 h-2 rounded-full" style="width: {{ $companyRequestsAccepted + $companyRequestsPending + $companyRequestsRejected > 0 ? ($companyRequestsRejected / ($companyRequestsAccepted + $companyRequestsPending + $companyRequestsRejected)) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="font-extrabold text-slate-800 mb-4">Statistik Kategori Event</h3>
            <canvas id="eventChart" width="400" height="300"></canvas>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="font-extrabold text-slate-800 mb-4">Statistik Jenis Bantuan</h3>
            <canvas id="fundingChart" width="400" height="300"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <h3 class="font-extrabold text-slate-800">Pendaftar Terbaru</h3>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentUsers as $user)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                        <div>
                            <p class="font-bold text-slate-800">{{ $user->name }}</p>
                            @if($user->profile)
                                <p class="text-xs text-slate-600 font-semibold">
                                    {{ $user->profile->organization_name ?? $user->profile->company_name ?? 'N/A' }}
                                </p>
                            @endif
                            <p class="text-xs text-slate-500">{{ $user->email }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $user->role === 'company' ? 'bg-teal-100 text-teal-700' : 'bg-indigo-100 text-indigo-700' }}">
                            {{ $user->role }}
                        </span>
                    </div>
                @empty
                    <div class="px-6 py-4 text-center text-sm text-slate-400">Belum ada pengguna.</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <h3 class="font-extrabold text-slate-800">Aktivitas Pengajuan</h3>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentTransactions as $trx)
                    <div class="px-6 py-4 flex flex-col hover:bg-slate-50 transition-colors gap-2">
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-bold text-slate-500 uppercase">{{ $trx->created_at->diffForHumans() }}</p>
                            @if($trx->status === 'approved')
                                <span class="px-2 py-0.5 bg-teal-100 text-teal-700 text-[10px] font-bold rounded">DEAL</span>
                            @elseif($trx->status === 'rejected')
                                <span class="px-2 py-0.5 bg-red-100 text-red-700 text-[10px] font-bold rounded">TOLAK</span>
                            @else
                                <span class="px-2 py-0.5 bg-amber-100 text-amber-700 text-[10px] font-bold rounded">PENDING</span>
                            @endif
                        </div>
                        <p class="text-sm text-slate-700">
                            <span class="font-bold">{{ $trx->initiator === 'event' ? ($trx->event->user->name ?? 'Mahasiswa') : ($trx->sponsorOffer->user->name ?? 'Company') }}</span> 
                            mengajukan ke 
                            <span class="font-bold">{{ $trx->initiator === 'event' ? ($trx->sponsorOffer->user->name ?? 'Company') : ($trx->event->user->name ?? 'Mahasiswa') }}</span>
                        </p>
                    </div>
                @empty
                    <div class="px-6 py-4 text-center text-sm text-slate-400">Belum ada aktivitas.</div>
                @endforelse
            </div>
        </div>

    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data untuk chart event
    const eventData = @json($eventStats);
    const eventLabels = Object.keys(eventData);
    const eventValues = Object.values(eventData);

    // Data untuk chart funding
    const fundingData = @json($fundingStats);
    const fundingLabels = Object.keys(fundingData);
    const fundingValues = Object.values(fundingData);

    // Warna untuk charts
    const colors = [
        '#6366f1', // indigo-500
        '#14b8a6', // teal-500
        '#f59e0b', // amber-500
        '#ef4444', // red-500
        '#8b5cf6', // violet-500
        '#06b6d4', // cyan-500
        '#84cc16', // lime-500
        '#f97316', // orange-500
    ];

    // Chart Event
    const eventCtx = document.getElementById('eventChart').getContext('2d');
    new Chart(eventCtx, {
        type: 'doughnut',
        data: {
            labels: eventLabels,
            datasets: [{
                data: eventValues,
                backgroundColor: colors.slice(0, eventLabels.length),
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // Chart Funding
    const fundingCtx = document.getElementById('fundingChart').getContext('2d');
    new Chart(fundingCtx, {
        type: 'doughnut',
        data: {
            labels: fundingLabels,
            datasets: [{
                data: fundingValues,
                backgroundColor: colors.slice(0, fundingLabels.length),
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection