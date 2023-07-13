<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToPelisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pelis', function (Blueprint $table) {
            // campo para relacionar con la tabla users
            $table->unsignedBigInteger('user_id')->nullable()->after('imagen');

            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pelis', function (Blueprint $table) {
            $table->dropForeign('pelis_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
}
