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
        Schema::create('inventory_devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('central_id')->nullable();
            $table->string('location')->nullable();
            $table->date('date');
            $table->time('time');

            // Device Sentral (JSON array)
            $table->json('device_sentral')->nullable(); // [{equipment, qty, status_active, status_shutdown, bonding_connect, bonding_not_connect, keterangan}]

            // Supporting Facilities (JSON array)
            $table->json('supporting_facilities')->nullable(); // [{equipment, qty, status_active, status_shutdown, bonding_connect, bonding_not_connect, keterangan}]

            $table->text('notes')->nullable();

            // Executors
            $table->string('executor_1')->nullable();
            $table->string('mitra_internal_1')->nullable();
            $table->string('executor_2')->nullable();
            $table->string('mitra_internal_2')->nullable();
            $table->string('executor_3')->nullable();
            $table->string('mitra_internal_3')->nullable();
            $table->string('executor_4')->nullable();
            $table->string('mitra_internal_4')->nullable();

            // Verifikator & Head of Sub Department
            $table->string('verifikator')->nullable();
            $table->string('verifikator_nik')->nullable();
            $table->string('head_of_sub_department')->nullable();
            $table->string('head_of_sub_department_nik')->nullable();

            // Images
            $table->json('images')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_devices');
    }
};
