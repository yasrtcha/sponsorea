<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Sponsorea</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
</head>
<body class="bg-[#f5f4f0] text-[#3d3d3d] flex h-screen overflow-hidden text-sm">

    <aside class="w-56 bg-white border-r border-gray-200 flex flex-col transition-all duration-300 z-20 shrink-0">
        <div class="h-16 flex items-center px-6 border-b border-gray-100">
            <a href="{{ route('explore.index') }}" class="text-xl font-extrabold flex items-center gap-2 text-[#3d3d3d] hover:text-[#f07b32] transition-colors">
                <svg class="w-6 h-6 text-[#f07b32]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                sponsorea
            </a>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            @include('layouts.sidebar')
        </nav>
    </aside>

    <div class="flex-1 flex flex-col relative overflow-hidden w-full">
        
        <header class="h-16 bg-white/80 backdrop-blur-md border-b border-gray-200 flex items-center justify-between px-6 z-30 shrink-0">
            <div class="flex items-center">
                <h1 class="text-lg font-bold text-[#3d3d3d]">@yield('page_title', 'Overview')</h1>
            </div>

            <div class="flex items-center gap-4">
                <div class="relative" x-data="{ notifOpen: false }">
                    <button @click="notifOpen = !notifOpen" @click.away="notifOpen = false" class="relative p-1.5 text-gray-400 hover:text-[#f07b32] transition-colors focus:outline-none">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        @if(auth()->user()->unreadNotifications()->count() > 0)
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 border-2 border-white rounded-full"></span>
                        @endif
                    </button>

                    <!-- Notification Modal -->
                    <div x-show="notifOpen" x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 transform translate-y-0"
                         x-transition:leave-end="opacity-0 transform -translate-y-2"
                         class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 max-h-[500px] flex flex-col">
                        
                        <!-- Header -->
                        <div class="p-3 border-b border-gray-100 flex items-center justify-between shrink-0">
                            <h3 class="text-sm font-bold text-[#3d3d3d]">Notifikasi</h3>
                            <button @click="notifOpen = false" class="p-1 text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 overflow-y-auto">
                            @php
                                $unreadNotifications = auth()->user()->unreadNotifications()->count();
                                $allNotifications = auth()->user()->notifications()->latest()->limit(10)->get();
                            @endphp

                            @if($allNotifications->count() > 0)
                                <div class="divide-y divide-gray-50">
                                    @foreach($allNotifications as $notification)
                                        <div class="p-3 hover:bg-gray-50 transition-colors {{ !$notification->read_at ? 'bg-[#fcf5f5]' : '' }}">
                                            <div class="flex gap-2.5">
                                                <!-- Avatar -->
                                                <div class="flex-shrink-0">
                                                    <div class="w-8 h-8 rounded-full bg-[#f07b32] text-white flex items-center justify-center text-xs font-bold">
                                                        {{ substr($notification->data['name'] ?? 'N', 0, 1) }}
                                                    </div>
                                                </div>

                                                <!-- Content -->
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-xs font-semibold text-[#3d3d3d]">
                                                        <span class="text-[#e27d32]">{{ $notification->data['name'] ?? 'Sistem' }}</span>
                                                        <span class="text-gray-600 font-normal">{{ $notification->data['action'] ?? 'mengirim notifikasi' }}</span>
                                                    </p>
                                                    <p class="text-xs text-gray-600 mt-0.5">{{ $notification->data['message'] ?? '' }}</p>
                                                    <p class="text-[10px] text-gray-400 mt-1.5">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>

                                                <!-- Action -->
                                                <div class="flex-shrink-0 flex items-start gap-1">
                                                    @if(!$notification->read_at)
                                                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="p-1 text-gray-400 hover:text-[#f07b32] hover:bg-[#fcf5f5] rounded transition-colors" title="Tandai sebagai dibaca">
                                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('notifications.delete', $notification->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus notifikasi ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-1 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors" title="Hapus">
                                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-6 text-center">
                                    <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <p class="text-gray-500 font-bold text-sm">Tidak ada notifikasi</p>
                                    <p class="text-gray-400 text-xs mt-1">Semua notifikasi Anda akan muncul di sini</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="h-6 w-px bg-gray-200 hidden sm:block"></div>

                <div class="relative" x-data="{ open: false }">
                    
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 p-1 pr-3 rounded-full hover:bg-gray-100 transition-all border border-transparent hover:border-gray-200 focus:outline-none">
                        <div class="w-8 h-8 rounded-full bg-[#3d3d3d] text-white flex items-center justify-center font-bold text-xs shadow-sm">
                            {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                        </div>
                        <div class="text-left hidden sm:block">
                            <p class="text-[13px] font-bold text-[#3d3d3d] leading-none">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-gray-500 capitalize font-medium mt-0.5">{{ auth()->user()->role }}</p>
                        </div>
                        <svg class="w-3.5 h-3.5 text-gray-400 transition-transform duration-200 ml-1" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" x-cloak
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-[1rem] shadow-xl border border-gray-100 py-1.5 z-50">
                        
                        <div class="px-4 py-2 border-b border-gray-50 mb-1">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Menu Utama</p>
                        </div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-[13px] font-bold text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Log out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 bg-[#f5f4f0] z-10 relative">
            <div class="max-w-6xl mx-auto space-y-5">
                @yield('content')
            </div>
        </main>
        
    </div>

</body>
</html>