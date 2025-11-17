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
        // Update UPS 1 Phase table
        Schema::table('ups_maintenances1', function (Blueprint $table) {
            $table->unsignedBigInteger('central_id')->nullable()->after('id');
            $table->foreign('central_id')->references('id')->on('central')->onDelete('set null');
            $table->dropColumn('location');
        });

        // Update UPS 3 Phase table
        Schema::table('ups_maintenances', function (Blueprint $table) {
            $table->unsignedBigInteger('central_id')->nullable()->after('id');
            $table->foreign('central_id')->references('id')->on('central')->onDelete('set null');
            $table->dropColumn('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore UPS 1 Phase table
        Schema::table('ups_maintenances1', function (Blueprint $table) {
            $table->dropForeign(['central_id']);
            $table->dropColumn('central_id');
            $table->string('location')->after('id');
        });

        // Restore UPS 3 Phase table
        Schema::table('ups_maintenances', function (Blueprint $table) {
            $table->dropForeign(['central_id']);
            $table->dropColumn('central_id');
            $table->string('location')->after('id');
        });
    }
};
