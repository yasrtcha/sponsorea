@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-50 py-12 px-6">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">🔔 Notifikasi</h1>
            <p class="text-slate-600 mt-2">Kelola semua notifikasi Anda di sini</p>
        </div>

        @if($notifications->isEmpty())
            <div class="text-center py-12 bg-white rounded-lg border border-slate-200">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p class="text-slate-500 text-lg">Tidak ada notifikasi</p>
                <p class="text-slate-400 text-sm mt-2">Semua notifikasi Anda akan muncul di sini</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($notifications as $notification)
                    <div class="bg-white rounded-lg border {{ $notification->read_at ? 'border-slate-200' : 'border-indigo-300 bg-indigo-50' }} p-4 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start gap-4">
                            <div class="flex-1">
                                <p class="font-medium {{ $notification->read_at ? 'text-slate-700' : 'text-indigo-900' }}">
                                    {{ $notification->data['message'] }}
                                </p>
                                <p class="text-slate-500 text-sm mt-1">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>

                            <div class="flex gap-2">
                                @if(!$notification->read_at)
                                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded hover:bg-indigo-100 text-indigo-600 transition-colors" title="Tandai sebagai dibaca">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('notifications.delete', $notification->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus notifikasi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded hover:bg-red-100 text-red-600 transition-colors" title="Hapus notifikasi">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        @if(isset($notification->data['url']))
                            <div class="mt-3">
                                <a href="{{ $notification->data['url'] }}" class="inline-block px-3 py-1.5 bg-indigo-600 text-white text-sm font-medium rounded hover:bg-indigo-700 transition-colors">
                                    Lihat →
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($notifications->hasPages())
                <div class="mt-8">
                    {{ $notifications->links('pagination::simple-bootstrap-4') }}
                </div>
            @endif
        @endif

    </div>
</div>
@endsection
