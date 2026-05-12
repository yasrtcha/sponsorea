<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\SponsorOffer;
use App\Models\SponsorshipRequest;
use App\Models\EventType;
use App\Models\FundingType;
use App\Notifications\AccountApprovedNotification;
use App\Notifications\AccountRejectedNotification;

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Ambil Statistik Keseluruhan
        $totalUsers = User::whereIn('role', ['event', 'company'])->count();
        $totalEvents = Event::count();
        $totalOffers = SponsorOffer::count();
        $totalTransactions = SponsorshipRequest::count();

        // Statistik verifikasi user
        $usersVerified = User::whereIn('role', ['event', 'company'])->where('verification_status', 'verified')->count();
        $usersRejected = User::whereIn('role', ['event', 'company'])->where('verification_status', 'rejected')->count();
        $usersPending = User::whereIn('role', ['event', 'company'])->where('verification_status', 'pending')->count();

        $eventRequestsAccepted = SponsorshipRequest::where('initiator', 'event')->where('status', 'approved')->count();
        $eventRequestsPending = SponsorshipRequest::where('initiator', 'event')->where('status', 'pending')->count();
        $eventRequestsRejected = SponsorshipRequest::where('initiator', 'event')->where('status', 'rejected')->count();

        $companyRequestsAccepted = SponsorshipRequest::where('initiator', 'company')->where('status', 'approved')->count();
        $companyRequestsPending = SponsorshipRequest::where('initiator', 'company')->where('status', 'pending')->count();
        $companyRequestsRejected = SponsorshipRequest::where('initiator', 'company')->where('status', 'rejected')->count();

        // Statistik kategori event
        $eventStats = Event::selectRaw('event_type as category, COUNT(id) as count')
            ->groupBy('event_type')
            ->get()
            ->pluck('count', 'category')
            ->toArray();

        // Statistik jenis bantuan (funding)
        $fundingStats = SponsorOffer::selectRaw('funding_type as category, COUNT(id) as count')
            ->groupBy('funding_type')
            ->get()
            ->pluck('count', 'category')
            ->toArray();

        // 2. Ambil Data Terbaru untuk Ditampilkan di Tabel (5 data terakhir)
        $recentUsers = User::whereIn('role', ['event', 'company'])->with('profile')->latest()->take(5)->get();
        $recentTransactions = SponsorshipRequest::with(['event.user', 'sponsorOffer.user'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalEvents', 'totalOffers', 'totalTransactions',
            'usersVerified', 'usersRejected', 'usersPending',
            'eventRequestsAccepted', 'eventRequestsPending', 'eventRequestsRejected',
            'companyRequestsAccepted', 'companyRequestsPending', 'companyRequestsRejected',
            'eventStats', 'fundingStats',
            'recentUsers', 'recentTransactions'
        ));
    }

    public function categories()
    {
        $eventTypes = EventType::latest()->get();
        $fundingTypes = FundingType::latest()->get();
        return view('admin.categories', compact('eventTypes', 'fundingTypes'));
    }

    public function verifications()
    {
        // Hanya tampilkan user yang sudah lengkap mengisi profile
        $pending = User::where('verification_status', 'pending')
            ->whereIn('role', ['event', 'company'])
            ->whereHas('profile')
            ->with('profile')
            ->latest()
            ->get();
            
        $approved = User::where('verification_status', 'verified')
            ->whereIn('role', ['event', 'company'])
            ->whereHas('profile')
            ->with('profile')
            ->orderBy('verified_at', 'desc')
            ->take(10)
            ->get();
            
        $rejected = User::where('verification_status', 'rejected')
            ->whereIn('role', ['event', 'company'])
            ->whereHas('profile')
            ->with('profile')
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();
        
        return view('admin.verifications', compact('pending', 'approved', 'rejected'));
    }

    public function approveUser(User $user)
    {
        $user->update([
            'verification_status' => 'verified',
            'verified_at' => now(),
        ]);
        
        // Send notification to user
        $user->notify(new AccountApprovedNotification($user));
        
        return back()->with('success', "Akun {$user->name} berhasil diverifikasi!");
    }

    public function rejectUser(Request $request, User $user)
    {
        $request->validate(['rejection_reason' => 'required|string|max:1000']);
        
        $user->update([
            'verification_status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);
        
        // Send notification to user
        $user->notify(new AccountRejectedNotification($user, $request->rejection_reason));
        
        return back()->with('success', "Akun {$user->name} berhasil ditolak!");
    }

    public function storeEventType(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        EventType::create(['name' => $request->name]);
        return back()->with('success', 'Jenis Event berhasil ditambahkan!');
    }

    public function updateEventType(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $eventType = EventType::findOrFail($id);
        $eventType->update(['name' => $request->name]);
        return back()->with('success', 'Jenis Event berhasil diperbarui!');
    }

    public function destroyEventType($id)
    {
        EventType::findOrFail($id)->delete();
        return back()->with('success', 'Jenis Event berhasil dihapus!');
    }

    public function storeFundingType(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        FundingType::create(['name' => $request->name]);
        return back()->with('success', 'Jenis Dukungan berhasil ditambahkan!');
    }

    public function updateFundingType(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $fundingType = FundingType::findOrFail($id);
        $fundingType->update(['name' => $request->name]);
        return back()->with('success', 'Jenis Dukungan berhasil diperbarui!');
    }

    public function destroyFundingType($id)
    {
        FundingType::findOrFail($id)->delete();
        return back()->with('success', 'Jenis Dukungan berhasil dihapus!');
    }
}