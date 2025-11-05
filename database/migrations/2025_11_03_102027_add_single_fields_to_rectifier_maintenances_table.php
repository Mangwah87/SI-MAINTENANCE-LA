<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rectifier_maintenances', function (Blueprint $table) {
            // Cek dulu apakah kolom sudah ada
            if (!Schema::hasColumn('rectifier_maintenances', 'ac_current_input')) {
                $table->decimal('ac_current_input', 8, 2)->nullable()->after('status_ac_input_voltage');
            }

            if (!Schema::hasColumn('rectifier_maintenances', 'dc_current_output')) {
                $table->decimal('dc_current_output', 8, 2)->nullable()->after('status_ac_current_input');
            }
        });
    }

    public function down()
    {
        Schema::table('rectifier_maintenances', function (Blueprint $table) {
            $table->dropColumn(['ac_current_input', 'dc_current_output']);
        });
    }
};
