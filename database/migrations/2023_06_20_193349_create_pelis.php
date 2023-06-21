<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelis', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->string('director', 255);
            $table->integer('anyo')->default(0);
            $table->boolean('descatalogada')->default(false);

            // marca de tiempo: created_at y updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pelis');
    }
}
