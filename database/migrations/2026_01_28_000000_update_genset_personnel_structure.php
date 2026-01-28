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
        Schema::table('genset_maintenances', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn([
                'technician_1_name',
                'technician_1_department',
                'technician_2_name',
                'technician_2_department',
                'technician_3_name',
                'technician_3_department',
                'approver_name',
                'approver_department',
                'approver_nik'
            ]);
        });

        Schema::table('genset_maintenances', function (Blueprint $table) {
            // Add new executor columns (4 executors like AC form)
            $table->string('executor_1')->nullable();
            $table->string('mitra_internal_1')->nullable();
            $table->string('executor_2')->nullable();
            $table->string('mitra_internal_2')->nullable();
            $table->string('executor_3')->nullable();
            $table->string('mitra_internal_3')->nullable();
            $table->string('executor_4')->nullable();
            $table->string('mitra_internal_4')->nullable();

            // Add verifikator columns
            $table->string('verifikator')->nullable();
            $table->string('verifikator_nik')->nullable();

            // Add head of sub department columns
            $table->string('head_of_sub_department')->nullable();
            $table->string('head_of_sub_department_nik')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('genset_maintenances', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn([
                'executor_1',
                'mitra_internal_1',
                'executor_2',
                'mitra_internal_2',
                'executor_3',
                'mitra_internal_3',
                'executor_4',
                'mitra_internal_4',
                'verifikator',
                'verifikator_nik',
                'head_of_sub_department',
                'head_of_sub_department_nik'
            ]);
        });

        Schema::table('genset_maintenances', function (Blueprint $table) {
            // Restore old columns
            $table->string('technician_1_name');
            $table->string('technician_1_department')->nullable();
            $table->string('technician_2_name')->nullable();
            $table->string('technician_2_department')->nullable();
            $table->string('technician_3_name')->nullable();
            $table->string('technician_3_department')->nullable();
            $table->string('approver_name')->nullable();
            $table->string('approver_department')->nullable();
            $table->string('approver_nik')->nullable();
        });
    }
};
