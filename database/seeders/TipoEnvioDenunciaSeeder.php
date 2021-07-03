<?php

namespace Database\Seeders;

use App\Models\TipoEnvioDenuncia;
use Illuminate\Database\Seeder;

class TipoEnvioDenunciaSeeder extends Seeder
{
    /**
     *
     *
     * @return void
     */
    public function run()
    {
        TipoEnvioDenuncia::create([
            'nombre' => 'Envío Directo',
            'descripcion' => 'No pedira más información'
        ]);

        TipoEnvioDenuncia::create([
            'nombre' => 'Nota + Imagen opcionales',
            'descripcion' => 'Abre una ventana para agregar imagen y colocar una nota opcional'
        ]);

        TipoEnvioDenuncia::create([
            'nombre' => 'Multiples opciones',
            'descripcion' => 'Esto abrira una nueva pantalla para ver mas opciones'
        ]);

    }
}
