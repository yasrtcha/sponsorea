<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\SponsorOffer;
use App\Models\EventType;
use App\Models\FundingType;

class ExploreController extends Controller
{
    public function index(Request $request)
    {
        // Cek kelengkapan profil - admin tidak perlu melengkapi profil
        if (!auth()->user()->hasCompletedProfile() && auth()->user()->role !== 'admin') {
            return redirect()->route('profile.complete');
        }
        
        $query = trim($request->query('q'));
        $eventType = trim($request->query('event_type') ?? '');
        $fundingType = trim($request->query('funding_type') ?? '');
        $offers = collect();

        $eventsQuery = Event::with('user.profile')
            ->whereNotIn('status', ['completed', 'rejected']);

        // Filter events berdasarkan role user
        // - Event/Mahasiswa: Lihat semua events (termasuk milik sendiri)
        // - Company: Lihat hanya events dari users dengan role 'event'
        // - Admin: Lihat semua events
        if (auth()->user()->role === 'company') {
            $eventsQuery->whereHas('user', function ($q) {
                $q->where('role', 'event');
            });
        }

        // Filter by event_type
        if ($eventType) {
            $eventsQuery->where('event_type', $eventType);
        }

        if ($query) {
            $eventsQuery->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhereHas('user.profile', function ($q2) use ($query) {
                      $q2->where('organization_name', 'like', "%{$query}%")
                         ->orWhere('company_name', 'like', "%{$query}%");
                  });
            });
        }

        $events = $eventsQuery->latest()->get();

        // Kalau user adalah panitia event atau admin, tampilkan juga penawaran dari sponsor
        if (auth()->user()->role === 'event' || auth()->user()->role === 'admin') {
            $offersQuery = SponsorOffer::with('user.profile')
                ->where('status', 'active');

            // Filter by funding_type
            if ($fundingType) {
                $offersQuery->where('funding_type', $fundingType);
            }

            if ($query) {
                $offersQuery->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%")
                      ->orWhereHas('user.profile', function ($q2) use ($query) {
                          $q2->where('company_name', 'like', "%{$query}%")
                             ->orWhere('organization_name', 'like', "%{$query}%");
                      });
                });
            }

            $offers = $offersQuery->latest()->get();
        }

        // Ambil semua event_type dan funding_type untuk filter dropdown
        $eventTypes = EventType::orderBy('name')->get();
        $fundingTypes = FundingType::orderBy('name')->get();

        // Ambil data pending request milik user untuk menandai kartu yang sudah ada pengajuan menunggu
        $pendingOfferIds = collect();
        $pendingEventIds = collect();

        if (auth()->user()->role === 'event') {
            // Untuk mahasiswa: cari offer mana yang SEMUA event-nya sudah pending
            $myEventIds = Event::where('user_id', auth()->id())
                ->where('status', '!=', 'completed')
                ->pluck('id');
            
            if ($myEventIds->isNotEmpty()) {
                $myEventCount = $myEventIds->count();
                
                // Offer yang SEMUA event user sudah punya pending request
                $pendingOfferIds = \App\Models\SponsorshipRequest::whereIn('event_id', $myEventIds)
                    ->where('status', 'pending')
                    ->groupBy('sponsor_offer_id')
                    ->havingRaw('COUNT(DISTINCT event_id) >= ?', [$myEventCount])
                    ->pluck('sponsor_offer_id');
            }
        } elseif (auth()->user()->role === 'company') {
            // Untuk perusahaan: cari event mana yang SEMUA offer-nya sudah pending
            $myOfferIds = \App\Models\SponsorOffer::where('user_id', auth()->id())
                ->where('status', 'active')
                ->pluck('id');
            
            if ($myOfferIds->isNotEmpty()) {
                $myOfferCount = $myOfferIds->count();
                
                // Event yang SEMUA offer user sudah punya pending request
                $pendingEventIds = \App\Models\SponsorshipRequest::whereIn('sponsor_offer_id', $myOfferIds)
                    ->where('status', 'pending')
                    ->groupBy('event_id')
                    ->havingRaw('COUNT(DISTINCT sponsor_offer_id) >= ?', [$myOfferCount])
                    ->pluck('event_id');
            }
        }
        
        return view('explore.index', compact('events', 'offers', 'query', 'eventType', 'fundingType', 'eventTypes', 'fundingTypes', 'pendingOfferIds', 'pendingEventIds'));
    }
}