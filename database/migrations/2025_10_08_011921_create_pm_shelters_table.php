<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pm_shelters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('central_id')->constrained('central')->onDelete('cascade');

            // Location & Equipment Info
            $table->string('location')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->enum('type', ['shelter', 'outdoor cabinet', 'pole outdoor cabinet'])->nullable();
            $table->string('brand_type')->nullable();
            $table->string('reg_number')->nullable();
            $table->string('serial_number')->nullable();

            // Check Results - Visual Check
            $table->string('kondisi_ruangan_result')->nullable();
            $table->enum('kondisi_ruangan_status', ['OK', 'NOK'])->nullable();
            $table->string('kondisi_kunci_result')->nullable();
            $table->enum('kondisi_kunci_status', ['OK', 'NOK'])->nullable();

            // Check Results - Fasilitas Ruangan
            $table->string('layout_tata_ruang_result')->nullable();
            $table->enum('layout_tata_ruang_status', ['OK', 'NOK'])->nullable();
            $table->string('kontrol_keamanan_result')->nullable();
            $table->enum('kontrol_keamanan_status', ['OK', 'NOK'])->nullable();
            $table->string('aksesibilitas_result')->nullable();
            $table->enum('aksesibilitas_status', ['OK', 'NOK'])->nullable();
            $table->string('aspek_teknis_result')->nullable();
            $table->enum('aspek_teknis_status', ['OK', 'NOK'])->nullable();

            // Room Temperature (3 fields)
            $table->string('room_temp_1_result')->nullable();
            $table->enum('room_temp_1_status', ['OK', 'NOK'])->nullable();
            $table->string('room_temp_2_result')->nullable();
            $table->enum('room_temp_2_status', ['OK', 'NOK'])->nullable();
            $table->string('room_temp_3_result')->nullable();
            $table->enum('room_temp_3_status', ['OK', 'NOK'])->nullable();

            // Notes
            $table->text('notes')->nullable();

            // Photos with metadata (stored as JSON)
            $table->json('photos')->nullable();

            // Executors (stored as JSON)
            $table->json('executors')->nullable();

            // Approvers - DIPISAH MENJADI 2 KOLOM
            $table->json('verifikator')->nullable(); // {name, nik}
            $table->json('head_of_sub_dept')->nullable(); // {name, nik}

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pm_shelters');
    }
};