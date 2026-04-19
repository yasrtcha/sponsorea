@extends('layouts.dashboard') 

@section('title', 'Buat Penawaran Sponsor')
@section('page_title', 'Buat Penawaran Sponsor')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
    <h2 class="text-2xl font-bold text-slate-800 mb-2">Informasi Program Sponsorship</h2>
    <p class="text-slate-500 mb-6">Kelola program bantuan atau CSR perusahaan Anda.</p>
    
    <form action="{{ route('sponsor-offer.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-3xl">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Program / Campaign</label>
            <input type="text" name="title" value="{{ old('title') }}" 
                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 focus:outline-none transition-all" 
                   placeholder="Contoh: CSR Sponsorea 2026 / Dukungan Event Mahasiswa" required>
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Bantuan / Funding</label>
            <select name="funding_type" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 focus:outline-none transition-all" required>
                <option value="" disabled selected>Pilih jenis dukungan...</option>
                @foreach($fundingTypes as $type)
                    <option value="{{ $type->name }}" {{ old('funding_type') == $type->name ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
            @error('funding_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi & Syarat Pengajuan</label>
            <textarea name="description" rows="4" 
                      class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 focus:outline-none transition-all resize-none" 
                      placeholder="Jelaskan kriteria event yang dicari, timbal balik yang diharapkan, dsb..." required>{{ old('description') }}</textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Upload Banner Program (Opsional, Format .JPG/.PNG)</label>
            <input type="file" name="banner_image" accept="image/jpeg, image/png, image/jpg" 
                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 focus:outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 cursor-pointer">
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Upload Guideline / SOP (Opsional, Format .PDF, Max 5MB)</label>
            <div class="relative flex items-center justify-center w-full">
                <label id="dropzone" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        
                        <p id="file-name" class="mb-2 text-sm text-slate-500 text-center px-4 line-clamp-1">
                            <span class="font-semibold">Klik untuk upload</span> panduan sponsor (jika ada)
                        </p>
                    </div>
                    
                    <input id="file-input" type="file" name="guideline_pdf" accept="application/pdf" class="hidden" />
                </label>
            </div>
            @error('guideline_pdf') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="pt-4 flex gap-4">
            <a href="{{ route('company.index') }}" class="px-6 py-3 border border-slate-200 rounded-xl text-slate-600 font-semibold hover:bg-slate-50 transition-colors">Batal</a>
            <button type="submit" class="flex-1 bg-teal-600 text-white font-bold py-3 px-4 rounded-xl hover:bg-teal-700 hover:shadow-lg transition-all">
                Terbitkan Penawaran
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

                fileNameDisplay.innerHTML = `
                    <span class="font-semibold text-teal-700">${file.name}</span> 
                    <br> <span class="text-xs text-teal-500">Ukuran: ${fileSize} MB</span>
                `;
                
                dropzone.classList.remove('border-slate-300', 'bg-slate-50', 'hover:bg-slate-100');
                dropzone.classList.add('border-teal-500', 'bg-teal-50', 'hover:bg-teal-100');
            } else {
                fileNameDisplay.innerHTML = `<span class="font-semibold">Klik untuk upload</span> panduan sponsor (jika ada)`;
                dropzone.classList.remove('border-teal-500', 'bg-teal-50', 'hover:bg-teal-100');
                dropzone.classList.add('border-slate-300', 'bg-slate-50', 'hover:bg-slate-100');
            }
        });
    });
</script>
@endsection