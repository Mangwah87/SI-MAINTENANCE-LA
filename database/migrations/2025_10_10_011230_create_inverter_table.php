<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel utama inverter
        Schema::create('inverters', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_dokumen')->default('FM-LAP-D2-SOP-003-008');
            $table->string('lokasi');
            $table->dateTime('tanggal_dokumentasi');
            $table->string('brand')->nullable();
            $table->string('reg_num')->nullable();
            $table->string('serial_num')->nullable();
            $table->string('perusahaan')->default('PT. Aplikanusa Lintasarta');
            $table->text('keterangan')->nullable();
            $table->string('boss')->nullable();
            
            // Performance Metrics
            $table->decimal('dc_input_voltage', 8, 2)->nullable();
            $table->decimal('dc_current_input', 8, 2)->nullable();
            $table->string('dc_current_inverter_type')->nullable();
            $table->decimal('ac_current_output', 8, 2)->nullable();
            $table->string('ac_current_inverter_type')->nullable();
            $table->decimal('neutral_ground_output_voltage', 8, 2)->nullable();
            $table->decimal('equipment_temperature', 8, 2)->nullable();
            
            // JSON Columns - TAMBAHKAN INI
            $table->json('pelaksana')->nullable();
            $table->json('pengawas')->nullable();
            $table->json('data_checklist')->nullable();
            
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inverters');
    }
};