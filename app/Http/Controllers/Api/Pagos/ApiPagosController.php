<?php

namespace App\Http\Controllers\Api\Pagos;

use App\Http\Controllers\Controller;
use App\Models\Banco;
use App\Models\Costo;
use App\Models\PartidaRegistroPago;
use App\Models\RegistroPago;
use App\Models\SolicitudPartidaNacimiento;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApiPagosController extends Controller
{

    // Este metodo puede ser utilizado para jwt, pero como en api.php
    // ya envolvemos el jwt a todas las rutas api que necesitan ser protegida
    // asi que esto no es necesario
    /*public function __construct(){
        Auth::shouldUse('clientes');
    }*/

    public function pagarPartidaNacimiento(Request $request){

        $reglaDatos = array(
            'idcliente' => 'required',
            'idpartida' => 'required',
            'nombre' => 'required',
            'numero' => 'required',
            'mes' => 'required',
            'anio' => 'required',
            'cvv' => 'required',
            'correo' => 'required'
        );

        $validarDatos = Validator::make($request->all(), $reglaDatos);

        if($validarDatos->fails()){ return ['success' => 0];}

        // Primero verificar el tiempo de token, por que tiene validez 59 minutos

        $infoBanco = Banco::where('id', 1)->first();

        $time1 = Carbon::parse($infoBanco->fecha_token);
        $horaEstimada = $time1->addMinute(50)->format('Y-m-d H:i:s'); // agregar 50 minutos
        $today = Carbon::now('America/El_Salvador')->format('Y-m-d H:i:s');

        $d1 = new DateTime($horaEstimada);
        $d2 = new DateTime($today);

        // costo de la partida de nacimiento
        $infoCosto = Costo::where('id', 1)->first();

        // informacion de la partida que se va a pagar
        $infoPartida = SolicitudPartidaNacimiento::where('id', $request->idpartida)->first();

        // cantidad * precio unitario
        $costo = $infoCosto->precio * $infoPartida->cantidad;
        $cc = ($infoBanco->comision * $costo) / 100;

        // total a pagar
        $pagara = $costo + $cc;
        $pagara = number_format((float)$pagara, 2, '.', '');

        $data = array (
            'tarjetaCreditoDebido' =>
                array (
                    'numeroTarjeta' => $request->numero,
                    'cvv' => $request->cvv,
                    'mesVencimiento' => $request->mes,
                    'anioVencimiento' => $request->anio,
                ),
            'monto' => $pagara,
            'emailCliente' => $request->correo,
            'nombreCliente' => $request->nombre,
            "formaPago" => "PagoNormal"
        );

        $convertido = json_encode($data);
        $tokenactual = $infoBanco->token;

        DB::beginTransaction();

        try {

            if ($d1 > $d2){
                // hay tiempo de token, generar compra

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.wompi.sv/TransaccionCompra",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_POSTFIELDS => $convertido,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_HTTPHEADER => array(
                        "authorization: Bearer $tokenactual",
                        "content-type: application/json"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);
                $code = curl_getinfo($curl);
                curl_close($curl);

                if ($err) {
                    return ['success' => 1]; // problema de peticion
                }else {
                    if(empty($response)){
                        return ['success' => 2, 'info' => $curl]; // problemas internos
                    }

                    if($code["http_code"] == 200){ // peticion correcta
                        $arrayjson = json_decode($response,true);

                        $idtransaccion = $arrayjson["idTransaccion"]; // guardar, string
                        $esreal = $arrayjson["esReal"]; // guardar, bool
                        $esaprobada = $arrayjson["esAprobada"]; // guardar, bool
                        //$monto = $arrayjson["monto"]; // decimal
                        $codigo = $arrayjson["codigoAutorizacion"];

                        if($esaprobada == false){
                            return ['success' => 5]; // reprobada, no pudo ser efectuada
                        }

                        $fechahoy = Carbon::now('America/El_Salvador');

                        // guardar datos
                        $reg = new RegistroPago();
                        $reg->fecha = $fechahoy;
                        $reg->pago_total = $pagara; // lo que pago al final
                        $reg->comision = $infoBanco->comision;
                        $reg->idtransaccion = $idtransaccion;
                        $reg->codigo = $codigo;
                        $reg->esreal = (int)$esreal;
                        $reg->esaprobada = (int)$esaprobada;
                        $reg->save();

                        // si pasa un error, entrara en el try catch
                        $regCliente = new PartidaRegistroPago();
                        $regCliente->id_registro_pago = $reg->id;
                        $regCliente->id_cliente = $request->idcliente;
                        $regCliente->id_solicitud_partida_nacimiento = $request->idpartida;
                        $regCliente->save();

                        // actualizar estado de la partida a PAGADO
                        SolicitudPartidaNacimiento::where('id', $request->idpartida)
                            ->update(['id_estado_partida' => 5]);

                        DB::commit();

                        return ['success' => 3]; // compra exitosa
                    }else{
                        // revisar los datos de su tarjeta
                        return ['success' => 4];
                    }
                }

            }else{

                // supero tiempo
                // generar token nuevo
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://id.wompi.sv/connect/token",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "grant_type=client_credentials&client_id=2881492c-24eb-4849-876d-a3068e2a8563&client_secret=21200088-b201-4903-8c07-e34bf90eba08&audience=wompi_api",
                    CURLOPT_HTTPHEADER => array(
                        "content-type: application/x-www-form-urlencoded"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    return ['success' => 1]; // error al obtener token
                } else {
                    $jsonArray = json_decode($response,true);
                    $key = "access_token";
                    $tokennuevo = $jsonArray[$key];
                    $fechahoy = Carbon::now('America/El_Salvador');

                    // GUARDAR TOKEN NUEVO
                    Banco::where('id', 1)->update(['token' => $tokennuevo, 'fecha_token' => $fechahoy]);
                    DB::commit();

                    // GENERAR COMPRA

                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://api.wompi.sv/TransaccionCompra",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_POSTFIELDS => $convertido,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_HTTPHEADER => array(
                            "authorization: Bearer $tokennuevo",
                            "content-type: application/json"
                        ),
                    ));

                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    $code = curl_getinfo($curl);
                    curl_close($curl);
                    if ($err) {
                        return ['success' => 1]; // problema realizar cobro
                    }else {
                        if(empty($response)){
                            return ['success' => 2]; // problemas
                        }

                        if($code["http_code"] == 200){ // peticion correcta
                            $arrayjson = json_decode($response,true);

                            $idtransaccion = $arrayjson["idTransaccion"]; // guardar, string
                            $codigo = $arrayjson["codigoAutorizacion"];
                            $esreal = $arrayjson["esReal"]; // guardar, bool
                            $esaprobada = $arrayjson["esAprobada"]; // guardar, bool
                            //$monto = $arrayjson["monto"]; // decimal

                            if($esaprobada == false){
                                return ['success' => 5]; // reprobada, no pudo ser efectuada
                            }

                            $fechahoy = Carbon::now('America/El_Salvador');

                            // guardar registro del pago
                            $reg = new RegistroPago();
                            $reg->fecha = $fechahoy;
                            $reg->pago_total = $pagara; // lo que pago al final
                            $reg->comision = $infoBanco->comision;
                            $reg->idtransaccion = $idtransaccion;
                            $reg->codigo = $codigo;
                            $reg->esreal = (int)$esreal;
                            $reg->esaprobada = (int)$esaprobada;
                            $reg->save();

                            // guardar registro del pago, partida, idcliente
                            $regCliente = new PartidaRegistroPago();
                            $regCliente->id_registro_pago = $reg->id;
                            $regCliente->id_cliente = $request->idcliente;
                            $regCliente->id_solicitud_partida_nacimiento = $request->idpartida;
                            $regCliente->save();

                            // actualizar estado de la partida a PAGADO
                            SolicitudPartidaNacimiento::where('id', $request->idpartida)
                                ->update(['id_estado_partida' => 5]);

                            DB::commit();

                            return ['success' => 3]; // compra exitosa
                        }else{
                            // revisar los datos de su tarjeta
                            return ['success' => 4];
                        }
                    }
                }
            }

        } catch(\Throwable $e){
            DB::rollback();
            // error
            return [
                'success' => 5
            ];
        }
    }

}
