<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rectifier_maintenances', function (Blueprint $table) {
            // PHYSICAL CHECK - NEW FIELDS
            $table->string('rectifier_module_installed')->nullable()->after('status_battery_connection');
            $table->enum('status_rectifier_module_installed', ['OK', 'NOK'])->default('OK')->after('rectifier_module_installed');

            $table->string('alarm_modul_rectifier')->nullable()->after('status_rectifier_module_installed');
            $table->enum('status_alarm_modul_rectifier', ['OK', 'NOK'])->default('OK')->after('alarm_modul_rectifier');

            // PERFORMANCE - REMOVE THESE FIELDS (drop columns)
            // battery_temperature, status_battery_temperature
            // charging_voltage_dc, status_charging_voltage_dc
            $table->dropColumn([
                'battery_temperature',
                'status_battery_temperature',
                'charging_voltage_dc',
                'status_charging_voltage_dc'
            ]);

            // EXECUTOR - NEW FIELDS
            $table->enum('executor_1_type', ['Mitra', 'Internal'])->nullable()->after('executor_1_department');
            $table->enum('executor_2_type', ['Mitra', 'Internal'])->nullable()->after('executor_2_department');
            $table->enum('executor_3_type', ['Mitra', 'Internal'])->nullable()->after('executor_3_department');

            // VERIFIKATOR
            $table->string('verifikator_name')->nullable()->after('supervisor_id_number');
            $table->string('verifikator_id_number')->nullable()->after('verifikator_name');

            // HEAD OF SUB DEPARTMENT
            $table->string('head_of_sub_dept_name')->nullable()->after('verifikator_id_number');
            $table->string('head_of_sub_dept_id')->nullable()->after('head_of_sub_dept_name');
        });
    }

    public function down()
    {
        Schema::table('rectifier_maintenances', function (Blueprint $table) {
            // Remove new fields
            $table->dropColumn([
                'rectifier_module_installed',
                'status_rectifier_module_installed',
                'alarm_modul_rectifier',
                'status_alarm_modul_rectifier',
                'executor_1_type',
                'executor_2_type',
                'executor_3_type',
                'verifikator_name',
                'verifikator_id_number',
                'head_of_sub_dept_name',
                'head_of_sub_dept_id'
            ]);

            // Restore removed fields
            $table->decimal('battery_temperature', 5, 2)->nullable();
            $table->enum('status_battery_temperature', ['OK', 'NOK'])->default('OK');
            $table->decimal('charging_voltage_dc', 5, 2)->nullable();
            $table->enum('status_charging_voltage_dc', ['OK', 'NOK'])->default('OK');
        });
    }
};
