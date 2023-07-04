<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TablePelisAddImageField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pelis', function(Blueprint $table) {
            // Crea el campo imagen en la tabla pelis
            $table->string('imagen', 255)
                    ->after('anyo')
                    ->nullable();
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
            // Elimina el campo imagen en la tabla pelis
            $table->dropColumn('imagen');
        });
    }
}
