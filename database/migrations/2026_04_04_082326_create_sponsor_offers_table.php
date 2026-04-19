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
        Schema::create('sponsor_offers', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->string('title'); // Nama program sponsorship
        $table->text('description'); // Penjelasan apa yang dicari perusahaan
        $table->string('banner_image')->nullable(); // Gambar banner (opsional)
        $table->string('funding_type'); // Misal: "Dana Tunai", "Barang/Produk", "Media Partner"
        $table->string('guideline_pdf')->nullable(); // File syarat/ketentuan PDF (opsional)
        $table->enum('status', ['active', 'inactive'])->default('active');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsor_offers');
    }
};
