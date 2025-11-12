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
        Schema::create('grounding_maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('doc_number')->unique();

            // General Info
            $table->string('location');
            $table->dateTime('maintenance_date'); // Changed from date_time for consistency
            $table->string('brand_type')->nullable();
            $table->string('reg_number')->nullable();
            $table->string('sn')->nullable(); // S/N

            $table->json('images')->nullable(); // Single JSON column for all images

            // Section 1: Visual Check (Result & Status)
            $table->string('visual_air_terminal_result')->nullable();
            $table->enum('visual_air_terminal_status', ['OK', 'NOK'])->default('OK');

            $table->string('visual_down_conductor_result')->nullable();
            $table->enum('visual_down_conductor_status', ['OK', 'NOK'])->default('OK');

            $table->string('visual_ground_rod_result')->nullable();
            $table->enum('visual_ground_rod_status', ['OK', 'NOK'])->default('OK');

            $table->string('visual_bonding_bar_result')->nullable();
            $table->enum('visual_bonding_bar_status', ['OK', 'NOK'])->default('OK');

            $table->string('visual_arrester_condition_result')->nullable();
            $table->enum('visual_arrester_condition_status', ['OK', 'NOK'])->default('OK');

            $table->string('visual_maksure_equipment_result')->nullable(); // f. Maksure All Equipment to Ground Bar
            $table->enum('visual_maksure_equipment_status', ['OK', 'NOK'])->default('OK');

            $table->string('visual_maksure_connection_result')->nullable(); // g. Maksure All Connection Tightened
            $table->enum('visual_maksure_connection_status', ['OK', 'NOK'])->default('OK');

            $table->string('visual_ob_light_result')->nullable(); // h. OB Light Installed if With Tower
            $table->enum('visual_ob_light_status', ['OK', 'NOK'])->default('OK');

            // Section 2: Performance Measurement (Result & Status)
            $table->string('perf_ground_resistance_result')->nullable(); // a. Ground Resistance (R)
            $table->enum('perf_ground_resistance_status', ['OK', 'NOK'])->default('OK');

            $table->string('perf_arrester_cutoff_power_result')->nullable(); // b. Arrester Cutoff Voltage (Power)
            $table->enum('perf_arrester_cutoff_power_status', ['OK', 'NOK'])->default('OK');

            $table->string('perf_arrester_cutoff_data_result')->nullable(); // c. Arrester Cutoff Voltage (Data)
            $table->enum('perf_arrester_cutoff_data_status', ['OK', 'NOK'])->default('OK');

            $table->string('perf_tighten_nut_result')->nullable(); // d. Tighten of Nut
            $table->enum('perf_tighten_nut_status', ['OK', 'NOK'])->default('OK');

            // Notes
            $table->text('notes')->nullable();

            // Pelaksana (Technicians) - Match PDF Table
            $table->string('technician_1_name')->nullable();
            $table->string('technician_1_company')->nullable(); // Changed from department
            $table->string('technician_2_name')->nullable();
            $table->string('technician_2_company')->nullable();
            $table->string('technician_3_name')->nullable();
            $table->string('technician_3_company')->nullable();

            // Mengetahui (Approver)
            $table->string('approver_name')->nullable();
            // Add approver company/dept if needed
            // $table->string('approver_company')->nullable();

            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grounding_maintenances');
    }
};