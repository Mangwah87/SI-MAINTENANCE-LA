<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('battery_maintenances', function (Blueprint $table) {
            $table->string('supervisor')->nullable()->after('technician_3_company');
        });
    }

    public function down(): void
    {
        Schema::table('battery_maintenances', function (Blueprint $table) {
            $table->dropColumn('supervisor');
        });
    }
};
