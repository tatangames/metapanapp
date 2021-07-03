<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListaDenunciasMultipleTable extends Migration
{
    /**
     * Aqui se registra las opciones extra de una denuncia
     * ejem: denuncia electrica se debe elegir si esta
     * cable cortado, foco quemado, agarro fuego el poste, etc.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_denuncias_multiple', function (Blueprint $table) {
            $table->id();

            // principal
            $table->bigInteger('id_lista_denuncias')->unsigned();

            // para saver como se enviara la denuncia
            // si directo, nota + imagen, o tiene multiple opciones
            $table->bigInteger('id_tipo_envio_denuncia')->unsigned();

            $table->dateTime('fecha');
            $table->string('nombre', 100);
            $table->string('descripcion', 100)->nullable();
            $table->string('imagen', 100);
            $table->integer('posicion');

            // unicamente tendra activo, que es igual a visible.
            $table->boolean('activo');

            $table->foreign('id_lista_denuncias')->references('id')->on('lista_denuncias');
            $table->foreign('id_tipo_envio_denuncia')->references('id')->on('tipo_envio_denuncia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lista_denuncias_multiple');
    }
}
