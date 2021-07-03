<?php

namespace App\Http\Controllers\Admin\Administrador\Zona;

use App\Http\Controllers\Controller;
use App\Models\Zona;
use App\Models\ZonaPoligono;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ZonaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todas las rutas
        $this->middleware('can:vista.grupo.admin.zona-mapa.zonas');
    }

    public function index(){
        return view('backend.admin.zona.index');
    }

    public function tablaIndex(){
        $listado = Zona::orderBy('nombre')->get();
        foreach ($listado as $z){
            $z->fecha = date("d-m-Y", strtotime($z->fecha));
        }
        return view('backend.admin.zona.tabla.tablazona', compact('listado'));
    }

    public function nuevaZona(Request $request){

        $regla = array(
            'nombre' => 'required',
            'latitud' => 'required',
            'longitud' => 'required'
        );

        $validar2 = Validator::make($request->all(), $regla);

        if($validar2->fails()){return ['success' => 0];}

        $fecha = Carbon::now('America/El_Salvador');

        $zona = new Zona();
        $zona->nombre = $request->nombre;
        $zona->latitud = $request->latitud;
        $zona->longitud = $request->longitud;
        $zona->activo = 1;
        $zona->fecha = $fecha;

        if($zona->save()){
            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }

    public function infoZona(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = Zona::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    public function editarZona(Request $request){

        $regla = array(
            'id' => 'required',
            'nombre' => 'required',
            'latitud' => 'required',
            'longitud' => 'required',
            'toggle' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0]; }

        Zona::where('id', $request->id)
            ->update(['nombre' => $request->nombre,
                'latitud' => $request->latitud,
                'longitud' => $request->longitud,
                'activo' => $request->toggle,
            ]);

        return ['success' => 1];
    }

    public function mapa($id){
        $poligono = ZonaPoligono::where('id_zona', $id)->get();
        return view('backend.admin.zona.mapa.index', compact('poligono'));
    }
}
