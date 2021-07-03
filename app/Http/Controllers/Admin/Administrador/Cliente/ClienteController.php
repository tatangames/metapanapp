<?php

namespace App\Http\Controllers\Admin\Administrador\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{

    public function __construct(){
        $this->middleware('auth');

        // aplica a todas las rutas
        $this->middleware('can:vista.grupo.admin.registros.clientes');
    }

    public function index(){
        return view('backend.admin.cliente.index');
    }

    public function indexTabla(){
        $cliente = Cliente::orderBy('fecha', 'ASC')->get();

        // ordenamiento de fecha
        foreach ($cliente as $c){
            $c->fecha = date("d-m-Y h:i A", strtotime($c->fecha));
        }

        return view('backend.admin.cliente.tabla.tablacliente', compact('cliente'));
    }

    // informacion del cliente
    public function informacion(Request $request){
        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = Cliente::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    // editar cliente
    public function editar(Request $request){
        $regla = array(
            'id' => 'required',
            'toggleEstado' => 'required',
            'toggleAcceso' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        Cliente::where('id', $request->id)
            ->update(['acceso' => $request->toggleAcceso,
                    'activo' => $request->toggleEstado]);

        return ['success' => 1];
    }


}
