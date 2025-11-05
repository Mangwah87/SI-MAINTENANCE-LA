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
        // Table untuk detail lokasi dan jadwal harian
        Schema::create('schedule_locations', function (Blueprint $table) {
            $table->id();

            // Foreign Key ke tabel utama jadwal
            $table->foreignId('schedule_maintenance_id')
                  ->constrained('schedule_maintenances')
                  ->onDelete('cascade');

            // Kolom Lokasi dan Petugas
            $table->string('nama'); // Nama Lokasi (contoh: Sentral A)
            $table->string('petugas'); // Nama Petugas yang bertanggung jawab

            // Kolom Rencana dan Realisasi. 
            // Karena satu lokasi bisa punya banyak tanggal Rencana/Realisasi (sesuai kalender 31 hari),
            // kita gunakan TEXT untuk menyimpan tanggal-tanggal yang dipisahkan koma (comma-separated dates: YYYY-MM-DD,YYYY-MM-DD)
            $table->text('rencana')->nullable(); 
            $table->text('realisasi')->nullable();

            // Kolom metadata
            $table->timestamps();
            
            // Index untuk query yang lebih cepat
            $table->index('nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_locations');
    }
};