<?php

namespace App\Http\Controllers\Api\Servicios;

use App\Http\Controllers\Controller;
use App\Models\ServicioAlcaldia;
use Illuminate\Http\Request;

class ApiServiciosController extends Controller
{

    // Este metodo puede ser utilizado para jwt, pero como en api.php
    // ya envolvemos el jwt a todas las rutas api que necesitan ser protegida
    // asi que esto no es necesario
    /*public function __construct(){
        Auth::shouldUse('clientes');
    }*/

    public function infoServicios(Request $request){

        $data = ServicioAlcaldia::where('visible', 1)
            ->orderBy('posicion', 'ASC')
            ->get();

        $msgActualizar = "Actualizar la App para poder usar este servicio. Gracias.";
        $msgServicios = "ahorita no se puede solicitar este servicio";

        return ['success' => 1,
            'info' => $data,
            'mensaje_servicios' => $msgServicios,
            'mensaje_actualizar' => $msgActualizar];
    }
}
