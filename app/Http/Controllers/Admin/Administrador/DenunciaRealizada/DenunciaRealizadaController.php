<?php

namespace App\Http\Controllers\Admin\Administrador\DenunciaRealizada;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\DenunciaRealizada;
use App\Models\DenunciaRealizadaMultiple;
use App\Models\EstadoDenuncia;
use App\Models\ListaDenuncias;
use App\Models\ListaDenunciasMultiple;
use App\Models\TipoEnvioDenuncia;
use App\Models\Zona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DenunciaRealizadaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todas las rutas
        $this->middleware('can:vista.grupo.admin.denuncias.denuncias-realizadas');
    }

    public function index(){
        return view('backend.admin.denunciarealizada.index');
    }

    public function tablaIndex(){
        $listado = DenunciaRealizada::orderBy('fecha', 'ASC')->get();
        foreach ($listado as $z){
            $z->fecha = date("d-m-Y h:i A", strtotime($z->fecha));
            $zona = Zona::where('id', $z->id_zona)->pluck('nombre')->first();
            $tel = Cliente::where('id', $z->id_cliente)->pluck('telefono')->first();
            $estado = EstadoDenuncia::where('id', $z->id_denuncia)->pluck('nombre_web')->first();
            $infoDenuncia = ListaDenuncias::where('id', $z->id_denuncia)->first();
            $tipoDenuncia = TipoEnvioDenuncia::where('id', $infoDenuncia->id_tipo_envio_denuncia)->first();

            $multiple = 0;
            if(DenunciaRealizadaMultiple::where('id_denuncia_realizada', $z->id)->first()){
                $multiple = 1;
            }

            $z->telefono = $tel;
            $z->zona = $zona;
            $z->estado = $estado;
            $z->multiple = $multiple;
            $z->nombredenuncia = $infoDenuncia->nombre;
            $z->tipodenuncia = $tipoDenuncia->nombre;
        }
        return view('backend.admin.denunciarealizada.tabla.tabladenunciarealizada', compact('listado'));
    }

    // NOTA: 03/07/2021
    // CAMBIAR API GOOGLE (porque puedo borrarla de mi cuenta jeje )
    public function mapaUbicacionDenuncia($id){

        $mapa = DenunciaRealizada::where('id', $id)->first();
        $api = "AIzaSyB-Iz6I6GtO09PaXGSQxZCjIibU_Li7yOM";

        $latitud = $mapa->latitud;
        $longitud = $mapa->longitud;

        return view('backend.admin.denunciarealizada.mapa.ubicacion', compact('latitud', 'longitud', 'api'));
    }

    // informacion opciones multiple
    public function infoMultipleOpcion(Request $request){
        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = DenunciaRealizadaMultiple::where('id_denuncia_realizada', $request->id)->first()){

            $info = ListaDenunciasMultiple::where('id', $data->id_lista_denuncias_multiple)->first();

            return ['success' => 1, 'nombre' => $info->nombre,
                'descripcion' => $info->descripcion];
        }else{
            return ['success' => 2];
        }
    }

}
