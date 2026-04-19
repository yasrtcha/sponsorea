<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use App\Models\EventType;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('user_id', auth()->id())->latest()->get();
        return view('event.index', compact('events'));
    }

    public function create()
    {
        // Tarik data Jenis Event dari database
        $eventTypes = EventType::orderBy('name', 'asc')->get();
        return view('event.create', compact('eventTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'event_type' => 'required|string', // Tambahan validasi event_type
            'description' => 'required|string',
            'event_date' => 'required|date',
            'poster_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'proposal_pdf' => 'required|mimes:pdf|max:5120',
        ]);

        $pdfPath = $request->file('proposal_pdf')->store('proposals', 'public');

        $posterPath = null;
        if ($request->hasFile('poster_image')) {
            $posterPath = $request->file('poster_image')->store('posters', 'public');
        }

        Event::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'event_type' => $request->event_type, // Simpan ke database
            'description' => $request->description,
            'event_date' => $request->event_date,
            'poster_image' => $posterPath,
            'proposal_pdf' => $pdfPath,
            'status' => 'pending',
        ]);

        return redirect()->route('event.dashboard')->with('success', 'Event dan Proposal berhasil diunggah!');    
    }

    public function edit(Event $event)
    {
        if ($event->user_id !== auth()->id()) abort(403, 'Akses Ditolak');
        
        // Tarik data Jenis Event dari database
        $eventTypes = EventType::orderBy('name', 'asc')->get();
        
        return view('event.edit', compact('event', 'eventTypes'));
    }

    public function update(Request $request, Event $event)
    {
        if ($event->user_id !== auth()->id()) abort(403, 'Akses Ditolak');

        $request->validate([
            'title' => 'required|string|max:255',
            'event_type' => 'required|string', // Tambahan validasi
            'description' => 'required|string',
            'event_date' => 'required|date',
            'poster_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'proposal_pdf' => 'nullable|mimes:pdf|max:5120',
        ]);

        // Ambil data teks (termasuk event_type)
        $data = $request->only(['title', 'event_type', 'description', 'event_date']);

        if ($request->hasFile('poster_image')) {
            if ($event->poster_image && Storage::disk('public')->exists($event->poster_image)) {
                Storage::disk('public')->delete($event->poster_image);
            }
            $data['poster_image'] = $request->file('poster_image')->store('posters', 'public');
        }

        if ($request->hasFile('proposal_pdf')) {
            if ($event->proposal_pdf && Storage::disk('public')->exists($event->proposal_pdf)) {
                Storage::disk('public')->delete($event->proposal_pdf);
            }
            $data['proposal_pdf'] = $request->file('proposal_pdf')->store('proposals', 'public');
        }

        $event->update($data);

        return redirect()->route('event.index')->with('success', 'Event berhasil diperbarui!');
    }

    public function closeEvent(Event $event)
    {
        if ($event->user_id !== auth()->id()) abort(403, 'Akses Ditolak');
        $event->update(['status' => 'completed']);
        return redirect()->route('event.index')->with('success', 'Event berhasil ditutup. Event ini tidak akan muncul lagi di pencarian perusahaan.');
    }

    public function destroy(Event $event)
    {
        if ($event->user_id !== auth()->id()) abort(403, 'Akses Ditolak');

        if ($event->proposal_pdf && Storage::disk('public')->exists($event->proposal_pdf)) {
            Storage::disk('public')->delete($event->proposal_pdf);
        }
        if ($event->poster_image && Storage::disk('public')->exists($event->poster_image)) {
            Storage::disk('public')->delete($event->poster_image);
        }
        
        $event->delete();
        return redirect()->route('event.index')->with('success', 'Event berhasil dihapus!');
    }
}