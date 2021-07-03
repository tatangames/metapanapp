<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * clientes que utilizaran la app
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();

            // se registra codigo area + telefono
            $table->string('telefono', 15)->unique();

            // se guarda el codigo generado que se envia por sms
            $table->string('codigo', 10);

            // fecha registro
            $table->dateTime('fecha');

            // para bloquear un usuario o no
            $table->boolean('activo');

            // acceso dado por administrador
            // si es true para este usuario
            // el cliente podra colocar cualquier codigo de acceso
            // e ingresara al sistema, validando siempre numero colocado.
            $table->boolean('acceso');

            // contandor de intentos cuando inicia sesion
            // cuanta los envios sms.
            $table->integer('contador');

            // nombre de la cuenta opcional
            //$table->string('nombre', 50)->nullable();

            // token de one signal para notificaciones
            $table->string('token_signal', 50)->nullable();

            // imagen opcional del usuario
            //$table->string('imagen', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
