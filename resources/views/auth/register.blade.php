@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 pt-12 relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-teal-400 opacity-15 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-0 transform -translate-x-1/3 -translate-y-1/2 w-80 h-80 bg-blue-500 opacity-8 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 right-1/3 w-72 h-72 bg-indigo-400 opacity-15 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 w-full max-w-5xl flex flex-row-reverse bg-white rounded-2xl shadow-xl overflow-hidden m-3 sm:m-6">
        
        <!-- Right Side - Branding/Info (Hidden on small screens) -->
        <div class="hidden md:flex md:w-5/12 bg-indigo-600 text-white p-10 flex-col justify-between relative overflow-hidden">

            <div class="relative z-10 text-right">
                <a href="{{ url('/') }}" class="text-2xl font-bold flex items-center justify-end gap-2 text-white hover:text-teal-200 transition-colors">
                    Sponsorea
                    <svg class="w-8 h-8 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </a>
                <div class="mt-16">
                    <h2 class="text-3xl font-extrabold mb-4 leading-tight">Mulai Perjalanan Anda</h2>
                    <p class="text-blue-100 text-lg">Buat akun untuk mengajukan proposal menarik atau mencari event potensial yang sesuai visi perusahaan.</p>
                </div>
            </div>

            <div class="relative z-10 mt-12">
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="text-left">
                            <h4 class="font-bold text-white">Untuk Perusahaan</h4>
                            <p class="text-sm text-teal-100">Ekspansi brand awareness</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="text-left">
                            <h4 class="font-bold text-white">Untuk Penyelenggara</h4>
                            <p class="text-sm text-teal-100">Jangkau ratusan sponsor</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Left Side - Form -->
        <div class="w-full md:w-7/12 p-8 sm:p-11 flex flex-col justify-center bg-white relative">
            <div class="text-center md:text-left mb-7">
                <h2 class="text-2xl font-bold text-gray-900">Daftar Akun</h2>
                <p class="text-gray-500 text-sm mt-1.5">Mulai perjalanan bersama Sponsorea</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm @error('name') border-red-500 @enderror"
                                   placeholder="John Doe" required>
                        </div>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1 bg-red-50 p-1.5 rounded">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm @error('email') border-red-500 @enderror"
                                   placeholder="you@example.com" required>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1 bg-red-50 p-1.5 rounded">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Pilih Peran Anda</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <select name="role"
                                class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 appearance-none text-sm @error('role') border-red-500 @enderror"
                                required>
                            <option value="">-- Pilih Peran Anda --</option>
                            <option value="event" {{ old('role') == 'event' ? 'selected' : '' }}>Penyelenggara Event</option>
                            <option value="company" {{ old('role') == 'company' ? 'selected' : '' }}>Perusahaan / Sponsor</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                    @error('role')
                        <p class="text-red-500 text-xs mt-1 bg-red-50 p-1.5 rounded">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input type="password" name="password"
                                   class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm @error('password') border-red-500 @enderror"
                                   placeholder="••••••••" required>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1 bg-red-50 p-1.5 rounded">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Konfirmasi Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input type="password" name="password_confirmation"
                                   class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm"
                                   placeholder="••••••••" required>
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-semibold py-2.5 px-4 rounded-lg hover:shadow-lg hover:shadow-indigo-500/25 hover:-translate-y-0.5 transition-all duration-200 text-sm mt-1">
                    Buat Akun Sekarang
                </button>
            </form>

            <p class="text-center text-xs text-gray-600 mt-5">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-800 transition-colors">Masuk Sekarang</a>
            </p>
        </div>
    </div>
</div>
@endsection