<?php

namespace App\Http\Controllers\Admin\Administrador\Banco;

use App\Http\Controllers\Controller;
use App\Models\Banco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BancoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todas las rutas
        $this->middleware('can:vista.grupo.admin.banco.banco-estado');
    }

    public function index(){
        return view('backend.admin.banco.index');
    }

    public function tablaIndex(){
        $listado = Banco::all();
        return view('backend.admin.banco.tabla.tablabanco', compact('listado'));
    }

    public function infoBanco(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = Banco::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    public function editarBanco(Request $request){

        $regla = array(
            'id' => 'required',
            'comision' => 'required',
            'toggle' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0]; }

        Banco::where('id', $request->id)
            ->update(['comision' => $request->comision,
                'activo' => $request->toggle
            ]);

        return ['success' => 1];
    }
}
