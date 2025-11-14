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
        Schema::create('rectifier_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Informasi Lokasi dan Perangkat
            $table->string('location');
            $table->dateTime('date_time');
            $table->string('reg_number')->nullable();
            $table->string('sn')->nullable();
            $table->string('brand_type');
            $table->string('power_module'); // Single/Dual/Three

            // 1. Visual Check
            $table->string('env_condition')->nullable();
            $table->enum('status_env_condition', ['OK', 'NOK'])->default('OK');
            $table->string('led_display')->nullable();
            $table->enum('status_led_display', ['OK', 'NOK'])->default('OK');
            $table->string('battery_connection')->nullable();
            $table->enum('status_battery_connection', ['OK', 'NOK'])->default('OK');

            // 2. Performance and Capacity Check
            // a. AC Input Voltage
            $table->decimal('ac_input_voltage', 8, 2)->nullable();
            $table->enum('status_ac_input_voltage', ['OK', 'NOK'])->default('OK');

            // b. AC Current Input (SUDAH DIGABUNG)
            $table->decimal('ac_current_input', 8, 2)->nullable();
            $table->enum('status_ac_current_input', ['OK', 'NOK'])->default('OK');

            // c. DC Current Output (SUDAH DIGABUNG)
            $table->decimal('dc_current_output', 8, 2)->nullable();
            $table->enum('status_dc_current_output', ['OK', 'NOK'])->default('OK');

            // d. Battery Temperature
            $table->decimal('battery_temperature', 8, 2)->nullable();
            $table->enum('status_battery_temperature', ['OK', 'NOK'])->default('OK');

            // e. Charging Voltage DC
            $table->decimal('charging_voltage_dc', 8, 2)->nullable();
            $table->enum('status_charging_voltage_dc', ['OK', 'NOK'])->default('OK');

            // f. Charging Current DC
            $table->decimal('charging_current_dc', 8, 2)->nullable();
            $table->enum('status_charging_current_dc', ['OK', 'NOK'])->default('OK');

            // 3. Backup Tests
            $table->string('backup_test_rectifier')->nullable();
            $table->enum('status_backup_test_rectifier', ['OK', 'NOK'])->default('OK');

            $table->decimal('backup_test_voltage_measurement1', 8, 2)->nullable();
            $table->decimal('backup_test_voltage_measurement2', 8, 2)->nullable();
            $table->enum('status_backup_test_voltage', ['OK', 'NOK'])->default('OK');

            // 4. Power Alarm Monitoring Test
            $table->string('power_alarm_test')->nullable();
            $table->enum('status_power_alarm_test', ['OK', 'NOK'])->default('OK');

            // Notes
            $table->text('notes')->nullable();

            // Images (JSON)
            $table->json('images')->nullable();

            // Personnel
            $table->string('executor_1');
            $table->string('executor_2')->nullable();
            $table->string('executor_3')->nullable();
            // Di migration, tambahkan kolom:
            $table->string('executor_1_department')->nullable();
            $table->string('executor_2_department')->nullable();
            $table->string('executor_3_department')->nullable();
            $table->string('supervisor');
            $table->string('supervisor_id_number')->nullable();
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
        Schema::dropIfExists('rectifier_maintenances');
    }
};
