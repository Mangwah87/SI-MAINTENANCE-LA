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

            // 1. Visual Check
            $table->string('environment_condition_result')->nullable();
            $table->text('environment_condition_comment')->nullable(); // Diubah ke text()
            $table->string('environment_condition_image')->nullable();

            $table->string('engine_oil_press_display_result')->nullable();
            $table->text('engine_oil_press_display_comment')->nullable(); // Diubah ke text()
            $table->string('engine_oil_press_display_image')->nullable();

            $table->string('engine_water_temp_display_result')->nullable();
            $table->text('engine_water_temp_display_comment')->nullable(); // Diubah ke text()
            $table->string('engine_water_temp_display_image')->nullable();

            $table->string('battery_connection_result')->nullable();
            $table->text('battery_connection_comment')->nullable(); // Diubah ke text()
            $table->string('battery_connection_image')->nullable();

            $table->string('engine_oil_level_result')->nullable();
            $table->text('engine_oil_level_comment')->nullable(); // Diubah ke text()
            $table->string('engine_oil_level_image')->nullable();

            $table->string('engine_fuel_level_result')->nullable();
            $table->text('engine_fuel_level_comment')->nullable(); // Diubah ke text()
            $table->string('engine_fuel_level_image')->nullable();

            $table->string('running_hours_result')->nullable();
            $table->text('running_hours_comment')->nullable(); // Diubah ke text()
            $table->string('running_hours_image')->nullable();

            $table->string('cooling_water_level_result')->nullable();
            $table->text('cooling_water_level_comment')->nullable(); // Diubah ke text()
            $table->string('cooling_water_level_image')->nullable();

            // 2. Engine Running Test - No Load
            $table->string('no_load_ac_voltage_rs')->nullable();
            $table->string('no_load_ac_voltage_st')->nullable();
            $table->string('no_load_ac_voltage_tr')->nullable();
            $table->string('no_load_ac_voltage_rn')->nullable();
            $table->string('no_load_ac_voltage_sn')->nullable();
            $table->string('no_load_ac_voltage_tn')->nullable();
            $table->text('no_load_ac_voltage_comment')->nullable(); // Diubah ke text()
            $table->string('no_load_ac_voltage_image')->nullable();

            $table->string('no_load_output_frequency_result')->nullable();
            $table->text('no_load_output_frequency_comment')->nullable(); // Diubah ke text()
            $table->string('no_load_output_frequency_image')->nullable();

            $table->string('no_load_battery_charging_current_result')->nullable();
            $table->text('no_load_battery_charging_current_comment')->nullable(); // Diubah ke text()
            $table->string('no_load_battery_charging_current_image')->nullable();
            
            $table->string('no_load_engine_cooling_water_temp_result')->nullable();
            $table->text('no_load_engine_cooling_water_temp_comment')->nullable(); // Diubah ke text()
            $table->string('no_load_engine_cooling_water_temp_image')->nullable();

            $table->string('no_load_engine_oil_press_result')->nullable();
            $table->text('no_load_engine_oil_press_comment')->nullable(); // Diubah ke text()
            $table->string('no_load_engine_oil_press_image')->nullable();
            
            // 2. Engine Running Test - Load Test
            $table->string('load_ac_voltage_rs')->nullable();
            $table->string('load_ac_voltage_st')->nullable();
            $table->string('load_ac_voltage_tr')->nullable();
            $table->string('load_ac_voltage_rn')->nullable();
            $table->string('load_ac_voltage_sn')->nullable();
            $table->string('load_ac_voltage_tn')->nullable();
            $table->text('load_ac_voltage_comment')->nullable(); // Diubah ke text()
            $table->string('load_ac_voltage_image')->nullable();

            $table->string('load_ac_current_r')->nullable();
            $table->string('load_ac_current_s')->nullable();
            $table->string('load_ac_current_t')->nullable();
            $table->text('load_ac_current_comment')->nullable(); // Diubah ke text()
            $table->string('load_ac_current_image')->nullable();

            $table->string('load_output_frequency_result')->nullable();
            $table->text('load_output_frequency_comment')->nullable(); // Diubah ke text()
            $table->string('load_output_frequency_image')->nullable();

            $table->string('load_battery_charging_current_result')->nullable();
            $table->text('load_battery_charging_current_comment')->nullable(); // Diubah ke text()
            $table->string('load_battery_charging_current_image')->nullable();

            $table->string('load_engine_cooling_water_temp_result')->nullable();
            $table->text('load_engine_cooling_water_temp_comment')->nullable(); // Diubah ke text()
            $table->string('load_engine_cooling_water_temp_image')->nullable();

            $table->string('load_engine_oil_press_result')->nullable();
            $table->text('load_engine_oil_press_comment')->nullable(); // Diubah ke text()
            $table->string('load_engine_oil_press_image')->nullable();

            // Notes, Pelaksana & Mengetahui
            $table->text('notes')->nullable(); // notes juga sebaiknya text()
            $table->string('technician_1_name');
            $table->string('technician_1_department')->nullable();
            $table->string('technician_2_name')->nullable();
            $table->string('technician_2_department')->nullable();
            $table->string('technician_3_name')->nullable();
            $table->string('technician_3_department')->nullable();

            $table->string('approver_name')->nullable();
            $table->string('approver_department')->nullable();

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