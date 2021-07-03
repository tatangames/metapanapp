<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDenunciaRealizadaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('denuncia_realizada', function (Blueprint $table) {
            $table->id();

            // cliente
            $table->bigInteger('id_cliente')->unsigned();

            // zona de la denuncia
            $table->bigInteger('id_zona')->unsigned();

            // estado de la denuncia
            $table->bigInteger('id_estado')->unsigned();

            // tipo denuncia
            $table->bigInteger('id_denuncia')->unsigned();

            // fecha de registro
            $table->dateTime('fecha');

            // gps
            $table->string('latitud', 100);
            $table->string('longitud', 100);

            // si utiliza imagen
            $table->string('imagen', 100)->nullable();
            // si utiliza descripcion
            $table->string('descripcion', 300)->nullable();

            // 0: no visible al cliente, 1: visible al cliente
            $table->boolean('visible_cliente');

            $table->foreign('id_cliente')->references('id')->on('clientes');
            $table->foreign('id_zona')->references('id')->on('zona');
            $table->foreign('id_estado')->references('id')->on('estado_denuncia');
            $table->foreign('id_denuncia')->references('id')->on('lista_denuncias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('denuncia_realizada');
    }
}
