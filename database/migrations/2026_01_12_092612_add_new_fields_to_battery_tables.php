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
        // Update battery_maintenances table
        Schema::table('battery_maintenances', function (Blueprint $table) {
            // Technician 4
            $table->string('technician_4_name')->nullable()->after('technician_3_company');
            $table->string('technician_4_company')->nullable()->after('technician_4_name');

            // Verifikator & Head of Sub Department
            $table->string('verifikator_name')->nullable()->after('technician_4_company');
            $table->string('verifikator_company')->nullable()->after('verifikator_name');
            $table->string('head_of_sub_dept')->nullable()->after('verifikator_company');

            // Rectifier Test Fields
            $table->decimal('rectifier_test_backup_voltage', 8, 2)->nullable()->after('head_of_sub_dept');
            $table->decimal('rectifier_test_measurement_1', 8, 2)->nullable()->after('rectifier_test_backup_voltage');
            $table->decimal('rectifier_test_measurement_2', 8, 2)->nullable()->after('rectifier_test_measurement_1');
            $table->string('rectifier_test_status')->nullable()->after('rectifier_test_measurement_2'); // OK/NOK
        });

        // Update battery_readings table
        Schema::table('battery_readings', function (Blueprint $table) {
            // Battery Type & End Device Battery
            $table->string('battery_type')->nullable()->after('battery_brand');
            $table->string('end_device_batt')->nullable()->after('battery_type');

            // SOH (State of Health)
            $table->decimal('soh', 5, 2)->nullable()->after('voltage')->comment('State of Health in percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('battery_maintenances', function (Blueprint $table) {
            $table->dropColumn([
                'technician_4_name',
                'technician_4_company',
                'verifikator_name',
                'verifikator_company',
                'head_of_sub_dept',
                'rectifier_test_backup_voltage',
                'rectifier_test_measurement_1',
                'rectifier_test_measurement_2',
                'rectifier_test_status'
            ]);
        });

        Schema::table('battery_readings', function (Blueprint $table) {
            $table->dropColumn([
                'battery_type',
                'end_device_batt',
                'soh'
            ]);
        });
    }
};
