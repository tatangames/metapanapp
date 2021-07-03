<?php

namespace App\Http\Controllers\Admin\Administrador\SoliPartidaNacimiento;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\EstadoPartida;
use App\Models\SolicitudPartidaNacimiento;
use App\Models\TipoPartida;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SoliPartidaNacimientoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todas las rutas
        $this->middleware('can:vista.grupo.admin.partida-nacimiento.soli-partida-nacimiento');
    }

    public function index(){
        return view('backend.admin.solipartidanacimiento.index');
    }

    public function tablaIndex(){
        $listado = SolicitudPartidaNacimiento::orderBy('fecha', 'ASC')->get();
        foreach ($listado as $z){
            $z->fecha = date("d-m-Y h:i A", strtotime($z->fecha));
            $ep = EstadoPartida::where('id', $z->id_estado_partida)->pluck('nombre_web')->first();
            $tp = TipoPartida::where('id', $z->id_tipo_partida)->pluck('nombre')->first();
            $tel = Cliente::where('id', $z->id_cliente)->pluck('telefono')->first();

            $z->estadopartida = $ep;
            $z->tipopartida = $tp;
            $z->telefono = $tel;
        }
        return view('backend.admin.solipartidanacimiento.tabla.tablasolipartidanacimiento', compact('listado'));
    }

    public function infoSoliPartidaNacimiento(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = SolicitudPartidaNacimiento::where('id', $request->id)->first()){

            $fechacancelado = '';
            if($data->fecha_cancelado != null){
                $fechacancelado = date("d-m-Y h:i A", strtotime($data->fecha_cancelado));
            }

            return ['success' => 1, 'info' => $data, 'fechacancelado' => $fechacancelado];
        }else{
            return ['success' => 2];
        }
    }
}
