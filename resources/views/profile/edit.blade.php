@extends('layouts.dashboard')

@section('title', 'Pengaturan Profil')
@section('page_title', 'Pengaturan Profil')

@section('content')
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
        <button onclick="closeToast()" class="ml-4 text-teal-400 hover:text-teal-600 transition-colors bg-teal-50 rounded-full p-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    <script>
        setTimeout(() => closeToast(), 4000);
        function closeToast() {
            const toast = document.getElementById('toast-success');
            if(toast) {
                toast.classList.replace('translate-y-0', '-translate-y-4');
                toast.classList.replace('opacity-100', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }
        }
    </script>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 xl:p-12 mb-10 w-full">
    <div class="mb-10 text-center sm:text-left">
        <h2 class="text-2xl font-extrabold text-[#3d3d3d] tracking-tight mb-2">Pengaturan Profil</h2>
        <p class="text-gray-500 text-sm font-medium">Pastikan informasi kontak dan deskripsi Anda tetap terbaru agar proses kerjasama sponsorship berjalan lancar.</p>
    </div>

    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Nama Akun (Akun Utama)</label>
                <input type="text" value="{{ $user->name }}" class="w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-[#f5f4f0] text-gray-500 font-bold text-sm cursor-not-allowed" disabled>
            </div>

            @if($user->role === 'event')
            <div class="md:col-span-2">
                <label class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Nama Organisasi / Kepanitiaan</label>
                <input type="text" name="organization_name" value="{{ old('organization_name', $profile->organization_name) }}" 
                       class="w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-white focus:ring-2 focus:ring-[#f07b32] focus:border-transparent focus:outline-none transition-all font-bold text-[#3d3d3d] text-sm" required>
                @error('organization_name')
                    <p class="mt-1 text-xs font-bold text-red-500">{{ $message }}</p>
                @enderror
            </div>
            @endif

            @if($user->role === 'company')
            <div>
                <label class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Nama Perusahaan (Brand)</label>
                <input type="text" name="company_name" value="{{ old('company_name', $profile->company_name) }}" 
                       class="w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-white focus:ring-2 focus:ring-[#f07b32] focus:border-transparent focus:outline-none transition-all font-bold text-[#3d3d3d] text-sm" required>
                @error('company_name')
                    <p class="mt-1 text-xs font-bold text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Sektor Industri</label>
                <input type="text" name="company_sector" value="{{ old('company_sector', $profile->company_sector) }}" 
                       class="w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-white focus:ring-2 focus:ring-[#f07b32] focus:border-transparent focus:outline-none transition-all font-bold text-[#3d3d3d] text-sm" required>
                @error('company_sector')
                    <p class="mt-1 text-xs font-bold text-red-500">{{ $message }}</p>
                @enderror
            </div>
            @endif

            <div class="md:col-span-2">
                <label class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Nomor WhatsApp</label>
                <input type="text" name="phone_number" value="{{ old('phone_number', $profile->phone_number) }}" 
                       class="w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-white focus:ring-2 focus:ring-[#f07b32] focus:border-transparent focus:outline-none transition-all font-bold text-[#3d3d3d] text-sm" required>
                @error('phone_number')
                    <p class="mt-1 text-xs font-bold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Alamat</label>
                <textarea name="address" rows="3" class="w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-white focus:ring-2 focus:ring-[#f07b32] focus:border-transparent focus:outline-none transition-all font-bold text-[#3d3d3d] text-sm resize-none" required>{{ old('address', $profile->address) }}</textarea>
                @error('address')
                    <p class="mt-1 text-xs font-bold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Deskripsi Bio</label>
                <textarea name="description" rows="4" class="w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-white focus:ring-2 focus:ring-[#f07b32] focus:border-transparent focus:outline-none transition-all font-bold text-[#3d3d3d] text-sm resize-none leading-relaxed" required>{{ old('description', $profile->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs font-bold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Instagram (Opsional)</label>
                <input type="text" name="instagram" value="{{ old('instagram', $profile->instagram) }}" 
                       class="w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-white focus:ring-2 focus:ring-[#f07b32] focus:border-transparent focus:outline-none transition-all font-bold text-[#3d3d3d] text-sm" 
                       placeholder="@username">
                @error('instagram')
                    <p class="mt-1 text-xs font-bold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">TikTok (Opsional)</label>
                <input type="text" name="tiktok" value="{{ old('tiktok', $profile->tiktok) }}" 
                       class="w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-white focus:ring-2 focus:ring-[#f07b32] focus:border-transparent focus:outline-none transition-all font-bold text-[#3d3d3d] text-sm" 
                       placeholder="@username">
                @error('tiktok')
                    <p class="mt-1 text-xs font-bold text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-8 mt-4 border-t border-gray-100">
            <a href="{{ route('event.dashboard') }}" onclick="if('{{ auth()->user()->role }}' === 'company') { this.href = '{{ route('company.dashboard') }}'; return false; }" class="text-center px-8 py-3.5 rounded-xl bg-gray-100 text-gray-500 font-extrabold hover:bg-gray-200 hover:text-gray-700 transition-colors w-full sm:w-auto">
                Batal
            </a>
            <button type="submit" class="px-8 py-3.5 rounded-xl bg-[#f07b32] text-white font-extrabold hover:bg-[#d96a25] transition-all shadow-lg shadow-[#f07b32]/20 hover:shadow-[#f07b32]/30 hover:-translate-y-0.5 w-full sm:w-auto">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
