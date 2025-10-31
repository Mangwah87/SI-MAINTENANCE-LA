<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pm_permohonan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama');
            $table->date('tanggal');
            $table->time('jam');
            $table->string('lokasi');
            $table->string('ruang');
            $table->text('permasalahan');
            $table->text('usulan_tindak_lanjut');
            $table->string('department');
            $table->string('sub_department')->nullable();
            $table->string('ditujukan_department')->default('Operations & Maintenance Support');
            $table->string('ditujukan_sub_department')->nullable();
            $table->enum('diinformasikan_melalui', ['email', 'fax', 'hardcopy'])->default('email');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_up_requests');
    }
};