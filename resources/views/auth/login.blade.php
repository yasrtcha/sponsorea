@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 pt-12 relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
        <div class="absolute -top-20 -left-20 w-64 h-64 bg-blue-400 opacity-15 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 right-0 transform translate-x-1/3 -translate-y-1/2 w-80 h-80 bg-indigo-500 opacity-8 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 left-1/3 w-72 h-72 bg-teal-400 opacity-15 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 w-full max-w-5xl flex bg-white rounded-2xl shadow-xl overflow-hidden m-3 sm:m-6">
        <!-- Left Side - Branding/Info (Hidden on small screens) -->
        <div class="hidden md:flex md:w-1/2 bg-indigo-600 text-white p-10 flex-col justify-between relative overflow-hidden">

            <div class="relative z-10">
                <a href="{{ url('/') }}" class="text-2xl font-bold flex items-center gap-2 text-white">
                    <svg class="w-8 h-8 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Sponsorea
                </a>
                <div class="mt-16">
                    <h2 class="text-3xl font-extrabold mb-4 leading-tight">Welcome Back!</h2>
                    <p class="text-blue-100 text-lg">Hubungkan event Anda dengan sponsor terbaik atau temukan event potensial untuk didukung.</p>
                </div>
            </div>

            <div class="relative z-10">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-2xl">
                    <p class="text-sm italic text-blue-50">"Platform ini benar-benar mempermudah kami mendapatkan sponsor untuk event kampus berskala nasional."</p>
                    <div class="mt-4 flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center font-bold">AS</div>
                        <div>
                            <p class="font-bold text-sm">Ahmad Syauqi</p>
                            <p class="text-xs text-blue-200">Ketua Pelaksana BEM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full md:w-1/2 p-8 sm:p-11 flex flex-col justify-center bg-white relative">
            <div class="text-center md:text-left mb-7">
                <h2 class="text-2xl font-bold text-gray-900">Masuk</h2>
                <p class="text-gray-500 text-sm mt-1.5">Selamat datang kembali ke Sponsorea</p>
            </div>

            @if(session('success'))
                <div class="mb-5 p-3 rounded-lg border border-teal-200 bg-teal-50 flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-4 w-4 text-teal-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-2.5">
                        <p class="text-xs font-medium text-teal-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 text-sm @error('email') border-red-500 @enderror"
                               placeholder="you@example.com" required>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1 bg-red-50 p-1.5 rounded">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password"
                               class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 text-sm @error('password') border-red-500 @enderror"
                               placeholder="••••••••" required>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1 bg-red-50 p-1.5 rounded">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember" type="checkbox" class="h-3.5 w-3.5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-xs text-gray-600">
                            Ingat Saya
                        </label>
                    </div>
                    <a href="#" class="text-xs font-medium text-indigo-600 hover:text-indigo-800 transition-colors">Lupa Password?</a>
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-semibold py-2.5 px-4 rounded-lg hover:shadow-lg hover:shadow-indigo-500/25 hover:-translate-y-0.5 transition-all duration-200 text-sm mt-1">
                    Masuk ke Akun
                </button>
            </form>

            <p class="text-center text-xs text-gray-600 mt-5">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">Daftar Sekarang</a>
            </p>
        </div>
    </div>
</div>
@endsection