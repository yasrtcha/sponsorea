@extends('layouts.dashboard')

@section('title', 'Pengaturan Profil')
@section('page_title', 'Pengaturan Profil')

@section('content')
@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
     class="mb-6 p-4 rounded-2xl bg-[#f0f9f8] border border-teal-100 flex items-start gap-3 animate-fade-in-down">
    <div class="w-8 h-8 rounded-full bg-teal-500 text-white flex items-center justify-center shrink-0">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
    </div>
    <div class="flex-1 mt-1.5">
        <h3 class="font-extrabold text-teal-800 text-sm">Berhasil!</h3>
        <p class="text-sm font-bold text-teal-700 mt-0.5">{{ session('success') }}</p>
    </div>
    <button @click="show = false" class="text-teal-600 hover:text-teal-800 mt-1.5">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
    </button>
</div>
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
