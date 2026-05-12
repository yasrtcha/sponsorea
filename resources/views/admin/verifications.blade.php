@extends('layouts.dashboard')

@section('title', 'Verifikasi Akun - Sponsorea')

@section('content')
<div x-data="{ 
        activeTab: 'pending',
        
        // State untuk Modal Approve & Reject
        approvalModalOpen: false,
        rejectionModalOpen: false,
        selectedUserId: null,
        selectedUserName: '',
        
        // State untuk Modal Detail Profil
        detailModalOpen: false,
        selectedUserDetail: null,
        
        openApprove(id, name) {
            this.selectedUserId = id;
            this.selectedUserName = name;
            this.approvalModalOpen = true;
        },
        openReject(id, name) {
            this.selectedUserId = id;
            this.selectedUserName = name;
            this.rejectionModalOpen = true;
        },
        openDetail(userObj) {
            this.selectedUserDetail = userObj;
            this.detailModalOpen = true;
        }
    }" 
    class="space-y-6 pb-12"
>
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-[#3d3d3d] tracking-tight">Verifikasi Pengguna</h1>
            <p class="mt-1 text-[13px] font-medium text-gray-500">Kelola dan tinjau pendaftaran akun Event Organizer & Sponsor.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-2xl bg-[#f0f9f8] p-4 border border-teal-200 shadow-sm" role="alert">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                </svg>
                <p class="text-[13px] font-bold text-teal-800">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Control Bar (Tabs) -->
    <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-2 flex flex-col md:flex-row justify-between items-center gap-3">
        <!-- Pill Tabs -->
        <div class="flex p-1 bg-[#f5f4f0] rounded-xl w-full">
            <button @click="activeTab = 'pending'" 
                    :class="activeTab === 'pending' ? 'bg-white text-[#f07b32] shadow-sm rounded-lg font-extrabold' : 'text-gray-500 hover:text-[#3d3d3d] font-semibold'"
                    class="flex-1 justify-center flex items-center px-4 py-2 text-[13px] transition-all duration-200">
                Menunggu ({{ $pending->count() }})
            </button>
            <button @click="activeTab = 'approved'" 
                    :class="activeTab === 'approved' ? 'bg-white text-[#f07b32] shadow-sm rounded-lg font-extrabold' : 'text-gray-500 hover:text-[#3d3d3d] font-semibold'"
                    class="flex-1 justify-center flex items-center px-4 py-2 text-[13px] transition-all duration-200">
                Disetujui
            </button>
            <button @click="activeTab = 'rejected'" 
                    :class="activeTab === 'rejected' ? 'bg-white text-[#f07b32] shadow-sm rounded-lg font-extrabold' : 'text-gray-500 hover:text-[#3d3d3d] font-semibold'"
                    class="flex-1 justify-center flex items-center px-4 py-2 text-[13px] transition-all duration-200">
                Ditolak
            </button>
        </div>
    </div>

    {{-- Helper Macro/PHP untuk format data profil ke JSON buat Alpine --}}
    @php
        $formatUserData = function($user, $status) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'status' => $status,
                'phone' => $user->profile?->phone_number ?? '-',
                'address' => $user->profile?->address ?? '-',
                'org' => $user->profile?->organization_name ?? '-',
                'company' => $user->profile?->company_name ?? '-',
                'sector' => $user->profile?->company_sector ?? '-',
                'desc' => $user->profile?->description ?? 'Belum ada deskripsi profil.',
                'ig' => $user->profile?->instagram ?? '-',
                'tiktok' => $user->profile?->tiktok ?? '-',
                'verified_at' => $user->verified_at ? $user->verified_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') . ' WIB' : '-',
                'profile_completed_at' => $user->profile?->profile_completed_at ? $user->profile->profile_completed_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') . ' WIB' : '-',
                'rejection_reason' => $user->rejection_reason ?? '-'
            ];
        };
    @endphp

    <div x-cloak x-show="activeTab === 'pending'">
        @if($pending->isEmpty())
            <div class="text-center py-16 bg-white rounded-3xl border-2 border-dashed border-gray-200 shadow-sm max-w-xl mx-auto mt-10">
                <div class="mx-auto w-16 h-16 bg-[#f5f4f0] rounded-full flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-base font-extrabold text-[#3d3d3d]">Tidak ada pengajuan</h3>
                <p class="mt-2 text-xs text-gray-500 font-medium">Belum ada akun baru yang menunggu verifikasi.</p>
            </div>
        @else
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($pending as $user)
                    <div 
                        @click="openDetail({{ Js::from($formatUserData($user, 'pending')) }})"
                        class="group cursor-pointer bg-white rounded-[1.5rem] border border-gray-100 shadow-sm overflow-hidden hover:shadow-lg hover:border-[#f07b32]/30 hover:-translate-y-1 transition-all duration-300 flex flex-col relative"
                    >
                        <div class="p-5 flex-1">
                            <div class="flex items-start justify-between relative">
                                <div class="pr-2">
                                    <h3 class="text-[15px] font-extrabold text-[#3d3d3d] truncate group-hover:text-[#f07b32] transition-colors leading-tight mb-1">{{ $user->name }}</h3>
                                    <p class="text-[11px] font-medium text-gray-500 truncate">{{ $user->email }}</p>
                                </div>
                                <span class="absolute top-0 right-0 inline-flex items-center rounded-lg bg-amber-50 px-2.5 py-1 text-[9px] font-extrabold text-amber-600 border border-amber-200 uppercase tracking-widest shadow-sm">
                                    Pending
                                </span>
                            </div>
                            <div class="mt-4 flex items-center gap-1.5">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Role:</span>
                                <span class="text-[11px] font-extrabold text-white bg-[#3d3d3d] px-2 py-0.5 rounded uppercase tracking-wider">
                                    @if($user->role === 'event') Event
                                    @elseif($user->role === 'company') Sponsor
                                    @else {{ ucfirst($user->role) }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="p-3 bg-gray-50/50 border-t border-gray-100 flex gap-2">
                            <button @click.stop="openReject({{ $user->id }}, '{{ addslashes($user->name) }}')" class="flex-1 rounded-xl bg-white px-3 py-2 text-[11px] font-extrabold text-red-600 shadow-sm border border-gray-200 hover:bg-gray-50 transition-colors uppercase tracking-wider">
                                Tolak
                            </button>
                            <button @click.stop="openApprove({{ $user->id }}, '{{ addslashes($user->name) }}')" class="flex-1 rounded-xl bg-emerald-600 px-3 py-2 text-[11px] font-extrabold text-white shadow-sm hover:bg-emerald-700 transition-colors uppercase tracking-wider">
                                Setujui
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div x-cloak x-show="activeTab === 'approved'">
        @if($approved->isEmpty())
             <div class="text-center py-16 bg-white rounded-3xl border-2 border-dashed border-gray-200 shadow-sm max-w-xl mx-auto mt-10">
                <div class="mx-auto w-16 h-16 bg-[#f5f4f0] rounded-full flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-base font-extrabold text-[#3d3d3d]">Tidak ada data</h3>
                <p class="mt-2 text-xs text-gray-500 font-medium">Belum ada akun yang disetujui.</p>
            </div>
        @else
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($approved as $user)
                    <div 
                        @click="openDetail({{ Js::from($formatUserData($user, 'approved')) }})"
                        class="group cursor-pointer bg-white rounded-[1.5rem] border border-gray-100 shadow-sm overflow-hidden hover:shadow-md hover:border-teal-200 hover:-translate-y-0.5 transition-all duration-200 flex flex-col relative"
                    >
                        <div class="p-5 flex-1">
                            <div class="pr-20 mb-3">
                                <h3 class="text-[15px] font-extrabold text-[#3d3d3d] group-hover:text-teal-600 transition-colors leading-tight mb-1 truncate">{{ $user->name }}</h3>
                                <p class="text-[11px] font-medium text-gray-500 truncate">{{ $user->email }}</p>
                            </div>
                            <span class="absolute top-5 right-5 inline-flex items-center rounded-lg bg-teal-50 px-2.5 py-1 text-[9px] font-extrabold text-teal-700 border border-teal-100 uppercase tracking-widest">
                                Disetujui
                            </span>
                            
                            <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between">
                                <span class="text-[11px] font-extrabold text-gray-400 bg-gray-100 px-2 py-0.5 rounded uppercase tracking-wider">
                                    @if($user->role === 'event') Event
                                    @elseif($user->role === 'company') Sponsor
                                    @else {{ ucfirst($user->role) }}
                                    @endif
                                </span>
                                <span class="text-[9px] text-[#f07b32] font-bold uppercase tracking-wider opacity-0 group-hover:opacity-100 transition-opacity">Detail Profil &rarr;</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div x-cloak x-show="activeTab === 'rejected'">
         @if($rejected->isEmpty())
             <div class="text-center py-16 bg-white rounded-3xl border-2 border-dashed border-gray-200 shadow-sm max-w-xl mx-auto mt-10">
                <div class="mx-auto w-16 h-16 bg-[#f5f4f0] rounded-full flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-base font-extrabold text-[#3d3d3d]">Tidak ada data</h3>
                <p class="mt-2 text-xs text-gray-500 font-medium">Belum ada akun yang ditolak pengajuannya.</p>
            </div>
        @else
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($rejected as $user)
                    <div 
                        @click="openDetail({{ Js::from($formatUserData($user, 'rejected')) }})"
                        class="group cursor-pointer bg-white rounded-[1.5rem] border border-gray-100 shadow-sm overflow-hidden hover:border-red-200 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col relative"
                    >
                        <div class="p-5 flex-1">
                            <div class="pr-16 mb-3">
                                <h3 class="text-[15px] font-extrabold text-[#3d3d3d] group-hover:text-red-600 transition-colors leading-tight mb-1 truncate">{{ $user->name }}</h3>
                                <p class="text-[11px] font-medium text-gray-500 truncate">{{ $user->email }}</p>
                            </div>
                            <span class="absolute top-5 right-5 inline-flex items-center rounded-lg bg-red-50 px-2.5 py-1 text-[9px] font-extrabold text-red-600 border border-red-100 uppercase tracking-widest">
                                Ditolak
                            </span>

                            <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between">
                                <span class="text-[11px] font-extrabold text-gray-400 bg-gray-100 px-2 py-0.5 rounded uppercase tracking-wider">
                                    @if($user->role === 'event') Event
                                    @elseif($user->role === 'company') Sponsor
                                    @else {{ ucfirst($user->role) }}
                                    @endif
                                </span>
                                <span class="text-[9px] text-[#f07b32] font-bold uppercase tracking-wider opacity-0 group-hover:opacity-100 transition-opacity">Lihat Alasan &rarr;</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- MODAL: Profil Detail -->
    <div x-cloak x-show="detailModalOpen" class="relative z-50" aria-labelledby="detail-modal" role="dialog" aria-modal="true">
        <div x-show="detailModalOpen" x-transition.opacity class="fixed inset-0 bg-[#3d3d3d]/50 backdrop-blur-sm transition-opacity"></div>
        
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <template x-if="selectedUserDetail">
                    <div @click.away="detailModalOpen = false" x-show="detailModalOpen" x-transition.scale.origin.bottom class="relative transform overflow-hidden rounded-[2rem] bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-xl">
                        
                        <div class="border-b border-gray-100 bg-white px-5 py-4 flex items-center justify-between sticky top-0 z-10">
                            <div>
                                <h3 class="text-lg font-extrabold leading-6 text-[#3d3d3d]" x-text="selectedUserDetail.name"></h3>
                                <p class="text-[11px] font-medium text-gray-500 mt-1" x-text="selectedUserDetail.email"></p>
                            </div>
                            <button @click="detailModalOpen = false" class="text-gray-400 hover:text-gray-600 transition-colors p-1.5 bg-gray-50 rounded-full">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="px-5 py-5 space-y-5">
                            
                            <!-- Badges Status -->
                            <template x-if="selectedUserDetail.status === 'rejected'">
                                <div class="space-y-3">
                                    <div class="bg-red-50 p-4 rounded-2xl border border-red-100">
                                        <h4 class="text-[11px] font-extrabold text-red-800 mb-1 uppercase tracking-wider">Alasan Penolakan:</h4>
                                        <p class="text-[13px] font-medium text-red-700" x-text="selectedUserDetail.rejection_reason"></p>
                                    </div>
                                    <div class="bg-[#f0f9f8] p-3 rounded-xl border border-teal-100 flex items-center gap-2 text-[11px] font-bold text-teal-800">
                                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-11.293a1 1 0 00-1.414 1.414L9 9.586 7.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                                        </svg>
                                        Profile dilengkapi pada <span class="font-extrabold" x-text="selectedUserDetail.profile_completed_at"></span>
                                    </div>
                                </div>
                            </template>
                            
                            <template x-if="selectedUserDetail.status === 'approved'">
                                <div class="space-y-3">
                                    <div class="bg-teal-50 p-3 rounded-xl border border-teal-100 flex items-center gap-2 text-[11px] font-bold text-teal-800">
                                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                        </svg>
                                        Telah disetujui pada <span class="font-extrabold" x-text="selectedUserDetail.verified_at"></span>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100 flex items-center gap-2 text-[11px] font-bold text-gray-600">
                                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-11.293a1 1 0 00-1.414 1.414L9 9.586 7.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                                        </svg>
                                        Profile dilengkapi pada <span class="font-extrabold" x-text="selectedUserDetail.profile_completed_at"></span>
                                    </div>
                                </div>
                            </template>
                            
                            <template x-if="selectedUserDetail.status === 'pending'">
                                <div class="bg-amber-50 p-3 rounded-xl border border-amber-100 flex items-center gap-2 text-[11px] font-bold text-amber-800">
                                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-11.293a1 1 0 00-1.414 1.414L9 9.586 7.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                                    </svg>
                                    Profile dilengkapi pada <span class="font-extrabold" x-text="selectedUserDetail.profile_completed_at"></span>
                                </div>
                            </template>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-[12px] font-extrabold text-[#3d3d3d] border-b border-gray-100 pb-2 mb-3 uppercase tracking-wider">Informasi Kontak</h4>
                                    <dl class="space-y-3 text-[13px]">
                                        <div>
                                            <dt class="text-gray-400 font-bold text-[10px] uppercase tracking-wider">Nomor HP</dt>
                                            <dd class="font-semibold text-[#3d3d3d] mt-0.5" x-text="selectedUserDetail.phone"></dd>
                                        </div>
                                        <div>
                                            <dt class="text-gray-400 font-bold text-[10px] uppercase tracking-wider">Alamat Lengkap</dt>
                                            <dd class="font-semibold text-[#3d3d3d] mt-0.5 leading-relaxed" x-text="selectedUserDetail.address"></dd>
                                        </div>
                                    </dl>
                                </div>

                                <div>
                                    <h4 class="text-[12px] font-extrabold text-[#3d3d3d] border-b border-gray-100 pb-2 mb-3 uppercase tracking-wider">Data Profesional</h4>
                                    <dl class="space-y-3 text-[13px]">
                                        <template x-if="selectedUserDetail.role === 'event'">
                                            <div>
                                                <dt class="text-gray-400 font-bold text-[10px] uppercase tracking-wider">Nama Organisasi / Event</dt>
                                                <dd class="font-semibold text-[#3d3d3d] mt-0.5" x-text="selectedUserDetail.org"></dd>
                                            </div>
                                        </template>
                                        <template x-if="selectedUserDetail.role === 'company'">
                                            <div>
                                                <dt class="text-gray-400 font-bold text-[10px] uppercase tracking-wider">Nama Perusahaan (Sektor)</dt>
                                                <dd class="font-semibold text-[#3d3d3d] mt-0.5 whitespace-nowrap">
                                                    <span x-text="selectedUserDetail.company"></span> 
                                                    (<span x-text="selectedUserDetail.sector" class="text-gray-500"></span>)
                                                </dd>
                                            </div>
                                        </template>
                                    </dl>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-[12px] font-extrabold text-[#3d3d3d] mb-2 uppercase tracking-wider border-b border-gray-100 pb-2">Deskripsi Lengkap</h4>
                                <div class="bg-white rounded-xl p-4 text-[13px] text-gray-600 whitespace-pre-wrap border border-gray-100 shadow-sm leading-relaxed" x-text="selectedUserDetail.desc"></div>
                            </div>

                            <div class="flex gap-4 border-t border-gray-100 pt-4">
                                <template x-if="selectedUserDetail.ig !== '-'">
                                    <a :href="`https://instagram.com/${selectedUserDetail.ig.replace('@', '')}`" target="_blank" class="text-[11px] font-extrabold text-[#f07b32] hover:text-[#d96a25] flex items-center gap-1 bg-[#f5f4f0] px-3 py-1.5 rounded-lg">📸 @<span x-text="selectedUserDetail.ig.replace('@', '')"></span></a>
                                </template>
                                <template x-if="selectedUserDetail.tiktok !== '-'">
                                    <a :href="`https://tiktok.com/@${selectedUserDetail.tiktok.replace('@', '')}`" target="_blank" class="text-[11px] font-extrabold text-[#3d3d3d] hover:text-black flex items-center gap-1 bg-[#f5f4f0] px-3 py-1.5 rounded-lg">🎵 @<span x-text="selectedUserDetail.tiktok.replace('@', '')"></span></a>
                                </template>
                            </div>

                        </div>
                        
                        <template x-if="selectedUserDetail.status === 'pending'">
                            <div class="bg-gray-50 px-5 py-4 flex gap-3 justify-end rounded-b-[2rem] border-t border-gray-100">
                                <button type="button" @click="detailModalOpen = false; openReject(selectedUserDetail.id, selectedUserDetail.name)" class="inline-flex justify-center rounded-[1rem] bg-white px-5 py-2.5 text-[11px] font-extrabold text-red-600 border border-gray-200 hover:bg-gray-50 transition-colors uppercase tracking-wider">
                                    Tolak Pendaftaran
                                </button>
                                <button type="button" @click="detailModalOpen = false; openApprove(selectedUserDetail.id, selectedUserDetail.name)" class="inline-flex justify-center rounded-[1rem] bg-emerald-600 px-5 py-2.5 text-[11px] font-extrabold text-white shadow-sm hover:bg-emerald-700 transition-colors uppercase tracking-wider">
                                    Setujui Akun
                                </button>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- MODAL: Approve Akun -->
    <div x-cloak x-show="approvalModalOpen" class="relative z-50">
        <div x-show="approvalModalOpen" x-transition.opacity class="fixed inset-0 bg-[#3d3d3d]/50 backdrop-blur-sm transition-opacity"></div>
        <div class="fixed inset-0 z-20 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div @click.away="approvalModalOpen = false" x-show="approvalModalOpen" x-transition.scale.origin.bottom class="relative transform overflow-hidden rounded-[2rem] bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-sm">
                    <div class="bg-white px-6 pb-6 pt-7 text-center">
                        <div class="mx-auto flex w-16 h-16 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 mb-4">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="text-lg font-extrabold text-[#3d3d3d] mb-2">Setujui Akun</h3>
                        <p class="text-[13px] text-gray-500 font-medium leading-relaxed">Apakah Anda yakin ingin menyetujui pendaftaran akun <br><span class="font-bold text-emerald-600" x-text="selectedUserName"></span>?</p>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 flex gap-3 flex-col-reverse sm:flex-row sm:justify-end border-t border-gray-100">
                        <button type="button" @click="approvalModalOpen = false" class="inline-flex w-full justify-center rounded-[1rem] bg-white px-4 py-2.5 text-[11px] font-extrabold text-[#3d3d3d] border border-gray-200 hover:bg-gray-50 transition-colors uppercase tracking-wider sm:w-auto mt-2 sm:mt-0">Batal</button>
                        <form method="POST" :action="`/admin/verifications/${selectedUserId}/approve`" class="w-full sm:w-auto">
                            @csrf @method('PUT')
                            <button type="submit" class="inline-flex w-full justify-center rounded-[1rem] bg-emerald-600 px-4 py-2.5 text-[11px] font-extrabold text-white shadow-sm hover:bg-emerald-700 transition-colors uppercase tracking-wider mb-2 sm:mb-0">Ya, Setujui</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: Reject Akun -->
    <div x-cloak x-show="rejectionModalOpen" class="relative z-50">
        <div x-show="rejectionModalOpen" x-transition.opacity class="fixed inset-0 bg-[#3d3d3d]/50 backdrop-blur-sm transition-opacity"></div>
        <div class="fixed inset-0 z-20 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div @click.away="rejectionModalOpen = false" x-show="rejectionModalOpen" x-transition.scale.origin.bottom class="relative transform overflow-hidden rounded-[2rem] bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-md">
                    <form method="POST" :action="`/admin/verifications/${selectedUserId}/reject`">
                        @csrf @method('PUT')
                        <div class="bg-white px-6 pb-6 pt-7">
                            <div class="mx-auto flex w-16 h-16 items-center justify-center rounded-full bg-red-50 text-red-500 mb-4">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            </div>
                            <div class="text-center mb-5">
                                <h3 class="text-lg font-extrabold text-[#3d3d3d] mb-2">Tolak Akun</h3>
                                <p class="text-[13px] text-gray-500 font-medium">Anda akan menolak pendaftaran <span class="font-bold text-red-500" x-text="selectedUserName"></span>.</p>
                            </div>
                            <div>
                                <label for="rejection_reason" class="block text-[11px] font-extrabold text-[#3d3d3d] mb-1.5 uppercase tracking-wider text-left">Alasan Penolakan</label>
                                <textarea id="rejection_reason" name="rejection_reason" rows="3" required class="block w-full rounded-2xl border-gray-200 py-3 px-4 text-[13px] font-medium text-[#3d3d3d] shadow-sm focus:ring-[#f07b32] focus:border-[#f07b32] transition-colors resize-none" placeholder="Masukkan alasan kenapa profil ini ditolak..."></textarea>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 flex gap-3 flex-col-reverse sm:flex-row sm:justify-end border-t border-gray-100">
                            <button type="button" @click="rejectionModalOpen = false" class="inline-flex w-full justify-center rounded-[1rem] bg-white px-4 py-2.5 text-[11px] font-extrabold text-[#3d3d3d] border border-gray-200 hover:bg-gray-50 transition-colors uppercase tracking-wider sm:w-auto mt-2 sm:mt-0">Batal</button>
                            <button type="submit" class="inline-flex w-full justify-center rounded-[1rem] bg-red-600 px-4 py-2.5 text-[11px] font-extrabold text-white shadow-sm hover:bg-red-500 transition-colors uppercase tracking-wider mb-2 sm:mb-0">Tolak Pendaftaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection