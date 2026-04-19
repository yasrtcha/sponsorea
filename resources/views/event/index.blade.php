@extends('layouts.dashboard')

@section('title', 'Event Saya')
@section('page_title', 'Daftar Event')

@section('content')
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-teal-50 border border-teal-100 text-teal-700 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Daftar Event</h2>
            <p class="text-slate-500 mt-1">Kelola proposal dan event yang sudah kamu ajukan.</p>
        </div>
        <a href="{{ route('event.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-0.5 transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Event Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        @if($events->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-sm">
                            <th class="p-4 font-semibold">Nama Event / Kegiatan</th>
                            <th class="p-4 font-semibold">Kategori</th> 
                            <th class="p-4 font-semibold">Tgl Pelaksanaan</th>
                            <th class="p-4 font-semibold">Status</th>
                            <th class="p-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr class="border-b border-slate-50 hover:bg-slate-50 transition-colors">
                            <td class="p-4">
                                <p class="font-bold text-slate-800">{{ $event->title }}</p>
                            </td>
                            <td class="p-4">
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 border border-indigo-100 rounded-lg text-xs font-medium">
                                    {{ $event->event_type ?? 'Belum ada kategori' }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-600">
                                {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d M Y') }}
                            </td>
                            <td class="p-4">
                                @if($event->status == 'active' || $event->status == 'pending' || $event->status == 'approved')
                                    <span class="px-3 py-1 bg-teal-50 text-teal-600 border border-teal-100 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-slate-100 text-slate-500 border border-slate-200 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-right flex items-center justify-end gap-2">
                                
                                <a href="{{ asset('storage/' . $event->proposal_pdf) }}" target="_blank" class="p-2 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors" title="Lihat Proposal">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>

                                <a href="{{ route('event.edit', $event->id) }}" class="p-2 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors" title="Edit Event">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>

                                @if($event->status !== 'completed' && $event->status !== 'rejected')
                                    <form action="{{ route('event.close', $event->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menutup event ini? Event kamu tidak akan bisa menerima sponsor lagi dan hilang dari pencarian perusahaan.');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="p-2 text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors" title="Tutup Pencarian Sponsor">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('event.destroy', $event->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus event ini? Proposal PDF juga akan terhapus.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" title="Hapus Event">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center flex flex-col items-center justify-center">
                <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Event</h3>
                <p class="text-slate-500 mb-6">Kamu belum mengupload proposal event apapun. Yuk, mulai cari sponsor untuk acaramu!</p>
                <a href="{{ route('event.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-indigo-700 transition-colors">
                    Upload Event Pertamamu
                </a>
            </div>
        @endif
    </div>
@endsection