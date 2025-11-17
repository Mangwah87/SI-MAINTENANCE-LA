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
        Schema::create('ups_maintenances1', function (Blueprint $table) {
            $table->id();

            // Images - JSON field untuk menyimpan semua gambar
            $table->json('images')->nullable();

            // Informasi Lokasi dan Perangkat
            $table->unsignedBigInteger('central_id')->nullable();
            $table->foreign('central_id')->references('id')->on('central')->onDelete('set null');
            $table->dateTime('date_time');
            $table->string('brand_type');
            $table->string('capacity');
            $table->string('reg_number')->nullable();
            $table->string('sn')->nullable();

            // 1. Visual Check
            $table->string('env_condition');
            $table->string('status_env_condition')->default('OK');
            $table->string('led_display');
            $table->string('status_led_display')->default('OK');
            $table->string('battery_connection');
            $table->string('status_battery_connection')->default('OK');

            // 2. Performance and Capacity Check
            // a. AC input voltage
            $table->decimal('ac_input_voltage', 8, 2);
            $table->enum('status_ac_input_voltage', ['OK', 'NOK'])->default('OK');

            // b. AC output voltage
            $table->decimal('ac_output_voltage', 8, 2);
            $table->enum('status_ac_output_voltage', ['OK', 'NOK'])->default('OK');

            // c. Neutral - Ground Output Voltage
            $table->decimal('neutral_ground_voltage', 8, 2);
            $table->enum('status_neutral_ground_voltage', ['OK', 'NOK'])->default('OK');

            // d. AC current input
            $table->decimal('ac_current_input', 8, 2);
            $table->enum('status_ac_current_input', ['OK', 'NOK'])->default('OK');

            // e. AC current output
            $table->decimal('ac_current_output', 8, 2);
            $table->enum('status_ac_current_output', ['OK', 'NOK'])->default('OK');

            // f. UPS temperature
            $table->decimal('ups_temperature', 5, 2);
            $table->enum('status_ups_temperature', ['OK', 'NOK'])->default('OK');

            // g. Output frequency
            $table->decimal('output_frequency', 5, 2);
            $table->enum('status_output_frequency', ['OK', 'NOK'])->default('OK');

            // h. Charging voltage
            $table->decimal('charging_voltage', 8, 2);
            $table->enum('status_charging_voltage', ['OK', 'NOK'])->default('OK');

            // i. Charging current
            $table->decimal('charging_current', 8, 2);
            $table->enum('status_charging_current', ['OK', 'NOK'])->default('OK');

            // j. FAN
            $table->string('fan');
            $table->enum('status_fan', ['OK', 'NOK'])->default('OK');

            // 3. Backup Tests
            // a. UPS Switching test
            $table->string('ups_switching_test');
            $table->enum('status_ups_switching_test', ['OK', 'NOK'])->default('OK');

            // b. Battery voltage (on Backup Mode)
            // - Measurement I (at the beginning)
            $table->decimal('battery_voltage_measurement_1', 8, 2);
            $table->enum('status_battery_voltage_measurement_1', ['OK', 'NOK'])->default('OK');

            // - Measurement II (15th minutes)
            $table->decimal('battery_voltage_measurement_2', 8, 2);
            $table->enum('status_battery_voltage_measurement_2', ['OK', 'NOK'])->default('OK');

            // 4. Power Alarm Monitoring Test
            $table->string('simonica_alarm_test');
            $table->enum('status_simonica_alarm_test', ['OK', 'NOK'])->default('OK');

            // Notes
            $table->text('notes')->nullable();

            // Personnel
            $table->string('executor_1');
            $table->string('executor_2')->nullable();
            $table->string('supervisor');
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
        Schema::dropIfExists('ups_maintenances1');
    }
};
