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
        Schema::table('maintenance_ac', function (Blueprint $table) {
            $table->string('brand_type')->nullable()->change();
            $table->string('capacity')->nullable()->change();

            $table->string('environment_condition')->nullable()->change();
            $table->string('status_environment_condition')->nullable()->change();

            $table->string('filter')->nullable()->change();
            $table->string('status_filter')->nullable()->change();

            $table->string('evaporator')->nullable()->change();
            $table->string('status_evaporator')->nullable()->change();

            $table->string('led_display')->nullable()->change();
            $table->string('status_led_display')->nullable()->change();

            $table->string('air_flow')->nullable()->change();
            $table->string('status_air_flow')->nullable()->change();

            $table->decimal('temp_shelter', 5, 2)->nullable()->change();
            $table->string('status_temp_shelter')->nullable()->change();

            $table->decimal('temp_outdoor_cabinet', 5, 2)->nullable()->change();
            $table->string('status_temp_outdoor_cabinet')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert if needed
    }
};
