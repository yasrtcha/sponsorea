<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Sponsorea</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Mencegah dropdown berkedip saat pertama diload */
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 flex h-screen overflow-hidden">

    <aside class="w-64 bg-indigo-700 text-white flex flex-col transition-all duration-300 z-20 shrink-0">
        <div class="h-20 flex items-center px-8 border-b border-indigo-800/50">
            <a href="{{ route('explore.index') }}" class="text-2xl font-bold flex items-center gap-2 text-white">
                <svg class="w-8 h-8 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                Sponsorea
            </a>
        </div>

        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
            @include('layouts.sidebar')
        </nav>
    </aside>

    <div class="flex-1 flex flex-col relative overflow-hidden w-full">
        
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-8 z-30 shrink-0">
            <div class="flex items-center">
                <h1 class="text-xl font-bold text-slate-800">@yield('page_title', 'Overview')</h1>
            </div>

            <div class="flex items-center gap-6">
                <button class="relative p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
                </button>

                <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>

                <div class="relative" x-data="{ open: false }">
                    
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 p-1 pr-4 rounded-full hover:bg-slate-100 transition-all border border-transparent hover:border-slate-200 focus:outline-none">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-600 to-blue-500 text-white flex items-center justify-center font-bold shadow-sm">
                            {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                        </div>
                        <div class="text-left hidden sm:block">
                            <p class="text-sm font-bold text-slate-700 leading-none">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500 capitalize">{{ auth()->user()->role }}</p>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                         class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50">
                        
                        <div class="px-4 py-2 border-b border-slate-50 mb-2">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Menu Utama</p>
                        </div>

                        @if(auth()->user()->isEvent())
                            <a href="{{ route('explore.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                Kembali ke Explore
                            </a>
                        @else
                            <a href="{{ route('explore.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                Kembali ke Explore
                            </a>
                        @endif

                        <div class="border-t border-slate-50 my-2"></div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-slate-50 z-10 relative">
            <div class="max-w-7xl mx-auto space-y-6">
                @yield('content')
            </div>
        </main>
        
    </div>

</body>
</html>