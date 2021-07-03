<?php

namespace App\Http\Controllers\Admin\Administrador\PartidaRegistroPago;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\EstadoPartida;
use App\Models\PartidaRegistroPago;
use App\Models\RegistroPago;
use App\Models\SolicitudPartidaNacimiento;
use App\Models\TipoPartida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PartidaRegistroPagoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todas las rutas
        $this->middleware('can:vista.grupo.admin.partida-nacimiento.partida-registro-pago');
    }

    public function index(){
        return view('backend.admin.partidaregistropago.index');
    }

    public function tablaIndex(){

        $listado = DB::table('registro_pago AS rp')
            ->join('partida_registro_pago AS prp', 'prp.id_registro_pago', '=', 'rp.id')
            ->select('prp.id', 'rp.id AS id_registro_pago', 'rp.fecha',
                'rp.pago_total', 'prp.id_cliente', 'prp.id_solicitud_partida_nacimiento')
            ->orderBy('rp.fecha', 'ASC')
            ->get();

        foreach ($listado as $z){
            $z->fecha = date("d-m-Y h:i A", strtotime($z->fecha));
            $tel = Cliente::where('id', $z->id_cliente)->pluck('telefono')->first();
            $info = SolicitudPartidaNacimiento::where('id', $z->id_solicitud_partida_nacimiento)->first();

            $estado = EstadoPartida::where('id', $info->id_estado_partida)->pluck('nombre_web')->first();

            $z->telefono = $tel;
            $z->solicito = $info->solicito;
            $z->estado = $estado;

        }

        return view('backend.admin.partidaregistropago.tabla.tablapartidaregistropago', compact('listado'));
    }

    // informacion del registro pago
    public function infoRegistroPago(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = RegistroPago::where('id', $request->id)->first()){

            $fecha = date("d-m-Y h:i A", strtotime($data->fecha));

            return ['success' => 1, 'info' => $data, 'fecha' => $fecha];
        }else{
            return ['success' => 2];
        }
    }

    // informacion de partida de nacimiento
    public function infoPartida(Request $request){
        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = SolicitudPartidaNacimiento::where('id', $request->id)->first()){

            $fecha = date("d-m-Y h:i A", strtotime($data->fecha));
            $estado = EstadoPartida::where('id', $data->id_estado_partida)->pluck('nombre_web')->first();
            $tipo = TipoPartida::where('id', $data->id_tipo_partida)->pluck('nombre')->first();

            return ['success' => 1, 'info' => $data,
                'fecha' => $fecha, 'estado' => $estado,
                'tipo' => $tipo];
        }else{
            return ['success' => 2];
        }
    }

}
