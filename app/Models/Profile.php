<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'phone_number',
        'address',
        'description',
        'avatar_logo',
        'organization_name',
        'company_sector',
        'instagram',
        'tiktok',
        'profile_completed_at',
    ];

    protected $casts = [
        'profile_completed_at' => 'datetime',
    ];

    // Relasi balik ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Method untuk menandai profile sebagai selesai
    public function markAsCompleted()
    {
        if (!$this->profile_completed_at) {
            $this->update(['profile_completed_at' => now()]);
        }
    }
}