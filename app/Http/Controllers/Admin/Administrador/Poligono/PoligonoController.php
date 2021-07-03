<?php

namespace App\Http\Controllers\Admin\Administrador\Poligono;

use App\Http\Controllers\Controller;
use App\Models\Zona;
use App\Models\ZonaPoligono;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PoligonoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todas las rutas
        $this->middleware('can:vista.grupo.admin.zona-mapa.zonas');
    }

    public function index($id){
        $nombre = Zona::where('id', $id)->pluck('nombre')->first();
        return view('backend.admin.zona.poligono.index', compact('nombre', 'id'));
    }

    public function nuevoPoligono(Request $request){

        $regla = array(
            'id' => 'required',
            'latitud' => 'required|array',
            'longitud' => 'required|array',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        for ($i = 0; $i < count($request->latitud); $i++) {

            $ingreso = new ZonaPoligono();
            $ingreso->id_zona = $request->id;
            $ingreso->latitud = $request->latitud[$i];
            $ingreso->longitud = $request->longitud[$i];
            $ingreso->save();
        }

        return ['success' => 1];
    }

    public function borrarPoligonos(Request $request){

        $rules = array(
            'id' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){ return ['success' => 0]; }

        ZonaPoligono::where('id_zona', $request->id)->delete();

        return ['success'=> 1];
    }

}
