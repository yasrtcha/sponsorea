<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sponsorship_requests', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel events dan sponsor_offers
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sponsor_offer_id')->constrained()->cascadeOnDelete();
            
            // Penanda: Siapa yang nge-klik tombol duluan? ('event' atau 'company')
            $table->enum('initiator', ['event', 'company']); 
            
            // Status transaksi
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            // Pesan pengantar (Opsional, misal: "Halo kak, event kami cocok nih!")
            $table->text('message')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sponsorship_requests');
    }
};