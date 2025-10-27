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
            $table->string('supervisor_id_number')->nullable()->after('supervisor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ups_maintenances', function (Blueprint $table) {
            $table->dropColumn('supervisor_id_number');
        });
    }
};
