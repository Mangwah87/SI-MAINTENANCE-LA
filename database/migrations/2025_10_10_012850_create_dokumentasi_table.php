<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumentasi', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_dokumen');
            $table->string('lokasi');
            $table->dateTime('tanggal_dokumentasi');
            $table->string('perusahaan')->default('PT. Aplikanusa Lintasarta');
            $table->text('keterangan')->nullable();
            $table->string('pengawas')->nullable();
            // ]
            
            // ✅ Tambahan untuk data perangkat
            $table->json('pelaksana')->nullable();
            $table->json('perangkat_sentral')->nullable();
            $table->json('sarana_penunjang')->nullable();

            // Relasi user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();

            $table->index(['lokasi', 'tanggal_dokumentasi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumentasi');
    }
};
