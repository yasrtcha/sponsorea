@if(auth()->user()->role === 'event')
    
    <a href="{{ route('event.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all text-[13px] {{ request()->routeIs('event.dashboard') ? 'bg-[#fcf5f5] text-[#f07b32] font-bold border border-[#f07b32]/10' : 'text-gray-500 hover:text-[#3d3d3d] hover:bg-gray-50 font-semibold' }}">
        <svg class="w-4 h-4 {{ request()->routeIs('event.dashboard') ? 'text-[#f07b32]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
        Dashboard
    </a>
    
    <a href="{{ route('explore.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all text-[13px] {{ request()->routeIs('explore.index') ? 'bg-[#fcf5f5] text-[#f07b32] font-bold border border-[#f07b32]/10' : 'text-gray-500 hover:text-[#3d3d3d] hover:bg-gray-50 font-semibold' }}">
        <svg class="w-4 h-4 {{ request()->routeIs('explore.index') ? 'text-[#f07b32]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        Jelajahi
    </a>
    
    <a href="{{ route('event.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all text-[13px] {{ request()->routeIs('event.index', 'event.create') ? 'bg-[#fcf5f5] text-[#f07b32] font-bold border border-[#f07b32]/10' : 'text-gray-500 hover:text-[#3d3d3d] hover:bg-gray-50 font-semibold' }}">
        <svg class="w-4 h-4 {{ request()->routeIs('event.index', 'event.create') ? 'text-[#f07b32]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        Event Saya
    </a>

    <a href="{{ route('event.requests') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all text-[13px] {{ request()->routeIs('event.requests') ? 'bg-[#fcf5f5] text-[#f07b32] font-bold border border-[#f07b32]/10' : 'text-gray-500 hover:text-[#3d3d3d] hover:bg-gray-50 font-semibold' }}">
        <svg class="w-4 h-4 {{ request()->routeIs('event.requests') ? 'text-[#f07b32]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
        Status Pengajuan
    </a>

    <a href="{{ route('event.incoming') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all text-[13px] {{ request()->routeIs('event.incoming') ? 'bg-[#fcf5f5] text-[#f07b32] font-bold border border-[#f07b32]/10' : 'text-gray-500 hover:text-[#3d3d3d] hover:bg-gray-50 font-semibold' }}">
        <svg class="w-4 h-4 {{ request()->routeIs('event.incoming') ? 'text-[#f07b32]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
        Tawaran Masuk
    </a>

    <a href="{{ route('report.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all text-[13px] {{ request()->routeIs('report.index') ? 'bg-[#fcf5f5] text-[#f07b32] font-bold border border-[#f07b32]/10' : 'text-gray-500 hover:text-[#3d3d3d] hover:bg-gray-50 font-semibold' }}">
        <svg class="w-4 h-4 {{ request()->routeIs('report.index') ? 'text-[#f07b32]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        Laporan Transaksi
    </a>

    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all text-[13px] {{ request()->routeIs('profile.edit') ? 'bg-[#fcf5f5] text-[#f07b32] font-bold border border-[#f07b32]/10' : 'text-gray-500 hover:text-[#3d3d3d] hover:bg-gray-50 font-semibold' }}">
        <svg class="w-4 h-4 {{ request()->routeIs('profile.edit') ? 'text-[#f07b32]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        Pengaturan Profil
    </a>

@elseif(auth()->user()->role === 'company')
    
    <a href="{{ route('company.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all text-[13px] {{ request()->routeIs('company.dashboard') ? 'bg-[#fcf5f5] text-[#f07b32] font-bold border border-[#f07b32]/10' : 'text-gray-500 hover:text-[#3d3d3d] hover:bg-gray-50 font-semibold' }}">
        <svg class="w-4 h-4 {{ request()->routeIs('company.dashboard') ? 'text-[#f07b32]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
        Dashboard
    </a>
    
    <a href="{{ route('explore.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all text-[13px] {{ request()->routeIs('explore.index') ? 'bg-[#fcf5f5] text-[#f07b32] font-bold border border-[#f07b32]/10' : 'text-gray-500 hover:text-[#3d3d3d] hover:bg-gray-50 font-semibold' }}">
        <svg class="w-4 h-4 {{ request()->routeIs('explore.index') ? 'text-[#f07b32]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        Jelajahi
    </a>
    
    <a href="{{ route('company.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all text-[13px] {{ request()->routeIs('company.index', 'sponsor-offer.create') ? 'bg-[#fcf5f5] text-[#f07b32] font-bold border border-[#f07b32]/10' : 'text-gray-500 hover:text-[#3d3d3d] hover:bg-gray-50 font-semibold' }}">
        <svg class="w-4 h-4 {{ request()->routeIs('company.index') ? 'text-[#f07b32]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Penawaran Sponsor
    </a>

    <a href="{{ route('company.incoming_requests') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all text-[13px] {{ request()->routeIs('company.incoming_requests') ? 'bg-[#fcf5f5] text-[#f07b32] font-bold border border-[#f07b32]/10' : 'text-gray-500 hover:text-[#3d3d3d] hover:bg-gray-50 font-semibold' }}">
        <svg class="w-4 h-4 {{ request()->routeIs('company.incoming_requests') ? 'text-[#f07b32]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        Proposal Masuk
    </a>

    <a href="{{ route('company.requests') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all text-[13px] {{ request()->routeIs('company.requests') ? 'bg-[#fcf5f5] text-[#f07b32] font-bold border border-[#f07b32]/10' : 'text-gray-500 hover:text-[#3d3d3d] hover:bg-gray-50 font-semibold' }}">
        <svg class="w-4 h-4 {{ request()->routeIs('company.requests') ? 'text-[#f07b32]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
        Status Penawaran
    </a>

    <a href="{{ route('report.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all text-[13px] {{ request()->routeIs('report.index') ? 'bg-[#fcf5f5] text-[#f07b32] font-bold border border-[#f07b32]/10' : 'text-gray-500 hover:text-[#3d3d3d] hover:bg-gray-50 font-semibold' }}">
        <svg class="w-4 h-4 {{ request()->routeIs('report.index') ? 'text-[#f07b32]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        Laporan Transaksi
    </a>

    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all text-[13px] {{ request()->routeIs('profile.edit') ? 'bg-[#fcf5f5] text-[#f07b32] font-bold border border-[#f07b32]/10' : 'text-gray-500 hover:text-[#3d3d3d] hover:bg-gray-50 font-semibold' }}">
        <svg class="w-4 h-4 {{ request()->routeIs('profile.edit') ? 'text-[#f07b32]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        Pengaturan Profil
    </a>

    @elseif(auth()->user()->role === 'admin')
    
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all text-[13px] {{ request()->routeIs('admin.dashboard') ? 'bg-[#fcf5f5] text-[#f07b32] font-bold border border-[#f07b32]/10' : 'text-gray-500 hover:text-[#3d3d3d] hover:bg-gray-50 font-semibold' }}">
        <svg class="w-4 h-4 {{ request()->routeIs('admin.dashboard') ? 'text-[#f07b32]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
        Dashboard Admin
    </a>
    
    <a href="{{ route('explore.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all text-[13px] {{ request()->routeIs('explore.index') ? 'bg-[#fcf5f5] text-[#f07b32] font-bold border border-[#f07b32]/10' : 'text-gray-500 hover:text-[#3d3d3d] hover:bg-gray-50 font-semibold' }}">
        <svg class="w-4 h-4 {{ request()->routeIs('explore.index') ? 'text-[#f07b32]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        Jelajahi
    </a>
    
    <a href="{{ route('admin.verifications') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all text-[13px] {{ request()->routeIs('admin.verifications') ? 'bg-[#fcf5f5] text-[#f07b32] font-bold border border-[#f07b32]/10' : 'text-gray-500 hover:text-[#3d3d3d] hover:bg-gray-50 font-semibold' }}">
        <svg class="w-4 h-4 {{ request()->routeIs('admin.verifications') ? 'text-[#f07b32]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7 20H5a2 2 0 01-2-2V9a2 2 0 012-2h2M9 20h10a2 2 0 002-2V9a2 2 0 00-2-2h-2"></path></svg>
        Verifikasi Akun
    </a>
    
    <a href="{{ route('admin.categories') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all text-[13px] {{ request()->routeIs('admin.categories') ? 'bg-[#fcf5f5] text-[#f07b32] font-bold border border-[#f07b32]/10' : 'text-gray-500 hover:text-[#3d3d3d] hover:bg-gray-50 font-semibold' }}">
        <svg class="w-4 h-4 {{ request()->routeIs('admin.categories') ? 'text-[#f07b32]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        Manajemen Kategori
    </a>
    
@endif