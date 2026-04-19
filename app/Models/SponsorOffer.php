<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'funding_type',
        'description',
        'banner_image',
        'funding_type',
        'guideline_pdf',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Penawaran sponsor ini punya banyak riwayat pengajuan dari event
    public function sponsorshipRequests()
    {
        return $this->hasMany(SponsorshipRequest::class);
    }
}
