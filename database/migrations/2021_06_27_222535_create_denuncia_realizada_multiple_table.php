<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDenunciaRealizadaMultipleTable extends Migration
{
    /**
     * guardara la opcion elegida de una denuncia multiple
     *
     * @return void
     */
    public function up()
    {
        Schema::create('denuncia_realizada_multiple', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_denuncia_realizada')->unsigned();
            $table->bigInteger('id_lista_denuncias_multiple')->unsigned();

            $table->foreign('id_denuncia_realizada')->references('id')->on('denuncia_realizada');
            $table->foreign('id_lista_denuncias_multiple')->references('id')->on('lista_denuncias_multiple');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('denuncia_realizada_multiple');
    }
}
