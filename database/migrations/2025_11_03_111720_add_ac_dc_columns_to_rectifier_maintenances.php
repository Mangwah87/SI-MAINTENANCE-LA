<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rectifier_maintenances', function (Blueprint $table) {
            // Cek dan tambah kolom ac_current_input
            if (!Schema::hasColumn('rectifier_maintenances', 'ac_current_input')) {
                $table->decimal('ac_current_input', 8, 2)->nullable()->after('status_ac_input_voltage');
            }

            // Cek dan tambah kolom dc_current_output
            if (!Schema::hasColumn('rectifier_maintenances', 'dc_current_output')) {
                $table->decimal('dc_current_output', 8, 2)->nullable()->after('status_ac_current_input');
            }
        });

        // Hapus kolom lama jika ada
        Schema::table('rectifier_maintenances', function (Blueprint $table) {
            $columnsToRemove = [];

            if (Schema::hasColumn('rectifier_maintenances', 'ac_current_input_single')) {
                $columnsToRemove[] = 'ac_current_input_single';
            }
            if (Schema::hasColumn('rectifier_maintenances', 'ac_current_input_dual')) {
                $columnsToRemove[] = 'ac_current_input_dual';
            }
            if (Schema::hasColumn('rectifier_maintenances', 'ac_current_input_three')) {
                $columnsToRemove[] = 'ac_current_input_three';
            }
            if (Schema::hasColumn('rectifier_maintenances', 'dc_current_output_single')) {
                $columnsToRemove[] = 'dc_current_output_single';
            }
            if (Schema::hasColumn('rectifier_maintenances', 'dc_current_output_dual')) {
                $columnsToRemove[] = 'dc_current_output_dual';
            }
            if (Schema::hasColumn('rectifier_maintenances', 'dc_current_output_three')) {
                $columnsToRemove[] = 'dc_current_output_three';
            }

            if (!empty($columnsToRemove)) {
                $table->dropColumn($columnsToRemove);
            }
        });
    }

    public function down(): void
    {
        Schema::table('rectifier_maintenances', function (Blueprint $table) {
            $table->dropColumn(['ac_current_input', 'dc_current_output']);

            $table->decimal('ac_current_input_single', 8, 2)->nullable();
            $table->decimal('ac_current_input_dual', 8, 2)->nullable();
            $table->decimal('ac_current_input_three', 8, 2)->nullable();
            $table->decimal('dc_current_output_single', 8, 2)->nullable();
            $table->decimal('dc_current_output_dual', 8, 2)->nullable();
            $table->decimal('dc_current_output_three', 8, 2)->nullable();
        });
    }
};
