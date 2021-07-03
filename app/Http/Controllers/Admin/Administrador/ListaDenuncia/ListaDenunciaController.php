<?php

namespace App\Http\Controllers\Admin\Administrador\ListaDenuncia;

use App\Http\Controllers\Controller;
use App\Models\DepartamentoDenuncia;
use App\Models\ListaDenuncias;
use App\Models\ListaDenunciasMultiple;
use App\Models\TipoEnvioDenuncia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ListaDenunciaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

        // aplica a todas las rutas
        $this->middleware('can:vista.grupo.admin.denuncias.lista-denuncias');
    }

    public function index(){
        $denuncia = TipoEnvioDenuncia::orderBy('id', 'ASC')->get();
        $departamento = DepartamentoDenuncia::orderBy('nombre')->get();
        return view('backend.admin.listadenuncia.index', compact('denuncia', 'departamento'));
    }

    public function tablaIndex(){
        $listado = ListaDenuncias::orderBy('posicion')->get();

        foreach ($listado as $z){
            $z->fecha = date("d-m-Y", strtotime($z->fecha));
            $nombre = TipoEnvioDenuncia::where('id', $z->id_tipo_envio_denuncia)->pluck('nombre')->first();
            $z->nombreestado = $nombre;
        }

        return view('backend.admin.listadenuncia.tabla.tablalistadenuncia', compact('listado'));
    }

    public function nuevoListaDenuncia(Request $request){

        $regla = array(
            'nombre' => 'required',
            'tipodenuncia' => 'required',
            'departamento' => 'required'
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

                $ts = new ListaDenuncias();
                $ts->nombre = $request->nombre;
                $ts->descripcion = $request->descripcion;
                $ts->id_tipo_envio_denuncia = $request->tipodenuncia;
                $ts->imagen = $nombreFoto;
                $ts->id_departamento_denuncia = $request->departamento;
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

    public function infoListaDenuncia(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = ListaDenuncias::where('id', $request->id)->first()){

            $tipo = TipoEnvioDenuncia::all();
            $departamento = DepartamentoDenuncia::orderBy('nombre')->get();

            return ['success' => 1, 'info' => $data,
                'tipo' => $tipo, 'tipo2' => $departamento];
        }else{
            return ['success' => 2];
        }
    }

    public function editarListaDenuncia(Request $request){

        $regla = array(
            'id' => 'required',
            'nombre' => 'required',
            'toggleactivo' => 'required',
            'togglevisible' => 'required',
            'tipodenuncia' => 'required',
            'departamento' => 'required'
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
                $imagenOld = ListaDenuncias::where('id', $request->id)->pluck('imagen')->first();

                ListaDenuncias::where('id', $request->id)
                    ->update(['nombre' => $request->nombre,
                        'descripcion' => $request->descripcion,
                        'id_tipo_envio_denuncia' => $request->tipodenuncia,
                        'id_departamento_denuncia' => $request->departamento,
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

            ListaDenuncias::where('id', $request->id)
                ->update(['nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'id_tipo_envio_denuncia' => $request->tipodenuncia,
                    'id_departamento_denuncia' => $request->departamento,
                    'visible' => $request->togglevisible,
                    'activo' => $request->toggleactivo,
                ]);

            return ['success' => 1];
        }
    }

    // modifica la posicion de los tipo servicio
    public function posicionListaDenuncia(Request $request){

        foreach ($request->order as $order) {

            $tipoid = $order['id'];

            ListaDenuncias::where('id', $tipoid)
                ->update(['posicion' => $order['posicion']]);
        }

        return ['success' => 1];
    }

    // ********** MULTIPLES OPCIONES *************

    public function indexMultipleOpciones($id){
        $denuncia = TipoEnvioDenuncia::orderBy('id', 'ASC')
            ->whereNotIn('id', [3]) // No mostrar la de multiple opciones
            ->get();

        $nombre = ListaDenuncias::where('id', $id)->pluck('nombre')->first();

        return view('backend.admin.listadenuncia.multiple.index', compact('id', 'denuncia', 'nombre'));
    }

    public function tablaIndexMultiple($id){

        $listado = ListaDenunciasMultiple::where('id_lista_denuncias', $id)
            ->orderBy('posicion', 'ASC')
            ->get();

        foreach ($listado as $z){
            $z->fecha = date("d-m-Y", strtotime($z->fecha));
            $nombre = TipoEnvioDenuncia::where('id', $z->id_tipo_envio_denuncia)->pluck('nombre')->first();
            $z->nombreestado = $nombre;
        }

        return view('backend.admin.listadenuncia.multiple.tabla.tablamultiple', compact('listado'));
    }

    public function nuevoListaDenunciaMultiple(Request $request){

        $regla = array(
            'nombre' => 'required',
            'tipodenuncia' => 'required'
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

                $ts = new ListaDenunciasMultiple();
                $ts->nombre = $request->nombre;
                $ts->descripcion = $request->descripcion;
                $ts->id_tipo_envio_denuncia = $request->tipodenuncia;
                $ts->id_lista_denuncias = $request->iddenuncia;
                $ts->imagen = $nombreFoto;
                $ts->activo = 0;
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

    public function infoListaDenunciaMultiple(Request $request){

        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){return ['success' => 0];}

        if($data = ListaDenunciasMultiple::where('id', $request->id)->first()){

            $tipo = TipoEnvioDenuncia::orderBy('id', 'ASC')
                ->whereNotIn('id', [3]) // No mostrar la de multiple opciones
                ->get();

            return ['success' => 1, 'info' => $data, 'tipo' => $tipo];
        }else{
            return ['success' => 2];
        }
    }

    public function editarListaDenunciaMultiple(Request $request){

        $regla = array(
            'id' => 'required',
            'nombre' => 'required',
            'toggleactivo' => 'required',
            'tipodenuncia' => 'required'
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
                $imagenOld = ListaDenunciasMultiple::where('id', $request->id)->pluck('imagen')->first();

                ListaDenunciasMultiple::where('id', $request->id)
                    ->update(['nombre' => $request->nombre,
                        'descripcion' => $request->descripcion,
                        'id_tipo_envio_denuncia' => $request->tipodenuncia,
                        'id_lista_denuncias' => $request->iddenuncia,
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

            ListaDenunciasMultiple::where('id', $request->id)
                ->update(['nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'id_tipo_envio_denuncia' => $request->tipodenuncia,
                    'id_lista_denuncias' => $request->iddenuncia,
                    'activo' => $request->toggleactivo,
                ]);

            return ['success' => 1];
        }
    }

    // modifica la posicion de los tipo servicio
    public function posicionListaDenunciaMultiple(Request $request){

        foreach ($request->order as $order) {

            $tipoid = $order['id'];

            ListaDenunciasMultiple::where('id', $tipoid)
                ->update(['posicion' => $order['posicion']]);
        }

        return ['success' => 1];
    }

}
