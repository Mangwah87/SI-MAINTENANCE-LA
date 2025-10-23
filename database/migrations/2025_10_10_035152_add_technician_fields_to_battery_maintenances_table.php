<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('battery_maintenances', function (Blueprint $table) {
            // Tambahkan kolom company dan notes jika belum ada
            if (!Schema::hasColumn('battery_maintenances', 'company')) {
                $table->string('company')->default('PT. Aplikarusa Lintasarta')->after('battery_temperature');
            }

            if (!Schema::hasColumn('battery_maintenances', 'notes')) {
                $table->text('notes')->nullable()->after('company');
            }

            // Tambahkan kolom pelaksana baru
            if (!Schema::hasColumn('battery_maintenances', 'technician_1_name')) {
                $table->string('technician_1_name')->after('technician_name');
            }

            if (!Schema::hasColumn('battery_maintenances', 'technician_1_company')) {
                $table->string('technician_1_company')->after('technician_1_name');
            }

            if (!Schema::hasColumn('battery_maintenances', 'technician_2_name')) {
                $table->string('technician_2_name')->nullable()->after('technician_1_company');
            }

            if (!Schema::hasColumn('battery_maintenances', 'technician_2_company')) {
                $table->string('technician_2_company')->nullable()->after('technician_2_name');
            }

            if (!Schema::hasColumn('battery_maintenances', 'technician_3_name')) {
                $table->string('technician_3_name')->nullable()->after('technician_2_company');
            }

            if (!Schema::hasColumn('battery_maintenances', 'technician_3_company')) {
                $table->string('technician_3_company')->nullable()->after('technician_3_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('battery_maintenances', function (Blueprint $table) {
            $table->dropColumn([
                'company',
                'notes',
                'technician_1_name',
                'technician_1_company',
                'technician_2_name',
                'technician_2_company',
                'technician_3_name',
                'technician_3_company'
            ]);
        });
    }
};
