@extends('layouts.dashboard')

@section('title', 'Penawaran Saya')
@section('page_title', 'Daftar Penawaran Sponsor')

@section('content')
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-teal-50 border border-teal-100 text-teal-700 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Program Sponsorship</h2>
            <p class="text-slate-500 mt-1">Kelola program bantuan atau CSR perusahaan Anda.</p>
        </div>
        <a href="{{ route('sponsor-offer.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-teal-700 hover:shadow-lg hover:-translate-y-0.5 transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Penawaran
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        @if($company->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-sm">
                            <th class="p-4 font-semibold">Nama Program</th>
                            <th class="p-4 font-semibold">Jenis Bantuan</th>
                            <th class="p-4 font-semibold">Status</th>
                            <th class="p-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($company as $offer)
                        <tr class="border-b border-slate-50 hover:bg-slate-50 transition-colors">
                            <td class="p-4">
                                <p class="font-bold text-slate-800">{{ $offer->title }}</p>
                            </td>
                            <td class="p-4 text-slate-600">
                                <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-lg text-xs font-semibold">{{ $offer->funding_type }}</span>
                            </td>
                            <td class="p-4">
                                @if($offer->status == 'active')
                                    <span class="px-3 py-1 bg-teal-50 text-teal-600 rounded-full text-xs font-bold">Aktif</span>
                                @else
                                    <span class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-xs font-bold">Nonaktif</span>
                                @endif
                            </td>
                            <td class="p-4 text-right flex items-center justify-end gap-2">
                                @if($offer->guideline_pdf)
                                    <a href="{{ asset('storage/' . $offer->guideline_pdf) }}" target="_blank" class="p-2 text-teal-600 bg-teal-50 hover:bg-teal-100 rounded-lg transition-colors" title="Lihat Guideline">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                @endif

                                <a href="{{ route('sponsor-offer.edit', $offer->id) }}" class="p-2 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors" title="Edit Penawaran">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>

                                @if($offer->status !== 'inactive')
                                    <form action="{{ route('sponsor-offer.close', $offer->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menutup penawaran ini? Penawaran Anda tidak akan bisa menerima event baru dan hilang dari pencarian event.');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="p-2 text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors" title="Tutup Pencarian Event">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('sponsor-offer.destroy', $offer->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus penawaran ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" title="Hapus Penawaran">
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
                <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Program Sponsorship</h3>
                <p class="text-slate-500 mb-6">Mulai buka peluang kerjasama dengan mendukung event-event mahasiswa.</p>
                <a href="{{ route('sponsor-offer.create') }}" class="bg-teal-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-teal-700 transition-colors">
                    Buat Penawaran Perdana
                </a>
            </div>
        @endif
    </div>
@endsection