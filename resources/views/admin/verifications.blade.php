@extends('layouts.dashboard')

@section('title', 'Verifikasi Akun - Sponsorea')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-50 py-12 px-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 mb-2">Verifikasi Akun Pengguna</h1>
            <p class="text-slate-600">Kelola verifikasi akun pendaftar baru</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabs Navigation -->
        <div class="mb-6 flex gap-4 border-b border-slate-200">
            <button onclick="switchTab('pending')" id="tab-pending" class="px-4 py-3 font-semibold border-b-2 border-indigo-600 text-indigo-600 focus:outline-none">
                📋 Menunggu Verifikasi
            </button>
            <button onclick="switchTab('approved')" id="tab-approved" class="px-4 py-3 font-semibold border-b-2 border-transparent text-slate-600 hover:text-slate-900 focus:outline-none">
                ✅ Disetujui
            </button>
            <button onclick="switchTab('rejected')" id="tab-rejected" class="px-4 py-3 font-semibold border-b-2 border-transparent text-slate-600 hover:text-slate-900 focus:outline-none">
                ❌ Ditolak
            </button>
        </div>

        <!-- Pending Tab -->
        <div id="pending-content" class="tab-content">
            @if($pending->isEmpty())
                <div class="text-center py-12 bg-white rounded-lg border border-slate-200">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="text-slate-500">Tidak ada akun yang menunggu verifikasi</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($pending as $user)
                        <div class="bg-white rounded-lg border border-slate-200 p-6 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-slate-900">{{ $user->name }}</h3>
                                    <p class="text-slate-600 text-sm">{{ $user->email }}</p>
                                    <p class="text-slate-600 text-sm mt-1">
                                        Tipe: <span class="font-medium">
                                            @if($user->role === 'event') 📚 Event Organizer
                                            @elseif($user->role === 'company') 🏢 Sponsor/Company
                                            @else {{ $user->role }}
                                            @endif
                                        </span>
                                    </p>
                                </div>
                                
                                <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">
                                    ⏳ Menunggu
                                </span>
                            </div>

                            @if($user->profile)
                                <div class="border-t border-slate-200 pt-4 mb-4">
                                    <h4 class="font-semibold text-slate-800 mb-3">📋 Data Profil:</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                        @if($user->profile->phone_number)
                                            <div>
                                                <span class="text-slate-500">📞 Nomor HP:</span>
                                                <p class="text-slate-800 font-medium">{{ $user->profile->phone_number }}</p>
                                            </div>
                                        @endif
                                        
                                        @if($user->profile->address)
                                            <div>
                                                <span class="text-slate-500">📍 Alamat:</span>
                                                <p class="text-slate-800 font-medium">{{ $user->profile->address }}</p>
                                            </div>
                                        @endif

                                        @if($user->isEvent() && $user->profile->organization_name)
                                            <div>
                                                <span class="text-slate-500">🏛️ Organisasi:</span>
                                                <p class="text-slate-800 font-medium">{{ $user->profile->organization_name }}</p>
                                            </div>
                                        @endif

                                        @if($user->isCompany() && $user->profile->company_name)
                                            <div>
                                                <span class="text-slate-500">🏢 Perusahaan:</span>
                                                <p class="text-slate-800 font-medium">{{ $user->profile->company_name }}</p>
                                            </div>
                                        @endif

                                        @if($user->isCompany() && $user->profile->company_sector)
                                            <div>
                                                <span class="text-slate-500">🏭 Sektor:</span>
                                                <p class="text-slate-800 font-medium">{{ $user->profile->company_sector }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    @if($user->profile->description)
                                        <div class="mt-3">
                                            <span class="text-slate-500 text-sm">📝 Deskripsi:</span>
                                            <p class="text-slate-800 text-sm mt-1 bg-slate-50 p-3 rounded">{{ $user->profile->description }}</p>
                                        </div>
                                    @endif

                                    @if($user->profile->instagram || $user->profile->tiktok)
                                        <div class="mt-3">
                                            <span class="text-slate-500 text-sm">📱 Media Sosial:</span>
                                            <div class="flex gap-3 mt-1 text-sm">
                                                @if($user->profile->instagram)
                                                    <span class="text-slate-800">📸 Instagram: <span class="font-medium">{{ $user->profile->instagram }}</span></span>
                                                @endif
                                                @if($user->profile->tiktok)
                                                    <span class="text-slate-800">🎵 TikTok: <span class="font-medium">{{ $user->profile->tiktok }}</span></span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <div class="flex gap-3 mt-6">
                                <button onclick="openApprovalModal({{ $user->id }}, '{{ $user->name }}')" class="flex-1 px-4 py-2.5 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                                    ✓ Approve
                                </button>
                                <button onclick="openRejectionModal({{ $user->id }}, '{{ $user->name }}')" class="flex-1 px-4 py-2.5 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
                                    ✕ Reject
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Approved Tab -->
        <div id="approved-content" class="tab-content hidden">
            @if($approved->isEmpty())
                <div class="text-center py-12 bg-white rounded-lg border border-slate-200">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-slate-500">Tidak ada akun yang disetujui</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($approved as $user)
                        <div class="bg-white rounded-lg border border-slate-200 p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-slate-900">{{ $user->name }}</h3>
                                    <p class="text-slate-600 text-sm">{{ $user->email }}</p>
                                    <p class="text-slate-600 text-sm mt-1">
                                        Tipe: <span class="font-medium">
                                            @if($user->role === 'event') 📚 Event Organizer
                                            @elseif($user->role === 'company') 🏢 Sponsor/Company
                                            @else {{ $user->role }}
                                            @endif
                                        </span>
                                    </p>
                                </div>
                                
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                    ✓ Disetujui
                                </span>
                            </div>

                            @if($user->profile)
                                <div class="border-t border-slate-200 pt-4 mb-4">
                                    <h4 class="font-semibold text-slate-800 mb-3">📋 Data Profil:</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                        @if($user->profile->phone_number)
                                            <div>
                                                <span class="text-slate-500">📞 Nomor HP:</span>
                                                <p class="text-slate-800 font-medium">{{ $user->profile->phone_number }}</p>
                                            </div>
                                        @endif
                                        
                                        @if($user->profile->address)
                                            <div>
                                                <span class="text-slate-500">📍 Alamat:</span>
                                                <p class="text-slate-800 font-medium">{{ $user->profile->address }}</p>
                                            </div>
                                        @endif

                                        @if($user->isEvent() && $user->profile->organization_name)
                                            <div>
                                                <span class="text-slate-500">🏛️ Organisasi:</span>
                                                <p class="text-slate-800 font-medium">{{ $user->profile->organization_name }}</p>
                                            </div>
                                        @endif

                                        @if($user->isCompany() && $user->profile->company_name)
                                            <div>
                                                <span class="text-slate-500">🏢 Perusahaan:</span>
                                                <p class="text-slate-800 font-medium">{{ $user->profile->company_name }}</p>
                                            </div>
                                        @endif

                                        @if($user->isCompany() && $user->profile->company_sector)
                                            <div>
                                                <span class="text-slate-500">🏭 Sektor:</span>
                                                <p class="text-slate-800 font-medium">{{ $user->profile->company_sector }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    @if($user->profile->description)
                                        <div class="mt-3">
                                            <span class="text-slate-500 text-sm">📝 Deskripsi:</span>
                                            <p class="text-slate-800 text-sm mt-1 bg-slate-50 p-3 rounded">{{ $user->profile->description }}</p>
                                        </div>
                                    @endif

                                    @if($user->profile->instagram || $user->profile->tiktok)
                                        <div class="mt-3">
                                            <span class="text-slate-500 text-sm">📱 Media Sosial:</span>
                                            <div class="flex gap-3 mt-1 text-sm">
                                                @if($user->profile->instagram)
                                                    <span class="text-slate-800">📸 Instagram: <span class="font-medium">{{ $user->profile->instagram }}</span></span>
                                                @endif
                                                @if($user->profile->tiktok)
                                                    <span class="text-slate-800">🎵 TikTok: <span class="font-medium">{{ $user->profile->tiktok }}</span></span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <p class="text-slate-500 text-xs mt-4">
                                Disetujui pada: {{ $user->verified_at?->format('d M Y H:i') ?? '-' }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Rejected Tab -->
        <div id="rejected-content" class="tab-content hidden">
            @if($rejected->isEmpty())
                <div class="text-center py-12 bg-white rounded-lg border border-slate-200">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <p class="text-slate-500">Tidak ada akun yang ditolak</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($rejected as $user)
                        <div class="bg-white rounded-lg border border-red-200 p-6 bg-red-50">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-slate-900">{{ $user->name }}</h3>
                                    <p class="text-slate-600 text-sm">{{ $user->email }}</p>
                                    <p class="text-slate-600 text-sm mt-1">
                                        Tipe: <span class="font-medium">
                                            @if($user->role === 'event') 📚 Event Organizer
                                            @elseif($user->role === 'company') 🏢 Sponsor/Company
                                            @else {{ $user->role }}
                                            @endif
                                        </span>
                                    </p>
                                </div>
                                
                                <span class="inline-block px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                                    ✕ Ditolak
                                </span>
                            </div>

                            @if($user->profile)
                                <div class="border-t border-red-200 pt-4 mb-4">
                                    <h4 class="font-semibold text-slate-800 mb-3">📋 Data Profil:</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                        @if($user->profile->phone_number)
                                            <div>
                                                <span class="text-slate-500">📞 Nomor HP:</span>
                                                <p class="text-slate-800 font-medium">{{ $user->profile->phone_number }}</p>
                                            </div>
                                        @endif
                                        
                                        @if($user->profile->address)
                                            <div>
                                                <span class="text-slate-500">📍 Alamat:</span>
                                                <p class="text-slate-800 font-medium">{{ $user->profile->address }}</p>
                                            </div>
                                        @endif

                                        @if($user->isEvent() && $user->profile->organization_name)
                                            <div>
                                                <span class="text-slate-500">🏛️ Organisasi:</span>
                                                <p class="text-slate-800 font-medium">{{ $user->profile->organization_name }}</p>
                                            </div>
                                        @endif

                                        @if($user->isCompany() && $user->profile->company_name)
                                            <div>
                                                <span class="text-slate-500">🏢 Perusahaan:</span>
                                                <p class="text-slate-800 font-medium">{{ $user->profile->company_name }}</p>
                                            </div>
                                        @endif

                                        @if($user->isCompany() && $user->profile->company_sector)
                                            <div>
                                                <span class="text-slate-500">🏭 Sektor:</span>
                                                <p class="text-slate-800 font-medium">{{ $user->profile->company_sector }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    @if($user->profile->description)
                                        <div class="mt-3">
                                            <span class="text-slate-500 text-sm">📝 Deskripsi:</span>
                                            <p class="text-slate-800 text-sm mt-1 bg-red-100 p-3 rounded">{{ $user->profile->description }}</p>
                                        </div>
                                    @endif

                                    @if($user->profile->instagram || $user->profile->tiktok)
                                        <div class="mt-3">
                                            <span class="text-slate-500 text-sm">📱 Media Sosial:</span>
                                            <div class="flex gap-3 mt-1 text-sm">
                                                @if($user->profile->instagram)
                                                    <span class="text-slate-800">📸 Instagram: <span class="font-medium">{{ $user->profile->instagram }}</span></span>
                                                @endif
                                                @if($user->profile->tiktok)
                                                    <span class="text-slate-800">🎵 TikTok: <span class="font-medium">{{ $user->profile->tiktok }}</span></span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            @if($user->rejection_reason)
                                <div class="mt-3 p-3 bg-red-100 border border-red-300 rounded text-red-700 text-sm">
                                    <p class="font-semibold mb-1">Alasan Penolakan:</p>
                                    <p>{{ $user->rejection_reason }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Approval Modal -->
<div id="approvalModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-sm mx-auto shadow-xl">
        <h3 class="text-lg font-bold text-slate-900 mb-4" id="approvalTitle">Setujui Akun Pengguna</h3>
        <p class="text-slate-600 mb-6">Apakah Anda yakin ingin menyetujui akun ini?</p>
        
        <div class="flex gap-3">
            <button onclick="closeApprovalModal()" class="flex-1 px-4 py-2 bg-slate-200 text-slate-700 font-semibold rounded-lg hover:bg-slate-300">
                Batal
            </button>
            <form id="approvalForm" method="POST" class="flex-1">
                @csrf
                @method('PUT')
                <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700">
                    Ya, Setujui
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div id="rejectionModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-sm mx-auto shadow-xl">
        <h3 class="text-lg font-bold text-slate-900 mb-4" id="rejectionTitle">Tolak Akun Pengguna</h3>
        
        <form id="rejectionForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Alasan Penolakan</label>
                <textarea name="rejection_reason" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 resize-none" rows="4" required placeholder="Jelaskan alasan penolakan akun ini..."></textarea>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeRejectionModal()" class="flex-1 px-4 py-2 bg-slate-200 text-slate-700 font-semibold rounded-lg hover:bg-slate-300">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700">
                    Tolak Akun
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function switchTab(tab) {
        // Hide all contents
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('[id^="tab-"]').forEach(el => {
            el.classList.remove('border-indigo-600', 'text-indigo-600');
            el.classList.add('border-transparent', 'text-slate-600');
        });
        
        // Show selected content
        document.getElementById(tab + '-content').classList.remove('hidden');
        document.getElementById('tab-' + tab).classList.add('border-indigo-600', 'text-indigo-600');
        document.getElementById('tab-' + tab).classList.remove('border-transparent', 'text-slate-600');
    }

    function openApprovalModal(userId, userName) {
        document.getElementById('approvalTitle').textContent = `Setujui Akun ${userName}?`;
        document.getElementById('approvalForm').action = `/admin/verifications/${userId}/approve`;
        document.getElementById('approvalModal').classList.remove('hidden');
    }

    function closeApprovalModal() {
        document.getElementById('approvalModal').classList.add('hidden');
    }

    function openRejectionModal(userId, userName) {
        document.getElementById('rejectionTitle').textContent = `Tolak Akun ${userName}?`;
        document.getElementById('rejectionForm').action = `/admin/verifications/${userId}/reject`;
        document.getElementById('rejectionForm').reset();
        document.getElementById('rejectionModal').classList.remove('hidden');
    }

    function closeRejectionModal() {
        document.getElementById('rejectionModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('approvalModal').addEventListener('click', function(e) {
        if (e.target === this) closeApprovalModal();
    });

    document.getElementById('rejectionModal').addEventListener('click', function(e) {
        if (e.target === this) closeRejectionModal();
    });
</script>
@endsection
