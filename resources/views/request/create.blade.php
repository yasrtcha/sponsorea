@extends('layouts.app') 
@section('content')
<div class="max-w-3xl mx-auto px-6 py-12">
    
    <div class="mb-8">
        <a href="{{ route('explore.index') }}" class="text-sm font-semibold text-slate-500 hover:text-indigo-600 flex items-center gap-2 mb-4">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Eksplorasi
        </a>
        <h2 class="text-3xl font-extrabold text-slate-900">
            {{ $type === 'offer' ? 'Ajukan Proposal Sponsor' : 'Tawarkan Program Sponsor' }}
        </h2>
        <p class="text-slate-500 mt-2">Pilih aset milikmu dan kirimkan pesan sapaan untuk memulai kerjasama.</p>
    </div>

    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 mb-8 flex items-center gap-4">
        <div class="w-12 h-12 rounded-full {{ $type === 'offer' ? 'bg-teal-100 text-teal-600' : 'bg-indigo-100 text-indigo-600' }} flex items-center justify-center font-bold text-xl">
            {{ substr($target->title, 0, 1) }}
        </div>
        <div>
            <p class="text-xs font-bold uppercase text-slate-500 mb-1">Target Pengajuan:</p>
            <h3 class="text-lg font-bold text-slate-800">{{ $target->title }}</h3>
        </div>
    </div>

    <div class="bg-white p-8 rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100">
        <form action="{{ route('request.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <input type="hidden" name="target_type" value="{{ $type }}">
            <input type="hidden" name="target_id" value="{{ $target->id }}">

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    {{ $type === 'offer' ? 'Pilih Event Kamu' : 'Pilih Penawaran Sponsor Kamu' }}
                </label>
                <select name="my_asset_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 {{ $type === 'offer' ? 'focus:ring-teal-500' : 'focus:ring-indigo-500' }} focus:outline-none transition-all bg-white" required>
                    <option value="" disabled selected>-- Silakan Pilih --</option>
                    @foreach($myAssets as $asset)
                        <option value="{{ $asset->id }}">{{ $asset->title }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-500 mt-2">
                    Data {{ $type === 'offer' ? 'proposal' : 'guideline' }} dari aset yang dipilih akan otomatis diteruskan.
                </p>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Pesan Pengantar (Sapaan)</label>
                <textarea name="message" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 {{ $type === 'offer' ? 'focus:ring-teal-500' : 'focus:ring-indigo-500' }} focus:outline-none transition-all resize-none" placeholder="Halo kak, event kami sangat relevan dengan brand perusahaan kakak lho..." required></textarea>
            </div>

            <button type="submit" class="w-full py-4 rounded-xl font-bold text-white transition-all shadow-lg {{ $type === 'offer' ? 'bg-teal-600 hover:bg-teal-700 shadow-teal-200' : 'bg-indigo-600 hover:bg-indigo-700 shadow-indigo-200' }}">
                Kirim Pengajuan Sekarang
            </button>
        </form>
    </div>
</div>
@endsection