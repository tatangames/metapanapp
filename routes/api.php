<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Login\ApiLoginController;
use App\Http\Controllers\Api\Servicios\ApiTipoServiciosController;
use App\Http\Controllers\Api\Servicios\ApiServiciosController;
use App\Http\Controllers\Api\Denuncias\ApiDenunciasController;
use App\Http\Controllers\Api\Partida\PartidaNacimientoController;
use App\Http\Controllers\Api\Solicitudes\ApiMisSolicitudesController;
use App\Http\Controllers\Api\Pagos\ApiPagosController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Este middlware verifica a que modelo darle el token api
// porque utilizamos una tabla llamada clientes
// revisar config/auth.php
Route::group(['middleware' => ['assign.guard:clientes']],function (){
    Route::post('/cliente/verificar-numero', [ApiLoginController::class, 'verificar']);
    Route::post('/cliente/login', [ApiLoginController::class, 'login']);
    Route::post('/cliente/reenviar', [ApiLoginController::class, 'reenviar']);

});


//Route::group(['middleware' => ['jwt.verify']], function() {

    //**** TIPO SERVICIOS ****
    // informacion de tipo servicios
    Route::get('/tiposervicios/informacion', [ApiTipoServiciosController::class, 'infoTipoServicios']);

    //**** SERVICIOS ****
    // informacion de servicios
    Route::get('/servicios/informacion', [ApiServiciosController::class, 'infoServicios']);

    //**** DENUNCIAS *****
    Route::get('/denuncias/informacion', [ApiDenunciasController::class, 'infoDenuncias']);
    Route::post('/denuncias/envio/v1', [ApiDenunciasController::class, 'ingresarDenunciaV1']);
    Route::post('/denuncias/envio/v2', [ApiDenunciasController::class, 'ingresarDenunciaV2']);

    // mostrar denuncias extras segun id de la denuncia
    Route::post('/denuncias/multiple', [ApiDenunciasController::class, 'infoDenunciaMultiple']);
    Route::post('/denuncias/multiple/envio/v1', [ApiDenunciasController::class, 'ingresarDenunciaMultipleV1']);
    Route::post('/denuncias/multiple/envio/v2', [ApiDenunciasController::class, 'ingresarDenunciaMultipleV2']);


    // PARTIDA DE NACIMIENTO
    Route::post('/solicitar/partida/nacimiento', [PartidaNacimientoController::class, 'ingresarPartidaNacimiento']);


    // --- MIS SOLICITUDES ---
    Route::post('/ver/mis-solicitudes', [ApiMisSolicitudesController::class, 'verMisSolicitudes']);
    Route::post('/solicitudes/ocultar/denuncia', [ApiMisSolicitudesController::class, 'ocultarDenuncia']);
    // cancelar solicitud solo cuando estado es 1: Pendiente
    Route::post('/solicitudes/cancelar/partida-cliente', [ApiMisSolicitudesController::class, 'cancelarPartidaEstadoPendiente']);
    // ocultar solicitud solo cuando estado es 3: Partida no encontrada
    Route::post('/solicitudes/ocultar/partida-cliente', [ApiMisSolicitudesController::class, 'ocultarPartidaEstadoNoEncontrada']);
    // completar solicitud
    Route::post('/solicitudes/partida/completar', [ApiMisSolicitudesController::class, 'completarSolicitudPartida']);



    // informacion de pagos con tarjeta
    Route::post('/informacion/pagos/tarjeta', [ApiMisSolicitudesController::class, 'informacionPagoPartida']);

    // realizar pago para partidad de nacimiento
    Route::post('/formulario/pagar/partida-nacimiento', [ApiPagosController::class, 'pagarPartidaNacimiento']);


//});
