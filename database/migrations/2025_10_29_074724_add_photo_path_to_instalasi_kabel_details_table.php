<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/..._add_photo_path_to_instalasi_kabel_details_table.php

public function up()
{
    Schema::table('instalasi_kabel_details', function (Blueprint $table) {
        // Tambahkan kolom photo_path (varchar, nullable)
        $table->string('photo_path')->nullable()->after('status'); 
    });
}

public function down()
{
    Schema::table('instalasi_kabel_details', function (Blueprint $table) {
        $table->dropColumn('photo_path');
    });
}
};
