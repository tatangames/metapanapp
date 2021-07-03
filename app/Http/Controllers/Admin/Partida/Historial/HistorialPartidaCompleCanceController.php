<?php

namespace App\Http\Controllers\Admin\Partida\Historial;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\EstadoPartida;
use App\Models\SolicitudPartidaNacimiento;
use App\Models\TipoPartida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HistorialPartidaCompleCanceController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        $this->middleware('can:vista.grupo.admin2.partidas.historial');
    }

    public function index(){
        return view('backend.revisadores.partida.historial.index');
    }

    public function tablaIndex(){

        // obtener todas las denuncias completadas
        // en proceso, pagar el usuario, pasar a traer partida
        // partida no encontradas, completada, cancelada
        $listado = SolicitudPartidaNacimiento::whereIn('id_estado_partida', [3, 6, 7])->get();

        foreach ($listado as $z){
            $z->fecha = date("d-m-Y h:i A", strtotime($z->fecha));

            $tel = Cliente::where('id', $z->id_cliente)->pluck('telefono')->first();
            $tipo = TipoPartida::where('id', $z->id_tipo_partida)->pluck('nombre')->first();

            if($z->id_estado_partida == 3){
                $estado = "No Encontrada";
            }
            else if($z->id_estado_partida == 6){
                $estado = "Completada";
            }else{
                $estado = "Cancelada";
            }

            $z->telefono = $tel;
            $z->tipo = $tipo;
            $z->estado = $estado;
        }

        return view('backend.revisadores.partida.historial.tabla.tablahistorial', compact('listado'));
    }

    public function informacionPartida(Request $request){
        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = SolicitudPartidaNacimiento::where('id', $request->id)->first()){

            $tipo = TipoPartida::where('id', $data->id_tipo_partida)->pluck('nombre')->first();

            if($data->fecha_cancelado != null){
                $data->fecha_cancelado = date("d-m-Y h:i A", strtotime($data->fecha_cancelado));
            }

            return ['success' => 1, 'info' => $data, 'tipo' => $tipo];
        }else{
            return ['success' => 2];
        }
    }

}
