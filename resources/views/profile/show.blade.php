@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 pt-16">
    <div class="max-w-3xl mx-auto px-6 py-8">
        <!-- Profil Card Utama -->
        <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">
            
            <!-- Header Background -->
            <div class="h-24 bg-white border-b border-slate-100"></div>

            <!-- Konten Profil -->
            <div class="px-6 pb-6">
                <!-- Avatar & Info Dasar -->
                <div class="flex flex-col md:flex-row gap-4 -mt-12 mb-6 items-start md:items-end">
                    <div class="w-24 h-24 rounded-xl bg-slate-200 border-4 border-white shadow-md flex items-center justify-center text-3xl font-bold shrink-0 {{ $user->role === 'company' ? 'bg-teal-100 text-teal-700' : 'bg-indigo-100 text-indigo-700' }}">
                        {{ substr($profile->company_name ?? $profile->organization_name ?? $user->name, 0, 1) }}
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <h1 class="text-3xl font-black text-slate-900 truncate">{{ $profile->company_name ?? $profile->organization_name ?? $user->name }}</h1>
                        <p class="text-slate-600 font-semibold text-sm mt-0.5 truncate">{{ $user->name }}</p>
                        <div class="flex gap-2 mt-2 flex-wrap">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $user->role === 'company' ? 'bg-teal-100 text-teal-700' : 'bg-indigo-100 text-indigo-700' }}">
                                {{ strtoupper($user->role) }}
                            </span>
                            @if($user->role === 'company' && $profile->company_sector)
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700">
                                    {{ $profile->company_sector }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <!-- Email -->
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Email</p>
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $user->email }}</p>
                    </div>

                    <!-- Telepon -->
                    @if($profile->phone_number)
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Telepon</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $profile->phone_number }}</p>
                        </div>
                    @endif

                    <!-- Alamat -->
                    @if($profile->address)
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Alamat</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $profile->address }}</p>
                        </div>
                    @endif

                    <!-- Instagram -->
                    @if($profile->instagram)
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Instagram</p>
                            <a href="https://instagram.com/{{ str_replace('@', '', $profile->instagram) }}" target="_blank" class="text-sm font-semibold text-pink-600 hover:text-pink-700 truncate flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.467.398.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.799-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/></svg>
                                {{ $profile->instagram }}
                            </a>
                        </div>
                    @endif

                    <!-- TikTok -->
                    @if($profile->tiktok)
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">TikTok</p>
                            <a href="https://tiktok.com/@{{ str_replace('@', '', $profile->tiktok) }}" target="_blank" class="text-sm font-semibold text-slate-900 hover:text-black truncate flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.1 1.82 2.89 2.89 0 0 1 2.31-4.64 2.86 2.86 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-.96-.08z"/></svg>
                                {{ $profile->tiktok }}
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-2">{{ $user->role === 'company' ? 'Tentang Perusahaan' : 'Tentang Organisasi' }}</h2>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <p class="text-slate-700 leading-relaxed text-sm">{{ $profile->description }}</p>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex gap-3 pt-4 border-t border-slate-100">
                    @auth
                        @if(auth()->id() !== $user->id)
                            <a href="{{ route('explore.index', ['q' => $profile->company_name ?? $profile->organization_name]) }}" class="flex-1 px-4 py-2.5 bg-slate-200 text-slate-700 font-bold rounded-lg hover:bg-slate-300 transition-colors text-center text-sm">
                                Konten Mereka
                            </a>
                        @else
                            <a href="{{ route('profile.edit') }}" class="flex-1 px-4 py-2.5 bg-slate-200 text-slate-700 font-bold rounded-lg hover:bg-slate-300 transition-colors text-center text-sm">
                                Edit Profil
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
