<?php

namespace App\Http\Controllers\Admin\Administrador\Notificaciones;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use OneSignal;

class NotificacionesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todas las rutas
        $this->middleware('can:vista.grupo.admin.servicios.notificaciones');
    }

    public function index(){
        return view('backend.admin.notificaciones.index');
    }

    function envioNotificacionTelefono(Request $request){

        // validaciones para los datos
        $reglaDatos = array(
            'telefono' => 'required',
            'titulo' => 'required',
            'mensaje' => 'required'
        );

        $validarDatos = Validator::make($request->all(), $reglaDatos);

        if($validarDatos->fails()){return ['success' => 0];}

        if($data = Cliente::where('telefono', $request->telefono)->first()){

            if($data->token_signal == null || $data->token_signal == "0000"){
                return ['success' => 1];
            }

            try {
                $this->envioNoticacionCliente($request->titulo, $request->mensaje, $data->token_signal);

                return ['success' => 2];
            } catch (Exception $e) {
                return ['success' => 3];
            }

        }else{
            return ['success' => 4];
        }
    }

    public function envioNoticacionCliente($titulo, $mensaje, $pilaUsuarios){
        OneSignal::notificacionCliente($titulo, $mensaje, $pilaUsuarios);
    }


}
