@extends('layouts.dashboard')

@section('title', 'Manajemen Kategori - Sponsorea')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-12 space-y-8">
    
    <div>
        <h2 class="text-3xl font-extrabold text-slate-900">Manajemen Kategori</h2>
        <p class="text-slate-500 mt-2">Atur pilihan Jenis Event dan Jenis Dukungan yang akan tampil di form pengguna.</p>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-teal-50 text-teal-700 font-bold border border-teal-100">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 bg-slate-50 border-b border-slate-100">
                <h3 class="font-extrabold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Kategori Event
                </h3>
                <form action="{{ route('admin.event-types.store') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="text" name="name" placeholder="Misal: Seminar Nasional" class="flex-1 px-4 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none" required>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-colors">Tambah</button>
                </form>
            </div>
            <div class="p-6 flex-1">
                <ul class="divide-y divide-slate-100">
                    @forelse($eventTypes as $item)
                        <li class="py-3 flex justify-between items-center group">
                            <span class="font-medium text-slate-700">{{ $item->name }}</span>
                            <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button onclick="openEditEventTypeModal({{ $item->id }}, '{{ $item->name }}')" class="text-blue-400 hover:text-blue-600">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form action="{{ route('admin.event-types.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="py-4 text-center text-slate-400 text-sm">Belum ada kategori.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 bg-slate-50 border-b border-slate-100">
                <h3 class="font-extrabold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Kategori Sponsorship
                </h3>
                <form action="{{ route('admin.funding-types.store') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="text" name="name" placeholder="Misal: Fresh Money" class="flex-1 px-4 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-teal-500 outline-none" required>
                    <button type="submit" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl transition-colors">Tambah</button>
                </form>
            </div>
            <div class="p-6 flex-1">
                <ul class="divide-y divide-slate-100">
                    @forelse($fundingTypes as $item)
                        <li class="py-3 flex justify-between items-center group">
                            <span class="font-medium text-slate-700">{{ $item->name }}</span>
                            <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button onclick="openEditFundingTypeModal({{ $item->id }}, '{{ $item->name }}')" class="text-blue-400 hover:text-blue-600">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form action="{{ route('admin.funding-types.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="py-4 text-center text-slate-400 text-sm">Belum ada kategori.</li>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>
</main>

<!-- Edit Event Type Modal -->
<div id="editEventTypeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl p-6 max-w-md mx-auto shadow-xl">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Edit Kategori Event</h3>
        
        <form id="editEventTypeForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Nama Kategori</label>
                <input type="text" id="eventTypeName" name="name" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600" required>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeEditEventTypeModal()" class="flex-1 px-4 py-2 bg-slate-200 text-slate-700 font-semibold rounded-lg hover:bg-slate-300">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Funding Type Modal -->
<div id="editFundingTypeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl p-6 max-w-md mx-auto shadow-xl">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Edit Kategori Sponsorship</h3>
        
        <form id="editFundingTypeForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Nama Kategori</label>
                <input type="text" id="fundingTypeName" name="name" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600" required>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeEditFundingTypeModal()" class="flex-1 px-4 py-2 bg-slate-200 text-slate-700 font-semibold rounded-lg hover:bg-slate-300">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
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

    // Close modal when clicking outside
    document.getElementById('editEventTypeModal').addEventListener('click', function(e) {
        if (e.target === this) closeEditEventTypeModal();
    });

    document.getElementById('editFundingTypeModal').addEventListener('click', function(e) {
        if (e.target === this) closeEditFundingTypeModal();
    });
</script>

@endsection