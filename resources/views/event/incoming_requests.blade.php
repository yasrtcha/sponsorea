@extends('layouts.dashboard')
@section('title', 'Tawaran Masuk')
@section('page_title', 'Tawaran Sponsor dari Perusahaan')

@section('content')
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-teal-50 border border-teal-100 text-teal-700 font-bold">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        @if($requests->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-sm">
                            <th class="p-4 font-semibold">Perusahaan Pengirim</th>
                            <th class="p-4 font-semibold">Event Anda yang Dituju</th>
                            <th class="p-4 font-semibold">Pesan & Berkas</th>
                            <th class="p-4 font-semibold text-right">Aksi Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $req)
                        <tr class="border-b border-slate-50 hover:bg-slate-50 transition-colors">
                            <td class="p-4">
                                <p class="font-bold text-slate-800">{{ $req->sponsorOffer->user->profile->company_name ?? 'Company' }}</p>
                                <p class="text-xs text-slate-500">{{ $req->sponsorOffer->title }}</p>
                                <span class="bg-teal-50 text-teal-700 px-2 py-0.5 rounded text-[10px] font-bold mt-1 inline-block">{{ $req->sponsorOffer->funding_type }}</span>
                            </td>
                            <td class="p-4 font-semibold text-indigo-600">{{ $req->event->title }}</td>
                            
                            <td class="p-4">
                                <p class="text-xs text-slate-600 italic line-clamp-2 mb-2">"{{ $req->message }}"</p>
                                @if($req->sponsorOffer && $req->sponsorOffer->guideline_pdf)
                                    <a href="{{ asset('storage/' . $req->sponsorOffer->guideline_pdf) }}" target="_blank" class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800 text-xs font-bold bg-indigo-50 px-2 py-1 rounded">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Buka Guideline PDF
                                    </a>
                                @endif
                            </td>

                            <td class="p-4 text-right">
                                @if($req->status === 'pending')
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="openRejectModal({{ $req->id }}, '{{ $req->event->title }}', '{{ $req->sponsorOffer->user->profile->company_name ?? 'Perusahaan' }}')" class="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-xl text-xs font-bold transition-colors">
                                            Tolak
                                        </button>
                                        <form action="{{ route('request.update_status', $req->id) }}" method="POST" onsubmit="return confirm('Terima tawaran sponsor ini?');">
                                            @csrf @method('PUT') <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="bg-teal-600 text-white hover:bg-teal-700 px-4 py-2 rounded-xl text-xs font-bold transition-colors shadow-sm">Terima</button>
                                        </form>
                                    </div>
                                @elseif($req->status === 'approved')
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-end gap-2">
                                            <span class="px-3 py-1 bg-teal-50 text-teal-600 rounded-full text-xs font-bold ring-1 ring-teal-100">Disetujui</span>
                                        </div>
                                        @if(!$req->mou_path)
                                            <button onclick="openMoUModal({{ $req->id }}, '{{ $req->event->title }}', '{{ $req->sponsorOffer->user->profile->company_name ?? 'Perusahaan' }}')" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 text-xs font-bold bg-blue-50 px-3 py-1 rounded-lg transition-colors">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                Upload MoU
                                            </button>
                                        @else
                                            <a href="{{ asset('storage/' . $req->mou_path) }}" target="_blank" class="inline-flex items-center gap-1 text-green-600 hover:text-green-800 text-xs font-bold bg-green-50 px-3 py-1 rounded-lg transition-colors">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Lihat MoU
                                            </a>
                                        @endif
                                    </div>
                                @else
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-end gap-2">
                                            <span class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-xs font-bold ring-1 ring-red-100">Ditolak</span>
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
            <div class="p-12 text-center text-slate-500">Belum ada tawaran sponsor yang masuk dari perusahaan.</div>
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

    <!-- Rejection Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-slate-800">Tolak Tawaran</h3>
                <button onclick="closeRejectModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="mb-4">
                <p class="text-sm text-slate-600 mb-2">Event: <span id="rejectEventTitle" class="font-semibold"></span></p>
                <p class="text-sm text-slate-600">Perusahaan: <span id="rejectSenderName" class="font-semibold"></span></p>
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
                        Tolak Tawaran
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
document.getElementById('mouModal').addEventListener('click', function(e) {
    if (e.target === this) closeMoUModal();
});

document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) closeRejectModal();
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
        if (!document.getElementById('rejectModal').classList.contains('hidden')) {
            closeRejectModal();
        }
        if (!document.getElementById('rejectionNotesModal').classList.contains('hidden')) {
            closeRejectionNotesModal();
        }
    }
});
</script>