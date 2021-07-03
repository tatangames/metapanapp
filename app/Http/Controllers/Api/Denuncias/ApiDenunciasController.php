<?php

namespace App\Http\Controllers\Api\Denuncias;

use App\Http\Controllers\Controller;

use App\Models\DenunciaRealizada;
use App\Models\DenunciaRealizadaMultiple;
use App\Models\ListaDenuncias;
use App\Models\ListaDenunciasMultiple;
use App\Models\Zona;
use App\Models\ZonaPoligono;
use Carbon\Carbon;
use GeometryLibrary\PolyUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiDenunciasController extends Controller
{

    // Este metodo puede ser utilizado para jwt, pero como en api.php
    // ya envolvemos el jwt a todas las rutas api que necesitan ser protegida
    // asi que esto no es necesario
    /*public function __construct(){
        Auth::shouldUse('clientes');
    }*/

    // obtener todas las denuncias visibles
    public function infoDenuncias(){
        // unicamente los visible, si esta inactivo mostrara el mensaje de inactividad
        // estado_envio funciona para ver como enviar la denuncia
        // (directo, nota + imagen, multiple opcion)

        $msgMensajeDenuncia = "Inactivo ahorita";
        $msgActualizarApp = "Actualizar la App para poder usar este servicio. Gracias.";
        $msgZonaInvalida = "Esta zona no es en Metapan";

        $data = ListaDenuncias::where('visible', '1')
            ->orderBy('posicion', 'ASC')
            ->get();

        return ['success' => 1, 'info' => $data,
            'mensaje_inactivo' => $msgMensajeDenuncia,
            'mensaje_actualizar' => $msgActualizarApp,
            'zona_invalida' => $msgZonaInvalida];
    }

    // denuncia version 1 (directa)
    public function ingresarDenunciaV1(Request $request){

        $rules = array(
            'iddenuncia' => 'required',
            'idcliente' => 'required',
            'latitud' => 'required',
            'longitud' => 'required'
        );

        $messages = array(
            'iddenuncia.required' => 'ID denuncia es requerido',
            'idcliente.required' => 'ID cliente es requerido',
            'latitud.required' => 'Latitud es requerido',
            'longitud.required' => 'Longitud es requerido',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ( $validator->fails()){
            return ['success' => 0];
        }

        // verificar si la denuncia puede entrar en la Zona

        $zonas = Zona::where('activo', 1)->get();
        foreach ($zonas as $z){
            $pila = array();
            $poligono = ZonaPoligono::where('id_zona', $z->id)->get();

            foreach ($poligono as $p){
                array_push($pila, ['lat' => $p->latitud, 'lng' => $p->longitud]);
            }

            $punto = ['lat' => $request->latitud, 'lng' => $request->longitud];

            $response =  PolyUtil::containsLocation($punto, $pila);

            if($response == 1){

                $fecha = Carbon::now('America/El_Salvador');

                $d = new DenunciaRealizada();
                $d->id_cliente = $request->idcliente;
                $d->id_zona = $z->id;
                $d->id_estado = 1; // Pendiente
                $d->id_denuncia = $request->iddenuncia;
                $d->fecha = $fecha;
                $d->latitud = $request->latitud;
                $d->longitud = $request->longitud;
                $d->imagen = '';
                $d->descripcion = '';
                $d->visible_cliente = 1; // cliente podre ver su propia denuncia

                if($d->save()){
                    return ['success' => 2];
                }
                return ['success' => 3];

            }else{
                // la denuncia no se esta siendo dentro de una zona valida
                return ['success' => 1];
            }
        }

        // Sino hay ninguna zona activa
        return ['success' => 1];
    }

    // registar denuncia con foto + descripcion | opciona
    public function ingresarDenunciaV2(Request $request){

        $rules = array(
            'iddenuncia' => 'required',
            'idcliente' => 'required',
            'latitud' => 'required',
            'longitud' => 'required'
        );

        $messages = array(
            'iddenuncia.required' => 'ID denuncia es requerido',
            'idcliente.required' => 'ID cliente es requerido',
            'latitud.required' => 'Latitud es requerido',
            'longitud.required' => 'Longitud es requerido',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ( $validator->fails()){
            return ['success' => 0];
        }

        // verificar si la denuncia puede entrar en la Zona

        $zonas = Zona::where('activo', 1)->get();
        foreach ($zonas as $z){
            $pila = array();
            $poligono = ZonaPoligono::where('id_zona', $z->id)->get();

            foreach ($poligono as $p){
                array_push($pila, ['lat' => $p->latitud, 'lng' => $p->longitud]);
            }

            $punto = ['lat' => $request->latitud, 'lng' => $request->longitud];

            $response =  PolyUtil::containsLocation($punto, $pila);

            if($response == 1){

                if($request->file('image')){

                    $cadena = Str::random(15);
                    $tiempo = microtime();
                    $union = $cadena . $tiempo;
                    $nombre = str_replace(' ', '_', $union);

                    // por defecto la extension sera .jpg
                    $nombreFoto = $nombre . strtolower('.jpg');
                    $avatar = $request->file('image');
                    $upload = Storage::disk('imagenes')->put($nombreFoto, \File::get($avatar));

                    if ($upload) {
                        // registrar denuncia
                        $fecha = Carbon::now('America/El_Salvador');

                        $d = new DenunciaRealizada();
                        $d->id_cliente = $request->idcliente;
                        $d->id_zona = $z->id;
                        $d->id_estado = 1; // Pendiente
                        $d->id_denuncia = $request->iddenuncia;
                        $d->fecha = $fecha;
                        $d->latitud = $request->latitud;
                        $d->longitud = $request->longitud;
                        $d->imagen = $nombreFoto;
                        $d->descripcion = $request->descripcion;
                        $d->visible_cliente = 1; // cliente podre ver su propia denuncia

                        if($d->save()){
                            // guardado correctamente
                            return ['success' => 1];
                        }else{
                            // no se guardo el registro
                            return ['success' => 2];
                        }

                    } else {
                        // error al subir imagen
                        return ['success' => 3];
                    }
                }else{
                    // guardar denuncia sin imagen
                    $fecha = Carbon::now('America/El_Salvador');

                    $d = new DenunciaRealizada();
                    $d->id_cliente = $request->idcliente;
                    $d->id_zona = $z->id;
                    $d->id_estado = 1; // Pendiente
                    $d->id_denuncia = $request->iddenuncia;
                    $d->fecha = $fecha;
                    $d->latitud = $request->latitud;
                    $d->longitud = $request->longitud;
                    $d->descripcion = $request->descripcion;
                    $d->visible_cliente = 1; // cliente podre ver su propia denuncia

                    if($d->save()){
                        // guardado correctamente
                        return ['success' => 1];
                    }else{
                        // no se guardo el registro
                        return ['success' => 2];
                    }
                }
            }else{
                // la denuncia no se esta siendo dentro de una zona valida
                return ['success' => 4];
            }
        }

        // en caso que ninguna zona este activa
        // la denuncia no se esta siendo dentro de una zona valida
        return ['success' => 4];
    }

    public function infoDenunciaMultiple(Request $request){

        $rules = array(
            'iddenuncia' => 'required'
        );

        $messages = array(
            'iddenuncia.required' => 'ID denuncia es requerido'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ( $validator->fails()){
            return ['success' => 0];
        }

        if(ListaDenuncias::where('id', $request->iddenuncia)->first()){

            $data = ListaDenunciasMultiple::where('id_lista_denuncias', $request->iddenuncia)
                ->orderBy('posicion', 'ASC')
                ->get();

            $msgActualizar = "Actualizar la App para poder usar este servicio. Gracias.";
            $msgZonaInvalida = "Esta zona no es en Metapan";

            return ['success' => 1,
                'info' => $data,
                'mensaje_actualizar' => $msgActualizar,
                'zona_invalida' => $msgZonaInvalida];
        }else{
            return ['success' => 2];
        }
    }

    public function ingresarDenunciaMultipleV1(Request $request){

        $rules = array(
            'iddenuncia' => 'required',
            'iddenunciamultiple' => 'required',
            'idcliente' => 'required',
            'latitud' => 'required',
            'longitud' => 'required'
        );

        $messages = array(
            'iddenuncia.required' => 'ID denuncia es requerido',
            'iddenunciamultiple.required' => 'ID denuncia multiple es requerido',
            'idcliente.required' => 'ID cliente es requerido',
            'latitud.required' => 'Latitud es requerido',
            'longitud.required' => 'Longitud es requerido',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ( $validator->fails()){
            return ['success' => 0];
        }

        // verificar si la denuncia puede entrar en la Zona

        $zonas = Zona::where('activo', 1)->get();
        foreach ($zonas as $z){
            $pila = array();
            $poligono = ZonaPoligono::where('id_zona', $z->id)->get();

            foreach ($poligono as $p){
                array_push($pila, ['lat' => $p->latitud, 'lng' => $p->longitud]);
            }

            $punto = ['lat' => $request->latitud, 'lng' => $request->longitud];

            $response =  PolyUtil::containsLocation($punto, $pila);

            if($response == 1){

                $fecha = Carbon::now('America/El_Salvador');

                $d = new DenunciaRealizada();
                $d->id_cliente = $request->idcliente;
                $d->id_zona = $z->id;
                $d->id_estado = 1; // Pendiente
                $d->id_denuncia = $request->iddenuncia;
                $d->fecha = $fecha;
                $d->latitud = $request->latitud;
                $d->longitud = $request->longitud;
                $d->descripcion = '';
                $d->visible_cliente = 1; // cliente podre ver su propia denuncia

                if($d->save()){
                    return ['success' => 2];
                }else{
                    return ['success' => 3];
                }

            }else{
                // la denuncia no se esta siendo dentro de una zona valida
                return ['success' => 1];
            }
        }

        // en caso que ninguna zona esta activa
        // la denuncia no se esta siendo dentro de una zona valida
        return ['success' => 1];
    }

    public function ingresarDenunciaMultipleV2(Request $request){

        $rules = array(
            'iddenuncia' => 'required',
            'iddenunciamultiple' => 'required',
            'idcliente' => 'required',
            'latitud' => 'required',
            'longitud' => 'required'
        );

        $messages = array(
            'iddenuncia.required' => 'ID denuncia es requerido',
            'iddenunciamultiple.required' => 'ID denuncia multiple es requerido',
            'idcliente.required' => 'ID cliente es requerido',
            'latitud.required' => 'Latitud es requerido',
            'longitud.required' => 'Longitud es requerido',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ( $validator->fails()){
            return ['success' => 0];
        }

        // verificar si la denuncia puede entrar en la Zona

        $zonas = Zona::where('activo', 1)->get();
        foreach ($zonas as $z){
            $pila = array();
            $poligono = ZonaPoligono::where('id_zona', $z->id)->get();

            foreach ($poligono as $p){
                array_push($pila, ['lat' => $p->latitud, 'lng' => $p->longitud]);
            }

            $punto = ['lat' => $request->latitud, 'lng' => $request->longitud];

            $response =  PolyUtil::containsLocation($punto, $pila);

            if($response == 1){

                if($request->file('image')){

                    $cadena = Str::random(15);
                    $tiempo = microtime();
                    $union = $cadena . $tiempo;
                    $nombre = str_replace(' ', '_', $union);

                    // por defecto la extension sera .jpg
                    $nombreFoto = $nombre . strtolower('.jpg');
                    $avatar = $request->file('image');
                    $upload = Storage::disk('imagenes')->put($nombreFoto, \File::get($avatar));

                    if ($upload) {
                        // registrar denuncia
                        $fecha = Carbon::now('America/El_Salvador');

                        $d = new DenunciaRealizada();
                        $d->id_cliente = $request->idcliente;
                        $d->id_zona = $z->id;
                        $d->id_estado = 1; // Pendiente
                        $d->id_denuncia = $request->iddenuncia;
                        $d->fecha = $fecha;
                        $d->latitud = $request->latitud;
                        $d->longitud = $request->longitud;
                        $d->imagen = $nombreFoto;
                        $d->descripcion = $request->descripcion;
                        $d->visible_cliente = 1;

                        if($d->save()){
                            // guardado correctamente

                            // guardar el tipo de denuncia multiple
                            $m = new DenunciaRealizadaMultiple();
                            $m->id_denuncia_realizada = $d->id;
                            $m->id_lista_denuncias_multiple = $request->iddenunciamultiple;

                            if($m->save()){
                                return ['success' => 1];
                            }else{
                                return ['success' => 2];
                            }

                        }else{
                            // no se guardo el registro
                            return ['success' => 2];
                        }

                    } else {
                        // error al subir imagen
                        return ['success' => 3];
                    }
                }else{
                    // guardar denuncia sin imagen
                    $fecha = Carbon::now('America/El_Salvador');

                    $d = new DenunciaRealizada();
                    $d->id_cliente = $request->idcliente;
                    $d->id_zona = $z->id;
                    $d->id_estado = 1; // Pendiente
                    $d->id_denuncia = $request->iddenuncia;
                    $d->fecha = $fecha;
                    $d->latitud = $request->latitud;
                    $d->longitud = $request->longitud;
                    $d->descripcion = $request->descripcion;
                    $d->visible_cliente = 1;

                    if($d->save()){

                        // guardar el tipo de denuncia multiple
                        $m = new DenunciaRealizadaMultiple();
                        $m->id_denuncia_realizada = $d->id;
                        $m->id_lista_denuncias_multiple = $request->iddenunciamultiple;

                        if($m->save()){
                            return ['success' => 1];
                        }else{
                            return ['success' => 2];
                        }
                    }else{
                        // no se guardo el registro
                        return ['success' => 2];
                    }
                }
            }else{
                // la denuncia no se esta siendo dentro de una zona valida
                return ['success' => 4];
            }
        }

        // en caso que ninguna zona esta activa
        // la denuncia no se esta siendo dentro de una zona valida
        return ['success' => 4];
    }



}
