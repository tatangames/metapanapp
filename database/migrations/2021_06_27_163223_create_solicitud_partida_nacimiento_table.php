<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudPartidaNacimientoTable extends Migration
{
    /**
     * Solicitudes para partida de nacimiento
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_partida_nacimiento', function (Blueprint $table) {
            $table->id();

            // diferentes estados de la partida
            $table->bigInteger('id_estado_partida')->unsigned();

            // tipo normal o certificada
            $table->bigInteger('id_tipo_partida')->unsigned();

            // quien solicito
            $table->bigInteger('id_cliente')->unsigned();

            // cantidad de partidas a solicitar
            $table->integer('cantidad');

            // nombre de la persona que solicito esto.
            $table->string('solicito', 100);

            // nombre de la persona de la partida, es opcional porque se puede
            // ocupar el mismo nombre del solicitante
            $table->string('persona', 100)->nullable();

            // fecha y hora de la solicitud
            $table->dateTime('fecha');

            // fecha de nacimiento
            $table->string('fecha_nacimiento', 20)->nullable();

            // nombre del padre
            $table->string('nombre_padre', 100)->nullable();

            // nombre de la madre
            $table->string('nombre_madre', 100)->nullable();

            // 0: no visible al cliente  1: visible al cliente
            $table->boolean('visible_cliente');

            // una nota cuando la solicitud no ha sido encontrada

            // cancelamiento
            //1: por cliente
            //2: por revisador cuando el usuario nunca pago la partida

            $table->integer('cancelado');
            // fecha cancelado
            $table->dateTime('fecha_cancelado')->nullable();
            // una nota por que fue cancelado
            $table->string('nota_cancelada', 200)->nullable();

            $table->foreign('id_estado_partida')->references('id')->on('estado_partida');
            $table->foreign('id_cliente')->references('id')->on('clientes');
            $table->foreign('id_tipo_partida')->references('id')->on('tipo_partida');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitud_partida_nacimiento');
    }
}
