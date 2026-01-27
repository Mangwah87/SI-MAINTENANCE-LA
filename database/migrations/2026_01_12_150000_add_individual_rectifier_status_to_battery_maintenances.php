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
        Schema::table('battery_maintenances', function (Blueprint $table) {
            // Add individual status fields for each rectifier test measurement
            $table->string('rectifier_test_backup_voltage_status')->nullable()->after('rectifier_test_backup_voltage');
            $table->string('rectifier_test_measurement_1_status')->nullable()->after('rectifier_test_measurement_1');
            $table->string('rectifier_test_measurement_2_status')->nullable()->after('rectifier_test_measurement_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('battery_maintenances', function (Blueprint $table) {
            $table->dropColumn([
                'rectifier_test_backup_voltage_status',
                'rectifier_test_measurement_1_status',
                'rectifier_test_measurement_2_status',
            ]);
        });
    }
};
