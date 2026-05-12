@extends('layouts.dashboard')

@section('title', 'Edit Penawaran')
@section('page_title', 'Edit Program Sponsor')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 xl:p-12 mb-10 w-full">
    <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-100">
        <a href="{{ route('company.index') }}" class="p-2.5 bg-[#fcf5f5] text-[#f07b32] hover:bg-[#f07b32] hover:text-white rounded-xl transition-all">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="text-2xl font-extrabold text-[#3d3d3d]">Edit Penawaran Sponsor</h2>
    </div>
    
    <form action="{{ route('sponsor-offer.update', $sponsorOffer->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-3xl">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-[11px] font-extrabold text-[#3d3d3d] uppercase tracking-widest mb-2.5">Nama Program / Campaign</label>
            <input type="text" name="title" value="{{ old('title', $sponsorOffer->title) }}" 
                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#f07b32]/20 focus:border-[#f07b32] bg-gray-50/30 text-[13px] font-medium text-[#3d3d3d] focus:outline-none transition-all" required>
        </div>

        <div>
            <label class="block text-[11px] font-extrabold text-[#3d3d3d] uppercase tracking-widest mb-2.5">Jenis Bantuan / Funding</label>
            <select name="funding_type" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#f07b32]/20 focus:border-[#f07b32] bg-gray-50/30 text-[13px] font-medium text-[#3d3d3d] focus:outline-none transition-all" required>
                <option value="" disabled>Pilih jenis dukungan...</option>
                @foreach($fundingTypes as $type)
                    <option value="{{ $type->name }}" {{ old('funding_type', $sponsorOffer->funding_type) == $type->name ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-[11px] font-extrabold text-[#3d3d3d] uppercase tracking-widest mb-2.5">Deskripsi & Syarat Pengajuan</label>
            <textarea name="description" rows="4" 
                      class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#f07b32]/20 focus:border-[#f07b32] bg-gray-50/30 text-[13px] font-medium text-[#3d3d3d] focus:outline-none transition-all resize-none" required>{{ old('description', $sponsorOffer->description) }}</textarea>
        </div>

        <div>
            <label class="block text-[11px] font-extrabold text-[#3d3d3d] uppercase tracking-widest mb-2.5">Ganti Banner Program (Opsional, Format .JPG/.PNG)</label>
            
            @if($sponsorOffer->banner_image)
                <div class="mb-4 p-2 border border-gray-100 rounded-2xl bg-white inline-block">
                    <img src="{{ asset('storage/' . $sponsorOffer->banner_image) }}" alt="Banner Lama" class="h-32 w-auto rounded-xl object-cover shadow-sm">
                </div>
            @endif
            
            <input type="file" name="banner_image" accept="image/jpeg, image/png, image/jpg" 
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#f07b32]/20 focus:border-[#f07b32] bg-white text-[13px] font-medium text-[#3d3d3d] transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[11px] file:font-extrabold file:bg-[#fcf5f5] file:text-[#f07b32] hover:file:bg-[#f07b32] hover:file:text-white file:transition-all cursor-pointer">
            <p class="text-[11px] text-gray-400 font-bold mt-2">Biarkan kosong jika tidak ingin mengganti banner.</p>
        </div>

        <div>
            <label class="block text-[11px] font-extrabold text-[#3d3d3d]] uppercase tracking-widest mb-2.5">Ganti Guideline / SOP (Opsional, Format .PDF)</label>
            <div class="relative flex items-center justify-center w-full">
                <label id="dropzone" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50/30 hover:bg-gray-50 transition-colors">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        <p id="file-name" class="mb-2 text-[12px] text-gray-500 font-medium text-center px-4">
                            <span class="font-extrabold text-[#f07b32]">Biarkan kosong</span> jika tidak ingin mengganti file sebelumnya
                        </p>
                    </div>
                    <input id="file-input" type="file" name="guideline_pdf" accept="application/pdf" class="hidden" />
                </label>
            </div>
        </div>

        <div class="pt-6">
            <button type="submit" class="bg-[#f07b32] text-white font-extrabold py-3 px-8 rounded-xl hover:bg-[#d96a25] shadow-lg shadow-[#f07b32]/20 transition-all text-sm">
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
                fileNameDisplay.innerHTML = `<span class="font-extrabold text-[#3d3d3d]">${file.name}</span> <br> <span class="text-[11px] font-bold text-[#f07b32]">Ukuran: ${fileSize} MB</span>`;
                dropzone.classList.remove('border-gray-300', 'bg-gray-50/30', 'hover:bg-gray-50');
                dropzone.classList.add('border-[#f07b32]', 'bg-[#fcf5f5]', 'hover:bg-[#f07b32]/5');
            } else {
                fileNameDisplay.innerHTML = `<span class="font-extrabold text-[#f07b32]">Biarkan kosong</span> jika tidak ingin mengganti file sebelumnya`;
                dropzone.classList.remove('border-[#f07b32]', 'bg-[#fcf5f5]', 'hover:bg-[#f07b32]/5');
                dropzone.classList.add('border-gray-300', 'bg-gray-50/30', 'hover:bg-gray-50');
            }
        });
    });
</script>
@endsection