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
        // 1. Tabel Header
        Schema::create('instalasi_kabel_headers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('no_dokumen')->unique();
            $table->string('location');
            $table->dateTime('date_time');
            $table->string('brand_type');
            $table->string('reg_number');
            $table->string('serial_number');
            $table->text('notes')->nullable();
            $table->string('bulan')->comment('Bulan dan Tahun PM (contoh: Oktober 2025)');
            $table->unsignedSmallInteger('jumlah_lokasi')->default(1);
            $table->string('dibuat_oleh');
            $table->timestamps();
        });

        // 2. Tabel Detail Pemeriksaan
        Schema::create('instalasi_kabel_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instalasi_kabel_header_id')->constrained()->onDelete('cascade'); // Relasi
            $table->string('item_description');
            $table->string('operational_standard');
            $table->string('result')->nullable();
            $table->enum('status', ['OK', 'NOK', 'N/A']);
            $table->string('photo_path')->nullable(); // ✅ Path untuk menyimpan foto
            $table->timestamps();
        });
        
        // 3. Tabel Signature/Pelaksana
        Schema::create('instalasi_kabel_signatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instalasi_kabel_header_id')->constrained()->onDelete('cascade'); // Relasi
            $table->unsignedTinyInteger('no');
            $table->string('role'); // Contoh: Pelaksana, Mengetahui
            $table->string('name');
            $table->string('perusahaan');
            $table->string('tanda_tangan_path')->nullable(); // Path untuk gambar tanda tangan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instalasi_kabel_signatures');
        Schema::dropIfExists('instalasi_kabel_details');
        Schema::dropIfExists('instalasi_kabel_headers');
    }
};