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
        Schema::table('ups_maintenances', function (Blueprint $table) {
            $table->string('brand_type')->nullable()->change();
            $table->string('capacity')->nullable()->change();

            $table->string('env_condition')->nullable()->change();
            $table->string('status_env_condition')->nullable()->change();
            $table->string('led_display')->nullable()->change();
            $table->string('status_led_display')->nullable()->change();
            $table->string('battery_connection')->nullable()->change();
            $table->string('status_battery_connection')->nullable()->change();

            $table->decimal('ac_input_voltage_rs', 8, 2)->nullable()->change();
            $table->decimal('ac_input_voltage_st', 8, 2)->nullable()->change();
            $table->decimal('ac_input_voltage_tr', 8, 2)->nullable()->change();
            $table->string('status_ac_input_voltage')->nullable()->change();

            $table->decimal('ac_output_voltage_rs', 8, 2)->nullable()->change();
            $table->decimal('ac_output_voltage_st', 8, 2)->nullable()->change();
            $table->decimal('ac_output_voltage_tr', 8, 2)->nullable()->change();
            $table->string('status_ac_output_voltage')->nullable()->change();

            $table->decimal('ac_current_input_r', 8, 2)->nullable()->change();
            $table->decimal('ac_current_input_s', 8, 2)->nullable()->change();
            $table->decimal('ac_current_input_t', 8, 2)->nullable()->change();
            $table->string('status_ac_current_input')->nullable()->change();

            $table->decimal('ac_current_output_r', 8, 2)->nullable()->change();
            $table->decimal('ac_current_output_s', 8, 2)->nullable()->change();
            $table->decimal('ac_current_output_t', 8, 2)->nullable()->change();
            $table->string('status_ac_current_output')->nullable()->change();

            $table->decimal('ups_temperature', 5, 2)->nullable()->change();
            $table->string('status_ups_temperature')->nullable()->change();

            $table->decimal('output_frequency', 5, 2)->nullable()->change();
            $table->string('status_output_frequency')->nullable()->change();

            $table->decimal('charging_voltage', 8, 2)->nullable()->change();
            $table->string('status_charging_voltage')->nullable()->change();

            $table->decimal('charging_current', 8, 2)->nullable()->change();
            $table->string('status_charging_current')->nullable()->change();

            $table->string('executor_1')->nullable()->change();
            $table->string('supervisor')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert if needed
    }
};
