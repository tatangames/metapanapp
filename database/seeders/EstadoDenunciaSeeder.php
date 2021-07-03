<?php

namespace Database\Seeders;

use App\Models\EstadoDenuncia;
use Illuminate\Database\Seeder;

class EstadoDenunciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EstadoDenuncia::create([
            'nombre_api' => 'Pendiente',
            'nombre_web' => 'Pendiente',
            'descripcion' => 'Nueva denuncia, necesita ser revisada',
        ]);

        EstadoDenuncia::create([
            'nombre_api' => 'En Proceso',
            'nombre_web' => 'En Proceso',
            'descripcion' => 'La denuncia esta en revisión',
        ]);

        EstadoDenuncia::create([
            'nombre_api' => 'Resuelto',
            'nombre_web' => 'Resuelto',
            'descripcion' => 'La denuncia ha sido resuelta',
        ]);
    }
}
