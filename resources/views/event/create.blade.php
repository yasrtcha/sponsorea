@extends('layouts.dashboard') @section('title', 'Buat Event')
@section('page_title', 'Event Saya')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
    <h2 class="text-2xl font-bold text-slate-800 mb-2">Upload Event & Proposal</h2>
    <p class="text-slate-500 mb-6">Tambahkan event kepanitiaanmu agar bisa dilihat oleh calon sponsor.</p>
    
    <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-3xl">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Event / Kegiatan</label>
            <input type="text" name="title" value="{{ old('title') }}" 
                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all" 
                   placeholder="Contoh: Studi Banding FORMAPI UB goes to Yogyakarta" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori / Jenis Event</label>
            <select name="event_type" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all" required>
                <option value="" disabled selected>-- Pilih Jenis Event --</option>
                @foreach($eventTypes as $type)
                    <option value="{{ $type->name }}" {{ old('event_type') == $type->name ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
            @error('event_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Pelaksanaan</label>
            <input type="date" name="event_date" value="{{ old('event_date') }}" 
                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Singkat Event</label>
            <textarea name="description" rows="4" 
                      class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all resize-none" 
                      placeholder="Jelaskan secara singkat tujuan acara dan apa keuntungan bagi sponsor..." required>{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Upload Poster Event (Opsional, Format .JPG/.PNG)</label>
            <input type="file" name="poster_image" accept="image/jpeg, image/png, image/jpg" 
                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Upload Proposal (Format .PDF, Max 5MB)</label>
            <div class="relative flex items-center justify-center w-full">
                <label id="dropzone" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        
                        <p id="file-name" class="mb-2 text-sm text-slate-500 text-center px-4 line-clamp-1">
                            <span class="font-semibold">Klik untuk upload</span> atau drag and drop
                        </p>
                    </div>
                    
                    <input id="file-input" type="file" name="proposal_pdf" accept="application/pdf" class="hidden" required />
                </label>
            </div>
            @error('proposal_pdf') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="pt-4 flex gap-4">
            <button type="submit" class="bg-indigo-600 text-white font-bold py-3 px-6 rounded-xl hover:bg-indigo-700 hover:shadow-lg transition-all">
                Simpan & Upload Proposal
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
                // Cek apakah ada file yang dipilih
                if (this.files && this.files.length > 0) {
                    const file = this.files[0];
                    const fileSize = (file.size / 1024 / 1024).toFixed(2); // Ubah ke MB

                    // Ganti teks dengan nama file dan ukurannya
                    fileNameDisplay.innerHTML = `
                        <span class="font-semibold text-indigo-700">${file.name}</span> 
                        <br> <span class="text-xs text-indigo-500">Ukuran: ${fileSize} MB</span>
                    `;
                    
                    // Ubah border dan background dropzone biar kelihatan sukses terpilih
                    dropzone.classList.remove('border-slate-300', 'bg-slate-50', 'hover:bg-slate-100');
                    dropzone.classList.add('border-indigo-500', 'bg-indigo-50', 'hover:bg-indigo-100');
                } else {
                    // Kalau user batal milih file, kembalikan ke tampilan awal
                    fileNameDisplay.innerHTML = `<span class="font-semibold">Klik untuk upload</span> atau drag and drop`;
                    dropzone.classList.remove('border-indigo-500', 'bg-indigo-50', 'hover:bg-indigo-100');
                    dropzone.classList.add('border-slate-300', 'bg-slate-50', 'hover:bg-slate-100');
                }
            });
        });
    </script>

@endsection