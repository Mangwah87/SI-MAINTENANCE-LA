<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pm_shelters', function (Blueprint $table) {
            $table->id();
            $table->string('location');
            $table->dateTime('date_time');
            $table->string('brand_type');
            $table->string('reg_number');
            $table->string('serial_number');

            // Visual Check
            $table->string('kondisi_ruangan_result')->nullable();
            $table->boolean('kondisi_ruangan_status')->default(false);
            $table->string('kondisi_kunci_result')->nullable();
            $table->boolean('kondisi_kunci_status')->default(false);

            // Fasilitas Ruangan
            $table->string('layout_result')->nullable();
            $table->boolean('layout_status')->default(false);
            $table->string('kontrol_keamanan_result')->nullable();
            $table->boolean('kontrol_keamanan_status')->default(false);
            $table->string('aksesibilitas_result')->nullable();
            $table->boolean('aksesibilitas_status')->default(false);
            $table->string('aspek_teknis_result')->nullable();
            $table->boolean('aspek_teknis_status')->default(false);

            $table->text('notes')->nullable();
            $table->json('pelaksana')->nullable(); // Array of executors
            $table->string('mengetahui')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pm_shelters');
    }
};