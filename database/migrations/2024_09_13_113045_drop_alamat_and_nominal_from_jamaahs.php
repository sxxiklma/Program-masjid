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
        $table->dropColumn('alamat');
        $table->dropColumn('nominal');
    });
}

public function down()
{
    Schema::table('jamaahs', function (Blueprint $table) {
        $table->string('alamat')->nullable();
        $table->decimal('nominal', 15, 2)->nullable();
    });
}

};
