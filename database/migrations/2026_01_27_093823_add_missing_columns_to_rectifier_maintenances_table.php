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
        Schema::table('rectifier_maintenances', function (Blueprint $table) {
            // Add missing battery_temperature columns (should be after dc_current_output)
            if (!Schema::hasColumn('rectifier_maintenances', 'battery_temperature')) {
                $table->decimal('battery_temperature', 8, 2)->nullable()->after('dc_current_output');
            }
            if (!Schema::hasColumn('rectifier_maintenances', 'status_battery_temperature')) {
                $table->enum('status_battery_temperature', ['OK', 'NOK'])->default('OK')->after('battery_temperature');
            }

            // Add missing charging_voltage_dc columns (should be after battery_temperature)
            if (!Schema::hasColumn('rectifier_maintenances', 'charging_voltage_dc')) {
                $table->decimal('charging_voltage_dc', 8, 2)->nullable()->after('status_battery_temperature');
            }
            if (!Schema::hasColumn('rectifier_maintenances', 'status_charging_voltage_dc')) {
                $table->enum('status_charging_voltage_dc', ['OK', 'NOK'])->default('OK')->after('charging_voltage_dc');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rectifier_maintenances', function (Blueprint $table) {
            $table->dropColumn([
                'battery_temperature',
                'status_battery_temperature',
                'charging_voltage_dc',
                'status_charging_voltage_dc'
            ]);
        });
    }
};
