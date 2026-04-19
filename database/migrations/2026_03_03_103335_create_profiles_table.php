<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('profiles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
        // Kolom umum untuk semua role
        $table->string('phone_number')->nullable();
        $table->text('address')->nullable();
        $table->text('description')->nullable(); 
        $table->string('avatar_logo')->nullable(); 
        
        // Kolom spesifik (Bisa diisi null jika role tidak sesuai)
        // Contoh untuk mahasiswa: Nama UKM/Organisasi (Misal: FORMAPI UB)
        $table->string('organization_name')->nullable(); 
        
        // Contoh untuk perusahaan: Sektor Industri (Misal: F&B, Teknologi, dll)
        $table->string('company_name')->nullable();
        $table->string('company_sector')->nullable();
        
        // Social Media
        $table->string('instagram')->nullable();
        $table->string('tiktok')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
