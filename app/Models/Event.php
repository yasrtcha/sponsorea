<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'event_type',
        'description',
        'poster_image',
        'event_date',
        'proposal_pdf',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Event ini punya banyak riwayat pengajuan sponsor
    public function sponsorshipRequests()
    {
        return $this->hasMany(SponsorshipRequest::class);
    }
}
