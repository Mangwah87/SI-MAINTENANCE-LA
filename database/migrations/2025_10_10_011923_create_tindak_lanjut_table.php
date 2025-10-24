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
        Schema::create('tindak_lanjut', function (Blueprint $table) {
            $table->id();

            // User yang membuat form
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Informasi Pelaksanaan PM (sesuai dokumen)
            $table->date('tanggal');
            $table->time('jam');
            $table->string('lokasi');
            $table->string('ruang');

            // Konten Utama (sesuai dokumen)
            $table->text('permasalahan');
            $table->text('tindakan_penyelesaian');
            $table->text('hasil_perbaikan');

            // Informasi Pelaksana & Approval (sesuai dokumen)
            $table->json('pelaksana')->nullable(); // {nama, department, sub_department}
            $table->json('mengetahui')->nullable(); // {nama, nik}

            // Informasi Department
            $table->string('department');
            $table->string('sub_department')->nullable();

            // Berdasarkan 
            $table->boolean('permohonan_tindak_lanjut')->default(false);
            $table->boolean('pelaksanaan_pm')->default(false);

            // Hasil Perbaikan Detail 
            $table->boolean('selesai')->default(false);
            $table->date('selesai_tanggal')->nullable();
            $table->time('selesai_jam')->nullable();
            $table->boolean('tidak_selesai')->default(false);
            $table->text('tidak_lanjut')->nullable(); // Keterangan jika tidak selesai

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['tanggal', 'lokasi']);
            $table->index('selesai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tindak_lanjut');
    }
};