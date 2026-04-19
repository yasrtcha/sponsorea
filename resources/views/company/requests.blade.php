@extends('layouts.dashboard')

@section('title', 'Status Penawaran')
@section('page_title', 'Status Penawaran Sponsor')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        @if($requests->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-sm">
                            <th class="p-4 font-semibold">Event Tujuan</th>
                            <th class="p-4 font-semibold">Program yang Ditawarkan</th>
                            <th class="p-4 font-semibold">Pesan Sapaan</th>
                            <th class="p-4 font-semibold text-center">Status Respon</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $req)
                        <tr class="border-b border-slate-50 hover:bg-slate-50 transition-colors">
                            <td class="p-4">
                                <p class="font-bold text-slate-800">{{ $req->event->title }}</p>
                                <p class="text-[10px] text-slate-400">Oleh: {{ $req->event->user->profile->organization_name ?? 'Panitia' }}</p>
                                <p class="text-[10px] text-slate-400">Dikirim {{ $req->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="p-4">
                                <p class="font-semibold text-teal-600">{{ $req->sponsorOffer->title }}</p>
                                <span class="bg-teal-50 text-teal-700 px-2 py-0.5 rounded text-[10px] font-bold mt-1 inline-block">{{ $req->sponsorOffer->funding_type }}</span>
                            </td>
                            <td class="p-4">
                                <p class="text-xs text-slate-600 italic line-clamp-2">"{{ $req->message }}"</p>
                            </td>
                            <td class="p-4 text-center">
                                @if($req->status === 'pending')
                                    <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[10px] font-bold ring-1 ring-amber-100">Menunggu Respon</span>
                                @elseif($req->status === 'approved')
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-center gap-2">
                                            <span class="px-3 py-1 bg-teal-50 text-teal-600 rounded-full text-[10px] font-bold ring-1 ring-teal-100">Disetujui Panitia</span>
                                        </div>
                                        @if($req->mou_path)
                                            <a href="{{ asset('storage/' . $req->mou_path) }}" target="_blank" class="inline-flex items-center gap-1 text-green-600 hover:text-green-800 text-xs font-bold bg-green-50 px-3 py-1 rounded-lg transition-colors">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Lihat MoU
                                            </a>
                                        @else
                                            <span class="text-xs text-slate-400 font-semibold">Menunggu MoU...</span>
                                        @endif
                                    </div>
                                @else
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-center gap-2">
                                            <span class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-[10px] font-bold ring-1 ring-red-100">Ditolak Panitia</span>
                                        </div>
                                        @if($req->rejection_notes)
                                            <button onclick="showRejectionNotes('{{ $req->rejection_notes }}')" class="inline-flex items-center gap-1 text-red-600 hover:text-red-800 text-xs font-bold bg-red-50 px-3 py-1 rounded-lg transition-colors">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Lihat Alasan
                                            </button>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </div>
                <p class="text-slate-500">Entry Laboratory belum mengirimkan tawaran sponsor ke event manapun.</p>
                <a href="{{ route('explore.index') }}" class="text-indigo-600 font-bold text-sm mt-2 inline-block">Cari Event untuk Disponsori</a>
            </div>
        @endif
    </div>

    <!-- Rejection Notes Modal -->
    <div id="rejectionNotesModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-slate-800">Alasan Penolakan</h3>
                <button onclick="closeRejectionNotesModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <p id="rejectionNotesContent" class="text-sm text-slate-700 leading-relaxed"></p>
            </div>
            
            <div class="flex justify-end pt-4">
                <button onclick="closeRejectionNotesModal()" class="bg-slate-100 text-slate-700 hover:bg-slate-200 px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>
@endsection

<script>
function showRejectionNotes(notes) {
    document.getElementById('rejectionNotesContent').textContent = notes;
    document.getElementById('rejectionNotesModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeRejectionNotesModal() {
    document.getElementById('rejectionNotesModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('rejectionNotesModal').addEventListener('click', function(e) {
    if (e.target === this) closeRejectionNotesModal();
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !document.getElementById('rejectionNotesModal').classList.contains('hidden')) {
        closeRejectionNotesModal();
    }
});
</script>