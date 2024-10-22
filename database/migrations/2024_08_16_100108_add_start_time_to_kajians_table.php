<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartTimeToKajiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kajians', function (Blueprint $table) {
            $table->timestamp('start_time')->nullable()->after('image'); // Menambahkan kolom start_time setelah kolom image
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kajians', function (Blueprint $table) {
            $table->dropColumn('start_time'); // Menghapus kolom start_time
        });
    }
}
