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
        // Table untuk data jadwal maintenance utama (Header)
        Schema::create('schedule_maintenances', function (Blueprint $table) {
            $table->id();

            // Sesuai dengan header dokumen Word
            // No. Dok. : FM-LAP-D2-SOP-003-007
            $table->string('doc_number')->unique()->nullable();
            
            // Bulan (Digunakan untuk menentukan bulan jadwal, disimpan sebagai tanggal awal bulan)
            $table->date('bulan'); 

            // Data yang membuat dan mengetahui (sesuai contoh di Controller sebelumnya)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Dibuat oleh user yang login
            $table->string('dibuat_oleh'); // Nama / NIK Pembuat (jika perlu nama lengkap, bukan hanya user_id)
            $table->string('mengetahui')->nullable(); // Nama / NIK Manajer yang Mengetahui

            // Kolom metadata
            $table->timestamps();
            $table->softDeletes(); // Opsional: Jika Anda menggunakan Soft Delete

            // Index untuk query yang lebih cepat
            $table->index('bulan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_maintenances');
    }
};