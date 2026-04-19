<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

@extends('layouts.app')

@section('title', 'Sponsorea - Platform Kemitraan Event & Sponsor')

@section('content')

@include('components.navbar')

<div class="bg-gradient-to-b from-slate-50 via-white to-slate-50 min-h-screen selection:bg-indigo-600 selection:text-white overflow-hidden">
    
    <!-- Hero Section -->
    <section class="relative pt-24 pb-4 px-6 overflow-hidden">
        <div class="max-w-5xl mx-auto">
            <!-- Badge -->
            <div class="flex justify-center mb-6">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 text-xs font-semibold text-indigo-600 tracking-wide uppercase">
                    <span class="w-1.5 h-1.5 bg-indigo-600 rounded-full animate-pulse"></span>
                    Platform Kemitraan Terdepan
                </div>
            </div>

            <!-- Main Headline -->
            <h1 class="text-4xl md:text-5xl font-bold text-center tracking-tight leading-[1.2] mb-5">
                Temukan Sponsor<br>
                <span class="text-indigo-600">Impian Anda</span>
            </h1>

            <!-- Subheading -->
            <p class="text-base md:text-lg text-slate-600 text-center mb-10 max-w-2xl mx-auto leading-relaxed font-normal">
                Platform terpercaya untuk menghubungkan event berkualitas dengan sponsor yang tepat. Kelola proposal dan raih dukungan dengan mudah.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 justify-center mb-12">
                <a href="{{ route('register') }}" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-100 transition-all text-center text-sm">
                    Mulai Gratis Sekarang
                </a>
                <a href="#fitur" class="px-6 py-3 bg-white text-indigo-600 font-semibold border border-slate-200 rounded-xl hover:bg-slate-50 transition-all text-center text-sm">
                    Pelajari Fitur
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="pt-2 pb-16 px-6">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mb-3">Fitur Unggulan Kami</h2>
                <p class="text-sm md:text-base text-slate-600 max-w-2xl mx-auto">Kelengkapan solusi untuk mengelola kerjasama sponsor dengan mudah</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="group bg-white rounded-2xl p-6 border border-slate-100 hover:border-indigo-200 hover:shadow-md hover:shadow-indigo-100/30 transition-all duration-300">
                    <div class="inline-flex w-12 h-12 items-center justify-center bg-indigo-50 rounded-xl mb-4 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Manajemen Proposal</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Unggah dan kelola proposal dalam satu platform terpusat.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="group bg-white rounded-2xl p-6 border border-slate-100 hover:border-indigo-200 hover:shadow-md hover:shadow-indigo-100/30 transition-all duration-300">
                    <div class="inline-flex w-12 h-12 items-center justify-center bg-indigo-50 rounded-xl mb-4 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Katalog Sponsor</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Jelajahi daftar lengkap perusahaan dengan budget aktif dan filter sesuai kebutuhan.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="group bg-white rounded-2xl p-6 border border-slate-100 hover:border-indigo-200 hover:shadow-md hover:shadow-indigo-100/30 transition-all duration-300">
                    <div class="inline-flex w-12 h-12 items-center justify-center bg-indigo-50 rounded-xl mb-4 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Dashboard Analytics</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Pantau progress real-time dengan visualisasi data yang jelas dan laporan komprehensif.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 pt-2 px-6">
        <div class="max-w-4xl mx-auto">
            <div class="relative rounded-2xl overflow-hidden">
                <!-- Background gradient -->
                <div class="absolute inset-0 bg-indigo-600"></div>

                <!-- Content -->
                <div class="relative p-8 md:p-12 text-center text-white">
                    <h2 class="text-3xl md:text-4xl font-black mb-4 tracking-tight leading-tight">Siap Mengubah Cara Anda <br> Mendapat Sponsor?</h2>
                    <p class="text-base text-white/90 mb-8 max-w-2xl mx-auto font-medium leading-relaxed">
                        Bergabunglah dengan ratusan event organizer dan perusahaan yang telah merasakan kemudahan mengelola kemitraan sponsor melalui Sponsorea.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-indigo-600 font-bold rounded-xl hover:bg-slate-100 transition-all duration-300 transform hover:-translate-y-1">
                            Daftar Sekarang - Gratis
                        </a>
                        <a href="{{ route('login') }}" class="px-8 py-3 bg-white/20 text-white font-bold rounded-xl border-2 border-white hover:bg-white/30 transition-all backdrop-blur-sm">
                            Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection