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
        Schema::table('rectifier_maintenances', function (Blueprint $table) {
            // Add user_id column after id
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');

            // Add index for better performance
            $table->index(['user_id', 'date_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rectifier_maintenances', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id', 'date_time']);
            $table->dropColumn('user_id');
        });
    }
};
