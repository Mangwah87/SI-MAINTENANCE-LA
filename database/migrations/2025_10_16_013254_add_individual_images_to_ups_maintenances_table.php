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
        Schema::table('ups_maintenances', function (Blueprint $table) {
            // Hanya 1 field JSON untuk menyimpan semua gambar
            $table->json('images')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ups_maintenances', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }
};
