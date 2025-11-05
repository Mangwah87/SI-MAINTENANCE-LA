<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rectifier_maintenances', function (Blueprint $table) {
            // Hapus kolom lama yang terpisah per power module
            if (Schema::hasColumn('rectifier_maintenances', 'ac_current_input_single')) {
                $table->dropColumn([
                    'ac_current_input_single',
                    'ac_current_input_dual',
                    'ac_current_input_three'
                ]);
            }

            if (Schema::hasColumn('rectifier_maintenances', 'dc_current_output_single')) {
                $table->dropColumn([
                    'dc_current_output_single',
                    'dc_current_output_dual',
                    'dc_current_output_three'
                ]);
            }

            // Tambah kolom baru yang universal
            if (!Schema::hasColumn('rectifier_maintenances', 'ac_current_input')) {
                $table->decimal('ac_current_input', 8, 2)->nullable()->after('status_ac_input_voltage');
            }

            if (!Schema::hasColumn('rectifier_maintenances', 'dc_current_output')) {
                $table->decimal('dc_current_output', 8, 2)->nullable()->after('status_ac_current_input');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rectifier_maintenances', function (Blueprint $table) {
            // Kembalikan ke kolom terpisah
            $table->decimal('ac_current_input_single', 8, 2)->nullable();
            $table->decimal('ac_current_input_dual', 8, 2)->nullable();
            $table->decimal('ac_current_input_three', 8, 2)->nullable();

            $table->decimal('dc_current_output_single', 8, 2)->nullable();
            $table->decimal('dc_current_output_dual', 8, 2)->nullable();
            $table->decimal('dc_current_output_three', 8, 2)->nullable();

            // Hapus kolom universal
            $table->dropColumn(['ac_current_input', 'dc_current_output']);
        });
    }
};
