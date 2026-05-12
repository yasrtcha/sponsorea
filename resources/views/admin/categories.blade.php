@extends('layouts.dashboard')

@section('title', 'Manajemen Kategori - Sponsorea')

@section('content')
<div class="space-y-6 pb-12">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-[#3d3d3d] tracking-tight">Manajemen Kategori</h1>
            <p class="mt-1 text-[13px] font-medium text-gray-500">Atur pilihan Jenis Event dan Jenis Pendanaan yang tampil di form pengguna.</p>
        </div>
    </div>

    @if(session('success'))
        <!-- Toast Notification -->
        <div id="toast-success" class="fixed top-8 right-8 z-50 bg-[#f0f9f8] border border-teal-200 px-6 py-4 rounded-[1.5rem] shadow-lg flex items-center gap-3 transition-all duration-500 transform translate-y-0 opacity-100">
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

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Kategori Event -->
        <div class="bg-white rounded-[1.5rem] border border-gray-100 shadow-sm flex flex-col overflow-hidden">
            <div class="p-5 bg-[#f5f4f0]/50 border-b border-gray-100">
                <h3 class="font-extrabold text-[15px] text-[#3d3d3d] mb-4 flex items-center gap-2 uppercase tracking-wider">
                    <div class="bg-white p-1.5 rounded-lg shadow-sm border border-gray-200">
                        <svg class="w-4 h-4 text-[#f07b32]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    Kategori Event
                </h3>
                <form action="{{ route('admin.event-types.store') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="text" name="name" placeholder="Misal: Seminar Nasional" class="flex-1 px-4 py-2 text-[13px] font-medium text-[#3d3d3d] rounded-xl border border-gray-200 focus:ring-[#f07b32] focus:border-[#f07b32] outline-none transition-colors" required>
                    <button type="submit" class="px-4 py-2 bg-[#f07b32] hover:bg-[#d96a25] text-white text-[11px] font-extrabold uppercase tracking-wider rounded-xl transition-colors shadow-sm">Tambah</button>
                </form>
            </div>
            <div class="p-5 flex-1 bg-white">
                <ul class="divide-y divide-gray-100">
                    @forelse($eventTypes as $item)
                        <li class="py-3 flex justify-between items-center group -mx-5 px-5 hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-[13px] text-[#3d3d3d]">{{ $item->name }}</span>
                            <div class="flex gap-1.5 opacity-100 sm:opacity-0 group-hover:opacity-100 transition-opacity">
                                <button type="button" onclick="openEditEventTypeModal({{ $item->id }}, '{{ addslashes($item->name) }}')" class="p-1.5 text-gray-400 bg-gray-100 rounded-lg hover:text-[#f07b32] hover:bg-[#f5f4f0] transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <form action="{{ route('admin.event-types.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-400 bg-red-50 rounded-lg hover:text-red-600 hover:bg-red-100 transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="py-8 text-center flex flex-col items-center justify-center">
                            <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                            </div>
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Belum ada kategori</span>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Kategori Pendanaan/Sponsorship -->
        <div class="bg-white rounded-[1.5rem] border border-gray-100 shadow-sm flex flex-col overflow-hidden">
            <div class="p-5 bg-[#f5f4f0]/50 border-b border-gray-100">
                <h3 class="font-extrabold text-[15px] text-[#3d3d3d] mb-4 flex items-center gap-2 uppercase tracking-wider">
                    <div class="bg-white p-1.5 rounded-lg shadow-sm border border-gray-200">
                        <svg class="w-4 h-4 text-[#f07b32]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    Kategori Sponsorship
                </h3>
                <form action="{{ route('admin.funding-types.store') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="text" name="name" placeholder="Misal: Fresh Money" class="flex-1 px-4 py-2 text-[13px] font-medium text-[#3d3d3d] rounded-xl border border-gray-200 focus:ring-[#f07b32] focus:border-[#f07b32] outline-none transition-colors" required>
                    <button type="submit" class="px-4 py-2 bg-[#f07b32] hover:bg-[#d96a25] text-white text-[11px] font-extrabold uppercase tracking-wider rounded-xl transition-colors shadow-sm">Tambah</button>
                </form>
            </div>
            <div class="p-5 flex-1 bg-white">
                <ul class="divide-y divide-gray-100">
                    @forelse($fundingTypes as $item)
                        <li class="py-3 flex justify-between items-center group -mx-5 px-5 hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-[13px] text-[#3d3d3d]">{{ $item->name }}</span>
                            <div class="flex gap-1.5 opacity-100 sm:opacity-0 group-hover:opacity-100 transition-opacity">
                                <button type="button" onclick="openEditFundingTypeModal({{ $item->id }}, '{{ addslashes($item->name) }}')" class="p-1.5 text-gray-400 bg-gray-100 rounded-lg hover:text-emerald-600 hover:bg-emerald-50 transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <form action="{{ route('admin.funding-types.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-400 bg-red-50 rounded-lg hover:text-red-600 hover:bg-red-100 transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="py-8 text-center flex flex-col items-center justify-center">
                            <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                            </div>
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Belum ada kategori</span>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>
</div>

<!-- Edit Event Type Modal -->
<div id="editEventTypeModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-[#3d3d3d]/50 backdrop-blur-sm transition-opacity"></div>
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0 relative">
        <div class="relative transform overflow-hidden rounded-[2rem] bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-sm">
            <div class="bg-white px-6 pb-6 pt-7">
                <div class="mx-auto flex w-12 h-12 items-center justify-center rounded-full bg-[#f5f4f0] text-[#f07b32] mb-4">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                </div>
                <h3 class="text-[15px] font-extrabold text-[#3d3d3d] mb-4 text-center uppercase tracking-wider">Edit Kategori Event</h3>
                
                <form id="editEventTypeForm" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-[11px] font-extrabold text-[#3d3d3d] mb-1.5 uppercase tracking-wider">Nama Kategori</label>
                        <input type="text" id="eventTypeName" name="name" class="w-full px-4 py-2.5 text-[13px] font-medium text-[#3d3d3d] border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#f07b32] focus:border-transparent transition-all" required>
                    </div>
                </form>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex gap-3 flex-col-reverse sm:flex-row sm:justify-end border-t border-gray-100">
                <button type="button" onclick="closeEditEventTypeModal()" class="inline-flex w-full justify-center rounded-[1rem] bg-white px-4 py-2.5 text-[11px] font-extrabold text-[#3d3d3d] border border-gray-200 hover:bg-gray-50 transition-colors uppercase tracking-wider sm:w-auto mt-2 sm:mt-0">
                    Batal
                </button>
                <button type="button" onclick="document.getElementById('editEventTypeForm').submit()" class="inline-flex w-full justify-center rounded-[1rem] bg-[#f07b32] px-4 py-2.5 text-[11px] font-extrabold text-white shadow-sm hover:bg-[#d96a25] transition-colors uppercase tracking-wider sm:w-auto">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Funding Type Modal -->
<div id="editFundingTypeModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-[#3d3d3d]/50 backdrop-blur-sm transition-opacity"></div>
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0 relative">
        <div class="relative transform overflow-hidden rounded-[2rem] bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-sm">
            <div class="bg-white px-6 pb-6 pt-7">
                <div class="mx-auto flex w-12 h-12 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 mb-4">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                </div>
                <h3 class="text-[15px] font-extrabold text-[#3d3d3d] mb-4 text-center uppercase tracking-wider">Edit Kategori Sponsorship</h3>
                
                <form id="editFundingTypeForm" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-[11px] font-extrabold text-[#3d3d3d] mb-1.5 uppercase tracking-wider">Nama Kategori</label>
                        <input type="text" id="fundingTypeName" name="name" class="w-full px-4 py-2.5 text-[13px] font-medium text-[#3d3d3d] border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all" required>
                    </div>
                </form>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex gap-3 flex-col-reverse sm:flex-row sm:justify-end border-t border-gray-100">
                <button type="button" onclick="closeEditFundingTypeModal()" class="inline-flex w-full justify-center rounded-[1rem] bg-white px-4 py-2.5 text-[11px] font-extrabold text-[#3d3d3d] border border-gray-200 hover:bg-gray-50 transition-colors uppercase tracking-wider sm:w-auto mt-2 sm:mt-0">
                    Batal
                </button>
                <button type="button" onclick="document.getElementById('editFundingTypeForm').submit()" class="inline-flex w-full justify-center rounded-[1rem] bg-emerald-600 px-4 py-2.5 text-[11px] font-extrabold text-white shadow-sm hover:bg-emerald-700 transition-colors uppercase tracking-wider sm:w-auto">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openEditEventTypeModal(id, name) {
        document.getElementById('eventTypeName').value = name;
        document.getElementById('editEventTypeForm').action = `/admin/event-types/${id}`;
        document.getElementById('editEventTypeModal').classList.remove('hidden');
    }

    function closeEditEventTypeModal() {
        document.getElementById('editEventTypeModal').classList.add('hidden');
    }

    function openEditFundingTypeModal(id, name) {
        document.getElementById('fundingTypeName').value = name;
        document.getElementById('editFundingTypeForm').action = `/admin/funding-types/${id}`;
        document.getElementById('editFundingTypeModal').classList.remove('hidden');
    }

    function closeEditFundingTypeModal() {
        document.getElementById('editFundingTypeModal').classList.add('hidden');
    }

    // Close modal when clicking outside background overlay
    window.addEventListener('click', function(e) {
        const eventModalBg = document.querySelector('#editEventTypeModal .bg-\\[\\#3d3d3d\\]\\/50');
        const fundModalBg = document.querySelector('#editFundingTypeModal .bg-\\[\\#3d3d3d\\]\\/50');
        
        if (e.target === eventModalBg) closeEditEventTypeModal();
        if (e.target === fundModalBg) closeEditFundingTypeModal();
    });
</script>

@endsection