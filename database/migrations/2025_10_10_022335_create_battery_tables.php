<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Table untuk data maintenance utama
        Schema::create('battery_maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('doc_number')->unique(); // FM-LAP-D2-SOP-003-013
            $table->string('location');
            $table->dateTime('maintenance_date');
            $table->decimal('battery_temperature', 5, 2)->nullable();
            $table->string('company')->default('PT. Aplikarusa Lintasarta');
            $table->text('notes')->nullable();

            // Data User
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Data Pelaksana - Kolom lama (untuk backward compatibility)
            $table->string('technician_name');

            // Data Pelaksana Baru - Multiple Technicians
            $table->string('technician_1_name');
            $table->string('technician_1_company');
            $table->string('technician_2_name')->nullable();
            $table->string('technician_2_company')->nullable();
            $table->string('technician_3_name')->nullable();
            $table->string('technician_3_company')->nullable();
            $table->string('supervisor_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Index untuk query yang lebih cepat
            $table->index('location');
            $table->index('maintenance_date');
        });

        // Table untuk data pembacaan battery
        Schema::create('battery_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('battery_maintenance_id')->constrained('battery_maintenances')->onDelete('cascade');
            $table->integer('bank_number');
            $table->string('battery_brand');
            $table->integer('battery_number');
            $table->decimal('voltage', 5, 2);

            // Data Foto
            $table->string('photo_path')->nullable();
            $table->decimal('photo_latitude', 10, 8)->nullable();
            $table->decimal('photo_longitude', 11, 8)->nullable();
            $table->dateTime('photo_timestamp')->nullable();

            $table->timestamps();

            // Index untuk query yang lebih cepat
            $table->index(['battery_maintenance_id', 'bank_number']);
            $table->index(['bank_number', 'battery_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('battery_readings');
        Schema::dropIfExists('battery_maintenances');
    }
};
