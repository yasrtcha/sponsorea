@extends('layouts.dashboard')

@section('title', 'Edit Event')
@section('page_title', 'Edit Event Saya')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('event.index') }}" class="p-2 bg-slate-50 text-slate-500 hover:text-indigo-600 rounded-xl transition-colors">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="text-2xl font-bold text-slate-800">Edit Event & Proposal</h2>
    </div>
    
    <form action="{{ route('event.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-3xl">
        @csrf
        @method('PUT') <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Event / Kegiatan</label>
            <input type="text" name="title" value="{{ old('title', $event->title) }}" 
                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori / Jenis Event</label>
            <select name="event_type" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all" required>
                <option value="" disabled>-- Pilih Jenis Event --</option>
                @foreach($eventTypes as $type)
                    <option value="{{ $type->name }}" {{ old('event_type', $event->event_type ?? '') == $type->name ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
            @error('event_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Pelaksanaan</label>
            <input type="date" name="event_date" value="{{ old('event_date', \Carbon\Carbon::parse($event->event_date)->format('Y-m-d')) }}" 
                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Singkat Event</label>
            <textarea name="description" rows="4" 
                      class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all resize-none" required>{{ old('description', $event->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Ganti Poster Event (Opsional, Format .JPG/.PNG)</label>
            
            @if($event->poster_image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $event->poster_image) }}" alt="Poster Lama" class="h-32 rounded-xl object-cover border border-slate-200 shadow-sm">
                </div>
            @endif
            
            <input type="file" name="poster_image" accept="image/jpeg, image/png, image/jpg" 
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 bg-white transition-all">
            <p class="text-xs text-slate-500 mt-1">Biarkan kosong jika tidak ingin mengganti poster.</p>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Ganti Proposal (Opsional, Format .PDF)</label>
            <div class="relative flex items-center justify-center w-full">
                <label id="dropzone" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        <p id="file-name" class="mb-2 text-sm text-slate-500 text-center px-4">
                            <span class="font-semibold text-indigo-500">Biarkan kosong</span> jika tidak ingin mengganti file sebelumnya
                        </p>
                    </div>
                    <input id="file-input" type="file" name="proposal_pdf" accept="application/pdf" class="hidden" />
                </label>
            </div>
        </div>

        <div class="pt-4 flex gap-4">
            <button type="submit" class="bg-indigo-600 text-white font-bold py-3 px-6 rounded-xl hover:bg-indigo-700 hover:shadow-lg transition-all">
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
                fileNameDisplay.innerHTML = `<span class="font-semibold text-indigo-700">${file.name}</span> <br> <span class="text-xs text-indigo-500">Ukuran: ${fileSize} MB</span>`;
                dropzone.classList.remove('border-slate-300', 'bg-slate-50', 'hover:bg-slate-100');
                dropzone.classList.add('border-indigo-500', 'bg-indigo-50', 'hover:bg-indigo-100');
            } else {
                fileNameDisplay.innerHTML = `<span class="font-semibold text-indigo-500">Biarkan kosong</span> jika tidak ingin mengganti file sebelumnya`;
                dropzone.classList.remove('border-indigo-500', 'bg-indigo-50', 'hover:bg-indigo-100');
                dropzone.classList.add('border-slate-300', 'bg-slate-50', 'hover:bg-slate-100');
            }
        });
    });
</script>
@endsection