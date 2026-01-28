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
        Schema::table('ups_maintenances1', function (Blueprint $table) {
            // Make all fields nullable except central_id and date_time
            $table->string('brand_type')->nullable()->change();
            $table->string('capacity')->nullable()->change();

            $table->string('env_condition')->nullable()->change();
            $table->string('status_env_condition')->nullable()->change();
            $table->string('led_display')->nullable()->change();
            $table->string('status_led_display')->nullable()->change();
            $table->string('battery_connection')->nullable()->change();
            $table->string('status_battery_connection')->nullable()->change();

            $table->decimal('ac_input_voltage', 8, 2)->nullable()->change();
            $table->string('status_ac_input_voltage')->nullable()->change();

            $table->decimal('ac_output_voltage', 8, 2)->nullable()->change();
            $table->string('status_ac_output_voltage')->nullable()->change();

            $table->decimal('neutral_ground_voltage', 8, 2)->nullable()->change();
            $table->string('status_neutral_ground_voltage')->nullable()->change();

            $table->decimal('ac_current_input', 8, 2)->nullable()->change();
            $table->string('status_ac_current_input')->nullable()->change();

            $table->decimal('ac_current_output', 8, 2)->nullable()->change();
            $table->string('status_ac_current_output')->nullable()->change();

            $table->decimal('ups_temperature', 5, 2)->nullable()->change();
            $table->string('status_ups_temperature')->nullable()->change();

            $table->decimal('output_frequency', 5, 2)->nullable()->change();
            $table->string('status_output_frequency')->nullable()->change();

            $table->decimal('charging_voltage', 8, 2)->nullable()->change();
            $table->string('status_charging_voltage')->nullable()->change();

            $table->decimal('charging_current', 8, 2)->nullable()->change();
            $table->string('status_charging_current')->nullable()->change();

            $table->string('fan')->nullable()->change();
            $table->string('status_fan')->nullable()->change();

            $table->string('ups_switching_test')->nullable()->change();
            $table->string('status_ups_switching_test')->nullable()->change();

            $table->decimal('battery_voltage_measurement_1', 8, 2)->nullable()->change();
            $table->string('status_battery_voltage_measurement_1')->nullable()->change();

            $table->decimal('battery_voltage_measurement_2', 8, 2)->nullable()->change();
            $table->string('status_battery_voltage_measurement_2')->nullable()->change();

            $table->string('simonica_alarm_test')->nullable()->change();
            $table->string('status_simonica_alarm_test')->nullable()->change();

            $table->string('executor_1')->nullable()->change();
            $table->string('supervisor')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ups_maintenances1', function (Blueprint $table) {
            // Revert back to NOT NULL (if needed)
            $table->string('brand_type')->nullable(false)->change();
            $table->string('capacity')->nullable(false)->change();
            $table->string('env_condition')->nullable(false)->change();
            $table->string('executor_1')->nullable(false)->change();
            $table->string('supervisor')->nullable(false)->change();
            // ... add others if you need to revert
        });
    }
};
