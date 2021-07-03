<?php

namespace App\Http\Controllers\Admin\Informativo\NuevaSolicitud;

use App\Http\Controllers\Controller;
use App\Models\DenunciaRealizada;
use App\Models\DenunciaRealizadaMultiple;
use App\Models\DepartamentoDenuncia;
use App\Models\HistorialDenunciaProceso;
use App\Models\HistorialPartidaProceso;
use App\Models\ListaDenuncias;
use App\Models\ListaDenunciasMultiple;
use App\Models\SolicitudPartidaNacimiento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NuevaSolicitudController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        $this->middleware('can:vista.grupo.admin2.solicitudes.nueva-solicitud');
    }

    public function index(){
        return view('backend.revisadores.informativo.nuevasolicitud.index');
    }

    public function tablaIndex(){

        // obtener todas las denuncias pendientes
        $denuncias = DenunciaRealizada::where('id_estado', 1)->get();

        // obtener todas las solicitudes para partida de nacimiento con estado 1: pendiente
        $partidas = SolicitudPartidaNacimiento::where('id_estado_partida', 1)->get();

        $dataArray = array();

        // el tipo 1: vista para denuncias
        foreach ($denuncias as $d){
            $fecha = date("d-m-Y h:i A", strtotime($d->fecha));

            $infoDenuncia = ListaDenuncias::where('id', $d->id_denuncia)->first();

            $departamento = DepartamentoDenuncia::where('id', $infoDenuncia->id_departamento_denuncia)
                ->pluck('nombre')->first();

            $nombreDenuncia = $infoDenuncia->nombre;

            // si fue una denuncia con opcion multiple, obtener nombre y concatenarlo
            if($dmr = DenunciaRealizadaMultiple::where('id_lista_denuncias_multiple', $d->id)->first()){

                // hoy buscar el nombre de esa opcion
                $dm = ListaDenunciasMultiple::where('id', $dmr->id_lista_denuncias_multiple)->first();

                $nombreDenuncia = $nombreDenuncia . ".. Opción: " . $dm->nombre;
            }

            // llenar el array
            $dataArray[] = [
                'identificador'=> 1, // tipo denuncia
                'id' => $d->id, // id de la denuncia
                'fecha' => $fecha, // fecha cuando fue hecha
                'tipo' => 'Denuncia',
                'nombre' => $nombreDenuncia, // nombre de la de nuncia
                'informar' => "Departamento: " . $departamento
            ];
        }

        // el tipo 2: vista para solicitud partida de nacimiento
        foreach ($partidas as $p){
            $fecha = date("d-m-Y h:i A", strtotime($p->fecha));

            // llenar el array
            $dataArray[] = [
                'identificador' => 2, // tipo partida
                'id' => $p->id, // id de la patida
                'fecha' => $fecha,
                'tipo' => 'Solicitud Partida Nacimiento',
                'nombre' => '',
                'informar' => 'Unidad Familiar'
            ];
        }

        // metodos para ordenar el array
        usort($dataArray, array( $this, 'sortDate' ));

        return view('backend.revisadores.informativo.nuevasolicitud.tabla.tablanuevasolicitud', compact('dataArray'));
    }

    // metodo para ordenar un array con fechas
    public function sortDate($a, $b){
        if (strtotime($a['fecha']) == strtotime($b['fecha'])) return 0;

        // con el simbolo > vamos a ordenar que las Fechas ultimas sean la primera posicion
        // con el simbolo < vamos a ordenar que las Fechas primeras este en la primera posicion
        return (strtotime($a['fecha']) > strtotime($b['fecha'])) ?-1:1;
    }


    // buscar departamento para mostrar en una ventana
    public function buscarDepartamento(Request $request){
        $regla = array(
            'id' => 'required' // is el id de la denuncia realizada
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = DenunciaRealizada::where('id', $request->id)->first()){

            $info = ListaDenuncias::where('id', $data->id_denuncia)->first();

            $departamento = DepartamentoDenuncia::where('id', $info->id_departamento_denuncia)
                ->pluck('nombre')->first();

            return ['success' => 1, 'info' => $data, 'departamento' => $departamento];
        }else{
            return ['success' => 2];
        }
    }

    // pasar la denuncia al estado en proceso
    public function verificarDenunciaEstadoEnProceso(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0]; }

        DenunciaRealizada::where('id', $request->id)
            ->update(['id_estado' => 2, // pasara a En Proceso
            ]);

        if(HistorialDenunciaProceso::where('id_denuncia_realizada', $request->id)
            ->where('id_estado', 2)->first()){
            // ya existe, no registrar
        }else{
            $fecha = Carbon::now('America/El_Salvador');
            $idusuario = Auth::id();

            // guardar un historial
            $h = new HistorialDenunciaProceso();
            $h->id_denuncia_realizada = $request->id;
            $h->id_usuario = $idusuario;
            $h->id_estado = 2; // paso a En Proceso
            $h->fecha = $fecha;
            $h->save();
        }

        return ['success' => 1];
    }

    // verificar partida y cambiar a estado 2: en proceso
    public function verificarPartidaEstadoEnProceso(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0]; }

        SolicitudPartidaNacimiento::where('id', $request->id)
            ->update(['id_estado_partida' => 2, // pasara a En Proceso
            ]);

        if(HistorialPartidaProceso::where('id_soli_partida_naci', $request->id)
            ->where('id_estado', 2)->first()){
            // ya existe, no registrar
        }else{
            $fecha = Carbon::now('America/El_Salvador');
            $idusuario = Auth::id();

            // guardar un historial
            $h = new HistorialPartidaProceso();
            $h->id_soli_partida_naci = $request->id;
            $h->id_usuario = $idusuario;
            $h->id_estado = 2; // paso a En Proceso
            $h->fecha = $fecha;
            $h->save();
        }

        return ['success' => 1];
    }


}
