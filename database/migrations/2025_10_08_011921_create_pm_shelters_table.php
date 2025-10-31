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

            // Location & Equipment Info
            $table->string('location')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
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

            // Notes
            $table->text('notes')->nullable();

            // Photos with metadata (stored as JSON)
            $table->json('photos')->nullable(); // [{path, latitude, longitude, taken_at, location_name}]

            // Executors (stored as JSON)
            $table->json('executors')->nullable(); // [{name, department, sub_department}]

            // Approver
            $table->json('approvers')->nullable(); // [{name,nik}]

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pm_shelters');
    }
};