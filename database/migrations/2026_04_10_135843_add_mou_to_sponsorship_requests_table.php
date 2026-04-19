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
        Schema::table('sponsorship_requests', function (Blueprint $table) {
            $table->string('mou_path')->nullable()->after('message'); // Path file kontrak MoU
            $table->timestamp('mou_uploaded_at')->nullable()->after('mou_path'); // Kapan MoU di-upload
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sponsorship_requests', function (Blueprint $table) {
            $table->dropColumn(['mou_path', 'mou_uploaded_at']);
        });
    }
};
