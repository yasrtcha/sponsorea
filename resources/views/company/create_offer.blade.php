@extends('layouts.dashboard') 

@section('title', 'Buat Penawaran Sponsor')
@section('page_title', 'Buat Penawaran Sponsor')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 xl:p-12 mb-10 w-full">
    <div class="mb-8 pb-6 border-b border-gray-100">
        <h2 class="text-2xl font-extrabold text-[#3d3d3d] mb-2">Informasi Program Sponsorship</h2>
        <p class="text-[13px] text-gray-500 font-medium">Kelola program bantuan atau CSR perusahaan Anda.</p>
    </div>
    
    <form action="{{ route('sponsor-offer.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-3xl">
        @csrf

        <div>
            <label class="block text-[11px] font-extrabold text-[#3d3d3d] uppercase tracking-widest mb-2.5">Nama Program / Campaign</label>
            <input type="text" name="title" value="{{ old('title') }}" 
                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#f07b32]/20 focus:border-[#f07b32] bg-gray-50/30 text-[13px] font-medium text-[#3d3d3d] focus:outline-none transition-all" 
                   placeholder="Contoh: CSR Sponsorea 2026 / Dukungan Event Mahasiswa" required>
            @error('title') <span class="text-red-500 text-[11px] font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-[11px] font-extrabold text-[#3d3d3d] uppercase tracking-widest mb-2.5">Jenis Bantuan / Funding</label>
            <select name="funding_type" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#f07b32]/20 focus:border-[#f07b32] bg-gray-50/30 text-[13px] font-medium text-[#3d3d3d] focus:outline-none transition-all" required>
                <option value="" disabled selected>Pilih jenis dukungan...</option>
                @foreach($fundingTypes as $type)
                    <option value="{{ $type->name }}" {{ old('funding_type') == $type->name ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
            @error('funding_type') <span class="text-red-500 text-[11px] font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-[11px] font-extrabold text-[#3d3d3d] uppercase tracking-widest mb-2.5">Deskripsi & Syarat Pengajuan</label>
            <textarea name="description" rows="4" 
                      class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#f07b32]/20 focus:border-[#f07b32] bg-gray-50/30 text-[13px] font-medium text-[#3d3d3d] focus:outline-none transition-all resize-none" 
                      placeholder="Jelaskan kriteria event yang dicari, timbal balik yang diharapkan, dsb..." required>{{ old('description') }}</textarea>
            @error('description') <span class="text-red-500 text-[11px] font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-[11px] font-extrabold text-[#3d3d3d] uppercase tracking-widest mb-2.5">Upload Banner Program (Opsional, Format .JPG/.PNG)</label>
            <input type="file" name="banner_image" accept="image/jpeg, image/png, image/jpg" 
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#f07b32]/20 focus:border-[#f07b32] bg-white text-[13px] font-medium text-[#3d3d3d] transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[11px] file:font-extrabold file:bg-[#fcf5f5] file:text-[#f07b32] hover:file:bg-[#f07b32] hover:file:text-white file:transition-all cursor-pointer">
        </div>

        <div>
            <label class="block text-[11px] font-extrabold text-[#3d3d3d] uppercase tracking-widest mb-2.5">Upload Guideline / SOP (Opsional, Format .PDF, Max 5MB)</label>
            <div class="relative flex items-center justify-center w-full">
                <label id="dropzone" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50/30 hover:bg-gray-50 transition-colors">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        
                        <p id="file-name" class="mb-2 text-[12px] text-gray-500 font-medium text-center px-4 line-clamp-1">
                            <span class="font-extrabold text-[#f07b32]">Klik untuk upload</span> panduan sponsor (jika ada)
                        </p>
                    </div>
                    
                    <input id="file-input" type="file" name="guideline_pdf" accept="application/pdf" class="hidden" />
                </label>
            </div>
            @error('guideline_pdf') <span class="text-red-500 text-[11px] font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="pt-6 flex gap-4">
            <a href="{{ route('company.index') }}" class="px-6 py-3 border border-gray-200 rounded-xl text-gray-500 font-extrabold text-sm hover:bg-gray-50 hover:text-[#3d3d3d] transition-all flex items-center justify-center">Batal</a>
            <button type="submit" class="flex-1 bg-[#f07b32] text-white font-extrabold py-3 px-4 rounded-xl hover:bg-[#d96a25] shadow-lg shadow-[#f07b32]/20 transition-all text-sm">
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
                    <span class="font-extrabold text-[#3d3d3d]">${file.name}</span> 
                    <br> <span class="text-[11px] font-bold text-[#f07b32]">Ukuran: ${fileSize} MB</span>
                `;
                
                dropzone.classList.remove('border-gray-300', 'bg-gray-50/30', 'hover:bg-gray-50');
                dropzone.classList.add('border-[#f07b32]', 'bg-[#fcf5f5]', 'hover:bg-[#f07b32]/5');
            } else {
                fileNameDisplay.innerHTML = `<span class="font-extrabold text-[#f07b32]">Klik untuk upload</span> panduan sponsor (jika ada)`;
                dropzone.classList.remove('border-[#f07b32]', 'bg-[#fcf5f5]', 'hover:bg-[#f07b32]/5');
                dropzone.classList.add('border-gray-300', 'bg-gray-50/30', 'hover:bg-gray-50');
            }
        });
    });
</script>
@endsection