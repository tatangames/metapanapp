<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadoDenunciaTable extends Migration
{
    /**
     * 3 diferentes estados para denuncias
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estado_denuncia', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_api', 50);
            $table->string('nombre_web', 50);
            $table->string('descripcion', 150)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estado_denuncia');
    }
}
