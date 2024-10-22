<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJeniskajianAndUstadzToKajiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kajians', function (Blueprint $table) {
            $table->unsignedBigInteger('jeniskajian_id')->after('start_time'); // Tambahkan setelah kolom start_time
            $table->unsignedBigInteger('ustadz_id')->after('jeniskajian_id'); // Tambahkan setelah kolom jeniskajian_id

            // Jika kolom ini adalah foreign key
            $table->foreign('jeniskajian_id')->references('id')->on('jeniskajians')->onDelete('cascade');
            $table->foreign('ustadz_id')->references('id')->on('ustadzs')->onDelete('cascade');
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
            $table->dropForeign(['jeniskajian_id']);
            $table->dropForeign(['ustadz_id']);
            $table->dropColumn('jeniskajian_id');
            $table->dropColumn('ustadz_id');
        });
    }
}
