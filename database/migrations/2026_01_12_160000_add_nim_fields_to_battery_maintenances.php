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
        Schema::table('battery_maintenances', function (Blueprint $table) {
            $table->string('verifikator_nim')->nullable()->after('verifikator_name');
            $table->string('head_of_sub_dept_nim')->nullable()->after('head_of_sub_dept');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('battery_maintenances', function (Blueprint $table) {
            $table->dropColumn(['verifikator_nim', 'head_of_sub_dept_nim']);
        });
    }
};
