<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('battery_maintenances', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('battery_temperature');
            $table->string('company')->nullable()->after('technician_name');
        });
    }

    public function down(): void
    {
        Schema::table('battery_maintenances', function (Blueprint $table) {
            $table->dropColumn(['notes', 'company']);
        });
    }
};
