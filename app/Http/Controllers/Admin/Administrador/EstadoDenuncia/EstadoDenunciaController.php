<?php

namespace App\Http\Controllers\Admin\Administrador\EstadoDenuncia;

use App\Http\Controllers\Controller;
use App\Models\EstadoDenuncia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstadoDenunciaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todas las rutas
        $this->middleware('can:vista.grupo.admin.estados.estado-denuncia');
    }

    public function index(){
        return view('backend.admin.estadodenuncia.index');
    }

    public function tablaIndex(){
        $listado = EstadoDenuncia::orderBy('id', 'ASC')->get();
        return view('backend.admin.estadodenuncia.tabla.tablaestadodenuncia', compact('listado'));
    }

    public function infoEstadoDenuncia(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = EstadoDenuncia::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    public function editarEstadoDenuncia(Request $request){

        $regla = array(
            'id' => 'required',
            'nombreapi' => 'required',
            'nombreweb' => 'required',
            'descripcion' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0]; }

        EstadoDenuncia::where('id', $request->id)
            ->update(['nombre_api' => $request->nombreapi,
                'nombre_web' => $request->nombreweb,
                'descripcion' => $request->descripcion
            ]);

        return ['success' => 1];
    }
}
