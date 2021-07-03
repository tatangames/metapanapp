<?php

namespace App\Http\Controllers\Admin\Administrador\Costo;

use App\Http\Controllers\Controller;
use App\Models\Costo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CostoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todas las rutas
        $this->middleware('can:vista.grupo.admin.banco.costos');
    }

    public function index(){
        return view('backend.admin.costo.index');
    }

    public function tablaIndex(){
        $listado = Costo::orderBy('nombre')->get();
        return view('backend.admin.costo.tabla.tablacosto', compact('listado'));
    }


    public function nuevoCosto(Request $request){

        $regla = array(
            'nombre' => 'required',
            'costo' => 'required'
        );

        $validar2 = Validator::make($request->all(), $regla);

        if($validar2->fails()){return ['success' => 0];}

        $costo = new Costo();
        $costo->nombre = $request->nombre;
        $costo->precio = $request->costo;

        if($costo->save()){
            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }


    public function infoCosto(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = Costo::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    public function editarCosto(Request $request){

        $regla = array(
            'id' => 'required',
            'costo' => 'required',
            'nombre' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0]; }

        Costo::where('id', $request->id)
            ->update(['nombre' => $request->nombre,
                'precio' => $request->costo
            ]);

        return ['success' => 1];
    }
}
