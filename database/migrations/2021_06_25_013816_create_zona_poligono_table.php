<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZonaPoligonoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zona_poligono', function (Blueprint $table) {
            $table->id();
            $table->string('latitud', 100);
            $table->string('longitud', 100);
            $table->bigInteger('id_zona')->unsigned();

            $table->foreign('id_zona')->references('id')->on('zona');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zona_poligono');
    }
}
