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
        Schema::create('ups_maintenances', function (Blueprint $table) {
            $table->id();

            // Informasi Lokasi dan Perangkat
            $table->string('location');
            $table->dateTime('date_time');
            $table->string('brand_type');
            $table->string('capacity');
            $table->string('reg_number')->nullable();
            $table->string('sn')->nullable();

            // Visual Check
            $table->string('env_condition');
            $table->string('led_display');
            $table->string('battery_connection');
            $table->enum('status_visual_check', ['OK', 'NOK'])->default('OK');

            // Performance and Capacity Check
            // a. AC Input Voltage
            $table->decimal('ac_input_voltage_rs', 8, 2);
            $table->decimal('ac_input_voltage_st', 8, 2);
            $table->decimal('ac_input_voltage_tr', 8, 2);
            $table->enum('status_ac_input_voltage', ['OK', 'NOK'])->default('OK');

            // b. AC Output Voltage
            $table->decimal('ac_output_voltage_rs', 8, 2);
            $table->decimal('ac_output_voltage_st', 8, 2);
            $table->decimal('ac_output_voltage_tr', 8, 2);
            $table->enum('status_ac_output_voltage', ['OK', 'NOK'])->default('OK');

            // c. AC Current Input
            $table->decimal('ac_current_input_r', 8, 2);
            $table->decimal('ac_current_input_s', 8, 2);
            $table->decimal('ac_current_input_t', 8, 2);
            $table->enum('status_ac_current_input', ['OK', 'NOK'])->default('OK');

            // d. AC Current Output
            $table->decimal('ac_current_output_r', 8, 2);
            $table->decimal('ac_current_output_s', 8, 2);
            $table->decimal('ac_current_output_t', 8, 2);
            $table->enum('status_ac_current_output', ['OK', 'NOK'])->default('OK');

            // e. UPS Temperature
            $table->decimal('ups_temperature', 5, 2);
            $table->enum('status_ups_temperature', ['OK', 'NOK'])->default('OK');

            // f. Output Frequency
            $table->decimal('output_frequency', 5, 2);
            $table->enum('status_output_frequency', ['OK', 'NOK'])->default('OK');

            // g. Charging Voltage
            $table->decimal('charging_voltage', 8, 2);
            $table->enum('status_charging_voltage', ['OK', 'NOK'])->default('OK');

            // h. Charging Current
            $table->decimal('charging_current', 8, 2);
            $table->enum('status_charging_current', ['OK', 'NOK'])->default('OK');

            // Notes
            $table->text('notes')->nullable();

            // Personnel
            $table->string('executor_1');
            $table->string('executor_2')->nullable();
            $table->string('supervisor');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ups_maintenances');
    }
};
