<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('instalasi_kabel_details', function (Blueprint $table) {
        $table->string('sub_category')->nullable()->after('category');
    });
}

public function down()
{
    Schema::table('instalasi_kabel_details', function (Blueprint $table) {
        $table->dropColumn('sub_category');
    });
}
};
