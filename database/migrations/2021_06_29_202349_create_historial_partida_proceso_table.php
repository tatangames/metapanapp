<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialPartidaProcesoTable extends Migration
{
    /**
     * Historial cuando ha sido cambiado un estado de la partida nacimiento
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_partida_proceso', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_soli_partida_naci')->unsigned();
            $table->bigInteger('id_usuario')->unsigned();
            $table->bigInteger('id_estado')->unsigned();
            $table->dateTime('fecha');

            $table->foreign('id_soli_partida_naci')->references('id')->on('solicitud_partida_nacimiento');
            $table->foreign('id_usuario')->references('id')->on('usuarios');
            $table->foreign('id_estado')->references('id')->on('estado_partida');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historial_partida_proceso');
    }
}
