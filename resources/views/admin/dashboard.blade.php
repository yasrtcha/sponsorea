@extends('layouts.dashboard')

@section('title', 'Super Admin Dashboard - Sponsorea')

@section('content')
<div class="space-y-6">
    
    <!-- Header Title -->
    <div>
        <h2 class="text-2xl font-extrabold text-[#3d3d3d]">Dashboard Super Admin</h2>
        <p class="text-xs text-gray-500 mt-1 font-medium">Selamat datang, Admin! Berikut adalah rekapitulasi data Sponsorea hari ini.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-[1rem] bg-[#fcf5f5] text-[#f07b32] flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total User</p>
                <h3 class="text-2xl font-extrabold text-[#3d3d3d] leading-none mt-1">{{ $totalUsers }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-[1rem] bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Event</p>
                <h3 class="text-2xl font-extrabold text-[#3d3d3d] leading-none mt-1">{{ $totalEvents }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-[1rem] bg-teal-50 text-teal-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Penawaran</p>
                <h3 class="text-2xl font-extrabold text-[#3d3d3d] leading-none mt-1">{{ $totalOffers }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-[1rem] bg-amber-50 text-amber-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Transaksi</p>
                <h3 class="text-2xl font-extrabold text-[#3d3d3d] leading-none mt-1">{{ $totalTransactions }}</h3>
            </div>
        </div>
    </div>

    <!-- User Verification Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Menunggu -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-[1rem] bg-amber-50 text-amber-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Akun Menunggu</p>
                <h3 class="text-2xl font-extrabold text-[#3d3d3d] leading-none mt-1">{{ $usersPending }}</h3>
            </div>
        </div>

        <!-- Disetujui -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-[1rem] bg-teal-50 text-teal-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Akun Disetujui</p>
                <h3 class="text-2xl font-extrabold text-[#3d3d3d] leading-none mt-1">{{ $usersVerified }}</h3>
            </div>
        </div>

        <!-- Ditolak -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-[1rem] bg-red-50 text-red-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Akun Ditolak</p>
                <h3 class="text-2xl font-extrabold text-[#3d3d3d] leading-none mt-1">{{ $usersRejected }}</h3>
            </div>
        </div>
    </div>

    <!-- Progress Bars Section -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Event to Company -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-50 flex items-center justify-between">
                <h3 class="text-sm font-extrabold text-[#3d3d3d]">Pengajuan (Event → Perusahaan)</h3>
            </div>
            <div class="p-6 space-y-5">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-600">Disetujui</span>
                        <span class="text-sm font-extrabold text-teal-600">{{ $eventRequestsAccepted }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        <div class="bg-teal-500 h-2.5 rounded-full" style="width: {{ $eventRequestsAccepted + $eventRequestsPending + $eventRequestsRejected > 0 ? ($eventRequestsAccepted / ($eventRequestsAccepted + $eventRequestsPending + $eventRequestsRejected)) * 100 : 0 }}%"></div>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-600">Menunggu</span>
                        <span class="text-sm font-extrabold text-amber-600">{{ $eventRequestsPending }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        <div class="bg-amber-500 h-2.5 rounded-full" style="width: {{ $eventRequestsAccepted + $eventRequestsPending + $eventRequestsRejected > 0 ? ($eventRequestsPending / ($eventRequestsAccepted + $eventRequestsPending + $eventRequestsRejected)) * 100 : 0 }}%"></div>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-600">Ditolak</span>
                        <span class="text-sm font-extrabold text-red-600">{{ $eventRequestsRejected }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        <div class="bg-red-500 h-2.5 rounded-full" style="width: {{ $eventRequestsAccepted + $eventRequestsPending + $eventRequestsRejected > 0 ? ($eventRequestsRejected / ($eventRequestsAccepted + $eventRequestsPending + $eventRequestsRejected)) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Company to Event -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-50 flex items-center justify-between">
                <h3 class="text-sm font-extrabold text-[#3d3d3d]">Penawaran (Perusahaan → Event)</h3>
            </div>
            <div class="p-6 space-y-5">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-600">Disetujui</span>
                        <span class="text-sm font-extrabold text-teal-600">{{ $companyRequestsAccepted }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        <div class="bg-teal-500 h-2.5 rounded-full" style="width: {{ $companyRequestsAccepted + $companyRequestsPending + $companyRequestsRejected > 0 ? ($companyRequestsAccepted / ($companyRequestsAccepted + $companyRequestsPending + $companyRequestsRejected)) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-600">Menunggu</span>
                        <span class="text-sm font-extrabold text-amber-600">{{ $companyRequestsPending }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        <div class="bg-amber-500 h-2.5 rounded-full" style="width: {{ $companyRequestsAccepted + $companyRequestsPending + $companyRequestsRejected > 0 ? ($companyRequestsPending / ($companyRequestsAccepted + $companyRequestsPending + $companyRequestsRejected)) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-600">Ditolak</span>
                        <span class="text-sm font-extrabold text-red-600">{{ $companyRequestsRejected }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        <div class="bg-red-500 h-2.5 rounded-full" style="width: {{ $companyRequestsAccepted + $companyRequestsPending + $companyRequestsRejected > 0 ? ($companyRequestsRejected / ($companyRequestsAccepted + $companyRequestsPending + $companyRequestsRejected)) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="text-sm font-bold text-[#3d3d3d] mb-4">Statistik Kategori Event</h3>
            <div class="relative w-full aspect-[4/3] max-h-64 mx-auto">
                <canvas id="eventChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="text-sm font-bold text-[#3d3d3d] mb-4">Statistik Jenis Bantuan</h3>
            <div class="relative w-full aspect-[4/3] max-h-64 mx-auto">
                <canvas id="fundingChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Logs Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 pb-8">
        
        <!-- Recent Users -->
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden flex flex-col max-h-[400px]">
            <div class="px-5 py-4 border-b border-gray-50">
                <h3 class="text-sm font-bold text-[#3d3d3d]">Pendaftar Terbaru</h3>
            </div>
            <div class="divide-y divide-gray-50 overflow-y-auto">
                @forelse($recentUsers as $user)
                    <div class="px-5 py-3.5 flex items-center justify-between hover:bg-gray-50/50 transition-colors">
                        <div>
                            <p class="font-bold text-[13px] text-[#3d3d3d]">{{ $user->name }}</p>
                            @if($user->profile)
                                <p class="text-[10px] text-gray-500 font-semibold mt-0.5">
                                    {{ $user->profile->organization_name ?? $user->profile->company_name ?? '-' }}
                                </p>
                            @endif
                            <p class="text-[10px] text-gray-400 mt-0.5">{{ $user->email }}</p>
                        </div>
                        <span class="px-2 py-1 rounded-md text-[9px] font-bolder uppercase tracking-wider {{ $user->role === 'company' ? 'bg-[#fcf5f5] text-[#f07b32]' : 'bg-gray-100 text-gray-600' }}">
                            {{ $user->role }}
                        </span>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-xs font-semibold text-gray-400">Belum ada pengguna terdaftar.</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden flex flex-col max-h-[400px]">
            <div class="px-5 py-4 border-b border-gray-50">
                <h3 class="text-sm font-bold text-[#3d3d3d]">Aktivitas Pengajuan</h3>
            </div>
            <div class="divide-y divide-gray-50 overflow-y-auto">
                @forelse($recentTransactions as $trx)
                    <div class="px-5 py-3.5 flex flex-col hover:bg-gray-50/50 transition-colors gap-1.5">
                        <div class="flex items-center justify-between">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $trx->created_at->diffForHumans() }}</p>
                            @if($trx->status === 'approved')
                                <span class="px-2 py-0.5 bg-teal-50 text-teal-600 text-[9px] font-bold rounded">DEAL</span>
                            @elseif($trx->status === 'rejected')
                                <span class="px-2 py-0.5 bg-red-50 text-red-500 text-[9px] font-bold rounded">TOLAK</span>
                            @else
                                <span class="px-2 py-0.5 bg-amber-50 text-amber-500 text-[9px] font-bold rounded">PENDING</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-600 leading-snug">
                            <span class="font-bold text-[#3d3d3d]">{{ $trx->initiator === 'event' ? ($trx->event->user->name ?? 'Mahasiswa') : ($trx->sponsorOffer->user->name ?? 'Company') }}</span> 
                            <span class="text-gray-400">mengajukan ke</span> 
                            <span class="font-bold text-[#3d3d3d]">{{ $trx->initiator === 'event' ? ($trx->sponsorOffer->user->name ?? 'Company') : ($trx->event->user->name ?? 'Mahasiswa') }}</span>
                        </p>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-xs font-semibold text-gray-400">Belum ada aktivitas.</div>
                @endforelse
            </div>
        </div>

    </div>
</div>

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

    // Warna untuk charts (Sesuai palette)
    const colors = [
        '#f07b32', // Orange Utama
        '#3d3d3d', // Dark text color
        '#6366f1', // indigo
        '#14b8a6', // teal
        '#f59e0b', // amber
        '#ef4444', // red
        '#8b5cf6', // violet
        '#06b6d4', // cyan
    ];

    // Chart Options Umum
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 15,
                    usePointStyle: true,
                    boxWidth: 8,
                    font: {
                        size: 11,
                        family: "'Inter', sans-serif",
                        weight: 'bold'
                    },
                    color: '#9ca3af' // text-gray-400
                }
            },
            tooltip: {
                backgroundColor: '#3d3d3d',
                titleFont: { size: 12, family: "'Inter', sans-serif" },
                bodyFont: { size: 12, family: "'Inter', sans-serif" },
                padding: 10,
                cornerRadius: 8,
                callbacks: {
                    label: function(context) {
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                        return ' ' + context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                    }
                }
            }
        },
        cutout: '65%' // Buat doughnutnya sedikit lebih tipis terlihat ringkas
    };

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
                borderColor: '#ffffff',
                hoverOffset: 4
            }]
        },
        options: chartOptions
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
                borderColor: '#ffffff',
                hoverOffset: 4
            }]
        },
        options: chartOptions
    });
</script>
@endsection