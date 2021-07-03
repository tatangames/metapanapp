<?php

namespace App\Http\Controllers\Api\Solicitudes;

use App\Http\Controllers\Controller;
use App\Models\Banco;
use App\Models\Costo;
use App\Models\DenunciaRealizada;
use App\Models\DenunciaRealizadaMultiple;
use App\Models\EstadoDenuncia;
use App\Models\EstadoPartida;
use App\Models\ListaDenuncias;
use App\Models\ListaDenunciasMultiple;
use App\Models\SolicitudPartidaNacimiento;
use App\Models\TipoPartida;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiMisSolicitudesController extends Controller
{
    // Este metodo puede ser utilizado para jwt, pero como en api.php
    // ya envolvemos el jwt a todas las rutas api que necesitan ser protegida
    // asi que esto no es necesario
    /*public function __construct(){
        Auth::shouldUse('clientes');
    }*/

    // cargara las solicitudes para denuncia y partida de nacimiento
    public function verMisSolicitudes(Request $request){

        $rules = array(
            'idcliente' => 'required', // id del cliente
        );

        // los demas campos son opcionales

        $validator = Validator::make($request->all(), $rules);

        if ( $validator->fails()){
            return ['success' => 0];
        }

        // obtener todas las solicitudes para denuncias
        $denuncias = DenunciaRealizada::where('id_cliente', $request->idcliente)
            ->where('visible_cliente', 1)
            ->get();

        // obtener todas las solicitudes para partida de nacimiento
        $partidas = SolicitudPartidaNacimiento::where('id_cliente', $request->idcliente)
            ->where('visible_cliente', 1)
            ->get();

        // pagina ayuda: https://blog.codehunger.in/how-to-use-usort-in-laravel-with-example/

        $dataArray = array();

        // el tipo 1: vista para denuncias
        foreach ($denuncias as $d){
            $fecha = date("d-m-Y h:i A", strtotime($d->fecha));

            $infoEstado = EstadoDenuncia::where('id', $d->id_estado)->first();
            $infoDenuncia = ListaDenuncias::where('id', $d->id_denuncia)->first();

            $nombreDenuncia = $infoDenuncia->nombre;

            // si fue una denuncia con opcion multiple, obtener nombre y concatenarlo
            if($dmr = DenunciaRealizadaMultiple::where('id_denuncia_realizada', $d->id)->first()){
                // hoy buscar el nombre de esa opcion
                $dm = DenunciaRealizada::where('id', $dmr->id_lista_denuncias_multiple)->first();

                $nombreDenuncia = $nombreDenuncia . " \n Opción: " . $dm->nombre;
            }

            // llenar el array
            $dataArray[] = [
                'nombre_tarjeta' => 'Denuncia',
                'tipo'=> 0,
                'id' => $d->id,
                'fecha' => $fecha,
                'id_estado' => $d->id_estado, // id ejemp: 1
                'nombre_estado' => $infoEstado->nombre_api, // nombre: Pendiente
                'nombre_denuncia' => $nombreDenuncia,
            ];
        }

        // el tipo 2: vista para solicitud partida de nacimiento
        foreach ($partidas as $p){
            $fecha = date("d-m-Y h:i A", strtotime($p->fecha));

            $infoEstado = EstadoPartida::where('id', $p->id_estado_partida)->first();
            $infoPartida = TipoPartida::where('id', $p->id_tipo_partida)->first();

            // llenar el array
            $dataArray[] = [
                'nombre_tarjeta' => 'Solicitud Partida de Nacimiento',
                'tipo' => 1,
                'id' => $p->id,
                'fecha' => $fecha,
                'id_estado' => $p->id_estado_partida,
                'nombre_estado' => $infoEstado->nombre_api,
                'tipo_partida' => $infoPartida->nombre,
                'cantidad' => $p->cantidad,
                'solicito' => $p->solicito,
                'persona' => $p->persona,
                'fecha_nacimiento' => $p->fecha_nacimiento,
                'nombre_padre' => $p->nombre_padre,
                'nombre_madre' => $p->nombre_madre,
                'nota_cancelada' => $p->nota_cancelada
            ];
        }

        // metodos para ordenar el array
        usort($dataArray, array( $this, 'sortDate' ));

        // mensaje para mostrar a los dialogos denuncia y solicitud
        $tituloDenuncia = 'Completar';
        $msgDenuncia = 'Su denuncia ha sido respondida y completada. Gracias.';

        $tituloPartida = 'Completar';
        $msgPartida = 'Su partida de nacimiento ha sido entregada. Gracias.';

        $msgCancelarPartida = 'Se cancelara la solicitud para Partida de Nacimiento';

        $msgPartidaNoEncontrada = 'Se cancelara la solicitud, Por Favor especificar más en la información';

        // cuando el cliente tenia que pagar y nunca pago
        $msgMeCancelaronPartida = "Se cancelo, porque nunca se realizo el Pago";

        $dataDialogo[] = [
            'tituloDenuncia' => $tituloDenuncia,
            'mensajeDenuncia'=> $msgDenuncia,
            'tituloPartida' => $tituloPartida,
            'mensajePartida' => $msgPartida,
            'mensajeCancelarPartida' => $msgCancelarPartida,
            'msgPartidaNoEncontrada' => $msgPartidaNoEncontrada,
            'msgMeCancelaron' => $msgMeCancelaronPartida
        ];

        return ['success' => 1, 'info' => $dataArray, 'infoDialogo' => $dataDialogo];
    }

    // metodo para ordenar un array con fechas
    public function sortDate($a, $b){
        if (strtotime($a['fecha']) == strtotime($b['fecha'])) return 0;

        // con el simbolo > vamos a ordenar que las Fechas ultimas sean la primera posicion
        // con el simbolo < vamos a ordenar que las Fechas primeras este en la primera posicion
        return (strtotime($a['fecha']) > strtotime($b['fecha'])) ?-1:1;
    }

    // ocultar una denuncia
    public function ocultarDenuncia(Request $request){
        $rules = array(
            'iddenuncia' => 'required',
        );

        // los demas campos son opcionales

        $validator = Validator::make($request->all(), $rules);

        if ( $validator->fails()){
            return ['success' => 0];
        }

        if(DenunciaRealizada::where('id', $request->iddenuncia)->first()){

            DenunciaRealizada::where('id', $request->iddenuncia)
                ->update(['visible_cliente' => 0]);
            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }


    // cancelar partida de nacimiento, solo cuando es estado 1: Pendiente
    public function cancelarPartidaEstadoPendiente(Request $request){

        $rules = array(
            'idpartida' => 'required',
        );

        // los demas campos son opcionales

        $validator = Validator::make($request->all(), $rules);

        if ( $validator->fails()){
            return ['success' => 0];
        }

        if($solicitud = SolicitudPartidaNacimiento::where('id', $request->idpartida)->first()){

            // unicamente si esta pendiente, podra ser cancelado
            if($solicitud->id_estado_partida == 1){

                $fecha = Carbon::now('America/El_Salvador');

                SolicitudPartidaNacimiento::where('id', $request->idpartida)
                    ->update(['visible_cliente' => 0,
                        'cancelado' => 1, // por cliente
                        'fecha_cancelado' => $fecha,
                        'id_estado_partida' => 7]); // estado: Cancelado

                return ['success' => 1];
            }else{
                // el estado cambio, no puede cancelar
                return ['success' => 2];
            }
        }else{
            return ['success' => 3];
        }
    }


    public function ocultarPartidaEstadoNoEncontrada(Request $request){

        $rules = array(
            'idpartida' => 'required',
        );

        // los demas campos son opcionales

        $validator = Validator::make($request->all(), $rules);

        if ( $validator->fails()){
            return ['success' => 0];
        }

        if($solicitud = SolicitudPartidaNacimiento::where('id', $request->idpartida)->first()){

            SolicitudPartidaNacimiento::where('id', $request->idpartida)
                ->update(['visible_cliente' => 0]);

            return ['success' => 1];

        }else{
            return ['success' => 3];
        }
    }

    // informacion para formulario de pago. Partida de nacimiento
    public function informacionPagoPartida(Request $request){

        $rules = array(
            'idpartida' => 'required',
        );

        // los demas campos son opcionales

        $validator = Validator::make($request->all(), $rules);

        if ( $validator->fails()){
            return ['success' => 0];
        }

        // --- Campos Fijos ---
        $infoBanco = Banco::where('id', 1)->first();
        $infoCosto = Costo::where('id', 1)->first();

        $infoPartida = SolicitudPartidaNacimiento::where('id', $request->idpartida)->first();

        // cantidad * precio unitario
        $costo = $infoCosto->precio * $infoPartida->cantidad;
        $cc = ($infoBanco->comision * $costo) / 100;

        $pagara = $costo + $cc;
        $pagara = number_format((float)$pagara, 2, '.', '');

        $titulo = 'Pago para Partida de Nacimiento';
        $msgActivo = 'Por el momento no aceptamos pagos de partida de nacimiento';

        $dataArray[] = [
            'activo' => $infoBanco->activo,
            'pagara' => $pagara,
            'titulo' => $titulo,
            'cantidad' => $infoPartida->cantidad,
            'msgActivo' => $msgActivo
        ];

        return ['success' => 1, 'info' => $dataArray];
    }

    public function completarSolicitudPartida(Request $request){
        $rules = array(
            'idpartida' => 'required',
        );

        // los demas campos son opcionales

        $validator = Validator::make($request->all(), $rules);

        if ( $validator->fails()){
            return ['success' => 0];
        }

        if($solicitud = SolicitudPartidaNacimiento::where('id', $request->idpartida)->first()){

            SolicitudPartidaNacimiento::where('id', $request->idpartida)
                ->update(['visible_cliente' => 0]);

            return ['success' => 1];
        }else{
            return ['success' => 3];
        }
    }

}
