<?php

namespace App\Http\Controllers\Admin\Partida\Pendientes;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\EstadoPartida;
use App\Models\HistorialPartidaProceso;
use App\Models\SolicitudPartidaNacimiento;
use App\Models\TipoPartida;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PartidaNacimientoPendienteController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        $this->middleware('can:vista.grupo.admin2.partidas.nueva-solicitud');
    }

    public function index(){
        return view('backend.revisadores.partida.nuevasolicitud.index');
    }

    public function tablaIndex(){

        // obtener todas las denuncias completadas
        // en proceso, pagar el usuario, pasar a traer partida
        $listado = SolicitudPartidaNacimiento::whereIn('id_estado_partida', [2,4,5])->get();

        foreach ($listado as $z){
            $z->fecha = date("d-m-Y h:i A", strtotime($z->fecha));

            $tel = Cliente::where('id', $z->id_cliente)->pluck('telefono')->first();
            $tipo = TipoPartida::where('id', $z->id_tipo_partida)->pluck('nombre')->first();
            $estado = EstadoPartida::where('id', $z->id_estado_partida)->pluck('nombre_web')->first();

            $z->telefono = $tel;
            $z->tipo = $tipo;
            $z->estado = $estado;
        }

        return view('backend.revisadores.partida.nuevasolicitud.tabla.tablanuevasolicitud', compact('listado'));
    }

    public function informacionPartida(Request $request){
        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = SolicitudPartidaNacimiento::where('id', $request->id)->first()){

            $tipo = TipoPartida::where('id', $data->id_tipo_partida)->pluck('nombre')->first();

            return ['success' => 1, 'info' => $data, 'tipo' => $tipo];
        }else{
            return ['success' => 2];
        }
    }

    // partida no encontrada, pasar a estado 3
    public function pasarPartidaEstado3(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0]; }

        SolicitudPartidaNacimiento::where('id', $request->id)
            ->update(['id_estado_partida' => 3, // pasara a no encontrado
                'nota_cancelada' => $request->nota
            ]);

        if(HistorialPartidaProceso::where('id_soli_partida_naci', $request->id)
            ->where('id_estado', 3)->first()){
            // ya existe, no registrar
        }else{
            $fecha = Carbon::now('America/El_Salvador');
            $idusuario = Auth::id();

            // guardar un historial
            $h = new HistorialPartidaProceso();
            $h->id_soli_partida_naci = $request->id;
            $h->id_usuario = $idusuario;
            $h->id_estado = 3; // pasar a Pagar
            $h->fecha = $fecha;
            $h->save();
        }

        return ['success' => 1];
    }

    // pasar a estado 4, el cliente podra realizar pago
    public function pasarPartidaEstado4(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0]; }

        SolicitudPartidaNacimiento::where('id', $request->id)
            ->update(['id_estado_partida' => 4, // pasara a Pagar
            ]);

        if(HistorialPartidaProceso::where('id_soli_partida_naci', $request->id)
            ->where('id_estado', 4)->first()){
            // ya existe, no registrar
        }else{
            $fecha = Carbon::now('America/El_Salvador');
            $idusuario = Auth::id();

            // guardar un historial
            $h = new HistorialPartidaProceso();
            $h->id_soli_partida_naci = $request->id;
            $h->id_usuario = $idusuario;
            $h->id_estado = 4; // pasar a Pagar
            $h->fecha = $fecha;
            $h->save();
        }

        return ['success' => 1];
    }

    // completar solicitud
    public function pasarPartidaEstado6(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0]; }

        SolicitudPartidaNacimiento::where('id', $request->id)
            ->update(['id_estado_partida' => 6, // pasara a Pagar
            ]);

        if(HistorialPartidaProceso::where('id_soli_partida_naci', $request->id)
            ->where('id_estado', 6)->first()){
            // ya existe, no registrar
        }else{
            $fecha = Carbon::now('America/El_Salvador');
            $idusuario = Auth::id();

            // guardar un historial
            $h = new HistorialPartidaProceso();
            $h->id_soli_partida_naci = $request->id;
            $h->id_usuario = $idusuario;
            $h->id_estado = 6; // pasar a Pagar
            $h->fecha = $fecha;
            $h->save();
        }

        return ['success' => 1];
    }


    // cancelar solicitud solo si el usuario no ha pagado
    public function pasarPartidaEstado7(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0]; }

        // no cancelar si el estado ha sido cambiado
        // los estados son 5 y 6
        if(SolicitudPartidaNacimiento::where('id', $request->id)
            ->whereIn('id_estado_partida', [5, 6])->first()){
            return ['success' => 1];
        }

        $fecha = Carbon::now('America/El_Salvador');

        SolicitudPartidaNacimiento::where('id', $request->id)
            ->update(['id_estado_partida' => 7, // cancelar
                'cancelado' => 2,
                'fecha_cancelado' => $fecha,
                'nota_cancelada' => $request->nota
            ]);

        if(HistorialPartidaProceso::where('id_soli_partida_naci', $request->id)
            ->where('id_estado', 7)->first()){
            // ya existe, no registrar
        }else{

            $idusuario = Auth::id();

            // guardar un historial
            $h = new HistorialPartidaProceso();
            $h->id_soli_partida_naci = $request->id;
            $h->id_usuario = $idusuario;
            $h->id_estado = 7; // pasar a Pagar
            $h->fecha = $fecha;
            $h->save();
        }

        return ['success' => 2];
    }


}
