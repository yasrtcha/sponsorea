<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\SponsorOffer;
use App\Models\SponsorshipRequest;

class DashboardController extends Controller
{
    public function eventDashboard()
    {
        if (!auth()->user()->hasCompletedProfile()) {
            return redirect()->route('profile.complete');
        }
        
        $userId = auth()->id();
        
        $totalEvents = Event::where('user_id', $userId)->count();
        // MENGHITUNG YANG DITOLAK
        $rejectedRequests = SponsorshipRequest::whereHas('event', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'rejected')->count(); // Ganti ke rejected
        
        $approvedRequests = SponsorshipRequest::whereHas('event', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'approved')->count();

        return view('event.dashboard', compact('totalEvents', 'rejectedRequests', 'approvedRequests'));
    }

    public function companyDashboard()
    {
        if (!auth()->user()->hasCompletedProfile()) {
            return redirect()->route('profile.complete');
        }
        
        $userId = auth()->id();

        $totalOffers = SponsorOffer::where('user_id', $userId)->count();
        // MENGHITUNG YANG DITOLAK
        $rejectedRequests = SponsorshipRequest::whereHas('sponsorOffer', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'rejected')->count(); // Ganti ke rejected
        
        $approvedRequests = SponsorshipRequest::whereHas('sponsorOffer', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'approved')->count();

        return view('company.dashboard', compact('totalOffers', 'rejectedRequests', 'approvedRequests'));
    }
}