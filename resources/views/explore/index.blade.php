<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eksplorasi - Sponsorea</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-white to-slate-50 text-slate-800">

    @include('components.navbar-app')

<div x-data="{ activeTab: '{{ auth()->user()->role === 'company' ? 'events' : 'offers' }}' }" class="min-h-screen">
    <!-- Hero Section -->
    <div class="relative pt-16 pb-12">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-indigo-100 opacity-30 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-20 -left-40 w-72 h-72 bg-teal-100 opacity-20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center">
            <h1 class="text-4xl sm:text-5xl font-black text-slate-900 mb-3">Jelajahi Peluang</h1>
            <p class="text-slate-500 text-lg mb-8">Temukan event atau sponsor yang sempurna untuk kolaborasi Anda</p>
            
            <!-- Search Input with Icon -->
            <div class="relative max-w-2xl mx-auto">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input id="q" name="q" type="search" value="{{ old('q', $query ?? '') }}" placeholder="Cari event, penawaran, atau organisasi..." class="w-full pl-12 pr-5 py-3.5 rounded-2xl border border-slate-200 bg-white text-slate-700 shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent placeholder:text-slate-400 transition-all duration-200" autofocus />
            </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-6 py-8">
        <!-- Error & Success Messages -->
        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <p class="text-sm font-bold">{{ session('error') }}</p>
                </div>
                @if(auth()->user()->role === 'event')
                    <a href="{{ route('event.index') }}" class="px-3 py-1.5 bg-red-100 hover:bg-red-200 rounded-lg text-xs font-bold transition-colors shrink-0">
                        Buat Event
                    </a>
                @else
                    <a href="{{ route('company.index') }}" class="px-3 py-1.5 bg-red-100 hover:bg-red-200 rounded-lg text-xs font-bold transition-colors shrink-0">
                        Buat Penawaran
                    </a>
                @endif
            </div>
        @endif
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-teal-50 text-teal-700 font-semibold border border-teal-100 flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Tab Navigation -->
        <div class="mb-8 flex flex-wrap gap-3 justify-center">
            @if(auth()->user()->role === 'event' || auth()->user()->role === 'admin')
                <button 
                    @click="activeTab = 'offers'" 
                    :class="activeTab === 'offers' ? 'bg-indigo-600 text-white shadow-lg' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-300'"
                    class="px-6 py-2.5 rounded-full font-semibold text-sm transition-all duration-200"
                >
                    Cari Sponsor
                </button>
            @endif
            
            @if(auth()->user()->role === 'company')
                <button 
                    @click="activeTab = 'events'" 
                    :class="activeTab === 'events' ? 'bg-indigo-600 text-white shadow-lg' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-300'"
                    class="px-6 py-2.5 rounded-full font-semibold text-sm transition-all duration-200"
                >
                    Cari Event
                </button>
            @elseif(auth()->user()->role === 'event' || auth()->user()->role === 'admin')
                <button 
                    @click="activeTab = 'events'" 
                    :class="activeTab === 'events' ? 'bg-indigo-600 text-white shadow-lg' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-300'"
                    class="px-6 py-2.5 rounded-full font-semibold text-sm transition-all duration-200"
                >
                    Lihat Event Lainnya
                </button>
            @endif
        </div>

        <!-- Filter Section -->
        <div class="mb-8 bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="flex flex-wrap gap-4 items-end">
                @if(auth()->user()->role === 'event' || auth()->user()->role === 'admin')
                    <div class="flex-1 min-w-64">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Filter Jenis Pendanaan</label>
                        <select id="fundingTypeFilter" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-700 bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">-- Semua Jenis Pendanaan --</option>
                            @foreach($fundingTypes as $type)
                                <option value="{{ $type->name }}" {{ $fundingType === $type->name ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                @if(auth()->user()->role === 'company' || auth()->user()->role === 'event' || auth()->user()->role === 'admin')
                    <div class="flex-1 min-w-64">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Filter Jenis Event</label>
                        <select id="eventTypeFilter" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-700 bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">-- Semua Jenis Event --</option>
                            @foreach($eventTypes as $type)
                                <option value="{{ $type->name }}" {{ $eventType === $type->name ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <button type="button" onclick="applyFilters()" class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
                    Terapkan Filter
                </button>

                @if($eventType || $fundingType)
                    <a href="{{ route('explore.index') }}" class="bg-slate-200 text-slate-700 px-6 py-2.5 rounded-lg font-semibold hover:bg-slate-300 transition-colors">
                        Reset Filter
                    </a>
                @endif
            </div>
        </div>

        <div id="exploreContent">
            <!-- PROGRAM SPONSORSHIP TAB -->
            @if(auth()->user()->role === 'event' || auth()->user()->role === 'admin')
                <section x-show="activeTab === 'offers'" x-transition class="space-y-8">
                    @if($offers->count() > 0)
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900 mb-2">Program Sponsorship Tersedia</h2>
                            <p class="text-slate-500 text-sm">{{ $offers->count() }} peluang sponsor menanti Anda</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                            @foreach($offers as $offer)
                                <div class="group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:border-indigo-200 hover:shadow-xl transition-all duration-300 flex flex-col h-full">
                                    
                                    <!-- Image Section with Badge -->
                                    <div class="relative h-44 overflow-hidden bg-gradient-to-br from-indigo-50 to-blue-50">
                                        @if($offer->banner_image)
                                            <img src="{{ asset('storage/' . $offer->banner_image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="flex items-center justify-center h-full">
                                                <div class="text-center">
                                                    <svg class="w-12 h-12 text-indigo-200 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    <p class="text-indigo-300 text-xs font-semibold">Sponsor Banner</p>
                                                </div>
                                            </div>
                                        @endif
                                        <!-- Badge -->
                                        <div class="absolute top-3 right-3">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-indigo-600 text-white text-xs font-bold shadow-lg">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M8.5 7c1.657 0 3-1.343 3-3S10.157 1 8.5 1 5.5 2.343 5.5 4 6.843 7 8.5 7zm0 2c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm6.5-11C11.12.5 9.5 2.12 9.5 4S11.12 7.5 13 7.5 16.5 5.88 16.5 4 14.88-10.5 13-10.5z"></path></svg>
                                                {{ $offer->funding_type }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Content Section -->
                                    <div class="p-6 flex flex-col flex-1">
                                        <!-- Organizer -->
                                        <a href="{{ route('user.profile.show', $offer->user->id) }}" class="flex items-center gap-3 mb-4 group/user">
                                            <div class="w-11 h-11 rounded-full bg-gradient-to-br from-indigo-100 to-blue-100 text-indigo-700 flex items-center justify-center font-bold border-2 border-indigo-200 group-hover/user:border-indigo-400 transition-colors">
                                                {{ substr($offer->user->profile->company_name ?? $offer->user->name ?? 'C', 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-900 group-hover/user:text-indigo-600 transition-colors">{{ $offer->user->profile->company_name ?? $offer->user->name ?? 'Company' }}</p>
                                                <p class="text-xs text-slate-400 font-medium">{{ $offer->created_at->diffForHumans() }}</p>
                                            </div>
                                        </a>

                                        <!-- Title -->
                                        <h3 class="text-lg font-bold text-slate-900 mb-3 line-clamp-2 group-hover:text-indigo-600 transition-colors">{{ $offer->title }}</h3>

                                        <!-- Description -->
                                        <div x-data="{ expanded: false }" class="mb-5 flex-1">
                                            <p :class="expanded ? '' : 'line-clamp-2'" class="text-slate-600 text-sm leading-relaxed transition-all duration-300">
                                                {{ $offer->description }}
                                            </p>
                                            @if(strlen($offer->description) > 80)
                                                <button @click="expanded = !expanded" class="text-indigo-600 text-xs font-semibold mt-2 hover:text-indigo-700 focus:outline-none">
                                                    <span x-text="expanded ? '▲ Sembunyikan' : '▼ Baca Lebih'"></span>
                                                </button>
                                            @endif
                                        </div>

                                        <!-- Divider -->
                                        <div class="border-t border-slate-100 pt-4 mt-auto flex gap-2">
                                            @if($offer->guideline_pdf)
                                                <a href="{{ asset('storage/' . $offer->guideline_pdf) }}" target="_blank" class="flex-1 bg-slate-50 hover:bg-slate-100 text-slate-700 font-semibold py-2.5 rounded-lg text-xs text-center transition-colors">
                                                    Guideline
                                                </a>
                                            @endif
                                            @if(auth()->user()->role !== 'admin')
                                                <a href="{{ route('request.create', ['type' => 'offer', 'id' => $offer->id]) }}" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg text-xs text-center transition-all hover:shadow-lg hover:-translate-y-0.5">
                                                    Ajukan
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="py-16 px-6 text-center">
                            <div class="inline-block mb-4">
                                <svg class="w-16 h-16 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2">Belum ada penawaran sponsor</h3>
                            <p class="text-slate-500 text-sm mb-6">Pantau halaman ini untuk peluang sponsorship terbaru</p>
                            <a href="{{ route('event.index') }}" class="inline-block px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors text-sm">
                                Buat Event Anda
                            </a>
                        </div>
                    @endif
                </section>
            @endif

            <!-- MARKETPLACE EVENT TAB -->
            @if(auth()->user()->role === 'company' || auth()->user()->role === 'event' || auth()->user()->role === 'admin')
                <section x-show="activeTab === 'events'" x-transition class="space-y-8">
                    @if($events->count() > 0)
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900 mb-2">Event Mencari Sponsor</h2>
                            <p class="text-slate-500 text-sm">{{ $events->count() }} event siap untuk kolaborasi</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                            @foreach($events as $event)
                                <div class="group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:border-indigo-200 hover:shadow-xl transition-all duration-300 flex flex-col h-full">
                                    
                                    <!-- Image Section with Badge -->
                                    <div class="relative h-44 overflow-hidden bg-gradient-to-br from-indigo-50 to-blue-50">
                                        @if($event->poster_image)
                                            <img src="{{ asset('storage/' . $event->poster_image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="flex items-center justify-center h-full">
                                                <div class="text-center">
                                                    <svg class="w-12 h-12 text-indigo-200 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    <p class="text-indigo-300 text-xs font-semibold">Event Poster</p>
                                                </div>
                                            </div>
                                        @endif
                                        <!-- Badge -->
                                        <div class="absolute top-3 right-3">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-indigo-600 text-white text-xs font-bold shadow-lg">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5.75A.75.75 0 016.25 0h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 015.5.75zM3 6a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V6zm12 1.75a.75.75 0 000 1.5h.008a.75.75 0 000-1.5H15zm.375 2.5a.375.375 0 100-.75.375.375 0 00.75zM15 12.75a.75.75 0 000 1.5h.008a.75.75 0 000-1.5H15zm0 2a.75.75 0 000 1.5h.008a.75.75 0 000-1.5H15z"></path></svg>
                                                {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d M Y') }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Content Section -->
                                    <div class="p-6 flex flex-col flex-1">
                                        <!-- Organizer -->
                                        <a href="{{ route('user.profile.show', $event->user->id) }}" class="flex items-center gap-3 mb-4 group/user">
                                            <div class="w-11 h-11 rounded-full bg-gradient-to-br from-indigo-100 to-blue-100 text-indigo-700 flex items-center justify-center font-bold border-2 border-indigo-200 group-hover/user:border-indigo-400 transition-colors">
                                                {{ substr($event->user->profile->organization_name ?? $event->user->name ?? 'O', 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-900 group-hover/user:text-indigo-600 transition-colors">{{ $event->user->profile->organization_name ?? $event->user->name ?? 'User' }}</p>
                                                <p class="text-xs text-slate-400 font-medium">{{ $event->created_at->diffForHumans() }}</p>
                                            </div>
                                        </a>

                                        <!-- Title -->
                                        <h3 class="text-lg font-bold text-slate-900 mb-3 line-clamp-2 group-hover:text-indigo-600 transition-colors">{{ $event->title }}</h3>

                                        <!-- Description -->
                                        <div x-data="{ expanded: false }" class="mb-5 flex-1">
                                            <p :class="expanded ? '' : 'line-clamp-2'" class="text-slate-600 text-sm leading-relaxed transition-all duration-300">
                                                {{ $event->description }}
                                            </p>
                                            @if(strlen($event->description) > 80)
                                                <button @click="expanded = !expanded" class="text-indigo-600 text-xs font-semibold mt-2 hover:text-indigo-700 focus:outline-none">
                                                    <span x-text="expanded ? '▲ Sembunyikan' : '▼ Baca Lebih'"></span>
                                                </button>
                                            @endif
                                        </div>

                                        <!-- Divider -->
                                        <div class="border-t border-slate-100 pt-4 mt-auto flex gap-2">
                                            @if($event->proposal_pdf)
                                                <a href="{{ asset('storage/' . $event->proposal_pdf) }}" target="_blank" class="flex-1 bg-slate-50 hover:bg-slate-100 text-slate-700 font-semibold py-2.5 rounded-lg text-xs text-center transition-colors">
                                                    Proposal
                                                </a>
                                            @endif
                                            
                                            @if(auth()->user()->role === 'company')
                                                <a href="{{ route('request.create', ['type' => 'event', 'id' => $event->id]) }}" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg text-xs text-center transition-all hover:shadow-lg hover:-translate-y-0.5">
                                                    ✨ Beri Sponsor
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="py-16 px-6 text-center">
                            <div class="inline-block mb-4">
                                <svg class="w-16 h-16 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2">Belum ada event terbuka</h3>
                            <p class="text-slate-500 text-sm mb-6">Pantau halaman ini untuk peluang event terbaru</p>
                            <a href="{{ route('company.index') }}" class="inline-block px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors text-sm">
                                Buat Penawaran Sponsor
                            </a>
                        </div>
                    @endif
                </section>
            @endif
        </div>
    </main>
</div>

<script>
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

        // Preserve filter parameters
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

    // Allow Enter key on filter inputs
    document.getElementById('eventTypeFilter')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') applyFilters();
    });
    document.getElementById('fundingTypeFilter')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') applyFilters();
    });
</script>
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9; 
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1; 
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8; 
    }
</style>

</body>
</html>