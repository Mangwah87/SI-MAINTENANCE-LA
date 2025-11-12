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
        Schema::create('cable_panel_maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('doc_number')->unique();

            // General Info - Based on PDF Header [cite: 10, 11, 12]
            $table->string('location');
            $table->dateTime('maintenance_date'); // Date / time [cite: 11]
            $table->string('brand_type')->nullable(); // Brand / Type [cite: 12]
            $table->string('reg_number')->nullable(); // Reg. Number [cite: 12]
            $table->string('sn')->nullable(); // S/N [cite: 12]

            $table->json('images')->nullable(); // Column for images, following style reference

            // Section 1: Visual Check 
            // a. Indicator Lamp
            $table->string('visual_indicator_lamp_result')->nullable();
            $table->enum('visual_indicator_lamp_status', ['OK', 'NOK'])->default('OK');
            
            // b. Voltmeter & Ampere meter
            $table->string('visual_voltmeter_ampere_meter_result')->nullable();
            $table->enum('visual_voltmeter_ampere_meter_status', ['OK', 'NOK'])->default('OK');

            // c. Arrester
            $table->string('visual_arrester_result')->nullable();
            $table->enum('visual_arrester_status', ['OK', 'NOK'])->default('OK');

            // d. MCB Input UPS
            $table->string('visual_mcb_input_ups_result')->nullable();
            $table->enum('visual_mcb_input_ups_status', ['OK', 'NOK'])->default('OK');

            // e. MCB Output UPS
            $table->string('visual_mcb_output_ups_result')->nullable();
            $table->enum('visual_mcb_output_ups_status', ['OK', 'NOK'])->default('OK');

            // f. MCB Bypass
            $table->string('visual_mcb_bypass_result')->nullable();
            $table->enum('visual_mcb_bypass_status', ['OK', 'NOK'])->default('OK');

            // Section 2: Performance Measurement 
            // I. MCB Temperature
            $table->string('perf_temp_mcb_input_ups_result')->nullable();
            $table->enum('perf_temp_mcb_input_ups_status', ['OK', 'NOK'])->default('OK');
            
            $table->string('perf_temp_mcb_output_ups_result')->nullable();
            $table->enum('perf_temp_mcb_output_ups_status', ['OK', 'NOK'])->default('OK');

            $table->string('perf_temp_mcb_bypass_ups_result')->nullable();
            $table->enum('perf_temp_mcb_bypass_ups_status', ['OK', 'NOK'])->default('OK');

            $table->string('perf_temp_mcb_load_rack_result')->nullable();
            $table->enum('perf_temp_mcb_load_rack_status', ['OK', 'NOK'])->default('OK');

            $table->string('perf_temp_mcb_cooling_unit_result')->nullable();
            $table->enum('perf_temp_mcb_cooling_unit_status', ['OK', 'NOK'])->default('OK');

            // II. Cable Temperature
            $table->string('perf_temp_cable_input_ups_result')->nullable();
            $table->enum('perf_temp_cable_input_ups_status', ['OK', 'NOK'])->default('OK');

            $table->string('perf_temp_cable_output_ups_result')->nullable();
            $table->enum('perf_temp_cable_output_ups_status', ['OK', 'NOK'])->default('OK');

            $table->string('perf_temp_cable_bypass_ups_result')->nullable();
            $table->enum('perf_temp_cable_bypass_ups_status', ['OK', 'NOK'])->default('OK');

            $table->string('perf_temp_cable_load_rack_result')->nullable();
            $table->enum('perf_temp_cable_load_rack_status', ['OK', 'NOK'])->default('OK');

            $table->string('perf_temp_cable_cooling_unit_result')->nullable();
            $table->enum('perf_temp_cable_cooling_unit_status', ['OK', 'NOK'])->default('OK');

            // Section 3: Performance Check 
            // a. Maksure All Cable Connection
            $table->string('perf_check_cable_connection_result')->nullable();
            $table->enum('perf_check_cable_connection_status', ['OK', 'NOK'])->default('OK');

            // b. Spare of MCB Load Rack
            $table->string('perf_check_spare_mcb_result')->nullable();
            $table->enum('perf_check_spare_mcb_status', ['OK', 'NOK'])->default('OK');

            // c. Single Line Diagram
            $table->string('perf_check_single_line_diagram_result')->nullable();
            $table->enum('perf_check_single_line_diagram_status', ['OK', 'NOK'])->default('OK');

            // Notes [cite: 15]
            $table->text('notes')->nullable();

            // Pelaksana (Technicians) - Based on PDF Page 2 
            $table->string('technician_1_name')->nullable();
            $table->string('technician_1_company')->nullable();
            $table->string('technician_2_name')->nullable();
            $table->string('technician_2_company')->nullable();
            $table->string('technician_3_name')->nullable();
            $table->string('technician_3_company')->nullable();

            // Mengetahui (Approver) 
            $table->string('approver_name')->nullable();

            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cable_panel_maintenances');
    }
};