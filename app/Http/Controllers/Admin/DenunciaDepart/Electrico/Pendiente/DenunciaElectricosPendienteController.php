<?php

namespace App\Http\Controllers\Admin\DenunciaDepart\Electrico\Pendiente;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\DenunciaRealizada;
use App\Models\DenunciaRealizadaMultiple;
use App\Models\HistorialDenunciaProceso;
use App\Models\ListaDenuncias;
use App\Models\ListaDenunciasMultiple;
use App\Models\Zona;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DenunciaElectricosPendienteController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        $this->middleware('can:vista.grupo.admin2.denuncia-electrico.nueva-solicitud');
    }

    public function index(){
        return view('backend.revisadores.denunciasdep.electrico.nuevasolicitud.index');
    }

    public function tablaIndex(){

        // obtener todas las denuncias en proceso
        //** UNICAMENTE DENUNCIAS DEPARTAMENTO ELECTRICAS */

        $listado = DB::table('denuncia_realizada AS dr')
            ->join('lista_denuncias AS ld', 'ld.id', '=', 'dr.id_denuncia')
            ->select('dr.id', 'dr.id_cliente', 'dr.id_zona', 'dr.imagen', 'dr.id_estado', 'dr.id_denuncia',
                'dr.fecha', 'dr.descripcion', 'ld.id_departamento_denuncia')
            ->where('ld.id_departamento_denuncia', 1) // UNICAMENTE DEPARTAMENTO ELECTRICO
                ->where('dr.id_estado', 2) // unicamente en proceso
            ->get();

        foreach ($listado as $z){
            $z->fecha = date("d-m-Y h:i A", strtotime($z->fecha));

            $tel = Cliente::where('id', $z->id_cliente)->pluck('telefono')->first();
            $zona = Zona::where('id', $z->id_zona)->pluck('nombre')->first();

            $infoDenuncia = ListaDenuncias::where('id', $z->id_denuncia)->first();

            $nombreDenuncia = $infoDenuncia->nombre;

            // si fue una denuncia con opcion multiple, obtener nombre y concatenarlo
            if($dmr = DenunciaRealizadaMultiple::where('id_denuncia_realizada', $z->id)->first()){
                // hoy buscar el nombre de esa opcion
                $dm = ListaDenunciasMultiple::where('id', $dmr->id_denuncia_realizada)->first();

                $nombreDenuncia = $nombreDenuncia . ". Opción: " . $dm->nombre;
            }

            $z->telefono = $tel;
            $z->zona = $zona;
            $z->nombre = $nombreDenuncia;
        }

        return view('backend.revisadores.denunciasdep.electrico.nuevasolicitud.tabla.tablanuevasolicitud', compact('listado'));
    }

    // NOTA: 03/07/2021
    // CAMBIAR API GOOGLE (porque puedo borrarla de mi cuenta jeje )
    public function verUbicacionDenuncia($id){

        $mapa = DenunciaRealizada::where('id', $id)->first();
        $api = "AIzaSyB-Iz6I6GtO09PaXGSQxZCjIibU_Li7yOM";

        $latitud = $mapa->latitud;
        $longitud = $mapa->longitud;

        return view('backend.revisadores.denunciasdep.electrico.nuevasolicitud.mapa.ubicacion', compact('latitud', 'longitud', 'api'));
    }

    // buscar imagen de la denuncia
    public function verImagenDenuncia(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = DenunciaRealizada::where('id', $request->id)->first()){

            return ['success' => 1, 'imagen' => $data->imagen];
        }else{
            return ['success' => 2];
        }
    }

    // finalizar proceso de la denuncia
    public function finalizarProcesoDenuncia(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0]; }

        DenunciaRealizada::where('id', $request->id)
            ->update(['id_estado' => 3, // pasara a Completado
            ]);

        // evitar que se registren 2 veces por error
        if(HistorialDenunciaProceso::where('id_denuncia_realizada', $request->id)
            ->where('id_estado', 3)->first()){
            // ya existe, no registrar
        }else{
            $fecha = Carbon::now('America/El_Salvador');
            $idusuario = Auth::id();

            // guardar un historial
            $h = new HistorialDenunciaProceso();
            $h->id_denuncia_realizada = $request->id;
            $h->id_usuario = $idusuario;
            $h->id_estado = 3; // paso a En Proceso
            $h->fecha = $fecha;
            $h->save();
        }

        return ['success' => 1];
    }
}
