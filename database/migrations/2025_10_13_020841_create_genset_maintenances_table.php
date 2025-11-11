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
        Schema::create('genset_maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('doc_number')->unique();
            $table->string('location');
            $table->dateTime('maintenance_date');
            $table->string('brand_type')->nullable();
            $table->string('capacity')->nullable();

            // KITA HANYA BUTUH SATU KOLOM JSON INI
            $table->json('images')->nullable();

            // 1. Visual Check (Semua kolom *_image dihapus)
            $table->string('environment_condition_result')->nullable();
            $table->text('environment_condition_comment')->nullable();

            $table->string('engine_oil_press_display_result')->nullable();
            $table->text('engine_oil_press_display_comment')->nullable();

            $table->string('engine_water_temp_display_result')->nullable();
            $table->text('engine_water_temp_display_comment')->nullable();

            $table->string('battery_connection_result')->nullable();
            $table->text('battery_connection_comment')->nullable();

            $table->string('engine_oil_level_result')->nullable();
            $table->text('engine_oil_level_comment')->nullable();

            $table->string('engine_fuel_level_result')->nullable();
            $table->text('engine_fuel_level_comment')->nullable();

            $table->string('running_hours_result')->nullable();
            $table->text('running_hours_comment')->nullable();

            $table->string('cooling_water_level_result')->nullable();
            $table->text('cooling_water_level_comment')->nullable();

            // 2. Engine Running Test - No Load (Semua kolom *_image dihapus)
            $table->string('no_load_ac_voltage_rs')->nullable();
            $table->string('no_load_ac_voltage_st')->nullable();
            $table->string('no_load_ac_voltage_tr')->nullable();
            $table->string('no_load_ac_voltage_rn')->nullable();
            $table->string('no_load_ac_voltage_sn')->nullable();
            $table->string('no_load_ac_voltage_tn')->nullable();
            $table->text('no_load_ac_voltage_comment')->nullable();

            $table->string('no_load_output_frequency_result')->nullable();
            $table->text('no_load_output_frequency_comment')->nullable();

            $table->string('no_load_battery_charging_current_result')->nullable();
            $table->text('no_load_battery_charging_current_comment')->nullable();
            
            $table->string('no_load_engine_cooling_water_temp_result')->nullable();
            $table->text('no_load_engine_cooling_water_temp_comment')->nullable();

            $table->string('no_load_engine_oil_press_result')->nullable();
            $table->text('no_load_engine_oil_press_comment')->nullable();
            
            // 2. Engine Running Test - Load Test (Semua kolom *_image dihapus)
            $table->string('load_ac_voltage_rs')->nullable();
            $table->string('load_ac_voltage_st')->nullable();
            $table->string('load_ac_voltage_tr')->nullable();
            $table->string('load_ac_voltage_rn')->nullable();
            $table->string('load_ac_voltage_sn')->nullable();
            $table->string('load_ac_voltage_tn')->nullable();
            $table->text('load_ac_voltage_comment')->nullable();

            $table->string('load_ac_current_r')->nullable();
            $table->string('load_ac_current_s')->nullable();
            $table->string('load_ac_current_t')->nullable();
            $table->text('load_ac_current_comment')->nullable();

            $table->string('load_output_frequency_result')->nullable();
            $table->text('load_output_frequency_comment')->nullable();

            $table->string('load_battery_charging_current_result')->nullable();
            $table->text('load_battery_charging_current_comment')->nullable();

            $table->string('load_engine_cooling_water_temp_result')->nullable();
            $table->text('load_engine_cooling_water_temp_comment')->nullable();

            $table->string('load_engine_oil_press_result')->nullable();
            $table->text('load_engine_oil_press_comment')->nullable();

            // Notes, Pelaksana & Mengetahui
            $table->text('notes')->nullable();
            $table->string('technician_1_name');
            $table->string('technician_1_department')->nullable();
            $table->string('technician_2_name')->nullable();
            $table->string('technician_2_department')->nullable();
            $table->string('technician_3_name')->nullable();
            $table->string('technician_3_department')->nullable();

            $table->string('approver_name')->nullable();
            $table->string('approver_department')->nullable();

            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genset_maintenances');
    }
};