<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Buat kolom baru untuk menampung ID
        Schema::table('battery_maintenances', function (Blueprint $table) {
            $table->unsignedBigInteger('central_id')->nullable()->after('location');
        });

        Schema::table('rectifier_maintenances', function (Blueprint $table) {
            $table->unsignedBigInteger('central_id')->nullable()->after('location');
        });

        Schema::table('genset_maintenances', function (Blueprint $table) {
            $table->unsignedBigInteger('central_id')->nullable()->after('location');
        });

        // 2. Migrasi data dari location (string) ke central_id (integer)
        // Battery
        DB::table('battery_maintenances')->get()->each(function ($record) {
            // Cari ID dari tabel central berdasarkan id_sentral atau nama
            $central = DB::table('central')
                ->where('id_sentral', $record->location)
                ->orWhere('nama', 'like', '%' . $record->location . '%')
                ->first();

            if ($central) {
                DB::table('battery_maintenances')
                    ->where('id', $record->id)
                    ->update(['central_id' => $central->id]);
            }
        });

        // Rectifier
        DB::table('rectifier_maintenances')->get()->each(function ($record) {
            $central = DB::table('central')
                ->where('id_sentral', $record->location)
                ->orWhere('nama', 'like', '%' . $record->location . '%')
                ->first();

            if ($central) {
                DB::table('rectifier_maintenances')
                    ->where('id', $record->id)
                    ->update(['central_id' => $central->id]);
            }
        });

        // Genset
        DB::table('genset_maintenances')->get()->each(function ($record) {
            $central = DB::table('central')
                ->where('id_sentral', $record->location)
                ->orWhere('nama', 'like', '%' . $record->location . '%')
                ->first();

            if ($central) {
                DB::table('genset_maintenances')
                    ->where('id', $record->id)
                    ->update(['central_id' => $central->id]);
            }
        });

        // 3. Hapus kolom location lama dan rename central_id menjadi location
        Schema::table('battery_maintenances', function (Blueprint $table) {
            $table->dropColumn('location');
        });
        Schema::table('battery_maintenances', function (Blueprint $table) {
            $table->renameColumn('central_id', 'location');
        });

        Schema::table('rectifier_maintenances', function (Blueprint $table) {
            $table->dropColumn('location');
        });
        Schema::table('rectifier_maintenances', function (Blueprint $table) {
            $table->renameColumn('central_id', 'location');
        });

        Schema::table('genset_maintenances', function (Blueprint $table) {
            $table->dropColumn('location');
        });
        Schema::table('genset_maintenances', function (Blueprint $table) {
            $table->renameColumn('central_id', 'location');
        });

        // 4. Tambahkan foreign key
        Schema::table('battery_maintenances', function (Blueprint $table) {
            $table->foreign('location')->references('id')->on('central')->onDelete('cascade');
        });

        Schema::table('rectifier_maintenances', function (Blueprint $table) {
            $table->foreign('location')->references('id')->on('central')->onDelete('cascade');
        });

        Schema::table('genset_maintenances', function (Blueprint $table) {
            $table->foreign('location')->references('id')->on('central')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys
        Schema::table('battery_maintenances', function (Blueprint $table) {
            $table->dropForeign(['location']);
        });
        Schema::table('rectifier_maintenances', function (Blueprint $table) {
            $table->dropForeign(['location']);
        });
        Schema::table('genset_maintenances', function (Blueprint $table) {
            $table->dropForeign(['location']);
        });

        // Kembalikan ke string
        Schema::table('battery_maintenances', function (Blueprint $table) {
            $table->string('location', 255)->change();
        });
        Schema::table('rectifier_maintenances', function (Blueprint $table) {
            $table->string('location', 255)->change();
        });
        Schema::table('genset_maintenances', function (Blueprint $table) {
            $table->string('location', 255)->change();
        });
    }
};
