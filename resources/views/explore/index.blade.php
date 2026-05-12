@extends('layouts.dashboard')

@section('title', 'Jelajahi')
@section('page_title', 'Jelajahi Peluang')

@section('content')
<div x-data="exploreComponent()" class="pb-16 space-y-6">
        
        <!-- Premium Hero Section (Card Formatted) -->
        <div class="relative bg-[#3d3d3d] pt-10 pb-16 overflow-hidden rounded-[2rem] border border-[#f07b32]/20 shadow-md">
            <!-- Grid Pattern Background -->
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
            
            <!-- Glow accents -->
            <div class="absolute top-0 right-1/4 w-80 h-80 bg-[#f07b32]/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-1/4 w-60 h-60 bg-gray-500/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative w-full mx-auto px-6 lg:px-10 text-center z-10">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight mb-4">
                    Peluang Kolaborasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#f07b32] to-[#ffb07a]">Terbaik</span>
                </h1>
                <p class="text-xs sm:text-sm text-gray-300 max-w-xl mx-auto mb-8 font-medium">
                    Temukan event yang merepresentasikan nilai perusahaan, atau pendanaan luar biasa untuk mendukung inovasi acara Anda.
                </p>
                
                <div class="max-w-2xl mx-auto relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#f07b32] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input id="q" name="q" type="search" value="{{ old('q', $query ?? '') }}" 
                           class="block w-full pl-11 pr-4 py-3.5 text-sm rounded-2xl bg-white/10 border border-white/20 text-white placeholder:text-gray-400 focus:bg-white focus:text-[#3d3d3d] focus:border-[#f07b32] focus:ring-4 focus:ring-[#f07b32]/30 transition-all shadow-xl backdrop-blur-md outline-none" 
                           placeholder="Coba ketik 'Festival' atau 'Beasiswa'..." autofocus>
                </div>
            </div>
        </div>

        <main class="relative z-20">

            <!-- Notifications -->
            @if(session('error'))
                <div id="toast-error" class="fixed top-20 right-8 z-50 bg-red-50 border border-red-200 px-6 py-4 rounded-3 shadow-lg flex items-center gap-3 transition-all duration-500 transform translate-y-0 opacity-100">
                    <div class="bg-red-100 p-1.5 rounded-full">
                        <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-[13px] text-red-800">Perhatian!</h4>
                        <p class="text-[11px] font-medium text-red-600">{{ session('error') }}</p>
                    </div>
                    <button onclick="closeErrorToast()" class="ml-4 text-red-400 hover:text-red-600 transition-colors bg-red-100 rounded-full p-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <script>
                    setTimeout(() => closeErrorToast(), 4000);
                    function closeErrorToast() {
                        const toast = document.getElementById('toast-error');
                        if(toast) {
                            toast.classList.replace('translate-y-0', '-translate-y-4');
                            toast.classList.replace('opacity-100', 'opacity-0');
                            setTimeout(() => toast.remove(), 500);
                        }
                    }
                </script>
            @endif

            @if(session('success'))
                <div id="toast-success" class="fixed top-20 right-8 z-50 bg-[#f0f9f8] border border-teal-200 px-6 py-4 rounded-3 shadow-lg flex items-center gap-3 transition-all duration-500 transform translate-y-0 opacity-100">
                    <div class="bg-teal-100 p-1.5 rounded-full">
                        <svg class="w-5 h-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-[13px] text-teal-800">Berhasil!</h4>
                        <p class="text-[11px] font-medium text-teal-600">{{ session('success') }}</p>
                    </div>
                    <button onclick="closeSuccessToast()" class="ml-4 text-teal-400 hover:text-teal-600 transition-colors bg-teal-50 rounded-full p-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <script>
                    setTimeout(() => closeSuccessToast(), 4000);
                    function closeSuccessToast() {
                        const toast = document.getElementById('toast-success');
                        if(toast) {
                            toast.classList.replace('translate-y-0', '-translate-y-4');
                            toast.classList.replace('opacity-100', 'opacity-0');
                            setTimeout(() => toast.remove(), 500);
                        }
                    }
                </script>
            @endif

            <!-- Control Bar (Tabs & Filters) -->
            <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-2 flex flex-col md:flex-row justify-between items-center gap-3 mb-6">
                
                <!-- Pill Tabs -->
                <div class="flex p-1 bg-[#f5f4f0] rounded-xl w-full md:w-auto">
                    @if(auth()->user()->role === 'event' || auth()->user()->role === 'admin')
                        <button @click="activeTab = 'offers'" 
                                :class="activeTab === 'offers' ? 'bg-white text-[#f07b32] shadow-sm rounded-lg font-bold' : 'text-gray-500 hover:text-[#3d3d3d] font-semibold'"
                                class="flex-1 justify-center md:flex-none flex items-center px-5 py-2.5 text-[13px] transition-all duration-200">
                            Program Sponsorship
                        </button>
                    @endif
                    
                    @if(auth()->user()->role === 'company' || auth()->user()->role === 'event' || auth()->user()->role === 'admin')
                        <button @click="activeTab = 'events'" 
                                :class="activeTab === 'events' ? 'bg-white text-[#f07b32] shadow-sm rounded-lg font-bold' : 'text-gray-500 hover:text-[#3d3d3d] font-semibold'"
                                class="flex-1 justify-center md:flex-none flex items-center px-5 py-2.5 text-[13px] transition-all duration-200">
                            Katalog Event
                        </button>
                    @endif
                </div>

                <!-- Filters -->
                <div class="flex items-center space-x-2 w-full md:w-auto px-2 pb-2 md:pb-0">
                    @if(auth()->user()->role === 'event' || auth()->user()->role === 'admin')
                        <div x-show="activeTab === 'offers'" x-cloak class="relative flex-grow md:flex-grow-0 min-w-[180px]">
                            <select id="fundingTypeFilter" class="appearance-none block w-full pl-3 pr-8 py-2.5 bg-gray-50 border border-gray-100 text-[13px] font-bold rounded-xl focus:ring-2 focus:ring-[#f07b32] focus:border-[#f07b32] text-[#3d3d3d] outline-none transition-all hover:bg-gray-100 cursor-pointer">
                                <option value="">Semua Sponsorship</option>
                                @foreach($fundingTypes as $type)
                                    <option value="{{ $type->name }}" {{ $fundingType === $type->name ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    @endif

                    @if(auth()->user()->role === 'company' || auth()->user()->role === 'event' || auth()->user()->role === 'admin')
                        <div x-show="activeTab === 'events'" x-cloak class="relative flex-grow md:flex-grow-0 min-w-[180px]">
                            <select id="eventTypeFilter" class="appearance-none block w-full pl-3 pr-8 py-2.5 bg-gray-50 border border-gray-100 text-[13px] font-bold rounded-xl focus:ring-2 focus:ring-[#f07b32] focus:border-[#f07b32] text-[#3d3d3d] outline-none transition-all hover:bg-gray-100 cursor-pointer">
                                <option value="">Semua Jenis Event</option>
                                @foreach($eventTypes as $type)
                                    <option value="{{ $type->name }}" {{ $eventType === $type->name ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    @endif

                    <button onclick="applyFilters()" class="inline-flex items-center justify-center p-2.5 border border-gray-200 rounded-xl shadow-sm text-gray-600 bg-white hover:bg-gray-50 hover:text-[#f07b32] focus:outline-none transition-colors" title="Terapkan Filter">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    </button>
                    
                    @if($eventType || $fundingType)
                        <a href="{{ route('explore.index') }}" class="text-[13px] text-red-500 hover:text-red-700 font-bold whitespace-nowrap transition-colors pl-1">
                            Reset
                        </a>
                    @endif
                </div>
            </div>

            <!-- Content Area -->
            <div id="exploreContent">
                
                <!-- OFFERS TAB -->
                @if(auth()->user()->role === 'event' || auth()->user()->role === 'admin')
                <div x-show="activeTab === 'offers'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                    @if($offers->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach($offers as $offer)
                            <div class="bg-white rounded-[1.5rem] border border-gray-100 shadow-sm overflow-hidden hover:shadow-lg hover:border-[#f07b32]/30 hover:-translate-y-1 transition-all duration-300 flex flex-col h-full group z-0 relative">
                                
                                <div class="relative h-40 bg-gray-100 overflow-hidden">
                                    @if($offer->banner_image)
                                        <img src="{{ asset('storage/' . $offer->banner_image) }}" alt="Banner" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                                    @else
                                        <div class="flex items-center justify-center h-full text-gray-300 bg-gray-100/50">
                                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                    

                                </div>
                                
                                <div class="p-5 flex flex-col flex-grow relative bg-white z-20">
                                    <!-- Avatar Floating (Button trigger modal) -->
                                    <button @click="openProfileModal({{ $offer->user->id }})" class="absolute -top-6 right-5 border-4 border-white rounded-xl w-12 h-12 flex items-center justify-center text-lg shadow-sm transition-transform hover:scale-110 hover:shadow-md focus:outline-none z-30 font-extrabold bg-[#fcf5f5] text-[#f07b32]" title="Lihat Profil">
                                         {{ substr($offer->user->profile->company_name ?? $offer->user->name ?? 'C', 0, 1) }}
                                    </button>

                                    <button @click="openProfileModal({{ $offer->user->id }})" class="text-left inline-block mt-1 mb-1.5 text-[10px] font-bold text-[#f07b32] uppercase tracking-wider pr-10 truncate hover:text-[#d96a25] transition-colors">
                                        {{ $offer->user->profile->company_name ?? $offer->user->name ?? 'Perusahaan' }}
                                    </button>
                                    
                                    <h3 class="text-sm font-extrabold text-[#3d3d3d] mb-1.5 line-clamp-2 leading-tight group-hover:text-[#f07b32] transition-colors">
                                        {{ $offer->title }}
                                    </h3>

                                    <div class="mb-2.5">
                                        <span class="inline-flex items-center px-2 py-1 rounded bg-[#f5f4f0] text-gray-600 text-[9px] font-extrabold uppercase tracking-wider border border-gray-200">
                                            {{ $offer->funding_type }}
                                        </span>
                                    </div>
                                    
                                    <!-- Deadline Badge -->
                                    @if($offer->deadline)
                                        @php
                                            $now = \Carbon\Carbon::now()->startOfDay();
                                            $isExpired = $offer->deadline->startOfDay() < $now;
                                        @endphp
                                        <div class="mb-2.5">
                                            @if($isExpired)
                                                <span class="inline-flex items-center px-2 py-1 rounded bg-red-50 text-red-600 text-[9px] font-extrabold uppercase tracking-wider border border-red-100">
                                                    <svg class="w-2.5 h-2.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                                    Berakhir
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded bg-emerald-50 text-emerald-600 text-[9px] font-extrabold uppercase tracking-wider border border-emerald-100">
                                                    <svg class="w-2.5 h-2.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                                    Hingga {{ $offer->deadline->setTimezone('Asia/Jakarta')->format('d M Y') }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <div class="mb-2.5">
                                            <span class="inline-flex items-center px-2 py-1 rounded bg-gray-50 text-gray-500 text-[9px] font-extrabold uppercase tracking-wider border border-gray-100">
                                                Tanpa Batas
                                            </span>
                                        </div>
                                    @endif
                                    
                                    <!-- Description -->
                                    <div x-data="{ expanded: false }" class="mb-5 flex-grow">
                                        <p :class="expanded ? '' : 'line-clamp-2'" class="text-xs text-gray-500 break-words leading-relaxed">
                                            {{ $offer->description }}
                                        </p>
                                        @if(strlen($offer->description) > 80)
                                            <button @click="expanded = !expanded" class="text-[#f07b32] text-[10px] font-bold mt-1.5 hover:text-[#d96a25] transition-colors focus:outline-none inline-flex items-center">
                                                <span x-text="expanded ? 'Sembunyikan' : 'Baca Selengkapnya'"></span>
                                                <svg x-show="!expanded" class="ml-1 w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                                <svg x-show="expanded" style="display:none;" class="ml-1 w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                            </button>
                                        @endif
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-2 pt-4 border-t border-gray-50 mt-auto">
                                        @if($offer->guideline_pdf)
                                            <a href="{{ asset('storage/' . $offer->guideline_pdf) }}" target="_blank" class="w-full inline-flex justify-center items-center px-2 py-2 border border-gray-200 shadow-sm text-[11px] font-bold rounded-xl text-gray-600 bg-white hover:bg-gray-50 hover:border-gray-300 transition-all focus:outline-none">
                                                Dokumen
                                            </a>
                                        @else
                                            <span class="w-full inline-flex justify-center items-center px-2 py-2 border border-gray-100 text-[11px] font-bold rounded-xl text-gray-400 bg-[#f5f4f0] cursor-not-allowed">
                                                Kosong
                                            </span>
                                        @endif
                                        
                                        @if(auth()->user()->role !== 'admin')
                                            @if($pendingOfferIds->contains($offer->id))
                                                <span class="w-full inline-flex justify-center items-center gap-1.5 px-2 py-2 border border-amber-200 text-[11px] font-extrabold rounded-xl text-amber-700 bg-amber-50 cursor-not-allowed">
                                                    <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Menunggu
                                                </span>
                                            @else
                                                <button onclick="openRequestModal('offer', {{ $offer->id }}, '{{ addslashes($offer->title) }}')" class="w-full inline-flex justify-center items-center px-2 py-2 border border-transparent shadow-sm text-[11px] font-extrabold rounded-xl text-white bg-[#f07b32] hover:bg-[#d96a25] transition-all focus:outline-none">
                                                    Ajukan
                                                </button>
                                            @endif
                                        @else
                                            <span class="w-full inline-flex justify-center items-center px-2 py-2 border border-transparent text-[11px] font-extrabold rounded-xl text-[#3d3d3d]/50 bg-[#3d3d3d]/10 cursor-not-allowed">
                                                Ajukan
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-20 bg-white rounded-[2rem] border-dashed border-2 border-gray-200 shadow-sm mx-auto max-w-xl">
                            <div class="mx-auto w-16 h-16 bg-[#f5f4f0] rounded-full flex items-center justify-center mb-4">
                                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <h3 class="text-base font-extrabold text-[#3d3d3d]">Belum ada penawaran tersedia</h3>
                            <p class="mt-2 text-xs text-gray-500 font-medium">Cek kembali halaman ini dalam beberapa waktu ke depan untuk info sponsorship.</p>
                        </div>
                    @endif
                </div>
                @endif

                <!-- EVENTS TAB -->
                @if(auth()->user()->role === 'company' || auth()->user()->role === 'event' || auth()->user()->role === 'admin')
                <div x-show="activeTab === 'events'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                    @if($events->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach($events as $event)
                            <div class="bg-white rounded-[1.5rem] border border-gray-100 shadow-sm overflow-hidden hover:shadow-lg hover:border-[#f07b32]/30 hover:-translate-y-1 transition-all duration-300 flex flex-col h-full group z-0 relative">
                                
                                <div class="relative h-40 bg-gray-100 overflow-hidden">
                                    @if($event->poster_image)
                                        <img src="{{ asset('storage/' . $event->poster_image) }}" alt="Poster" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                                    @else
                                        <div class="flex items-center justify-center h-full text-gray-300 bg-gray-100/50">
                                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                    
                                    <div class="absolute top-3 left-3 z-20">
                                        <span class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-[#3d3d3d]/90 text-white text-[10px] font-extrabold tracking-wider shadow-sm backdrop-blur-sm">
                                            <svg class="w-3 h-3 mr-1 text-[#f07b32]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                                        </span>
                                    </div>
                                    

                                </div>
                                
                                <div class="p-5 flex flex-col flex-grow relative bg-white z-20">
                                    <!-- Avatar Floating (Button trigger modal) -->
                                    <button @click="openProfileModal({{ $event->user->id }})" class="absolute -top-6 right-5 border-4 border-white rounded-xl w-12 h-12 flex items-center justify-center text-lg shadow-sm transition-transform hover:scale-110 hover:shadow-md focus:outline-none z-30 font-extrabold bg-[#f5f4f0] text-[#3d3d3d]" title="Lihat Profil">
                                         {{ substr($event->user->profile->organization_name ?? $event->user->name ?? 'O', 0, 1) }}
                                    </button>

                                    <button @click="openProfileModal({{ $event->user->id }})" class="text-left inline-block mt-1 mb-1.5 text-[10px] font-bold text-gray-500 uppercase tracking-widest pr-10 truncate hover:text-[#3d3d3d] transition-colors">
                                        {{ $event->user->profile->organization_name ?? $event->user->name ?? 'Organisasi' }}
                                    </button>
                                    
                                    <h3 class="text-sm font-extrabold text-[#3d3d3d] mb-1.5 line-clamp-2 leading-tight group-hover:text-[#f07b32] transition-colors">
                                        {{ $event->title }}
                                    </h3>

                                    <div class="mb-2.5">
                                        <span class="inline-flex px-2 py-1 rounded bg-[#f5f4f0] text-gray-600 text-[9px] font-extrabold uppercase tracking-wider border border-gray-200">
                                            {{ $event->event_type }}
                                        </span>
                                    </div>
                                    
                                    <!-- Description -->
                                    <div x-data="{ expanded: false }" class="mb-5 flex-grow">
                                        <p :class="expanded ? '' : 'line-clamp-2'" class="text-xs text-gray-500 break-words leading-relaxed">
                                            {{ $event->description }}
                                        </p>
                                        @if(strlen($event->description) > 80)
                                            <button @click="expanded = !expanded" class="text-[#f07b32] text-[10px] font-bold mt-1.5 hover:text-[#d96a25] transition-colors focus:outline-none inline-flex items-center">
                                                <span x-text="expanded ? 'Sembunyikan' : 'Baca Selengkapnya'"></span>
                                                <svg x-show="!expanded" class="ml-1 w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                                <svg x-show="expanded" style="display:none;" class="ml-1 w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                            </button>
                                        @endif
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-2 pt-4 border-t border-gray-50 mt-auto">
                                        @if($event->proposal_pdf)
                                            <a href="{{ asset('storage/' . $event->proposal_pdf) }}" target="_blank" class="w-full inline-flex justify-center items-center px-2 py-2 border border-gray-200 shadow-sm text-[11px] font-bold rounded-xl text-gray-600 bg-white hover:bg-gray-50 hover:border-gray-300 transition-all focus:outline-none">
                                                Proposal
                                            </a>
                                        @else
                                            <span class="w-full inline-flex justify-center items-center px-2 py-2 border border-gray-100 text-[11px] font-bold rounded-xl text-gray-400 bg-[#f5f4f0] cursor-not-allowed">
                                                Kosong
                                            </span>
                                        @endif
                                        
                                        @if(auth()->user()->role === 'company')
                                            @if($pendingEventIds->contains($event->id))
                                                <span class="w-full inline-flex justify-center items-center gap-1.5 px-2 py-2 border border-amber-200 text-[11px] font-extrabold rounded-xl text-amber-700 bg-amber-50 cursor-not-allowed">
                                                    <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Tunggu
                                                </span>
                                            @else
                                                <button onclick="openRequestModal('event', {{ $event->id }}, '{{ addslashes($event->title) }}')" class="w-full inline-flex justify-center items-center px-2 py-2 border border-transparent shadow-sm text-[11px] font-extrabold rounded-xl text-white bg-[#3d3d3d] hover:bg-black transition-all focus:outline-none group/btn">
                                                    <svg class="mr-1.5 h-3.5 w-3.5 text-gray-400 group-hover/btn:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                    Sponsori
                                                </button>
                                            @endif
                                        @else
                                            <span class="w-full inline-flex justify-center items-center px-2 py-2 border border-transparent text-[11px] font-extrabold rounded-xl text-gray-400 bg-gray-200 cursor-not-allowed hidden">
                                                Sponsori
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-20 bg-white rounded-[2rem] border-dashed border-2 border-gray-200 shadow-sm mx-auto max-w-xl">
                            <div class="mx-auto w-16 h-16 bg-[#f5f4f0] rounded-full flex items-center justify-center mb-4">
                                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <h3 class="text-base font-extrabold text-[#3d3d3d]">Belum ada event terbuka</h3>
                            <p class="mt-2 text-xs text-gray-500 font-medium">Event yang mencari sponsor akan mendisplay ide mereka di sini.</p>
                        </div>
                    @endif
                </div>
                @endif
                
            </div>
        </main>

        <!-- Profile Modal -->
        <div x-cloak x-show="profileModalOpen" class="relative z-50" aria-labelledby="profile-modal" role="dialog" aria-modal="true">
            <div x-show="profileModalOpen" x-transition.opacity class="fixed inset-0 bg-[#3d3d3d]/50 backdrop-blur-sm transition-opacity"></div>
            
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <!-- Loading State -->
                    <template x-if="loadingProfile">
                        <div class="bg-white rounded-[2rem] p-8 flex flex-col items-center justify-center shadow-2xl">
                            <svg class="animate-spin h-8 w-8 text-[#f07b32] mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="text-sm font-bold text-gray-500">Memuat profil...</p>
                        </div>
                    </template>

                    <!-- Profile Content -->
                    <template x-if="selectedProfile">
                        <div @click.away="profileModalOpen = false" x-show="profileModalOpen" x-transition.scale.origin.bottom class="relative transform overflow-visible rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-2xl">
                            
                            <!-- Header Background -->
                            <div class="h-28 bg-gradient-to-r from-[#f0f9f8] to-[#f5f4f0] relative rounded-t-3xl">
                                <button @click="profileModalOpen = false" class="absolute top-4 right-4 text-gray-400 hover:text-[#3d3d3d] transition-colors p-1.5 bg-white/50 backdrop-blur-sm rounded-full shadow-sm z-50">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Konten Profil -->
                            <div class="px-8 pb-8">
                                <!-- Avatar & Info Dasar -->
                                <div class="flex flex-col sm:flex-row gap-5 -mt-14 mb-6 items-start sm:items-center relative z-10">
                                    <div class="w-28 h-28 rounded-2xl bg-white border-[4px] border-white shadow-lg flex items-center justify-center text-5xl font-black shrink-0" :class="selectedProfile.role === 'company' ? 'bg-[#fcf5f5] text-[#f07b32]' : 'bg-[#f5f4f0] text-[#3d3d3d]'">
                                        <span x-text="selectedProfile.initial"></span>
                                    </div>
                                    
                                    <div class="flex-1 min-w-0 pt-6">
                                        <h1 class="text-2xl font-extrabold text-[#3d3d3d] truncate leading-tight" x-text="selectedProfile.display_name"></h1>
                                        <p class="text-sm text-gray-500 font-medium mt-1 truncate" x-text="selectedProfile.name"></p>
                                    </div>
                                </div>
                                
                                <div class="flex gap-2 flex-wrap mb-6">
                                    <span class="px-2.5 py-1 rounded bg-gray-100 text-gray-500 text-[9px] font-extrabold uppercase tracking-wider border border-gray-200" x-text="selectedProfile.role">
                                    </span>
                                    <template x-if="selectedProfile.role === 'company' && selectedProfile.sector !== '-'">
                                        <span class="px-2.5 py-1 rounded bg-[#fcf5f5] text-[#f07b32] text-[9px] font-extrabold uppercase tracking-wider border border-[#f07b32]/20" x-text="selectedProfile.sector">
                                        </span>
                                    </template>
                                </div>

                                <!-- Info Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                    <!-- Email -->
                                    <div>
                                        <p class="text-gray-400 font-bold text-[10px] uppercase tracking-wider mb-0.5">Email</p>
                                        <p class="text-[13px] font-semibold text-[#3d3d3d] truncate" x-text="selectedProfile.email"></p>
                                    </div>

                                    <!-- Telepon -->
                                    <template x-if="selectedProfile.phone">
                                        <div>
                                            <p class="text-gray-400 font-bold text-[10px] uppercase tracking-wider mb-0.5">Telepon</p>
                                            <p class="text-[13px] font-semibold text-[#3d3d3d]" x-text="selectedProfile.phone"></p>
                                        </div>
                                    </template>

                                    <!-- Alamat -->
                                    <template x-if="selectedProfile.address">
                                        <div class="md:col-span-2">
                                            <p class="text-gray-400 font-bold text-[10px] uppercase tracking-wider mb-0.5">Alamat</p>
                                            <p class="text-[13px] font-semibold text-[#3d3d3d] leading-relaxed" x-text="selectedProfile.address"></p>
                                        </div>
                                    </template>
                                </div>

                                <!-- Sosmed -->
                                <div class="flex gap-4 mb-6">
                                    <template x-if="selectedProfile.instagram">
                                        <a :href="`https://instagram.com/${selectedProfile.instagram}`" target="_blank" class="text-[11px] font-extrabold text-[#f07b32] hover:text-[#d96a25] flex items-center gap-1 bg-[#f5f4f0] px-3 py-1.5 rounded-lg">📸 @<span x-text="selectedProfile.instagram"></span></a>
                                    </template>
                                    <template x-if="selectedProfile.tiktok">
                                        <a :href="`https://tiktok.com/@${selectedProfile.tiktok}`" target="_blank" class="text-[11px] font-extrabold text-[#3d3d3d] hover:text-black flex items-center gap-1 bg-[#f5f4f0] px-3 py-1.5 rounded-lg">🎵 @<span x-text="selectedProfile.tiktok"></span></a>
                                    </template>
                                </div>

                                <!-- Deskripsi -->
                                <div>
                                    <h2 class="text-gray-400 font-bold text-[10px] uppercase tracking-wider pb-1 mb-2" x-text="selectedProfile.role === 'company' ? 'TENTANG PERUSAHAAN' : 'TENTANG ORGANISASI'"></h2>
                                    <p class="text-[13px] text-gray-600 leading-relaxed max-h-40 overflow-y-auto pr-2 custom-scrollbar" x-text="selectedProfile.description"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Request Modal -->
    <div id="requestModal" class="hidden fixed inset-0 bg-[#3d3d3d]/50 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto">
            <!-- Header -->
            <div class="sticky top-0 bg-white border-b border-gray-100 p-6 flex items-center justify-between z-10">
                <div>
                    <h3 id="requestModalTitle" class="text-lg font-extrabold text-[#3d3d3d]">Ajukan Pengajuan</h3>
                    <p class="text-[11px] text-gray-500 font-medium mt-1">Target: <span id="requestModalTarget" class="font-extrabold text-[#f07b32]"></span></p>
                </div>
                <button onclick="closeRequestModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-1 bg-gray-50 rounded-full">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Form -->
            <div class="p-6">
                <form id="requestForm" class="space-y-5">
                    <input type="hidden" id="requestType" name="target_type">
                    <input type="hidden" id="requestTargetId" name="target_id">

                    <div>
                        <label class="block text-[13px] font-extrabold text-[#3d3d3d] mb-2">
                            Pilih Aset Kamu
                        </label>
                        <select id="requestAssetId" name="my_asset_id" class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-[#f07b32] focus:border-[#f07b32] focus:outline-none transition-all bg-white text-sm font-semibold text-[#3d3d3d]" required>
                            <option value="" disabled selected>-- Silakan Pilih --</option>
                        </select>
                        <p class="text-[10px] text-gray-500 font-medium mt-2">Dokumen dari aset yang dipilih akan otomatis diteruskan.</p>
                    </div>

                    <div>
                        <label class="block text-[13px] font-extrabold text-[#3d3d3d] mb-2">Pesan Pengantar</label>
                        <textarea id="requestMessage" name="message" rows="4" class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-[#f07b32] focus:border-[#f07b32] focus:outline-none transition-all resize-none text-sm font-semibold" placeholder="Halo, ini sangat cocok dengan brand Anda..." required></textarea>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="closeRequestModal()" class="flex-1 px-4 py-3.5 border border-gray-200 rounded-[1rem] text-[13px] font-extrabold text-[#3d3d3d] hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 px-4 py-3.5 bg-[#f07b32] text-white rounded-[1rem] text-[13px] font-extrabold hover:bg-[#d96a25] transition-colors shadow-sm">
                            Kirim Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script SETELAH modal agar getElementById bisa menemukan elemen -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('exploreComponent', () => ({
                activeTab: '{{ auth()->user()->role === 'company' ? 'events' : 'offers' }}',
                profileModalOpen: false,
                selectedProfile: null,
                loadingProfile: false,
                async openProfileModal(userId) {
                    this.loadingProfile = true;
                    this.profileModalOpen = true;
                    this.selectedProfile = null;
                    
                    try {
                        const response = await fetch(`/user/${userId}/profile`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });
                        const result = await response.json();
                        if (result.success) {
                            this.selectedProfile = result.data;
                        } else {
                            alert(result.message || 'Gagal memuat profil');
                            this.profileModalOpen = false;
                        }
                    } catch (error) {
                        console.error('Error fetching profile:', error);
                        alert('Terjadi kesalahan saat memuat profil');
                        this.profileModalOpen = false;
                    } finally {
                        this.loadingProfile = false;
                    }
                }
            }));
        });

        const searchInput = document.getElementById('q');
        const exploreContent = document.getElementById('exploreContent');
        let searchTimeout;

        function replaceExploreContent(html) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newContent = doc.getElementById('exploreContent');
            if (newContent && exploreContent) {
                exploreContent.innerHTML = newContent.innerHTML;
                if (window.Alpine) {
                    window.Alpine.initTree(exploreContent);
                }
            }
        }

        function updateSearch() {
            const query = searchInput.value.trim();
            const url = new URL('{{ route('explore.index') }}', window.location.origin);

            if (query) {
                url.searchParams.set('q', query);
            }

            const eventTypeFilter = document.getElementById('eventTypeFilter');
            const fundingTypeFilter = document.getElementById('fundingTypeFilter');
            
            if (eventTypeFilter && eventTypeFilter.value) {
                url.searchParams.set('event_type', eventTypeFilter.value);
            }
            if (fundingTypeFilter && fundingTypeFilter.value) {
                url.searchParams.set('funding_type', fundingTypeFilter.value);
            }

            fetch(url.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.text())
                .then(html => {
                    replaceExploreContent(html);
                    window.history.replaceState({}, '', url.toString());
                    searchInput.focus();
                    const len = searchInput.value.length;
                    searchInput.setSelectionRange(len, len);
                })
                .catch(() => {
                    if (!query) {
                        window.location.href = url.toString();
                    }
                });
        }

        function handleSearchInput() {
            if (searchTimeout) {
                clearTimeout(searchTimeout);
            }
            searchTimeout = setTimeout(updateSearch, 700);
        }

        function applyFilters() {
            const url = new URL('{{ route('explore.index') }}', window.location.origin);
            const query = searchInput?.value.trim();
            
            if (query) {
                url.searchParams.set('q', query);
            }

            const eventTypeFilter = document.getElementById('eventTypeFilter');
            const fundingTypeFilter = document.getElementById('fundingTypeFilter');
            
            if (eventTypeFilter && eventTypeFilter.value) {
                url.searchParams.set('event_type', eventTypeFilter.value);
            }
            if (fundingTypeFilter && fundingTypeFilter.value) {
                url.searchParams.set('funding_type', fundingTypeFilter.value);
            }

            window.location.href = url.toString();
        }

        searchInput?.addEventListener('input', handleSearchInput);

        document.getElementById('eventTypeFilter')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') applyFilters();
        });
        document.getElementById('fundingTypeFilter')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') applyFilters();
        });

        // Request Modal Functions
        let currentRequestData = { type: null, targetId: null, targetTitle: null };

        function openRequestModal(type, targetId, targetTitle) {
            currentRequestData = { type, targetId, targetTitle };
            document.getElementById('requestModalTitle').textContent = type === 'offer' 
                ? 'Ajukan Proposal Sponsor' 
                : 'Tawarkan Program Sponsor';
            document.getElementById('requestModalTarget').innerHTML = `<strong>${targetTitle}</strong>`;
            document.getElementById('requestType').value = type;
            document.getElementById('requestTargetId').value = targetId;
            document.getElementById('requestMessage').value = '';
            loadAssets(type);
            document.getElementById('requestModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeRequestModal() {
            document.getElementById('requestModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function loadAssets(type) {
            const targetId = currentRequestData.targetId;
            const endpoint = `/request/create/${type}/${targetId}`;
            const submitBtn = document.querySelector('#requestForm button[type="submit"]');
            
            // Reset submit button
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            
            fetch(endpoint, {
                headers: { 
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('requestAssetId');
                
                if (data.success && Array.isArray(data.assets) && data.assets.length > 0) {
                    select.innerHTML = '<option value="" disabled selected>-- Silakan Pilih --</option>';
                    data.assets.forEach(asset => {
                        select.innerHTML += `<option value="${asset.id}">${asset.title}</option>`;
                    });
                } else {
                    // Tampilkan pesan error dari server atau default
                    const msg = data.message || 'Tidak ada aset tersedia';
                    select.innerHTML = `<option value="" disabled selected>${msg}</option>`;
                    // Disable submit button
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            })
            .catch(error => {
                console.error('Error loading assets:', error);
                document.getElementById('requestAssetId').innerHTML = '<option value="" disabled selected>Gagal memuat data</option>';
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            });
        }

        // Event listener untuk submit form
        document.getElementById('requestForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const type = document.getElementById('requestType').value;
            const assetId = document.getElementById('requestAssetId').value;
            const message = document.getElementById('requestMessage').value;

            if (!assetId || !message.trim()) {
                showErrorToast('Mohon isi semua field!');
                return;
            }

            const formData = new FormData();
            formData.append('target_type', type);
            formData.append('target_id', currentRequestData.targetId);
            formData.append('my_asset_id', assetId);
            formData.append('message', message);

            fetch('{{ route("request.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccessToast('Pengajuan berhasil dikirim!');
                    closeRequestModal();
                } else {
                    showErrorToast(data.message || 'Terjadi kesalahan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorToast('Gagal mengirim pengajuan');
            });
        });

        function showSuccessToast(message) {
            const toastId = 'toast-success-' + Date.now();
            const toastHtml = `
                <div id="${toastId}" class="fixed top-20 right-8 z-50 bg-[#f0f9f8] border border-teal-200 px-6 py-4 rounded-3 shadow-lg flex items-center gap-3 transition-all duration-500 transform translate-y-0 opacity-100">
                    <div class="bg-teal-100 p-1.5 rounded-full">
                        <svg class="w-5 h-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-[13px] text-teal-800">Berhasil!</h4>
                        <p class="text-[11px] font-medium text-teal-600">${message}</p>
                    </div>
                    <button onclick="closeSuccessToast('${toastId}')" class="ml-4 text-teal-400 hover:text-teal-600 transition-colors bg-teal-50 rounded-full p-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', toastHtml);
            setTimeout(() => closeSuccessToast('${toastId}'), 4000);
        }

        function closeSuccessToast(toastId) {
            const toast = document.getElementById(toastId);
            if(toast) {
                toast.classList.replace('translate-y-0', '-translate-y-4');
                toast.classList.replace('opacity-100', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }
        }

        function showErrorToast(message) {
            const toastId = 'toast-error-' + Date.now();
            const toastHtml = `
                <div id="${toastId}" class="fixed top-20 right-8 z-50 bg-red-50 border border-red-200 px-6 py-4 rounded-3 shadow-lg flex items-center gap-3 transition-all duration-500 transform translate-y-0 opacity-100">
                    <div class="bg-red-100 p-1.5 rounded-full">
                        <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-[13px] text-red-800">Perhatian!</h4>
                        <p class="text-[11px] font-medium text-red-600">${message}</p>
                    </div>
                    <button onclick="closeErrorToast('${toastId}')" class="ml-4 text-red-400 hover:text-red-600 transition-colors bg-red-100 rounded-full p-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', toastHtml);
            setTimeout(() => closeErrorToast('${toastId}'), 4000);
        }

        function closeErrorToast(toastId) {
            const toast = document.getElementById(toastId);
            if(toast) {
                toast.classList.replace('translate-y-0', '-translate-y-4');
                toast.classList.replace('opacity-100', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }
        }

        // Close modal on outside click
        document.getElementById('requestModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRequestModal();
            }
        });
    </script>

@endsection