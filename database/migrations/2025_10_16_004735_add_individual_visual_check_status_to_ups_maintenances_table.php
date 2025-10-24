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
        Schema::table('ups_maintenances', function (Blueprint $table) {
            // Add individual status fields for visual check items
            $table->string('status_env_condition')->default('OK')->after('env_condition');
            $table->string('status_led_display')->default('OK')->after('led_display');
            $table->string('status_battery_connection')->default('OK')->after('battery_connection');

            // Remove the general visual check status field
            $table->dropColumn('status_visual_check');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ups_maintenances', function (Blueprint $table) {
            // Remove individual status fields
            $table->dropColumn([
                'status_env_condition',
                'status_led_display',
                'status_battery_connection'
            ]);

            // Restore the general visual check status field
            $table->string('status_visual_check')->default('OK')->after('battery_connection');
        });
    }
};
