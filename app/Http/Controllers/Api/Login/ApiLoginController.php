<?php

namespace App\Http\Controllers\Api\Login;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Auth;
use Twilio\Rest\Client;
use Exception;

class ApiLoginController extends Controller
{

    // Este metodo puede ser utilizado para jwt, pero como en api.php
    // ya envolvemos el jwt a todas las rutas api que necesitan ser protegida
    // asi que esto no es necesario
    /*public function __construct(){
        Auth::shouldUse('clientes');
    }*/

    // verificar numero telefonico
    public function verificar(Request $request){
        $regla = array('telefono' => 'required');


        $validacion = Validator::make($request->all(), $regla);

        if ($validacion->fails()){return ['success' => 0];}

        // unir area + numero para poder enviar el sms
        $unido = '+503' . $request->telefono;

        // generar codigo sms
        $codigo = '';
        for($i = 0; $i < 6; $i++) {
            $codigo .= mt_rand(0, 9);
        }

        // verificar si existe numero
        if($cliente = Cliente::where('telefono', $unido)->first()){

            // verificar usuario bloqueado
            if($cliente->activo == 0){
                // el usuario esta bloqueado
                return ['success' => 1];
            }

            // verificar si permitimos el acceso sin codigo sms
            if($cliente->acceso == 1){
                // el usuario pasa a pantalla ingresar codigo sms
                // pero aqui podra ingresar cualquier codigo y lo dejara pasar
                return ['success' => 2];
            }else {

                DB::beginTransaction();

                try {

                    // enviar sms y actualizar contador
                    $contador = $cliente->contador + 1;
                    Cliente::where('id', $cliente->id)->update(['contador' => $contador, 'codigo' => $codigo]);

                    if($this->enviarSms($unido, $codigo) == true){
                        DB::commit();
                        return ['success' => 2];
                    }else{
                        return ['success' => 3];
                    }

                }catch(\Throwable $e){
                    DB::rollback();
                    return ['success' => 4];
                }
            }
        }else{

            // cliente aun no registrado
            DB::beginTransaction();

            try {

                $fecha = Carbon::now('America/El_Salvador');

                $c = new Cliente();
                $c->telefono = $request->telefono;
                $c->codigo = $codigo;
                $c->fecha = $fecha;
                $c->activo = 1;
                $c->acceso = 0;
                $c->contador = 1;
                $c->token_signal = $request->fcm;
                $c->save();

                if($this->enviarSms($unido, $codigo) == true){

                    DB::commit();
                    return ['success' => 2];
                }else{
                    return ['success' => 3];
                }

            }catch(\Throwable $e){
                DB::rollback();
                return ['success' => 3];
            }
        }
    }

    // verifica codigo + numero telefonico
    public function login(Request $request){

        $regla = array('telefono' => 'required', 'codigo' => 'required');


        $validacion = Validator::make($request->all(), $regla);

        if ($validacion->fails()){return ['success' => 0];}

        if($cliente = Cliente::where('telefono', $request->telefono)->first()){

            if($cliente->activo == 0){

                // el cliente esta bloqueado
                return ['success' => 1];
            }

            // un admin le dio acceso a este telefono, podra colocar cualquier codigo
            // y permitira su acceso
            if($cliente->acceso == 1){

                // actualizar token
                Cliente::where('id', $cliente->id)
                    ->update(['token_signal' => $request->fcm]);

                // generar token y devolver datos del usuario
                $token = JWTAuth::fromUser($cliente);

                return [
                    'success' => 2,
                    'id' => $cliente->id,
                    'token' => $token
                ];
            }else{

                // verificar telefono y codigo enviado por sms
                if(Cliente::where('telefono', $request->telefono)->where('codigo', $request->codigo)->first()){

                    // actualizar token
                    Cliente::where('id', $cliente->id)
                        ->update(['token_signal' => $request->fcm]);

                    // generar token y devolver datos del usuario
                    $token = JWTAuth::fromUser($cliente);

                    return [
                        'success' => 2,
                        'id' => $cliente->id,
                        'token' => $token
                    ];

                }else{
                    // codigo incorrecto
                    return ['success' => 3];
                }
            }

        }else{
            // cliente no encontrado
            return ['success' => 4];
        }
    }

    // cuando el cliente quiere reenviar el sms
    public function reenviar(Request $request){

        $regla = array('telefono' => 'required');

        $validacion = Validator::make($request->all(), $regla);

        if ($validacion->fails()){return ['success' => 0];}

        // unir area + numero para poder enviar el sms
        $unido = '+503' . $request->telefono;

        if($cliente = Cliente::where('telefono', $unido)->first()){

            if($cliente->activo == 0){
                // el cliente esta bloqueado
                return ['success' => 1];
            }

            // verificar si permitimos el acceso sin codigo sms, dado por un admin
            if($cliente->acceso == 1){

                $token = JWTAuth::fromUser($cliente);
                return [
                    'success' => 2,
                    'id' => $cliente->id,
                    'token' => $token
                ];
            }else {
                DB::beginTransaction();

                try {

                    // enviar sms y actualizar contador
                    $contador = $cliente->contador + 1;
                    Cliente::where('id', $cliente->id)->update(['contador' => $contador]);

                    if($this->enviarSms($unido, $cliente->codigo) == true){
                        DB::commit();
                        return ['success' => 3];
                    }else{
                        return ['success' => 4];
                    }

                }catch(\Throwable $e){
                    DB::rollback();
                    return ['success' => 4];
                }
            }
        }else{
            // cliente no encontrado
            return ['success' => 5];
        }
    }


    private function enviarSms($numero, $codigo){

        // las llaves se obtienen de config/twiliokey.php

        /*$sid = config('twiliokey.Twilio_SID');
        $token = config('twiliokey.Twilio_TOKEN');
        $twilioNumber = config('twiliokey.Twilio_NUMBER');
        $client = new Client($sid, $token);

        try {
            $client->account->messages->create(
                $numero,
                array(
                    'from' =>  $twilioNumber,
                    'body' =>'Tu codigo es: '.$codigo
                )
            );

            return true;
        } catch (Exception  $e) {
            return false;
        }*/
        return true;
    }
}
