<?php

namespace App\Http\Controllers\Api\Partida;

use App\Http\Controllers\Controller;
use App\Models\SolicitudPartidaNacimiento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PartidaNacimientoController extends Controller
{

    // Este metodo puede ser utilizado para jwt, pero como en api.php
    // ya envolvemos el jwt a todas las rutas api que necesitan ser protegida
    // asi que esto no es necesario
    /*public function __construct(){
        Auth::shouldUse('clientes');
    }*/

    public function ingresarPartidaNacimiento(Request $request){

        $rules = array(
            'idcliente' => 'required', // id del cliente
            'cantidad' => 'required', // cantidad de partidas a solicitar
            'solicita' => 'required', // nombre del solicitante
        );

        // los demas campos son opcionales

        $validator = Validator::make($request->all(), $rules);

        if ( $validator->fails()){
            return ['success' => 0];
        }

        // guardar solicitud

        $fecha = Carbon::now('America/El_Salvador');

        $solicitud = new SolicitudPartidaNacimiento();
        $solicitud->id_estado_partida = 1; // pendiente
        $solicitud->id_tipo_partida = $request->tipopartida;
        $solicitud->id_cliente = $request->idcliente;
        $solicitud->cantidad = $request->cantidad;
        $solicitud->solicito = $request->solicita;
        $solicitud->persona = $request->persona;
        $solicitud->fecha = $fecha;
        $solicitud->fecha_nacimiento = $request->fecha;
        $solicitud->nombre_padre = $request->padre;
        $solicitud->nombre_madre = $request->madre;
        $solicitud->cancelado = 0; // defecto
        $solicitud->visible_cliente = 1;

        if($solicitud->save()){
            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }
}
