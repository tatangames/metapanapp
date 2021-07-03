<?php

namespace App\Http\Controllers\Api\Servicios;

use App\Http\Controllers\Controller;
use App\Models\TipoServicios;
use Illuminate\Http\Request;

class ApiTipoServiciosController extends Controller
{

    // Este metodo puede ser utilizado para jwt, pero como en api.php
    // ya envolvemos el jwt a todas las rutas api que necesitan ser protegida
    // asi que esto no es necesario
    /*public function __construct(){
        Auth::shouldUse('clientes');
    }*/

    // informacion de los servicios que se ofrece
    // ejem: denuncias, partidas de nacimiento.
    public function infoTipoServicios(){
        // unicamente los visible, si esta inactivo mostrara el mensaje de inactividad
        $data = TipoServicios::where('visible', '1')
            ->select('id', 'nombre', 'imagen', 'activo')
            ->orderBy('posicion', 'ASC')->get();

        $msgTipoServicio = "No disponible por el momento";
        $msgActualizarApp = "Actualizar la App para poder usar este servicio. Gracias.";

        return ['success' => 1, 'info' => $data,
            'mensaje_tiposervicios' => $msgTipoServicio,
            'mensaje_actualizar' => $msgActualizarApp];
    }
}
