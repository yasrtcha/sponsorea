<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorshipRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'sponsor_offer_id',
        'initiator',
        'status',
        'message',
        'rejection_notes',
        'mou_path',
        'mou_uploaded_at'
    ];

    // Relasi balik ke Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relasi balik ke Penawaran Sponsor
    public function sponsorOffer()
    {
        return $this->belongsTo(SponsorOffer::class);
    }
}