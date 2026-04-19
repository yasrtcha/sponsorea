@extends('layouts.dashboard')

@section('title', 'Laporan Transaksi')
@section('page_title', 'Laporan Kerjasama')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 print:hidden space-y-4">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Rekapitulasi Kerjasama</h3>
                <p class="text-sm text-slate-500">Menampilkan data kerjasama yang sah dan telah disetujui.</p>
            </div>
            <button onclick="window.print()" class="flex items-center gap-2 bg-indigo-600 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Print
            </button>
        </div>

        @if($events->count() > 0)
        <div class="border-t border-slate-200 pt-4">
            <div class="flex items-end gap-3">
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        @if(auth()->user()->isEvent())
                            Filter Berdasarkan Event
                        @else
                            Filter Berdasarkan Penawaran Sponsor
                        @endif
                    </label>
                    <select id="eventFilter" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-700 bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @if(auth()->user()->isEvent())
                            <option value="">-- Tampilkan Semua Event --</option>
                            @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ $selectedEvent && $selectedEvent->id === $event->id ? 'selected' : '' }}>
                                {{ $event->title }}
                            </option>
                            @endforeach
                        @else
                            <option value="">-- Tampilkan Semua Penawaran --</option>
                            @foreach($events as $offer)
                            <option value="{{ $offer->id }}" {{ $selectedEvent && $selectedEvent->id === $offer->id ? 'selected' : '' }}>
                                {{ $offer->title }}
                            </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <button type="button" onclick="applyFilter()" class="bg-slate-700 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-slate-800 transition-colors">
                    Filter
                </button>
                @if($selectedEvent)
                <a href="{{ route('report.index') }}" class="bg-slate-200 text-slate-700 px-6 py-2.5 rounded-lg font-semibold hover:bg-slate-300 transition-colors">
                    Reset
                </a>
                @endif
            </div>
        </div>
        @endif
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 print:p-0 print:border-none print:shadow-none w-full">
        
        <div class="hidden print:block border-b-4 border-black pb-4 mb-6 text-center">
            <h1 class="text-2xl font-black uppercase tracking-widest text-black">SPONSOREA</h1>
            <p class="text-sm text-black">Platform Kemitraan Mahasiswa & Perusahaan</p>
            <p class="text-sm text-black">Kota Malang, Jawa Timur</p>
        </div>

        <div class="hidden print:block text-center mb-6">
            <h2 class="text-lg font-bold text-black uppercase underline decoration-2 underline-offset-4">Laporan Rekapitulasi Kerjasama</h2>
            @if($selectedEvent)
            <p class="text-xs text-black mt-2">Event: <span class="font-bold">{{ $selectedEvent->title }}</span></p>
            @endif
            <p class="text-xs text-black mt-2">Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB</p>
            <p class="text-xs text-black mt-1 font-bold">Pihak Terkait: {{ auth()->user()->profile->organization_name ?? auth()->user()->profile->company_name ?? auth()->user()->name }}</p>
        </div>

        @if($requests->count() > 0)
            <div class="overflow-x-auto print:overflow-visible" id="reportTable">
                <table class="w-full text-left border-collapse print:border print:border-black">
                    <thead>
                        <tr class="bg-slate-50 print:bg-transparent border-b-2 border-slate-200 print:border-black text-slate-500 print:text-black text-xs uppercase tracking-wider">
                            <th class="p-4 print:p-2 print:border print:border-black font-bold text-center w-12">No</th>
                            @if(auth()->user()->isEvent())
                                <th class="p-4 print:p-2 print:border print:border-black font-bold">Data Event</th>
                                <th class="p-4 print:p-2 print:border print:border-black font-bold">Data Sponsor</th>
                            @else
                                <th class="p-4 print:p-2 print:border print:border-black font-bold">Penawaran Kami</th>
                                <th class="p-4 print:p-2 print:border print:border-black font-bold">Event yang Disponsori</th>
                            @endif
                            <th class="p-4 print:p-2 print:border print:border-black font-bold text-center">Bentuk Support</th>
                            <th class="p-4 print:p-2 print:border print:border-black font-bold text-center">Tgl Deal</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($requests as $index => $req)
                        <tr class="border-b border-slate-100 print:border-black">
                            <td class="p-4 print:p-2 print:border print:border-black text-center text-slate-400 print:text-black font-medium">
                                {{ $index + 1 }}
                            </td>
                            @if(auth()->user()->isEvent())
                                <td class="p-4 print:p-2 print:border print:border-black">
                                    <p class="font-bold text-slate-800 print:text-black">{{ $req->event->title }}</p>
                                    <p class="text-xs text-slate-500 print:text-black">Oleh: {{ $req->event->user->profile->organization_name ?? 'Panitia' }}</p>
                                </td>
                                <td class="p-4 print:p-2 print:border print:border-black">
                                    <p class="font-bold text-indigo-600 print:text-black">{{ $req->sponsorOffer->user->profile->company_name ?? 'Company' }}</p>
                                    <p class="text-xs text-slate-500 print:text-black">{{ $req->sponsorOffer->title }}</p>
                                </td>
                            @else
                                <td class="p-4 print:p-2 print:border print:border-black">
                                    <p class="font-bold text-indigo-600 print:text-black">{{ $req->sponsorOffer->title }}</p>
                                    <p class="text-xs text-slate-500 print:text-black">{{ $req->sponsorOffer->funding_type }}</p>
                                </td>
                                <td class="p-4 print:p-2 print:border print:border-black">
                                    <p class="font-bold text-slate-800 print:text-black">{{ $req->event->title }}</p>
                                    <p class="text-xs text-slate-500 print:text-black">Penyelenggara: {{ $req->event->user->profile->organization_name ?? $req->event->user->name ?? 'Panitia' }}</p>
                                </td>
                            @endif
                            <td class="p-4 print:p-2 print:border print:border-black text-center align-middle">
                                <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-bold print:bg-transparent print:p-0 print:text-black print:font-normal print:capitalize">
                                    {{ $req->sponsorOffer->funding_type }}
                                </span>
                            </td>
                            <td class="p-4 print:p-2 print:border print:border-black text-center font-medium text-slate-600 print:text-black">
                                {{ $req->updated_at->translatedFormat('d/m/Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="hidden print:grid grid-cols-2 mt-16 gap-10 w-full px-10">
                @if(auth()->user()->isEvent())
                    <div class="text-center">
                        <p class="text-sm text-black mb-20">Pihak Pertama<br>( Penyelenggara Event )</p>
                        <p class="text-sm font-bold text-black underline decoration-1 underline-offset-4">{{ auth()->user()->name }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-black mb-20">Pihak Kedua<br>( Perusahaan / Sponsor )</p>
                        <p class="text-sm font-bold text-black underline decoration-1 underline-offset-4">(............................................)</p>
                    </div>
                @else
                    <div class="text-center">
                        <p class="text-sm text-black mb-20">Pihak Pertama<br>( Penyelenggara Event )</p>
                        <p class="text-sm font-bold text-black underline decoration-1 underline-offset-4">(............................................)</p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-black mb-20">Pihak Kedua<br>( Perusahaan / Sponsor )</p>
                        <p class="text-sm font-bold text-black underline decoration-1 underline-offset-4">{{ auth()->user()->name }}</p>
                    </div>
                @endif
            </div>

        @else
            <div class="text-center py-16 print:hidden">
                <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <p class="text-slate-500 font-medium">Belum ada data kerjasama yang disetujui.</p>
            </div>
        @endif
    </div>
</div>

<style>
    @media print {
        /* Hilangkan warna background bawaan browser */
        body { background-color: white !important; }
        
        /* Sembunyikan elemen dashboard */
        aside, header, nav { display: none !important; }
        .ml-64 { margin-left: 0 !important; }
        
        /* Hilangkan shadow dan border bawaan div utama */
        * { box-shadow: none !important; }
        
        /* Atur margin halaman biar pas kertas A4 */
        @page { size: A4 portrait; margin: 2cm; }
    }
</style>

<script>
function applyFilter() {
    const filterId = document.getElementById('eventFilter').value;
    const isCompany = {{ auth()->user()->isCompany() ? 'true' : 'false' }};
    const paramName = isCompany ? 'offer_id' : 'event_id';
    
    if (filterId) {
        window.location.href = `{{ route('report.index') }}?${paramName}=${filterId}`;
    } else {
        window.location.href = '{{ route('report.index') }}';
    }
}

// Enter key untuk filter
document.getElementById('eventFilter')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        applyFilter();
    }
});
</script>
@endsection