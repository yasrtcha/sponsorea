@extends('layouts.dashboard')

@section('title', 'Status Pengajuan')
@section('page_title', 'Riwayat Pengajuan Sponsor')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($requests->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="p-5 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest">Event Anda</th>
                            <th class="p-5 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest">Perusahaan Tujuan</th>
                            <th class="p-5 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest">Pesan</th>
                            <th class="p-5 text-[11px] font-extrabold text-gray-400 uppercase tracking-widest text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($requests as $req)
                        <tr class="group hover:bg-[#fcf5f5]/30 transition-all duration-300">
                            <td class="p-5">
                                <p class="font-extrabold text-black text-sm transition-colors">{{ $req->event->title }}</p>
                                <p class="text-[10px] text-gray-400 font-bold mt-1 uppercase tracking-wider">Dikirim {{ $req->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="p-5">
                                <p class="font-extrabold text-black text-sm transition-colors">{{ $req->sponsorOffer->user->profile->company_name ?? 'Perusahaan' }}</p>
                                <p class="text-[11px] text-gray-500 font-medium mt-1">{{ $req->sponsorOffer->title }}</p>
                            </td>
                            <td class="p-5">
                                <p class="text-[11px] text-gray-600 italic line-clamp-2 mb-2 font-medium">"{{ $req->message }}"</p>
                            </td>
                            <td class="p-5 text-center">
                                @if($req->status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[10px] font-black uppercase tracking-wider border border-amber-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5 align-middle"></span>
                                        Menunggu
                                    </span>
                                @elseif($req->status === 'awaiting_mou')
                                    <div class="flex flex-col items-center gap-2">
                                        <span class="inline-flex items-center px-3 py-1 bg-orange-50 text-orange-600 rounded-full text-[10px] font-black uppercase tracking-wider border border-orange-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500 mr-1.5 align-middle animate-pulse"></span>
                                            Menunggu MoU
                                        </span>
                                        @if(!$req->mou_path)
                                            <button onclick="openMoUModal({{ $req->id }}, '{{ $req->event->title }}', '{{ $req->sponsorOffer->user->profile->company_name ?? 'Perusahaan' }}')" class="inline-flex items-center gap-1.5 text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-[10px] font-extrabold uppercase tracking-wider border border-transparent hover:shadow-sm transition-all mt-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                Upload MoU
                                            </button>
                                        @else
                                            <a href="{{ asset('storage/' . $req->mou_path) }}" target="_blank" class="inline-flex items-center gap-1.5 text-green-600 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg text-[10px] font-extrabold uppercase tracking-wider border border-transparent hover:shadow-sm transition-all mt-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Lihat MoU
                                            </a>
                                        @endif
                                    </div>
                                @elseif($req->status === 'approved')
                                    <div class="flex flex-col items-center gap-2">
                                        <span class="inline-flex items-center px-3 py-1 bg-teal-50 text-teal-600 rounded-full text-[10px] font-black uppercase tracking-wider border border-teal-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-teal-500 mr-1.5 align-middle"></span>
                                            Diterima
                                        </span>
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
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <h3 class="text-xl font-extrabold text-[#3d3d3d] mb-2">Belum Ada Pengajuan</h3>
                <p class="text-gray-500 mb-8 max-w-sm font-medium">Belum ada pengajuan kerjasama yang kamu kirim.</p>
                <a href="{{ route('explore.index') }}" class="bg-[#f07b32] text-white px-8 py-3.5 rounded-xl font-extrabold hover:bg-[#d96a25] transition-all shadow-lg shadow-[#f07b32]/20 hover:shadow-[#f07b32]/30">
                    Mulai Cari Sponsor
                </a>
            </div>
        @endif
    </div>

    <!-- MoU Upload Modal -->
    <div id="mouModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-slate-800">Upload Kontrak MoU</h3>
                <button onclick="closeMoUModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="mb-4">
                <p class="text-sm text-slate-600 mb-2">Event: <span id="modalEventTitle" class="font-semibold"></span></p>
                <p class="text-sm text-slate-600">Perusahaan: <span id="modalCompanyName" class="font-semibold"></span></p>
            </div>
            
            <form id="mouForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih File Kontrak MoU (PDF)</label>
                    <input type="file" name="mou_file" accept=".pdf" required class="block w-full text-sm border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-slate-500 mt-1">Maksimal 5MB, format PDF</p>
                </div>
                
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeMoUModal()" class="flex-1 bg-slate-100 text-slate-700 hover:bg-slate-200 px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                        Upload MoU
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
function openMoUModal(requestId, eventTitle, companyName) {
    document.getElementById('modalEventTitle').textContent = eventTitle;
    document.getElementById('modalCompanyName').textContent = companyName;
    document.getElementById('mouForm').action = `/request/${requestId}/upload-mou`;
    document.getElementById('mouModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeMoUModal() {
    document.getElementById('mouModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    // Reset form
    document.getElementById('mouForm').reset();
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
document.getElementById('mouModal').addEventListener('click', function(e) {
    if (e.target === this) closeMoUModal();
});

document.getElementById('rejectionNotesModal').addEventListener('click', function(e) {
    if (e.target === this) closeRejectionNotesModal();
});

// Close modals with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        if (!document.getElementById('mouModal').classList.contains('hidden')) {
            closeMoUModal();
        }
        if (!document.getElementById('rejectionNotesModal').classList.contains('hidden')) {
            closeRejectionNotesModal();
        }
    }
});
</script>