<?php

namespace App\Http\Controllers\Admin\Administrador\ServicioAlcaldia;

use App\Http\Controllers\Controller;
use App\Models\ServicioAlcaldia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ServicioAlcaldiaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todas las rutas
        $this->middleware('can:vista.grupo.admin.servicios.servicios-alcaldia');
    }

    public function index(){
        return view('backend.admin.servicioalcaldia.index');
    }

    public function tablaIndex(){
        $listado = ServicioAlcaldia::orderBy('posicion')->get();
        foreach ($listado as $z){
            $z->fecha = date("d-m-Y", strtotime($z->fecha));
        }
        return view('backend.admin.servicioalcaldia.tabla.tablaservicioalcaldia', compact('listado'));
    }

    public function nuevoServicioAlcaldia(Request $request){

        $regla = array(
            'nombre' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if($validar->fails()){return ['success' => 0];}

        if($request->hasFile('imagen')) {

            $regla2 = array(
                'imagen' => 'required|image',
            );

            $validar2 = Validator::make($request->all(), $regla2);

            if ( $validar2->fails()){ return ['success' => 0]; }

            $cadena = Str::random(16);
            $tiempo = microtime();
            $union = $cadena . $tiempo;
            $nombre = str_replace(' ', '_', $union);

            $extension = '.' . $request->imagen->getClientOriginalExtension();
            $nombreFoto = $nombre . strtolower($extension);
            $avatar = $request->file('imagen');
            $upload = Storage::disk('imagenes')->put($nombreFoto, \File::get($avatar));

            if ($upload) {
                $fecha = Carbon::now('America/El_Salvador');

                $ts = new ServicioAlcaldia();
                $ts->nombre = $request->nombre;
                $ts->imagen = $nombreFoto;
                $ts->activo = 0;
                $ts->visible = 0;
                $ts->posicion = 1;
                $ts->fecha = $fecha;

                if($ts->save()){
                    return ['success' => 1];
                }else{
                    return ['success' => 2];
                }

            } else {
                return ['success' => 2];
            }
        }else{
            return ['success' => 2];
        }
    }

    public function infoServicioAlcaldia(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = ServicioAlcaldia::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $data];
        }else{
            return ['success' => 2];
        }
    }

    public function editarServicioAlcaldia(Request $request){

        $regla = array(
            'id' => 'required',
            'nombre' => 'required',
            'toggleactivo' => 'required',
            'togglevisible' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0]; }

        // validar imagen
        if($request->hasFile('imagen')){

            $regla2 = array(
                'imagen' => 'required|image',
            );

            $validar2 = Validator::make($request->all(), $regla2);

            if($validar2->fails()){ return ['success' => 0]; }

            $cadena = Str::random(16);
            $tiempo = microtime();
            $union = $cadena.$tiempo;
            $nombre = str_replace(' ', '_', $union);

            $extension = '.'.$request->imagen->getClientOriginalExtension();
            $nombreFoto = $nombre.strtolower($extension);
            $avatar = $request->file('imagen');

            // guardar imagen
            $upload = Storage::disk('imagenes')->put($nombreFoto, \File::get($avatar));

            if($upload){

                // para borrar imagen anterior del disco
                $imagenOld = ServicioAlcaldia::where('id', $request->id)->pluck('imagen')->first();

                ServicioAlcaldia::where('id', $request->id)
                    ->update(['nombre' => $request->nombre,
                        'visible' => $request->togglevisible,
                        'activo' => $request->toggleactivo,
                        'imagen' => $nombreFoto
                    ]);

                // borrar foto anterior
                if(Storage::disk('imagenes')->exists($imagenOld)){
                    Storage::disk('imagenes')->delete($imagenOld);
                }

                return ['success' => 1];
            }else{
                return ['success' => 2];
            }

        }else{

            ServicioAlcaldia::where('id', $request->id)
                ->update(['nombre' => $request->nombre,
                    'visible' => $request->togglevisible,
                    'activo' => $request->toggleactivo,
                ]);

            return ['success' => 1];
        }
    }

    // modifica la posicion de los tipo servicio
    public function posicionServicioAlcaldia(Request $request){

        foreach ($request->order as $order) {

            $tipoid = $order['id'];

            ServicioAlcaldia::where('id', $tipoid)
                ->update(['posicion' => $order['posicion']]);
        }

        return ['success' => 1];
    }
}
