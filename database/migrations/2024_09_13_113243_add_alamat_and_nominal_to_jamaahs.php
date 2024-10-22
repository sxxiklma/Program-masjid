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
    Schema::table('jamaahs', function (Blueprint $table) {
        $table->string('alamat')->after('nomor'); // Menambahkan kolom alamat
        $table->decimal('nominal', 15, 2)->after('alamat'); // Menambahkan kolom nominal
    });
}

public function down()
{
    Schema::table('jamaahs', function (Blueprint $table) {
        $table->dropColumn('alamat');
        $table->dropColumn('nominal');
    });
}

};
