<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartidaRegistroPagoTable extends Migration
{
    /**
     * Registrar y vincularlo al registro general de un pago
     * Esto es para partida de nacimiento
     * Esto tambien se hace si se necesita pagar por otro documento,
     * se debera generar otra tabla para llevar registros aparte
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partida_registro_pago', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_registro_pago')->unsigned();
            $table->bigInteger('id_cliente')->unsigned();
            $table->bigInteger('id_solicitud_partida_nacimiento')->unsigned();

            $table->foreign('id_registro_pago')->references('id')->on('registro_pago');
            $table->foreign('id_cliente')->references('id')->on('clientes');
            $table->foreign('id_solicitud_partida_nacimiento')->references('id')->on('solicitud_partida_nacimiento');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partida_registro_pago');
    }
}
