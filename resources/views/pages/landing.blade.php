<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

@extends('layouts.app')

@section('title', 'Sponsorea - Platform Kemitraan Event & Sponsor')
@section('hide_navbar', true)

@section('content')

<div class="bg-[#ffffff] min-h-screen selection:bg-[#f07b32] selection:text-white overflow-hidden pb-12">
    
    <!-- Top Action Buttons -->
    <div class="absolute top-0 right-0 p-6 z-50 flex gap-3">
        @if(auth()->check())
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="px-6 py-2.5 text-[#3d3d3d] font-bold rounded-full hover:bg-white/40 transition-all text-sm backdrop-blur-sm">
                    Logout
                </button>
            </form>
            <a href="{{ auth()->user()->role === 'event' ? route('event.dashboard') : (auth()->user()->role === 'company' ? route('company.dashboard') : route('explore.index')) }}" class="px-6 py-2.5 bg-[#f07b32] text-white font-bold rounded-full hover:bg-[#d96a25] transition-all text-sm shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="px-6 py-2.5 text-[#3d3d3d] font-bold rounded-full hover:bg-white/40 transition-all text-sm backdrop-blur-sm">
                Login
            </a>
            <a href="{{ route('register') }}" class="px-6 py-2.5 bg-[#f07b32] text-white font-bold rounded-full hover:bg-[#d96a25] transition-all text-sm shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                Daftar
            </a>
        @endif
    </div>

    <!-- Hero Section -->
    <section class="relative pt-24 pb-12 px-6 overflow-hidden">
        <div class="max-w-5xl mx-auto">
            <!-- Badge -->
            <div class="flex justify-center mb-6">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-gray-200 text-xs font-bold text-[#e27d32] tracking-wide uppercase shadow-sm">
                    <span class="w-2 h-2 bg-[#f07b32] rounded-full animate-pulse"></span>
                    Sponsorea - Solusi Kemitraan Event & Sponsor Terpercaya
                </div>
            </div>

            <!-- Main Headline -->
            <h1 class="text-4xl md:text-6xl font-extrabold text-[#3d3d3d] text-center tracking-tight leading-[1.2] mb-6">
                Temukan Kolaborasi<br>
                <span class="text-[#f07b32]">Event & Sponsor</span>
            </h1>

            <!-- Subheading -->
            <p class="text-base md:text-lg text-gray-500 text-center mb-10 max-w-2xl mx-auto leading-relaxed font-medium">
                Platform terpercaya untuk menghubungkan event berkualitas dengan sponsor yang relevan, dan sebaliknya. Wujudkan kemitraan yang sukses.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                <a href="{{ route('register') }}" class="px-8 py-3.5 bg-[#f07b32] text-white font-bold rounded-full hover:bg-[#d96a25] transition-all text-center text-sm shadow-md hover:shadow-lg hover:-translate-y-0.5 transform">
                    Mulai Gratis Sekarang
                </a>
                <a href="#fitur" class="px-8 py-3.5 bg-white text-[#3d3d3d] font-bold border border-gray-200 rounded-full hover:bg-gray-50 transition-all text-center text-sm shadow-sm hover:shadow-md hover:-translate-y-0.5 transform">
                    Pelajari Fitur
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-12 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-extrabold text-[#3d3d3d] mb-4">Fitur Unggulan Kami</h2>
                <p class="text-sm md:text-base font-medium text-gray-500 max-w-2xl mx-auto">Kelengkapan solusi untuk mengelola kerjasama sponsor dengan mudah</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group bg-white rounded-[2rem] p-8 shadow-xl hover:-translate-y-1 transition-all duration-300 border border-transparent hover:border-[#f07b32]/20 relative overflow-hidden">
                    <div class="inline-flex w-14 h-14 items-center justify-center bg-[#f5f4f0] rounded-2xl mb-6 group-hover:bg-[#f07b32] group-hover:text-white text-[#f07b32] transition-colors">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#3d3d3d] mb-3">Manajemen Terpusat</h3>
                    <p class="text-sm font-medium text-gray-500 leading-relaxed">
                        Ajukan dan terima proposal atau penawaran sponsor dalam satu platform yang mudah digunakan.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="group bg-white rounded-[2rem] p-8 shadow-xl hover:-translate-y-1 transition-all duration-300 border border-transparent hover:border-[#f07b32]/20 relative overflow-hidden">
                    <div class="inline-flex w-14 h-14 items-center justify-center bg-[#f5f4f0] rounded-2xl mb-6 group-hover:bg-[#f07b32] group-hover:text-white text-[#f07b32] transition-colors">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#3d3d3d] mb-3">Katalog Peluang</h3>
                    <p class="text-sm font-medium text-gray-500 leading-relaxed">
                        Jelajahi daftar event dan program sponsor, lalu filter sesuai kebutuhan spesifik Anda.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="group bg-white rounded-[2rem] p-8 shadow-xl hover:-translate-y-1 transition-all duration-300 border border-transparent hover:border-[#f07b32]/20 relative overflow-hidden">
                    <div class="inline-flex w-14 h-14 items-center justify-center bg-[#f5f4f0] rounded-2xl mb-6 group-hover:bg-[#f07b32] group-hover:text-white text-[#f07b32] transition-colors">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#3d3d3d] mb-3">Dashboard Analytics</h3>
                    <p class="text-sm font-medium text-gray-500 leading-relaxed">
                        Pantau status kerjasama dan performa dengan visualisasi data yang jelas dan mudah dipahami.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 px-6">
        <div class="max-w-5xl mx-auto">
            <div class="bg-[#f07b32] relative rounded-[2rem] shadow-xl overflow-hidden p-12 md:p-16 text-center text-white flex flex-col items-center justify-center">
                <!-- Graphic Accents matching auth pages -->
                <div class="absolute -top-16 -right-16 w-64 h-64 bg-white opacity-20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-black opacity-10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10">
                    <h2 class="text-3xl md:text-5xl font-extrabold mb-6 tracking-tight leading-tight">Siap Mengubah Cara Anda <br> Menjalin Kemitraan?</h2>
                    <p class="text-sm md:text-base text-white/90 mb-10 max-w-2xl mx-auto font-medium leading-relaxed">
                        Bergabunglah dengan ratusan event organizer dan perusahaan yang telah merasakan kemudahan mengelola kemitraan melalui Sponsorea.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}" class="px-8 py-3.5 bg-white text-[#f07b32] font-bold rounded-full hover:bg-[#f5f4f0] transition-all transform hover:-translate-y-0.5 text-sm">
                            Daftar Sekarang - Gratis
                        </a>
                        <a href="{{ route('login') }}" class="px-8 py-3.5 bg-white/20 text-white font-bold rounded-full border border-white/20 hover:bg-white/30 transition-all backdrop-blur-sm transform hover:-translate-y-0.5 text-sm">
                            Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection