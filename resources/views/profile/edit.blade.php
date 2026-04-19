@extends('layouts.dashboard')

@section('title', 'Pengaturan Profil')
@section('page_title', 'Pengaturan Profil')

@section('content')
@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
     class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start gap-3 animate-pulse">
    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
    <div class="flex-1">
        <h3 class="font-semibold text-sm">Berhasil!</h3>
        <p class="text-sm">{{ session('success') }}</p>
    </div>
    <button @click="show = false" class="text-emerald-600 hover:text-emerald-800">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
    </button>
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800 mb-2">Pengaturan Profil</h2>
        <p class="text-slate-600">Pastikan informasi kontak dan deskripsi Anda tetap terbaru agar proses kerjasama sponsorship berjalan lancar.</p>
    </div>

    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6">
            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-2">Nama Akun (Akun Utama)</label>
                <input type="text" value="{{ $user->name }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-500 cursor-not-allowed" disabled>
            </div>

            @if($user->role === 'event')
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Organisasi / Kepanitiaan</label>
                <input type="text" name="organization_name" value="{{ old('organization_name', $profile->organization_name) }}" 
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:outline-none transition-all" required>
                @error('organization_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            @endif

            @if($user->role === 'company')
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Perusahaan (Brand)</label>
                <input type="text" name="company_name" value="{{ old('company_name', $profile->company_name) }}" 
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:outline-none transition-all" required>
                @error('company_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Sektor Industri</label>
                <input type="text" name="company_sector" value="{{ old('company_sector', $profile->company_sector) }}" 
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:outline-none transition-all" required>
                @error('company_sector')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            @endif

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor WhatsApp</label>
                <input type="text" name="phone_number" value="{{ old('phone_number', $profile->phone_number) }}" 
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:outline-none transition-all" required>
                @error('phone_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat</label>
                <textarea name="address" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:outline-none transition-all resize-none" required>{{ old('address', $profile->address) }}</textarea>
                @error('address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:outline-none transition-all resize-none" required>{{ old('description', $profile->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Instagram</label>
                <input type="text" name="instagram" value="{{ old('instagram', $profile->instagram) }}" 
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:outline-none transition-all" 
                       placeholder="Contoh: @nama_akun">
                @error('instagram')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">TikTok</label>
                <input type="text" name="tiktok" value="{{ old('tiktok', $profile->tiktok) }}" 
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:outline-none transition-all" 
                       placeholder="Contoh: @nama_akun">
                @error('tiktok')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex gap-3 pt-6 border-t border-slate-200">
            <a href="{{ route('event.dashboard') }}" onclick="if('{{ auth()->user()->role }}' === 'company') { this.href = '{{ route('company.dashboard') }}'; }" class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition-colors">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
