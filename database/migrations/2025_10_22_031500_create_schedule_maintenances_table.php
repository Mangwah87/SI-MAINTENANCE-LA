<?php
// 2025_10_22_031500_create_schedule_maintenances_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_maintenances', function (Blueprint $table) {
            $table->id();

            $table->string('doc_number')->unique()->nullable();
            
            // KOREKSI: Hanya $table dan tanpa ->after()
            $table->date('tanggal_pembuatan')->nullable(); 

            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->string('dibuat_oleh'); 
            $table->string('mengetahui')->nullable(); 

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        // KOREKSI: Hanya dropIfExists
        Schema::dropIfExists('schedule_maintenances');
    }
};