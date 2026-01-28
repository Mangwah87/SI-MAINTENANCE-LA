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
            if (!Schema::hasColumn('rectifier_maintenances', 'rectifier_module_installed')) {
                $table->string('rectifier_module_installed')->nullable()->after('status_battery_connection');
            }
            if (!Schema::hasColumn('rectifier_maintenances', 'status_rectifier_module_installed')) {
                $table->enum('status_rectifier_module_installed', ['OK', 'NOK'])->default('OK')->after('rectifier_module_installed');
            }

            if (!Schema::hasColumn('rectifier_maintenances', 'alarm_modul_rectifier')) {
                $table->string('alarm_modul_rectifier')->nullable()->after('status_rectifier_module_installed');
            }
            if (!Schema::hasColumn('rectifier_maintenances', 'status_alarm_modul_rectifier')) {
                $table->enum('status_alarm_modul_rectifier', ['OK', 'NOK'])->default('OK')->after('alarm_modul_rectifier');
            }

            // EXECUTOR - NEW FIELDS
            if (!Schema::hasColumn('rectifier_maintenances', 'executor_1_type')) {
                $table->enum('executor_1_type', ['Mitra', 'Internal'])->nullable()->after('executor_1_department');
            }
            if (!Schema::hasColumn('rectifier_maintenances', 'executor_2_type')) {
                $table->enum('executor_2_type', ['Mitra', 'Internal'])->nullable()->after('executor_2_department');
            }
            if (!Schema::hasColumn('rectifier_maintenances', 'executor_3_type')) {
                $table->enum('executor_3_type', ['Mitra', 'Internal'])->nullable()->after('executor_3_department');
            }

            // VERIFIKATOR
            if (!Schema::hasColumn('rectifier_maintenances', 'verifikator_name')) {
                $table->string('verifikator_name')->nullable()->after('supervisor_id_number');
            }
            if (!Schema::hasColumn('rectifier_maintenances', 'verifikator_id_number')) {
                $table->string('verifikator_id_number')->nullable()->after('verifikator_name');
            }

            // HEAD OF SUB DEPARTMENT
            if (!Schema::hasColumn('rectifier_maintenances', 'head_of_sub_dept_name')) {
                $table->string('head_of_sub_dept_name')->nullable()->after('verifikator_id_number');
            }
            if (!Schema::hasColumn('rectifier_maintenances', 'head_of_sub_dept_id')) {
                $table->string('head_of_sub_dept_id')->nullable()->after('head_of_sub_dept_name');
            }
        });
    }

    public function down()
    {
        Schema::table('rectifier_maintenances', function (Blueprint $table) {
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
        });
    }
};
