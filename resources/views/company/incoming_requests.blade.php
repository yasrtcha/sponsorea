@extends('layouts.dashboard')

@section('title', 'Proposal Masuk')
@section('page_title', 'Proposal Masuk')

@section('content')
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-teal-50 border border-teal-100 text-teal-700 font-bold">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($requests->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="p-5 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest">Pengirim (Event)</th>
                            <th class="p-5 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest">Program yang Dilamar</th>
                            <th class="p-5 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest">Pesan & Berkas</th>
                            <th class="p-5 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest text-center">Aksi Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($requests as $req)
                        <tr class="group hover:bg-[#fcf5f5]/30 transition-all duration-300">
                            <td class="p-5">
                                <p class="font-extrabold text-black text-sm transition-colors">{{ $req->event->title }}</p>
                                <p class="text-[11px] text-gray-500 font-medium mt-1">Oleh: {{ $req->event->user->profile->organization_name ?? 'Panitia' }}</p>
                                <p class="text-[10px] text-gray-400 font-bold mt-1 uppercase tracking-wider">{{ \Carbon\Carbon::parse($req->event->event_date)->translatedFormat('d M Y') }}</p>
                            </td>
                            <td class="p-5">
                                <p class="font-extrabold text-black text-sm mb-2 transition-colors">{{ $req->sponsorOffer->title }}</p>
                                <span class="inline-block bg-[#f5f4f0] text-gray-600 px-3 py-1.5 rounded-lg text-[10px] font-extrabold uppercase tracking-wider border border-gray-100">
                                    {{ $req->sponsorOffer->funding_type }}
                                </span>
                            </td>
                            <td class="p-5">
                                <p class="text-[11px] text-gray-600 italic line-clamp-2 mb-2 font-medium">"{{ $req->message }}"</p>
                                @if($req->event->proposal_pdf)
                                    <a href="{{ asset('storage/' . $req->event->proposal_pdf) }}" target="_blank" class="inline-flex items-center gap-1.5 text-teal-600 bg-teal-50 hover:bg-teal-100 px-3 py-1.5 rounded-lg text-[10px] font-extrabold uppercase tracking-wider border border-transparent hover:shadow-sm transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Buka Proposal PDF
                                    </a>
                                @endif
                            </td>
                            <td class="p-5 text-center">
                                @if($req->status === 'pending')
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="openRejectModal({{ $req->id }}, '{{ $req->event->title }}', '{{ $req->event->user->profile->organization_name ?? 'Panitia' }}')" class="bg-red-50 text-red-600 hover:bg-red-100 border border-transparent px-4 py-2 rounded-xl text-[11px] font-extrabold uppercase tracking-wider transition-all hover:shadow-md">
                                            Tolak
                                        </button>
                                        <form action="{{ route('request.update_status', $req->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menyetujui proposal ini?');" class="m-0 p-0" style="display: inline-flex; align-items: center;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="bg-teal-500 text-white hover:bg-teal-600 px-4 py-2 rounded-xl text-[11px] font-extrabold uppercase tracking-wider transition-all hover:shadow-md shadow-teal-500/20">Terima</button>
                                        </form>
                                    </div>
                                @elseif($req->status === 'awaiting_mou')
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-center gap-2">
                                            <span class="inline-flex items-center px-3 py-1 bg-orange-50 text-orange-600 rounded-full text-[10px] font-black uppercase tracking-wider border border-orange-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-orange-500 mr-1.5 align-middle animate-pulse"></span>
                                                Menunggu MoU
                                            </span>
                                        </div>
                                        @if(!$req->mou_path)
                                            <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider">Menunggu MoU...</span>
                                        @else
                                            <a href="{{ asset('storage/' . $req->mou_path) }}" target="_blank" class="inline-flex items-center gap-1.5 text-green-600 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg text-[10px] font-extrabold uppercase tracking-wider border border-transparent hover:shadow-sm transition-all mt-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Lihat MoU
                                            </a>
                                        @endif
                                    </div>
                                @elseif($req->status === 'approved')
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-center gap-2">
                                            <span class="inline-flex items-center px-3 py-1 bg-teal-50 text-teal-600 rounded-full text-[10px] font-black uppercase tracking-wider border border-teal-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-teal-500 mr-1.5 align-middle"></span>
                                                Diterima
                                            </span>
                                        </div>
                                        @if($req->mou_path)
                                            <a href="{{ asset('storage/' . $req->mou_path) }}" target="_blank" class="inline-flex items-center gap-1.5 text-green-600 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg text-[10px] font-extrabold uppercase tracking-wider border border-transparent hover:shadow-sm transition-all mt-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Lihat MoU
                                            </a>
                                        @endif
                                    </div>
                                @else
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-center gap-2">
                                            <span class="inline-flex items-center px-3 py-1 bg-red-50 text-red-600 rounded-full text-[10px] font-black uppercase tracking-wider border border-red-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5 align-middle"></span>
                                                Ditolak
                                            </span>
                                        </div>
                                        @if($req->rejection_notes)
                                            <button onclick="showRejectionNotes('{{ $req->rejection_notes }}')" class="inline-flex items-center gap-1.5 text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg text-[10px] font-extrabold uppercase tracking-wider border border-transparent hover:shadow-sm transition-all mt-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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
            <div class="py-20 text-center flex flex-col items-center justify-center px-6">
                <div class="w-20 h-20 bg-[#f5f4f0] text-[#3d3d3d]/20 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <h3 class="text-xl font-extrabold text-[#3d3d3d] mb-2">Belum Ada Proposal Masuk</h3>
                <p class="text-gray-500 max-w-sm font-medium">Belum ada proposal event yang masuk ke program Anda.</p>
            </div>
        @endif
    </div>

    <!-- Rejection Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-slate-800">Tolak Proposal</h3>
                <button onclick="closeRejectModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="mb-4">
                <p class="text-sm text-slate-600 mb-2">Event: <span id="rejectEventTitle" class="font-semibold"></span></p>
                <p class="text-sm text-slate-600">Pengirim: <span id="rejectSenderName" class="font-semibold"></span></p>
            </div>
            
            <form id="rejectForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="rejected">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                    <textarea name="rejection_notes" required rows="4" class="block w-full text-sm border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500 resize-none" placeholder="Berikan alasan penolakan yang jelas..."></textarea>
                    <p class="text-xs text-slate-500 mt-1">Maksimal 1000 karakter</p>
                </div>
                
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeRejectModal()" class="flex-1 bg-slate-100 text-slate-700 hover:bg-slate-200 px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 bg-red-600 text-white hover:bg-red-700 px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                        Tolak Proposal
                    </button>
                </div>
            </form>
        </div>
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
function openRejectModal(requestId, eventTitle, senderName) {
    document.getElementById('rejectEventTitle').textContent = eventTitle;
    document.getElementById('rejectSenderName').textContent = senderName;
    document.getElementById('rejectForm').action = `/request/${requestId}/status`;
    document.getElementById('rejectModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    document.getElementById('rejectForm').reset();
}

function showRejectionNotes(notes) {
    document.getElementById('rejectionNotesContent').textContent = notes;
    document.getElementById('rejectionNotesModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeRejectionNotesModal() {
    document.getElementById('rejectionNotesModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modals when clicking outside
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) closeRejectModal();
});

document.getElementById('rejectionNotesModal').addEventListener('click', function(e) {
    if (e.target === this) closeRejectionNotesModal();
});

// Close modals with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        if (!document.getElementById('rejectModal').classList.contains('hidden')) {
            closeRejectModal();
        }
        if (!document.getElementById('rejectionNotesModal').classList.contains('hidden')) {
            closeRejectionNotesModal();
        }
    }
});
</script>