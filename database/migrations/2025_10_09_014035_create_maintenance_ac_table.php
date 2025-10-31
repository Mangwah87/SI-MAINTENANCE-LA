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
        Schema::create('maintenance_ac', function (Blueprint $table) {
            $table->id();

            // Images - JSON field untuk menyimpan semua gambar berdasarkan kategori
            $table->json('images')->nullable();

            // Informasi Lokasi dan Perangkat
            $table->string('location');
            $table->dateTime('date_time');
            $table->string('brand_type');
            $table->string('capacity');
            $table->string('reg_number')->nullable();
            $table->string('sn')->nullable();

            // 1. Visual Check
            // a. Environment Condition
            $table->string('environment_condition');
            $table->enum('status_environment_condition', ['OK', 'NOK'])->default('OK');

            // b. Filter
            $table->string('filter');
            $table->enum('status_filter', ['OK', 'NOK'])->default('OK');

            // c. Evaporator
            $table->string('evaporator');
            $table->enum('status_evaporator', ['OK', 'NOK'])->default('OK');

            // d. LED & display (include remote control)
            $table->string('led_display');
            $table->enum('status_led_display', ['OK', 'NOK'])->default('OK');

            // e. Air Flow
            $table->string('air_flow');
            $table->enum('status_air_flow', ['OK', 'NOK'])->default('OK');

            // 2. Room Temperature Shelter/ODC
            $table->decimal('temp_shelter', 5, 2);
            $table->enum('status_temp_shelter', ['OK', 'NOK'])->default('OK');

            $table->decimal('temp_outdoor_cabinet', 5, 2);
            $table->enum('status_temp_outdoor_cabinet', ['OK', 'NOK'])->default('OK');

            // 3. Input Current Air Cond
            // AC 1
            $table->decimal('ac1_current', 5, 2)->nullable();
            $table->enum('status_ac1', ['OK', 'NOK'])->nullable();

            // AC 2
            $table->decimal('ac2_current', 5, 2)->nullable();
            $table->enum('status_ac2', ['OK', 'NOK'])->nullable();

            // AC 3
            $table->decimal('ac3_current', 5, 2)->nullable();
            $table->enum('status_ac3', ['OK', 'NOK'])->nullable();

            // AC 4
            $table->decimal('ac4_current', 5, 2)->nullable();
            $table->enum('status_ac4', ['OK', 'NOK'])->nullable();

            // AC 5
            $table->decimal('ac5_current', 5, 2)->nullable();
            $table->enum('status_ac5', ['OK', 'NOK'])->nullable();

            // AC 6
            $table->decimal('ac6_current', 5, 2)->nullable();
            $table->enum('status_ac6', ['OK', 'NOK'])->nullable();

            // AC 7
            $table->decimal('ac7_current', 5, 2)->nullable();
            $table->enum('status_ac7', ['OK', 'NOK'])->nullable();

            // Notes / Additional Information
            $table->text('notes')->nullable();

            // Personnel (Pelaksana)
            $table->string('executor_1')->nullable();
            $table->string('executor_2')->nullable();
            $table->string('executor_3')->nullable();

            // Supervisor (Mengetahui)
            $table->string('supervisor')->nullable();
            $table->string('supervisor_id_number')->nullable();

            // Department Information
            $table->string('department')->nullable();
            $table->string('sub_department')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_ac');
    }
};
