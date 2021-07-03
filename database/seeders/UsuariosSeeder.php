<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    /**
     * Crear 1 usuario administrador con su rol
     *
     * @return void
     */
    public function run()
    {
        Usuario::create([
            'nombre' => 'Jonathan Moran',
            'cargo' => 'Administrador',
            'usuario' => 'tatan',
            'password' => bcrypt('admin'),
            'activo' => '1'
        ])->assignRole('Super-Admin');

        Usuario::create([
            'nombre' => 'Pepe',
            'cargo' => 'Informacion',
            'usuario' => 'info',
            'password' => bcrypt('admin'),
            'activo' => '1'
        ])->assignRole('Admin-Informativo');

        Usuario::create([
            'nombre' => 'Juan',
            'cargo' => 'Revisador Denuncias',
            'usuario' => 'denuncia',
            'password' => bcrypt('admin'),
            'activo' => '1'
        ])->assignRole('Admin-Electrico');

        Usuario::create([
            'nombre' => 'Felipe',
            'cargo' => 'Revisador Partida',
            'usuario' => 'partida',
            'password' => bcrypt('admin'),
            'activo' => '1'
        ])->assignRole('Admin-Partidas');


    }
}
