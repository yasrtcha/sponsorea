@extends('layouts.dashboard')

@section('title', 'Event Saya')
@section('page_title', 'Daftar Event')

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

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-extrabold text-[#3d3d3d] tracking-tight">Daftar Event</h2>
            <p class="text-gray-500 text-sm mt-1 font-medium">Kelola proposal dan event yang sudah kamu ajukan untuk mendapatkan sponsor.</p>
        </div>
        <a href="{{ route('event.create') }}" class="group bg-[#f07b32] text-white px-6 py-3 rounded-xl font-bold hover:bg-[#d96a25] shadow-lg shadow-[#f07b32]/20 hover:shadow-[#f07b32]/30 hover:-translate-y-0.5 transition-all flex items-center gap-2">
            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Tambah Event Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($events->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="p-5 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest">Nama Event / Kegiatan</th>
                            <th class="p-5 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest text-center">Kategori</th> 
                            <th class="p-5 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest text-center">Tgl Pelaksanaan</th>
                            <th class="p-5 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest text-center">Status</th>
                            <th class="p-5 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($events as $event)
                        <tr class="group hover:bg-[#fcf5f5]/30 transition-all duration-300">
                            <td class="p-5">
                                <p class="font-extrabold text-black text-sm transition-colors">{{ $event->title }}</p>
                            </td>
                            <td class="p-5 text-center">
                                <span class="px-3 py-1.5 bg-[#f5f4f0] text-gray-600 border border-gray-100 rounded-lg text-[10px] font-extrabold uppercase tracking-wider">
                                    {{ $event->event_type ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="p-5 text-center text-xs font-bold text-gray-500">
                                {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d M Y') }}
                            </td>
                            <td class="p-5 text-center">
                                @if($event->status == 'active' || $event->status == 'pending' || $event->status == 'approved')
                                    <span class="inline-flex items-center px-3 py-1 bg-teal-50 text-teal-600 rounded-full text-[10px] font-black uppercase tracking-wider border border-teal-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-teal-500 mr-1.5 animate-pulse"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 bg-gray-50 text-gray-400 rounded-full text-[10px] font-black uppercase tracking-wider border border-gray-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400 mr-1.5"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="p-5">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ asset('storage/' . $event->proposal_pdf) }}" target="_blank" class="w-9 h-9 flex items-center justify-center text-[#f07b32] bg-[#fcf5f5] hover:bg-[#f07b32] hover:text-white hover:shadow-md border border-transparent rounded-lg transition-all" title="Lihat Proposal">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>

                                    <a href="{{ route('event.edit', $event->id) }}" class="w-9 h-9 flex items-center justify-center text-amber-600 bg-amber-50 hover:bg-amber-100 hover:shadow-md border border-transparent rounded-lg transition-all" title="Edit Event">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    @if($event->status !== 'completed' && $event->status !== 'rejected')
                                        <form action="{{ route('event.close', $event->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menutup event ini? Event kamu tidak akan bisa menerima sponsor lagi dan hilang dari pencarian perusahaan.');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="w-9 h-9 flex items-center justify-center text-slate-600 bg-slate-100 hover:bg-slate-200 hover:shadow-md border border-transparent rounded-lg transition-all" title="Tutup Pencarian Sponsor">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('event.destroy', $event->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus event ini? Proposal PDF juga akan terhapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-9 h-9 flex items-center justify-center text-red-600 bg-red-50 hover:bg-red-100 hover:shadow-md border border-transparent rounded-lg transition-all" title="Hapus Event">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-20 text-center flex flex-col items-center justify-center px-6">
                <div class="w-20 h-20 bg-[#f5f4f0] text-[#3d3d3d]/20 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <h3 class="text-xl font-extrabold text-[#3d3d3d] mb-2">Belum Ada Event</h3>
                <p class="text-gray-500 mb-8 max-w-sm font-medium">Kamu belum mengupload proposal event apapun. Yuk, mulai cari sponsor untuk acaramu!</p>
                <a href="{{ route('event.create') }}" class="bg-[#f07b32] text-white px-8 py-3.5 rounded-xl font-extrabold hover:bg-[#d96a25] transition-all shadow-lg shadow-[#f07b32]/20 hover:shadow-[#f07b32]/30">
                    Upload Event Pertamamu
                </a>
            </div>
        @endif
    </div>
@endsection