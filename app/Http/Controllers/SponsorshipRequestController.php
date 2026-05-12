<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\SponsorOffer;
use App\Models\SponsorshipRequest;
use App\Notifications\NewSponsorshipRequestNotification;
use App\Notifications\NewOfferApplicationNotification;
use App\Notifications\SponsorshipRequestApprovedNotification;
use App\Notifications\SponsorshipRequestRejectedNotification;
use App\Notifications\MoUUploadedNotification;

class SponsorshipRequestController extends Controller
{
    // 1. Menampilkan Form Pengajuan
    public function create($type, $id)
    {
        $role = auth()->user()->role;
        $myAssets = collect();
        $target = null;

        // JIKA MAHASISWA NGAJUIN KE PERUSAHAAN
        if ($type === 'offer' && $role === 'event') {
            $target = SponsorOffer::findOrFail($id);

            // Ambil ID event yang sudah punya pending request dengan offer ini
            $pendingEventIds = SponsorshipRequest::where('sponsor_offer_id', $id)
                ->where('status', 'pending')
                ->pluck('event_id');

            $myAssets = Event::where('user_id', auth()->id())
                            ->where('status', '!=', 'completed')
                            ->whereNotIn('id', $pendingEventIds) // Filter yang sudah pending
                            ->get();
            
            // Cek apakah user punya event sama sekali
            $totalEvents = Event::where('user_id', auth()->id())
                            ->where('status', '!=', 'completed')
                            ->count();

            if ($totalEvents === 0) {
                if (request()->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Kamu belum membuat event'], 400);
                }
                return redirect()->back()->with('error', 'Oops! Kamu belum membuat event. Silakan buat profil event kamu terlebih dahulu di Dashboard Event sebelum mengajukan proposal.');
            }

            if ($myAssets->isEmpty()) {
                if (request()->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Semua event kamu sudah memiliki pengajuan yang sedang menunggu ke program sponsor ini.'], 409);
                }
                return redirect()->back()->with('error', 'Semua event kamu sudah memiliki pengajuan yang sedang menunggu ke program sponsor ini.');
            }
        } 
        
        // JIKA PERUSAHAAN NGAJUIN KE MAHASISWA
        elseif ($role === 'company' && $type === 'event') {
            $target = Event::findOrFail($id);

            // Ambil ID offer yang sudah punya pending request dengan event ini
            $pendingOfferIds = SponsorshipRequest::where('event_id', $id)
                ->where('status', 'pending')
                ->pluck('sponsor_offer_id');

            $myAssets = SponsorOffer::where('user_id', auth()->id())
                                   ->where('status', 'active')
                                   ->whereNotIn('id', $pendingOfferIds) // Filter yang sudah pending
                                   ->get();
            
            // Cek apakah user punya offer sama sekali
            $totalOffers = SponsorOffer::where('user_id', auth()->id())
                                   ->where('status', 'active')
                                   ->count();

            if ($totalOffers === 0) {
                if (request()->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Perusahaan belum punya penawaran sponsor'], 400);
                }
                return redirect()->back()->with('error', 'Oops! Perusahaan Anda belum memiliki penawaran sponsor aktif. Silakan buat program sponsor terlebih dahulu.');
            }

            if ($myAssets->isEmpty()) {
                if (request()->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Semua program sponsor Anda sudah memiliki pengajuan yang sedang menunggu ke event ini.'], 409);
                }
                return redirect()->back()->with('error', 'Semua program sponsor Anda sudah memiliki pengajuan yang sedang menunggu ke event ini.');
            }
        }

        // BENTENG KEAMANAN: Jika URL dimanipulasi dan target tidak ditemukan
        if (!$target) {
            if (request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
            }
            return redirect()->route('explore.index')->with('error', 'Akses tidak diizinkan atau data tidak ditemukan.');
        }

        // Jika AJAX request, return JSON dengan assets
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'assets' => $myAssets->map(fn($asset) => ['id' => $asset->id, 'title' => $asset->title])->values()->all()
            ]);
        }

        // Jika regular request, return view
        return view('request.create', compact('target', 'myAssets', 'type'));
    }

    // 2. Memproses Transaksi ke Database
    public function store(Request $request)
    {
        $request->validate([
            'target_type' => 'required|in:event,offer',
            'target_id' => 'required|integer',
            'my_asset_id' => 'required|integer',
            'message' => 'nullable|string',
        ]);

        $role = auth()->user()->role;

        $data = [
            'initiator' => $role,
            'message' => $request->message,
            'status' => 'pending',
        ];

        // Tentukan mana ID Event dan mana ID Sponsor Offer
        if ($role === 'event') {
            $data['event_id'] = $request->my_asset_id;
            $data['sponsor_offer_id'] = $request->target_id;
        } else {
            $data['event_id'] = $request->target_id;
            $data['sponsor_offer_id'] = $request->my_asset_id;
        }

        // VALIDASI DUPLIKAT: Cek apakah sudah ada pending request untuk pasangan ini
        $existingPending = SponsorshipRequest::where('event_id', $data['event_id'])
            ->where('sponsor_offer_id', $data['sponsor_offer_id'])
            ->where('status', 'pending')
            ->exists();

        if ($existingPending) {
            $msg = 'Sudah ada pengajuan yang masih menunggu antara event dan program sponsor ini. Harap tunggu hingga pengajuan sebelumnya diproses.';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 409);
            }
            return redirect()->back()->with('error', $msg);
        }

        $sponsorshipRequest = SponsorshipRequest::create($data);

        // Send notifications based on who initiated
        if ($role === 'event') {
            // Event organizer sent request to sponsor, notify the sponsor company
            $sponsor = $sponsorshipRequest->sponsorOffer->user;
            $sponsor->notify(new NewSponsorshipRequestNotification($sponsorshipRequest));
        } else {
            // Company sent offer to event organizer, notify the event organizer
            $eventOrganizer = $sponsorshipRequest->event->user;
            $eventOrganizer->notify(new NewOfferApplicationNotification($sponsorshipRequest));
        }

        $message = 'Pengajuan berhasil dikirim! Menunggu konfirmasi pihak terkait.';
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
        return redirect()->route('explore.index')->with('success', $message);
    }

    // ====================================================================
    // AREA MAHASISWA (EVENT)
    // ====================================================================
    
    // 1. Status Pengajuan (Keluar): Mahasiswa -> Perusahaan
    public function outgoingEvent()
    {
        $myEventIds = \App\Models\Event::where('user_id', auth()->id())->pluck('id');
        $requests = SponsorshipRequest::with(['event', 'sponsorOffer.user.profile'])
                    ->whereIn('event_id', $myEventIds)
                    ->where('initiator', 'event') // KUNCI FIX: Hanya yang dikirim mahasiswa
                    ->latest()->get();

        return view('event.requests', compact('requests'));
    }

    // 2. Tawaran Masuk (Masuk): Perusahaan -> Mahasiswa (Butuh Aksi Terima/Tolak)
    public function incomingEvent()
    {
        $myEventIds = \App\Models\Event::where('user_id', auth()->id())->pluck('id');
        $requests = SponsorshipRequest::with(['event', 'sponsorOffer.user.profile'])
                    ->whereIn('event_id', $myEventIds)
                    ->where('initiator', 'company') // KUNCI FIX: Hanya yang dikirim perusahaan
                    ->latest()->get();

        return view('event.incoming_requests', compact('requests'));
    }

    // ====================================================================
    // AREA PERUSAHAAN (COMPANY)
    // ====================================================================

    // 3. Status Penawaran (Keluar): Perusahaan -> Mahasiswa
    public function outgoingCompany()
    {
        $myOfferIds = \App\Models\SponsorOffer::where('user_id', auth()->id())->pluck('id');
        $requests = SponsorshipRequest::with(['event.user.profile', 'sponsorOffer'])
                    ->whereIn('sponsor_offer_id', $myOfferIds)
                    ->where('initiator', 'company') // KUNCI FIX: Hanya yang dikirim perusahaan
                    ->latest()->get();

        return view('company.requests', compact('requests'));
    }

    // 4. Proposal Masuk (Masuk): Mahasiswa -> Perusahaan (Butuh Aksi Terima/Tolak)
    public function incomingCompany()
    {
        $myOfferIds = \App\Models\SponsorOffer::where('user_id', auth()->id())->pluck('id');
        $requests = SponsorshipRequest::with(['event.user.profile', 'sponsorOffer'])
                    ->whereIn('sponsor_offer_id', $myOfferIds)
                    ->where('initiator', 'event') // KUNCI FIX: Hanya yang dikirim mahasiswa
                    ->latest()->get();

        return view('company.incoming_requests', compact('requests'));
    }

    // ====================================================================
    // FUNGSI UPDATE STATUS (ACC / TOLAK)
    // ====================================================================
    public function updateStatus(Request $request, $id)
    {
        $sponsorshipRequest = SponsorshipRequest::findOrFail($id);
        
        // Validasi berbeda untuk approved vs rejected
        if ($request->status === 'rejected') {
            $request->validate([
                'status' => 'required|in:approved,rejected',
                'rejection_notes' => 'required|string|max:1000' // Catatan wajib untuk penolakan
            ], [
                'rejection_notes.required' => 'Silakan berikan alasan penolakan.',
                'rejection_notes.max' => 'Alasan penolakan maksimal 1000 karakter.'
            ]);
        } else {
            $request->validate(['status' => 'required|in:approved,rejected']);
        }

        // KEAMANAN BARU: Pastikan hanya PIHAK PENERIMA yang bisa ACC/Tolak
        if (auth()->user()->role === 'company') {
            if ($sponsorshipRequest->sponsorOffer->user_id !== auth()->id() || $sponsorshipRequest->initiator !== 'event') {
                abort(403, 'Anda tidak bisa menyetujui pengajuan yang Anda kirim sendiri!');
            }
        } elseif (auth()->user()->role === 'event') {
            if ($sponsorshipRequest->event->user_id !== auth()->id() || $sponsorshipRequest->initiator !== 'company') {
                abort(403, 'Anda tidak bisa menyetujui pengajuan yang Anda kirim sendiri!');
            }
        }

        // Update status dan rejection_notes jika ada
        $updateData = ['status' => $request->status];
        if ($request->status === 'rejected' && $request->rejection_notes) {
            $updateData['rejection_notes'] = $request->rejection_notes;
        }
        
        $sponsorshipRequest->update($updateData);

        // Send notifications to the initiator
        if ($request->status === 'approved') {
            $initiatorUser = $sponsorshipRequest->initiator === 'event' 
                ? $sponsorshipRequest->event->user 
                : $sponsorshipRequest->sponsorOffer->user;
            $initiatorUser->notify(new SponsorshipRequestApprovedNotification($sponsorshipRequest));
        } else {
            $initiatorUser = $sponsorshipRequest->initiator === 'event' 
                ? $sponsorshipRequest->event->user 
                : $sponsorshipRequest->sponsorOffer->user;
            $initiatorUser->notify(new SponsorshipRequestRejectedNotification($sponsorshipRequest));
        }

        $pesan = $request->status === 'approved' ? 'Kerjasama berhasil DISETUJUI!' : 'Kerjasama telah DITOLAK.';
        return back()->with('success', $pesan);
    }

    // ====================================================================
    // FUNGSI LAPORAN TRANSAKSI (HANYA APPROVED)
    // ====================================================================
    public function report(Request $request)
    {
        $user = auth()->user();
        $requests = collect();
        $events = collect();
        $selectedEvent = null;

        if ($user->role === 'event') {
            // Tarik data event punya mahasiswa ini
            $myEventIds = \App\Models\Event::where('user_id', $user->id)->pluck('id');
            
            // Ambil semua event untuk dropdown
            $events = \App\Models\Event::where('user_id', $user->id)->get();
            
            // Jika ada filter event
            if ($request->event_id) {
                $selectedEvent = \App\Models\Event::findOrFail($request->event_id);
                // Validasi bahwa event ini punya user yang sama
                if ($selectedEvent->user_id !== $user->id) {
                    abort(403, 'Anda tidak memiliki akses ke event ini.');
                }
                $requests = SponsorshipRequest::with(['event', 'sponsorOffer.user.profile'])
                            ->where('event_id', $request->event_id)
                            ->where('status', 'approved')
                            ->latest()->get();
            } else {
                // Ambil semua transaksi yang APPROVED dari semua event
                $requests = SponsorshipRequest::with(['event', 'sponsorOffer.user.profile'])
                            ->whereIn('event_id', $myEventIds)
                            ->where('status', 'approved')
                            ->latest()->get();
            }
                        
        } elseif ($user->role === 'company') {
            // Tarik data penawaran punya perusahaan ini
            $myOfferIds = \App\Models\SponsorOffer::where('user_id', $user->id)->pluck('id');
            
            // Ambil semua sponsor offers yang punya approved requests
            $events = \App\Models\SponsorOffer::where('user_id', $user->id)
                            ->whereHas('sponsorshipRequests', function($query) {
                                $query->where('status', 'approved');
                            })
                            ->get();
            
            // Jika ada filter sponsor offer
            if ($request->offer_id) {
                $selectedEvent = \App\Models\SponsorOffer::findOrFail($request->offer_id);
                // Validasi bahwa offer ini punya user yang sama
                if ($selectedEvent->user_id !== $user->id) {
                    abort(403, 'Anda tidak memiliki akses ke penawaran ini.');
                }
                $requests = SponsorshipRequest::with(['event.user.profile', 'sponsorOffer'])
                            ->where('sponsor_offer_id', $request->offer_id)
                            ->where('status', 'approved')
                            ->latest()->get();
            } else {
                // Ambil semua transaksi yang APPROVED dari semua penawaran
                $requests = SponsorshipRequest::with(['event.user.profile', 'sponsorOffer'])
                            ->whereIn('sponsor_offer_id', $myOfferIds)
                            ->where('status', 'approved')
                            ->latest()->get();
            }
        }

        return view('report.index', compact('requests', 'events', 'selectedEvent'));
    }

    // ====================================================================
    // FUNGSI UPLOAD KONTRAK MoU (SETELAH ACC - HANYA DARI MAHASISWA)
    // ====================================================================
    public function uploadMoU(Request $request, $id)
    {
        $sponsorshipRequest = SponsorshipRequest::findOrFail($id);

        // VALIDASI: Hanya bisa upload jika status approved
        if ($sponsorshipRequest->status !== 'approved') {
            return back()->with('error', 'Kontrak MoU hanya bisa di-upload setelah kerjasama disetujui!');
        }

        // KEAMANAN: HANYA MAHASISWA (EVENT) YANG BISA UPLOAD MoU
        if (auth()->user()->role !== 'event') {
            abort(403, 'Hanya pihak Mahasiswa/Event yang dapat mengupload kontrak MoU!');
        }

        if ($sponsorshipRequest->event->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengupload MoU ini!');
        }

        // VALIDASI FILE
        $request->validate([
            'mou_file' => 'required|file|mimes:pdf|max:5120' // Max 5MB
        ], [
            'mou_file.required' => 'Silakan pilih file MoU terlebih dahulu.',
            'mou_file.mimes' => 'File harus berformat PDF.',
            'mou_file.max' => 'Ukuran file maksimal 5MB.'
        ]);

        // HAPUS FILE LAMA JIKA ADA
        if ($sponsorshipRequest->mou_path && \Storage::exists('public/' . $sponsorshipRequest->mou_path)) {
            \Storage::delete('public/' . $sponsorshipRequest->mou_path);
        }

        // STORE FILE BARU
        $file = $request->file('mou_file');
        $fileName = 'mou_' . $sponsorshipRequest->id . '_' . time() . '.pdf';
        $filePath = $file->storeAs('mou_contracts', $fileName, 'public');

        // UPDATE DATABASE
        $sponsorshipRequest->update([
            'mou_path' => $filePath,
            'mou_uploaded_at' => now()
        ]);

        // Send notification to the sponsor company
        $sponsor = $sponsorshipRequest->sponsorOffer->user;
        $sponsor->notify(new MoUUploadedNotification($sponsorshipRequest, auth()->user()));

        return back()->with('success', 'Kontrak MoU berhasil di-upload!');
    }
}