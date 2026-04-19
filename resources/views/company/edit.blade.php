@extends('layouts.dashboard')

@section('title', 'Edit Penawaran')
@section('page_title', 'Edit Program Sponsor')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('company.index') }}" class="p-2 bg-slate-50 text-slate-500 hover:text-teal-600 rounded-xl transition-colors">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="text-2xl font-bold text-slate-800">Edit Penawaran Sponsor</h2>
    </div>
    
    <form action="{{ route('sponsor-offer.update', $sponsorOffer->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-3xl">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Program / Campaign</label>
            <input type="text" name="title" value="{{ old('title', $sponsorOffer->title) }}" 
                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 focus:outline-none transition-all" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Bantuan / Funding</label>
            <select name="funding_type" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 focus:outline-none transition-all" required>
                <option value="" disabled>Pilih jenis dukungan...</option>
                @foreach($fundingTypes as $type)
                    <option value="{{ $type->name }}" {{ old('funding_type', $sponsorOffer->funding_type) == $type->name ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi & Syarat Pengajuan</label>
            <textarea name="description" rows="4" 
                      class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 focus:outline-none transition-all resize-none" required>{{ old('description', $sponsorOffer->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Ganti Banner Program (Opsional, Format .JPG/.PNG)</label>
            
            @if($sponsorOffer->banner_image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $sponsorOffer->banner_image) }}" alt="Banner Lama" class="h-32 w-auto rounded-xl object-cover border border-slate-200 shadow-sm">
                </div>
            @endif
            
            <input type="file" name="banner_image" accept="image/jpeg, image/png, image/jpg" 
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 bg-white transition-all">
            <p class="text-xs text-slate-500 mt-1">Biarkan kosong jika tidak ingin mengganti banner.</p>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Ganti Guideline / SOP (Opsional, Format .PDF)</label>
            <div class="relative flex items-center justify-center w-full">
                <label id="dropzone" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        <p id="file-name" class="mb-2 text-sm text-slate-500 text-center px-4">
                            <span class="font-semibold text-teal-500">Biarkan kosong</span> jika tidak ingin mengganti file sebelumnya
                        </p>
                    </div>
                    <input id="file-input" type="file" name="guideline_pdf" accept="application/pdf" class="hidden" />
                </label>
            </div>
        </div>

        <div class="pt-4 flex gap-4">
            <button type="submit" class="bg-teal-600 text-white font-bold py-3 px-6 rounded-xl hover:bg-teal-700 hover:shadow-lg transition-all">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('file-input');
        const fileNameDisplay = document.getElementById('file-name');
        const dropzone = document.getElementById('dropzone');

        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                const file = this.files[0];
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                fileNameDisplay.innerHTML = `<span class="font-semibold text-teal-700">${file.name}</span> <br> <span class="text-xs text-teal-500">Ukuran: ${fileSize} MB</span>`;
                dropzone.classList.remove('border-slate-300', 'bg-slate-50', 'hover:bg-slate-100');
                dropzone.classList.add('border-teal-500', 'bg-teal-50', 'hover:bg-teal-100');
            } else {
                fileNameDisplay.innerHTML = `<span class="font-semibold text-teal-500">Biarkan kosong</span> jika tidak ingin mengganti file sebelumnya`;
                dropzone.classList.remove('border-teal-500', 'bg-teal-50', 'hover:bg-teal-100');
                dropzone.classList.add('border-slate-300', 'bg-slate-50', 'hover:bg-slate-100');
            }
        });
    });
</script>
@endsection