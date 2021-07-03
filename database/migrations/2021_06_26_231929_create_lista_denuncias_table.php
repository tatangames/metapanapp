<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListaDenunciasTable extends Migration
{
    /**
     * Todas las denuncias que existiran.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_denuncias', function (Blueprint $table) {
            $table->id();
            // para saver como se enviara la denuncia
            // si directo, nota + imagen, o tiene multiple opciones
            // si es multiple opcion se registra en otra tabla sus opciones a tener
            $table->bigInteger('id_tipo_envio_denuncia')->unsigned();

            // colocarle un departamento a donde pertenece esta denuncia
            $table->bigInteger('id_departamento_denuncia')->unsigned();

            $table->string('nombre', 100);
            $table->string('descripcion', 100)->nullable();

            // imagen para la denuncia
            $table->string('imagen', 100);

            // si hay un problema saldra una alerta con un mensaje no disponibilidad
            $table->boolean('activo');

            // es para mostrar o no al usuario esta opcion
            $table->boolean('visible');

            // fecha de ingreso
            $table->date('fecha');

            // posicion de la denuncia
            $table->integer('posicion');

            $table->foreign('id_tipo_envio_denuncia')->references('id')->on('tipo_envio_denuncia');
            $table->foreign('id_departamento_denuncia')->references('id')->on('departamento_denuncia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lista_denuncias');
    }
}
