@extends('layouts.app')

@section('hide_navbar', true)

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#d9d3ca] py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden font-sans">
    <!-- Logo / Brand -->
    <a href="{{ url('/') }}" class="absolute top-8 left-8 sm:left-12 flex items-center gap-2 text-gray-500 font-bold text-lg hover:text-[#f07b32] transition-colors z-10">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
        sponsorea
    </a>

    <!-- Tombol Logout -->
    <form method="POST" action="{{ route('logout') }}" class="absolute top-8 right-8 sm:right-12 z-10">
        @csrf
        <button type="submit" class="flex items-center gap-2 px-5 py-2.5 bg-white/60 hover:bg-white text-gray-600 hover:text-[#f07b32] text-sm font-bold rounded-full shadow-sm hover:shadow-md transition-all">
            Keluar
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
        </button>
    </form>

    <div class="w-full max-w-3xl bg-white rounded-[2rem] shadow-xl overflow-hidden p-8 sm:p-12 relative z-10 mt-8">

        <div class="mb-8 text-center">
            <div class="inline-block px-4 py-1.5 bg-[#f5f4f0] text-[#e27d32] border border-[#f5f4f0] rounded-full text-xs font-bold tracking-wide mb-4">
                Langkah Terakhir
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-[#3d3d3d] mb-2 tracking-tight">Halo, {{ auth()->user()->name }}!</h2>
            <p class="text-sm font-medium text-gray-500 max-w-xl mx-auto">
                Satu langkah lagi untuk menyelesaikan pengaturan akun Anda. Lengkapi profil di bawah ini untuk mengakses dashboard.
            </p>
        </div>

        <form method="POST" action="{{ route('profile.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2 space-y-5">
                        @if(auth()->user()->role === 'event')
                            <div>
                                <label class="block text-xs font-bold text-[#3d3d3d] mb-1.5">Nama Organisasi / Kepanitiaan</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                    </div>
                                    <input type="text" name="organization_name" value="{{ old('organization_name') }}"
                                        class="w-full pl-11 pr-4 py-3 rounded-xl bg-[#f5f4f0] border-transparent focus:bg-white focus:ring-2 focus:ring-[#e27d32] text-sm font-medium focus:outline-none transition-all placeholder-gray-400"
                                        placeholder="Contoh: BEM Fakultas Ilmu Komputer / FORMAPI UB" required>
                                </div>
                            </div>
                        @endif

                        @if(auth()->user()->role === 'company')
                            <div>
                                <label class="block text-xs font-bold text-[#3d3d3d] mb-1.5">Nama Perusahaan</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                    </div>
                                    <input type="text" name="company_name" value="{{ old('company_name') }}"
                                        class="w-full pl-11 pr-4 py-3 rounded-xl bg-[#f5f4f0] border-transparent focus:bg-white focus:ring-2 focus:ring-[#e27d32] text-sm font-medium focus:outline-none transition-all placeholder-gray-400"
                                        placeholder="Contoh: PT Sponsorea Teknologi" required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-[#3d3d3d] mb-1.5">Sektor Industri</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                    </div>
                                    <input type="text" name="company_sector" value="{{ old('company_sector') }}"
                                        class="w-full pl-11 pr-4 py-3 rounded-xl bg-[#f5f4f0] border-transparent focus:bg-white focus:ring-2 focus:ring-[#e27d32] text-sm font-medium focus:outline-none transition-all placeholder-gray-400"
                                        placeholder="Contoh: Food & Beverage, Technology, dsb." required>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-[#3d3d3d] mb-1.5">Nomor Telepon / WhatsApp</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                            </div>
                            <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                                class="w-full pl-11 pr-4 py-3 rounded-xl bg-[#f5f4f0] border-transparent focus:bg-white focus:ring-2 focus:ring-[#e27d32] text-sm font-medium focus:outline-none transition-all placeholder-gray-400"
                                placeholder="Contoh: 081234567890" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#3d3d3d] mb-1.5">Instagram</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.467.398.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.799-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/></svg>
                            </div>
                            <input type="text" name="instagram" value="{{ old('instagram') }}"
                                class="w-full pl-11 pr-4 py-3 rounded-xl bg-[#f5f4f0] border-transparent focus:bg-white focus:ring-2 focus:ring-[#e27d32] text-sm font-medium focus:outline-none transition-all placeholder-gray-400"
                                placeholder="Contoh: @nama_akun">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#3d3d3d] mb-1.5">TikTok</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.1 1.82 2.89 2.89 0 0 1 2.31-4.64 2.86 2.86 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-.96-.08z"/></svg>
                            </div>
                            <input type="text" name="tiktok" value="{{ old('tiktok') }}"
                                class="w-full pl-11 pr-4 py-3 rounded-xl bg-[#f5f4f0] border-transparent focus:bg-white focus:ring-2 focus:ring-[#e27d32] text-sm font-medium focus:outline-none transition-all placeholder-gray-400"
                                placeholder="Contoh: @nama_akun">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-[#3d3d3d] mb-1.5">Alamat Lengkap</label>
                        <div class="relative">
                            <div class="absolute top-4 left-0 pl-4 pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <textarea name="address" rows="2"
                                    class="w-full pl-11 pr-4 py-3 rounded-xl bg-[#f5f4f0] border-transparent focus:bg-white focus:ring-2 focus:ring-[#e27d32] text-sm font-medium focus:outline-none transition-all placeholder-gray-400 resize-none"
                                    placeholder="{{ auth()->user()->isEvent() ? 'Alamat sekretariat kepanitiaan / kampus' : 'Alamat kantor perusahaan' }}" required>{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-[#3d3d3d] mb-1.5">Deskripsi Singkat</label>
                        <div class="relative">
                            <div class="absolute top-4 left-0 pl-4 pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <textarea name="description" rows="3"
                                    class="w-full pl-11 pr-4 py-3 rounded-xl bg-[#f5f4f0] border-transparent focus:bg-white focus:ring-2 focus:ring-[#e27d32] text-sm font-medium focus:outline-none transition-all placeholder-gray-400 resize-none"
                                    placeholder="{{ auth()->user()->isEvent() ? 'Ceritakan secara singkat tentang organisasi atau track record event Anda...' : 'Ceritakan tentang fokus perusahaan dan apa yang biasa Anda sponsori...' }}" required>{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-[#f07b32] text-white font-bold py-3.5 px-6 rounded-full hover:bg-[#d96a25] shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all text-sm mt-8">
                    Simpan dan Lanjutkan
                </button>
            </form>
        </div>
    </div>
@endsection