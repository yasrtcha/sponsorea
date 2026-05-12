<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Sponsorea</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex items-center justify-center bg-[#d9d3ca] p-4 sm:p-6 lg:p-8 font-sans">

    <!-- Outer Container (White Box) -->
    <div class="w-full max-w-[1000px] bg-white rounded-[2rem] flex flex-col md:flex-row shadow-xl overflow-hidden min-h-[600px]">

        <!-- Left Side - Form -->
        <div class="w-full md:w-1/2 p-8 sm:p-12 md:p-14 relative flex flex-col justify-center">
            <!-- Brand -->
            <a href="{{ url('/') }}" class="absolute top-8 left-8 sm:left-12 flex items-center gap-2 text-gray-400 font-bold text-lg hover:text-[#f07b32] transition-colors">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                sponsorea
            </a>

            <div class="mt-8 mb-8">
                <h2 class="text-3xl font-extrabold text-[#3d3d3d] mb-1">Log in</h2>
                <p class="text-sm font-medium text-gray-500">or <a href="{{ route('register') }}" class="text-[#e27d32] font-bold hover:underline">create an account</a> if you don't have one yet</p>
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-700 text-sm font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-xs font-bold text-[#3d3d3d] mb-1.5">Username or email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full px-4 py-3 rounded-xl bg-[#f5f4f0] border-transparent focus:bg-white focus:ring-2 focus:ring-[#e27d32] text-sm font-medium focus:outline-none transition-all @error('email') ring-1 ring-red-500 @enderror"
                           required>
                    <div class="flex justify-end mt-1">
                        <a href="#" class="text-[10px] font-bold text-[#e27d32] hover:underline">I can't remember</a>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#3d3d3d] mb-1.5">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                               class="w-full px-4 py-3 rounded-xl bg-[#f5f4f0] border-transparent focus:bg-white focus:ring-2 focus:ring-[#e27d32] text-sm font-medium focus:outline-none transition-all pr-10 @error('password') ring-1 ring-red-500 @enderror"
                               placeholder="••••••••••" required>
                        <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#e27d32] hover:text-[#d96a25]">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between pb-2">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="h-3.5 w-3.5 text-[#e27d32] border-gray-300 rounded focus:ring-[#e27d32] bg-[#f5f4f0]">
                        <label for="remember" class="ml-2 text-xs font-bold text-gray-500">Remember me</label>
                    </div>
                    <a href="#" class="text-[10px] font-bold text-[#e27d32] hover:underline">I forgot the password</a>
                </div>

                <button type="submit" class="w-full bg-[#f07b32] text-white font-bold py-3.5 px-6 rounded-full hover:bg-[#d96a25] transition-all text-sm mt-2">
                    Log in
                </button>
            </form>
        </div>

        <!-- Right Side - Graphic -->
        <div class="hidden md:flex md:w-1/2 bg-[#f07b32] relative p-12 flex-col justify-center overflow-hidden">
            <h3 class="text-2xl font-extrabold text-white mb-8 tracking-tight">Selamat Datang Kembali!</h3>
            <div class="space-y-6 relative z-10">
                <!-- Feature 1 -->
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center shadow-sm shrink-0 border border-white/20 backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-sm mb-1">Lanjutkan Kolaborasi</h4>
                        <p class="text-xs font-medium text-white/80 leading-relaxed">Masuk untuk mengelola proposal, memantau status kerjasama, dan menemukan peluang baru.</p>
                    </div>
                </div>
                <!-- Feature 2 -->
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center shadow-sm shrink-0 border border-white/20 backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-sm mb-1">Dashboard Analitik</h4>
                        <p class="text-xs font-medium text-white/80 leading-relaxed">Akses dashboard Anda untuk melihat performa event atau kampanye sponsorship Anda secara real-time.</p>
                    </div>
                </div>
                <!-- Feature 3 -->
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center shadow-sm shrink-0 border border-white/20 backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-sm mb-1">Koneksi & Keamanan Terjamin</h4>
                        <p class="text-xs font-medium text-white/80 leading-relaxed">Data event dan perusahaan dilindungi, memastikan negosiasi yang aman dan saling menguntungkan.</p>
                    </div>
                </div>
            </div>
            
            <!-- Graphic Accents -->
            <div class="absolute -top-16 -right-16 w-64 h-64 bg-white opacity-20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-black opacity-10 rounded-full blur-3xl pointer-events-none"></div>
        </div>

    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        }
    </script>
</body>
</html>