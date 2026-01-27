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
        Schema::create('poles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('central_id')->nullable()->constrained('central')->onDelete('set null');
            $table->date('date');
            $table->time('time');
            $table->string('type_pole'); // SST/Pole/Tripole/Triangle/Triangle Wired

            // Physical Check - Section 1
            $table->string('foundation_condition')->nullable();
            $table->string('status_foundation_condition')->nullable();

            $table->string('pole_tower_foundation_flange')->nullable();
            $table->string('status_pole_tower_foundation_flange')->nullable();

            $table->string('pole_tower_support_flange')->nullable();
            $table->string('status_pole_tower_support_flange')->nullable();

            $table->string('flange_condition_connection')->nullable();
            $table->string('status_flange_condition_connection')->nullable();

            $table->string('pole_tower_condition')->nullable();
            $table->string('status_pole_tower_condition')->nullable();

            $table->string('arm_antenna_condition')->nullable();
            $table->string('status_arm_antenna_condition')->nullable();

            $table->string('availability_basbar_ground')->nullable();
            $table->string('status_availability_basbar_ground')->nullable();

            $table->string('bonding_bar')->nullable();
            $table->string('status_bonding_bar')->nullable();

            // Performance Measurement - Section 2
            $table->string('inclination_measurement')->nullable();

            // Data Personnel (4 Executors)
            $table->string('executor_1')->nullable();
            $table->string('mitra_internal_1')->nullable();
            $table->string('executor_2')->nullable();
            $table->string('mitra_internal_2')->nullable();
            $table->string('executor_3')->nullable();
            $table->string('mitra_internal_3')->nullable();
            $table->string('executor_4')->nullable();
            $table->string('mitra_internal_4')->nullable();

            // Verifikator dan Head of Sub Department
            $table->string('verifikator')->nullable();
            $table->string('verifikator_nik')->nullable();
            $table->string('head_of_sub_department')->nullable();
            $table->string('head_of_sub_department_nik')->nullable();

            // Notes
            $table->text('notes')->nullable();

            // JSON Column for checklist data
            $table->json('data_checklist')->nullable();

            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poles');
    }
};
