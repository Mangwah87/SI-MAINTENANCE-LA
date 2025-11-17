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
            // Tambah kolom central_id
            $table->unsignedBigInteger('central_id')->nullable()->after('id');
            $table->foreign('central_id')->references('id')->on('central')->onDelete('set null');

            // Hapus kolom location
            $table->dropColumn('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance_ac', function (Blueprint $table) {
            $table->dropForeign(['central_id']);
            $table->dropColumn('central_id');

            // Restore kolom location
            $table->string('location')->after('id');
        });
    }
};
