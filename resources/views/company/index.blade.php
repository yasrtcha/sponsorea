@extends('layouts.dashboard')

@section('title', 'Penawaran Saya')
@section('page_title', 'Daftar Penawaran Sponsor')

@section('content')
    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-[#f0f9f8] border border-teal-100 flex items-center gap-3 shadow-sm animate-fade-in-down">
            <div class="w-8 h-8 rounded-full bg-teal-500 text-white flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <p class="text-sm font-bold text-teal-800">{{ session('success') }}</p>
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-extrabold text-[#3d3d3d] tracking-tight">Program Sponsorship</h2>
            <p class="text-gray-500 text-sm mt-1 font-medium">Kelola program bantuan atau CSR perusahaan Anda dengan mudah.</p>
        </div>
        <a href="{{ route('sponsor-offer.create') }}" class="group bg-[#f07b32] text-white px-6 py-3 rounded-xl font-bold hover:bg-[#d96a25] shadow-lg shadow-[#f07b32]/20 hover:shadow-[#f07b32]/30 hover:-translate-y-0.5 transition-all flex items-center gap-2">
            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Buat Penawaran
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($company->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="p-5 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest">Nama Program</th>
                            <th class="p-5 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest">Jenis Bantuan</th>
                            <th class="p-5 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest text-center">Status</th>
                            <th class="p-5 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($company as $offer)
                        <tr class="group hover:bg-[#fcf5f5]/30 transition-all duration-300">
                            <td class="p-5">
                                <p class="font-extrabold text-black text-sm transition-colors">{{ $offer->title }}</p>
                            </td>
                            <td class="p-5">
                                <span class="bg-[#f5f4f0] text-gray-600 px-3 py-1.5 rounded-lg text-[10px] font-extrabold uppercase tracking-wider border border-gray-100">
                                    {{ $offer->funding_type }}
                                </span>
                            </td>
                            <td class="p-5 text-center">
                                @if($offer->status == 'active')
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
                                    @if($offer->guideline_pdf)
                                        <a href="{{ asset('storage/' . $offer->guideline_pdf) }}" target="_blank" class="w-9 h-9 flex items-center justify-center text-teal-600 bg-teal-50 hover:bg-teal-100 hover:shadow-md border border-transparent rounded-lg transition-all" title="Lihat Guideline">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                    @endif

                                    <a href="{{ route('sponsor-offer.edit', $offer->id) }}" class="w-9 h-9 flex items-center justify-center text-amber-600 bg-amber-50 hover:bg-amber-100 hover:shadow-md border border-transparent rounded-lg transition-all" title="Edit Penawaran">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    @if($offer->status !== 'inactive')
                                        <form action="{{ route('sponsor-offer.close', $offer->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menutup penawaran ini? Penawaran Anda tidak akan bisa menerima event baru dan hilang dari pencarian event.');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="w-9 h-9 flex items-center justify-center text-slate-600 bg-slate-100 hover:bg-slate-200 hover:shadow-md border border-transparent rounded-lg transition-all" title="Tutup Pencarian Event">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('sponsor-offer.destroy', $offer->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus penawaran ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-9 h-9 flex items-center justify-center text-red-600 bg-red-50 hover:bg-red-100 hover:shadow-md border border-transparent rounded-lg transition-all" title="Hapus Penawaran">
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
                <h3 class="text-xl font-extrabold text-[#3d3d3d] mb-2">Belum Ada Program Sponsorship</h3>
                <p class="text-gray-500 mb-8 max-w-sm font-medium">Mulai buka peluang kerjasama dengan mendukung event-event mahasiswa yang luar biasa.</p>
                <a href="{{ route('sponsor-offer.create') }}" class="bg-[#f07b32] text-white px-8 py-3.5 rounded-xl font-extrabold hover:bg-[#d96a25] transition-all shadow-lg shadow-[#f07b32]/20 hover:shadow-[#f07b32]/30">
                    Buat Penawaran Perdana
                </a>
            </div>
        @endif
    </div>
@endsection