<?php

namespace App\Http\Controllers\Admin\Administrador\Departamento;

use App\Http\Controllers\Controller;
use App\Models\DepartamentoDenuncia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartamentoDenunciaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todas las rutas
        $this->middleware('can:vista.grupo.admin.denuncias.departamento');
    }

    public function index(){
        return view('backend.admin.departamento.index');
    }

    public function tablaIndex(){
        $listado = DepartamentoDenuncia::orderBy('nombre')->get();
        foreach ($listado as $z){
            $z->fecha = date("d-m-Y", strtotime($z->fecha));
        }
        return view('backend.admin.departamento.tabla.tabladepartamento', compact('listado'));
    }

    public function nuevoDepartamento(Request $request){

        $regla = array(
            'nombre' => 'required',
        );

        $validar2 = Validator::make($request->all(), $regla);

        if($validar2->fails()){return ['success' => 0];}


        $de = new DepartamentoDenuncia();
        $de->nombre = $request->nombre;

        if($de->save()){
            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }

    public function infoDepartamento(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = DepartamentoDenuncia::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    public function editarDepartamento(Request $request){

        $regla = array(
            'id' => 'required',
            'nombre' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0]; }

        DepartamentoDenuncia::where('id', $request->id)
            ->update(['nombre' => $request->nombre,
            ]);

        return ['success' => 1];
    }
}
