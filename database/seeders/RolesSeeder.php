<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // --- CREAR ROLES ---

        // administrador con todos los permisos
        $role1 = Role::create(['name' => 'Super-Admin']);

        // usuario de informacion
        $role2 = Role::create(['name' => 'Admin-Informativo']);

        // usuario para departamento electrico
        $role3 = Role::create(['name' => 'Admin-Electrico']);

        // usuario para repondar partidas
        $role4 = Role::create(['name' => 'Admin-Partidas']);

        // --- CREAR PERMISOS ---

        // Vista de Ingreso
        Permission::create(['name' => 'rol.registros.clientes', 'description' => 'Cuando inicia el sistema, se redirigirá la vista al grupo Registros, vista Clientes'])->syncRoles($role1);
        Permission::create(['name' => 'rol.informativo.nuevas-solicitudes', 'description' => 'Cuando inicia el sistema, se redirigirá la vista al grupo Solicitudes (informativo), vista nuevas solicitudes'])->syncRoles($role2);
        Permission::create(['name' => 'rol.denuncia.nuevas-solicitudes', 'description' => 'Cuando inicia el sistema, se redirigirá la vista al grupo Solicitudes (denuncia), vista nuevas solicitudes'])->syncRoles($role3);
        Permission::create(['name' => 'rol.partida.nuevas-solicitudes', 'description' => 'Cuando inicia el sistema, se redirigirá la vista al grupo Solicitudes (partida), vista nuevas solicitudes'])->syncRoles($role4);


        // Lista de permisos
        Permission::create(['name' => 'grupo.admin.roles-y-permisos', 'description' => 'Contenedor para el grupo llamado: Roles y Permisos'])->syncRoles($role1);

        Permission::create(['name' => 'grupo.admin.registros', 'description' => 'Contenedor para el grupo llamado: Registros'])->syncRoles($role1);
        Permission::create(['name' => 'vista.grupo.admin.registros.clientes', 'description' => 'Vista index para grupo Registros - vista clientes'])->syncRoles($role1);

        Permission::create(['name' => 'grupo.admin.estados', 'description' => 'Contenedor para el grupo llamado: Estados'])->syncRoles($role1);
        Permission::create(['name' => 'vista.grupo.admin.estados.estado-partida', 'description' => 'Vista index para grupo Estados - vista estado partida'])->syncRoles($role1);
        Permission::create(['name' => 'vista.grupo.admin.estados.estado-denuncia', 'description' => 'Vista index para grupo Estados - vista estado denuncia'])->syncRoles($role1);
        Permission::create(['name' => 'vista.grupo.admin.estados.tipo-envio-denuncia', 'description' => 'Vista index para grupo Estados - vista tipo envio denuncia'])->syncRoles($role1);

        Permission::create(['name' => 'grupo.admin.partida-nacimiento', 'description' => 'Contenedor para el grupo llamado: Partida Nacimiento'])->syncRoles($role1);
        Permission::create(['name' => 'vista.grupo.admin.partida-nacimiento.soli-partida-nacimiento', 'description' => 'Vista index para grupo Partida Nacimiento - vista soli partida nacimiento'])->syncRoles($role1);
        Permission::create(['name' => 'vista.grupo.admin.partida-nacimiento.partida-registro-pago', 'description' => 'Vista index para grupo Partida Nacimiento - vista partida registro pago'])->syncRoles($role1);

        Permission::create(['name' => 'grupo.admin.denuncias', 'description' => 'Contenedor para el grupo llamado: Denuncias'])->syncRoles($role1);
        Permission::create(['name' => 'vista.grupo.admin.denuncias.lista-denuncias', 'description' => 'Vista index para grupo Denunicas - vista lista denuncias'])->syncRoles($role1);
        Permission::create(['name' => 'vista.grupo.admin.denuncias.denuncias-realizadas', 'description' => 'Vista index para grupo Denuncias - vista denunicas realizadas'])->syncRoles($role1);
        Permission::create(['name' => 'vista.grupo.admin.denuncias.departamento', 'description' => 'Vista index para grupo Denuncias - vista departamento'])->syncRoles($role1);


        Permission::create(['name' => 'grupo.admin.zona-mapa', 'description' => 'Contenedor para el grupo llamado: Zona Mapa'])->syncRoles($role1);
        Permission::create(['name' => 'vista.grupo.admin.zona-mapa.zonas', 'description' => 'Vista index para grupo Zona Mapa - vista zonas'])->syncRoles($role1);

        Permission::create(['name' => 'grupo.admin.banco', 'description' => 'Contenedor para el grupo llamado: Banco'])->syncRoles($role1);
        Permission::create(['name' => 'vista.grupo.admin.banco.registro-de-pagos', 'description' => 'Vista index para grupo Banco - vista registro de pagos'])->syncRoles($role1);
        Permission::create(['name' => 'vista.grupo.admin.banco.banco-estado', 'description' => 'Vista index para grupo Banco - vista banco estado'])->syncRoles($role1);
        Permission::create(['name' => 'vista.grupo.admin.banco.costos', 'description' => 'Vista index para grupo Banco - vista costos'])->syncRoles($role1);

        Permission::create(['name' => 'grupo.admin.servicios', 'description' => 'Contenedor para el grupo llamado: Servicios'])->syncRoles($role1);
        Permission::create(['name' => 'vista.grupo.admin.servicios.tipo-servicios', 'description' => 'Vista index para grupo Servicios - vista tipo servicios'])->syncRoles($role1);
        Permission::create(['name' => 'vista.grupo.admin.servicios.servicios-alcaldia', 'description' => 'Vista index para grupo Servicios - vista servicios alcaldia'])->syncRoles($role1);
        Permission::create(['name' => 'vista.grupo.admin.servicios.notificaciones', 'description' => 'Vista index para grupo Servicios - vista notificaciones'])->syncRoles($role1);


        // permisos para informacion
        Permission::create(['name' => 'grupo.admin2.solicitudes', 'description' => 'Contenedor para el grupo llamado: Nuevas Solicitudes (Informativo)'])->syncRoles($role2);
        Permission::create(['name' => 'vista.grupo.admin2.solicitudes.nueva-solicitud', 'description' => 'Vista index para grupo Solicitudes - vista nuevas solicitudes (Informativo)'])->syncRoles($role2);


        // permisos para revision Denunicias
        Permission::create(['name' => 'grupo.admin2.denuncias.nuevassolicitudes', 'description' => 'Contenedor para el grupo llamado: Nuevas Solicitudes (Denuncia electricos)'])->syncRoles($role3);
        Permission::create(['name' => 'vista.grupo.admin2.denuncia-electrico.nueva-solicitud', 'description' => 'Vista index para grupo Nuevas Solicitudes - vista nuevas solicitudes (Denuncia electrico)'])->syncRoles($role3);
        Permission::create(['name' => 'vista.grupo.admin2.denuncia-electrico.historial', 'description' => 'Vista index para grupo Nuevas Solicitudes - vista historial (Denuncia electrico)'])->syncRoles($role3);


        // permisos para revision partidas
        Permission::create(['name' => 'grupo.admin2.partidas.nuevassolicitudes', 'description' => 'Contenedor para el grupo llamado: Nuevas Solicitudes (Partidas)'])->syncRoles($role4);
        Permission::create(['name' => 'vista.grupo.admin2.partidas.nueva-solicitud', 'description' => 'Vista index para grupo Nuevas Solicitudes (Partidas) - vista nuevas solicitudes'])->syncRoles($role4);
        Permission::create(['name' => 'vista.grupo.admin2.partidas.historial', 'description' => 'Vista index para grupo Nuevas Solicitudes (Partidas) - vista historial'])->syncRoles($role4);



    }
}
