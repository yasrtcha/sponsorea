<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SponsorOffer;
use Illuminate\Support\Facades\Storage;
use App\Models\FundingType; // Tambahan Model FundingType

class SponsorOfferController extends Controller
{
    public function index()
    {
        $company = SponsorOffer::where('user_id', auth()->id())->latest()->get();
        return view('company.index', compact('company'));
    }

    public function create()
    {
        // Tarik data dari database
        $fundingTypes = FundingType::orderBy('name', 'asc')->get();
        return view('company.create_offer', compact('fundingTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'funding_type' => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'guideline_pdf' => 'nullable|mimes:pdf|max:5120',
        ]);

        $pdfPath = null;
        if ($request->hasFile('guideline_pdf')) {
            $pdfPath = $request->file('guideline_pdf')->store('guidelines', 'public');
        }

        $bannerPath = null;
        if ($request->hasFile('banner_image')) {
            $bannerPath = $request->file('banner_image')->store('banners', 'public');
        }

        SponsorOffer::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'funding_type' => $request->funding_type,
            'banner_image' => $bannerPath,
            'guideline_pdf' => $pdfPath,
            'status' => 'active',
        ]);

        return redirect()->route('company.dashboard')->with('success', 'Penawaran Sponsor berhasil dipublikasikan!');
    }

    public function edit(SponsorOffer $sponsorOffer)
    {
        if ($sponsorOffer->user_id !== auth()->id()) abort(403, 'Akses Ditolak');
        
        // Tarik data dari database
        $fundingTypes = FundingType::orderBy('name', 'asc')->get();
        
        return view('company.edit', compact('sponsorOffer', 'fundingTypes'));
    }

    public function update(Request $request, SponsorOffer $sponsorOffer)
    {
        if ($sponsorOffer->user_id !== auth()->id()) abort(403, 'Akses Ditolak');

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'funding_type' => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'guideline_pdf' => 'nullable|mimes:pdf|max:5120',
        ]);

        $data = $request->only(['title', 'description', 'funding_type']);

        if ($request->hasFile('banner_image')) {
            if ($sponsorOffer->banner_image && Storage::disk('public')->exists($sponsorOffer->banner_image)) {
                Storage::disk('public')->delete($sponsorOffer->banner_image);
            }
            $data['banner_image'] = $request->file('banner_image')->store('banners', 'public');
        }

        if ($request->hasFile('guideline_pdf')) {
            if ($sponsorOffer->guideline_pdf && Storage::disk('public')->exists($sponsorOffer->guideline_pdf)) {
                Storage::disk('public')->delete($sponsorOffer->guideline_pdf);
            }
            $data['guideline_pdf'] = $request->file('guideline_pdf')->store('guidelines', 'public');
        }

        $sponsorOffer->update($data);

        return redirect()->route('company.index')->with('success', 'Penawaran Sponsor berhasil diperbarui!');
    }

    public function closeOffer(SponsorOffer $sponsorOffer)
    {
        if ($sponsorOffer->user_id !== auth()->id()) abort(403, 'Akses Ditolak');
        $sponsorOffer->update(['status' => 'inactive']);
        return redirect()->route('company.index')->with('success', 'Penawaran Sponsor berhasil ditutup. Penawaran ini tidak akan muncul lagi di pencarian event.');
    }

    public function destroy(SponsorOffer $sponsorOffer)
    {
        if ($sponsorOffer->user_id !== auth()->id()) abort(403, 'Akses Ditolak');

        if ($sponsorOffer->guideline_pdf && Storage::disk('public')->exists($sponsorOffer->guideline_pdf)) {
            Storage::disk('public')->delete($sponsorOffer->guideline_pdf);
        }
        if ($sponsorOffer->banner_image && Storage::disk('public')->exists($sponsorOffer->banner_image)) {
            Storage::disk('public')->delete($sponsorOffer->banner_image);
        }

        $sponsorOffer->delete();
        return redirect()->route('company.index')->with('success', 'Penawaran Sponsor berhasil dihapus!');
    }
}