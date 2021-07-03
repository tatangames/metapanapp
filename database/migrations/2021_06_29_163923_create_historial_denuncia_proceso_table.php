<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialDenunciaProcesoTable extends Migration
{
    /**
     * Historial cuando ha sido cambiado un estado de la denuncia
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_denuncia_proceso', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_denuncia_realizada')->unsigned();
            $table->bigInteger('id_usuario')->unsigned();
            $table->bigInteger('id_estado')->unsigned();
            $table->dateTime('fecha');

            $table->foreign('id_denuncia_realizada')->references('id')->on('denuncia_realizada');
            $table->foreign('id_usuario')->references('id')->on('usuarios');
            $table->foreign('id_estado')->references('id')->on('estado_denuncia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historial_denuncia_proceso');
    }
}
