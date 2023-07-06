<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TablePelisAddFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pelis', function(Blueprint $table) {
            $table->string('isan', 7)->unique()->after('descatalogada')->nullable();
            $table->string('color', 7)->after('isan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pelis', function(Blueprint $table) {
            $table->dropColumn('isan');
            $table->dropColumn('color');
        });
    }
}
