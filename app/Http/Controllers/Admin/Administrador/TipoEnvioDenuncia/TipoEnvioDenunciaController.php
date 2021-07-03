<?php

namespace App\Http\Controllers\Admin\Administrador\TipoEnvioDenuncia;

use App\Http\Controllers\Controller;
use App\Models\TipoEnvioDenuncia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoEnvioDenunciaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todas las rutas
        $this->middleware('can:vista.grupo.admin.estados.tipo-envio-denuncia');
    }

    public function index(){
        return view('backend.admin.tipoenviodenuncia.index');
    }

    public function tablaIndex(){
        $listado = TipoEnvioDenuncia::orderBy('id', 'ASC')->get();
        return view('backend.admin.tipoenviodenuncia.tabla.tablatipoenviodenuncia', compact('listado'));
    }

    public function infoTipoEnvioDenuncia(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = TipoEnvioDenuncia::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    public function editarTipoEnvioDenuncia(Request $request){

        $regla = array(
            'id' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0]; }

        TipoEnvioDenuncia::where('id', $request->id)
            ->update(['nombre' => $request->nombre,
                'descripcion' => $request->descripcion
            ]);

        return ['success' => 1];
    }
}
