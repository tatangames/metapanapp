<?php

namespace App\Http\Controllers\Admin\Administrador\EstadoPartida;

use App\Http\Controllers\Controller;
use App\Models\EstadoPartida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstadoPartidaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todas las rutas
        $this->middleware('can:vista.grupo.admin.estados.estado-partida');
    }

    public function index(){
        return view('backend.admin.estadopartida.index');
    }

    public function tablaIndex(){
        $listado = EstadoPartida::orderBy('id', 'ASC')->get();
        return view('backend.admin.estadopartida.tabla.tablaestadopartida', compact('listado'));
    }

    public function infoEstadoPartida(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = EstadoPartida::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    public function editarEstadoPartida(Request $request){

        $regla = array(
            'id' => 'required',
            'nombreapi' => 'required',
            'nombreweb' => 'required',
            'descripcion' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0]; }

        EstadoPartida::where('id', $request->id)
            ->update(['nombre_api' => $request->nombreapi,
                'nombre_web' => $request->nombreweb,
                'descripcion' => $request->descripcion
            ]);

        return ['success' => 1];
    }
}
