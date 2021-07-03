<?php

namespace App\Http\Controllers\Admin\Administrador\RegistroPago;

use App\Http\Controllers\Controller;
use App\Models\RegistroPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegistroPagoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todas las rutas
        $this->middleware('can:vista.grupo.admin.banco.registro-de-pagos');
    }

    public function index(){
        return view('backend.admin.registropago.index');
    }

    public function tablaIndex(){
        $listado = RegistroPago::orderBy('fecha', 'ASC')->get();
        foreach ($listado as $z){
            $z->fecha = date("d-m-Y", strtotime($z->fecha));
        }
        return view('backend.admin.registropago.tabla.tablaregistropago', compact('listado'));
    }

}
