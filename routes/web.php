<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Login\LoginController;
use App\Http\Controllers\Admin\Controles\ControlController;
use App\Http\Controllers\Admin\Administrador\Perfil\PerfilController;
use App\Http\Controllers\Admin\Administrador\Cliente\ClienteController;
use App\Http\Controllers\Admin\Administrador\Costo\CostoController;
use App\Http\Controllers\Admin\Administrador\Banco\BancoController;
use App\Http\Controllers\Admin\Administrador\Zona\ZonaController;
use App\Http\Controllers\Admin\Administrador\Poligono\PoligonoController;
use App\Http\Controllers\Admin\Administrador\TipoServicios\TipoServiciosController;
use App\Http\Controllers\Admin\Administrador\EstadoPartida\EstadoPartidaController;
use App\Http\Controllers\Admin\Administrador\EstadoDenuncia\EstadoDenunciaController;
use App\Http\Controllers\Admin\Administrador\TipoEnvioDenuncia\TipoEnvioDenunciaController;
use App\Http\Controllers\Admin\Administrador\ServicioAlcaldia\ServicioAlcaldiaController;
use App\Http\Controllers\Admin\Administrador\ListaDenuncia\ListaDenunciaController;
use App\Http\Controllers\Admin\Administrador\RegistroPago\RegistroPagoController;
use App\Http\Controllers\Admin\Administrador\SoliPartidaNacimiento\SoliPartidaNacimientoController;
use App\Http\Controllers\Admin\Administrador\PartidaRegistroPago\PartidaRegistroPagoController;
use App\Http\Controllers\Admin\Administrador\DenunciaRealizada\DenunciaRealizadaController;
use App\Http\Controllers\Admin\Controles\RolesController;
use App\Http\Controllers\Admin\Controles\PermisosController;
use App\Http\Controllers\Admin\Informativo\NuevaSolicitud\NuevaSolicitudController;
use App\Http\Controllers\Admin\Administrador\Departamento\DepartamentoDenunciaController;
use App\Http\Controllers\Admin\DenunciaDepart\Electrico\Pendiente\DenunciaElectricosPendienteController;
use App\Http\Controllers\Admin\DenunciaDepart\Electrico\Historial\HistoDenunciaElectricoController;
use App\Http\Controllers\Admin\Partida\Pendientes\PartidaNacimientoPendienteController;
use App\Http\Controllers\Admin\Partida\Historial\HistorialPartidaCompleCanceController;
use App\Http\Controllers\Admin\Administrador\Notificaciones\NotificacionesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class,'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');


// --- CONTROL WEB ---
Route::get('/panel', [ControlController::class,'indexRedireccionamiento'])->name('admin.panel');

    // **** --- ADMINISTRADOR --- ****

    // --- ROLES ---
    Route::get('/admin/roles/index', [RolesController::class,'index'])->name('admin.roles.index');
    Route::get('/admin/roles/tabla', [RolesController::class,'tablaRoles']);
    Route::get('/admin/roles/lista/permisos/{id}', [RolesController::class,'vistaPermisos']);
    Route::get('/admin/roles/permisos/tabla/{id}', [RolesController::class,'tablaRolesPermisos']);
    Route::post('/admin/roles/permiso/borrar', [RolesController::class, 'borrarPermiso']);
    Route::post('/admin/roles/permiso/agregar', [RolesController::class, 'agregarPermiso']);
    Route::get('/admin/roles/permisos/lista', [RolesController::class,'listaTodosPermisos']);
    Route::get('/admin/roles/permisos-todos/tabla', [RolesController::class,'tablaTodosPermisos']);
    Route::post('/admin/roles/borrar-global', [RolesController::class, 'borrarRolGlobal']);

    // --- PERMISOS ---
    Route::get('/admin/permisos/index', [PermisosController::class,'index'])->name('admin.permisos.index');
    Route::get('/admin/permisos/tabla', [PermisosController::class,'tablaUsuarios']);
    Route::post('/admin/permisos/nuevo-usuario', [PermisosController::class, 'nuevoUsuario']);
    Route::post('/admin/permisos/info-usuario', [PermisosController::class, 'infoUsuario']);
    Route::post('/admin/permisos/editar-usuario', [PermisosController::class, 'editarUsuario']);
    Route::post('/admin/permisos/nuevo-rol', [PermisosController::class, 'nuevoRol']);
    Route::post('/admin/permisos/extra-nuevo', [PermisosController::class, 'nuevoPermisoExtra']);
    Route::post('/admin/permisos/extra-borrar', [PermisosController::class, 'borrarPermisoGlobal']);


    // --- CLIENTES REGISTRADOS ---
    Route::get('/admin/cliente/lista', [ClienteController::class,'index'])->name('cliente.lista.index');
    Route::get('/admin/cliente/listado-tabla', [ClienteController::class,'indexTabla']);
    Route::post('/admin/cliente/listado-info', [ClienteController::class, 'informacion']);
    Route::post('/admin/cliente/listado-editar', [ClienteController::class, 'editar']);

    // --- PERFIL ---
    Route::get('/admin/editar-perfil/index', [PerfilController::class,'index'])->name('admin.perfil');
    Route::post('/admin/editar-perfil/actualizar', [PerfilController::class, 'editarUsuario']);

    // --- COSTOS ---
    Route::get('/admin/costo/listado', [CostoController::class,'index'])->name('costo.index');
    Route::get('/admin/costo/listado-tabla', [CostoController::class,'tablaIndex']);
    Route::post('/admin/costo/listado-nuevo', [CostoController::class,'nuevoCosto']);
    Route::post('/admin/costo/listado-info', [CostoController::class,'infoCosto']);
    Route::post('/admin/costo/listado-editar', [CostoController::class,'editarCosto']);

    // --- BANCO ---
    Route::get('/admin/banco/listado', [BancoController::class,'index'])->name('banco.index');
    Route::get('/admin/banco/listado-tabla', [BancoController::class,'tablaIndex']);
    Route::post('/admin/banco/listado-info', [BancoController::class,'infoBanco']);
    Route::post('/admin/banco/listado-editar', [BancoController::class,'editarBanco']);

    // --- ZONA ---
    Route::get('/admin/zona/listado', [ZonaController::class,'index'])->name('zona.index');
    Route::get('/admin/zona/listado-tabla', [ZonaController::class,'tablaIndex']);
    Route::post('/admin/zona/listado-nuevo', [ZonaController::class,'nuevaZona']);
    Route::post('/admin/zona/listado-info', [ZonaController::class,'infoZona']);
    Route::post('/admin/zona/listado-editar', [ZonaController::class,'editarZona']);
    Route::get('/admin/zona/mapa/{id}', [ZonaController::class,'mapa']);

    // --- POLIGONO ---
    Route::get('/admin/zona/poligono/{id}', [PoligonoController::class,'index']);
    Route::post('/admin/zona/poligono/listado-nuevo', [PoligonoController::class,'nuevoPoligono']);
    Route::post('/admin/zona/poligono/borrar', [PoligonoController::class,'borrarPoligonos']);

    // --- TIPO SERVICIOS ---
    Route::get('/admin/tiposervicio/listado', [TipoServiciosController::class,'index'])->name('tipo.servicio.index');
    Route::get('/admin/tiposervicio/listado-tabla', [TipoServiciosController::class,'tablaIndex']);
    Route::post('/admin/tiposervicio/listado-nuevo', [TipoServiciosController::class,'nuevoTipoServicio']);
    Route::post('/admin/tiposervicio/listado-info', [TipoServiciosController::class,'infoTipoServicio']);
    Route::post('/admin/tiposervicio/listado-editar', [TipoServiciosController::class,'editarTipoServicio']);
    Route::post('/admin/tiposervicio/modificar/posiciones', [TipoServiciosController::class,'posicionTipoServicio']);

    // --- ESTADO PARTIDA ---
    Route::get('/admin/estadopartida/listado', [EstadoPartidaController::class,'index'])->name('estado.partida.index');
    Route::get('/admin/estadopartida/listado-tabla', [EstadoPartidaController::class,'tablaIndex']);
    Route::post('/admin/estadopartida/listado-info', [EstadoPartidaController::class,'infoEstadoPartida']);
    Route::post('/admin/estadopartida/listado-editar', [EstadoPartidaController::class,'editarEstadoPartida']);

    // --- ESTADO DENUNCIA ---
    Route::get('/admin/estadodenuncia/listado', [EstadoDenunciaController::class,'index'])->name('estado.denuncia.index');
    Route::get('/admin/estadodenuncia/listado-tabla', [EstadoDenunciaController::class,'tablaIndex']);
    Route::post('/admin/estadodenuncia/listado-info', [EstadoDenunciaController::class,'infoEstadoDenuncia']);
    Route::post('/admin/estadodenuncia/listado-editar', [EstadoDenunciaController::class,'editarEstadoDenuncia']);

    // --- TIPO ENVIO DENUNCIA ---

    Route::get('/admin/tipoenviodenuncia/listado', [TipoEnvioDenunciaController::class,'index'])->name('tipo.envio.denuncia.index');
    Route::get('/admin/tipoenviodenuncia/listado-tabla', [TipoEnvioDenunciaController::class,'tablaIndex']);
    Route::post('/admin/tipoenviodenuncia/listado-info', [TipoEnvioDenunciaController::class,'infoTipoEnvioDenuncia']);
    Route::post('/admin/tipoenviodenuncia/listado-editar', [TipoEnvioDenunciaController::class,'editarTipoEnvioDenuncia']);

    // --- SERVICIOS ALCALDIA ---
    Route::get('/admin/servicioalcaldia/listado', [ServicioAlcaldiaController::class,'index'])->name('servicio.alcaldia.index');
    Route::get('/admin/servicioalcaldia/listado-tabla', [ServicioAlcaldiaController::class,'tablaIndex']);
    Route::post('/admin/servicioalcaldia/listado-nuevo', [ServicioAlcaldiaController::class,'nuevoServicioAlcaldia']);
    Route::post('/admin/servicioalcaldia/listado-info', [ServicioAlcaldiaController::class,'infoServicioAlcaldia']);
    Route::post('/admin/servicioalcaldia/listado-editar', [ServicioAlcaldiaController::class,'editarServicioAlcaldia']);
    Route::post('/admin/servicioalcaldia/modificar/posiciones', [ServicioAlcaldiaController::class,'posicionServicioAlcaldia']);

    // --- LISTA DENUNCIAS ---
    Route::get('/admin/listadenuncia/listado', [ListaDenunciaController::class,'index'])->name('lista.denuncia.index');
    Route::get('/admin/listadenuncia/listado-tabla', [ListaDenunciaController::class,'tablaIndex']);
    Route::post('/admin/listadenuncia/listado-nuevo', [ListaDenunciaController::class,'nuevoListaDenuncia']);
    Route::post('/admin/listadenuncia/listado-info', [ListaDenunciaController::class,'infoListaDenuncia']);
    Route::post('/admin/listadenuncia/listado-editar', [ListaDenunciaController::class,'editarListaDenuncia']);
    Route::post('/admin/listadenuncia/modificar/posiciones', [ListaDenunciaController::class,'posicionListaDenuncia']);

    // multiples opciones
    Route::get('/admin/listadenuncia/opciones-multiples/{id}', [ListaDenunciaController::class,'indexMultipleOpciones']);
    Route::get('/admin/listadenuncia/multiple/listado-tabla/{id}', [ListaDenunciaController::class,'tablaIndexMultiple']);
    Route::post('/admin/listadenuncia/multiple/listado-nuevo', [ListaDenunciaController::class,'nuevoListaDenunciaMultiple']);
    Route::post('/admin/listadenuncia/multiple/listado-info', [ListaDenunciaController::class,'infoListaDenunciaMultiple']);
    Route::post('/admin/listadenuncia/multiple/listado-editar', [ListaDenunciaController::class,'editarListaDenunciaMultiple']);
    Route::post('/admin/listadenuncia/multiple/modificar/posiciones', [ListaDenunciaController::class,'posicionListaDenunciaMultiple']);

    // --- REGISTRO DE PAGOS ---
    Route::get('/admin/registropago/listado', [RegistroPagoController::class,'index'])->name('registro.pago.index');
    Route::get('/admin/registropago/listado-tabla', [RegistroPagoController::class,'tablaIndex']);

    // --- SOLICITUD PARTIDA DE NACIMIENTO ---
    Route::get('/admin/solipartidanacimiento/listado', [SoliPartidaNacimientoController::class,'index'])->name('soli.partida.nacimiento.index');
    Route::get('/admin/solipartidanacimiento/listado-tabla', [SoliPartidaNacimientoController::class,'tablaIndex']);
    Route::post('/admin/solipartidanacimiento/listado-info', [SoliPartidaNacimientoController::class,'infoSoliPartidaNacimiento']);

    // --- PARTIDA NACIMIENTO - REGISTRO PAGO ---
    Route::get('/admin/partidaregistropago/listado', [PartidaRegistroPagoController::class,'index'])->name('partida.registro.pago.index');
    Route::get('/admin/partidaregistropago/listado-tabla', [PartidaRegistroPagoController::class,'tablaIndex']);
    Route::post('/admin/partidaregistropago/info-registropago', [PartidaRegistroPagoController::class,'infoRegistroPago']);
    Route::post('/admin/partidaregistropago/info-partida', [PartidaRegistroPagoController::class,'infoPartida']);

    // --- DENUNCIA REALIZADAS ---
    Route::get('/admin/denunciarealizada/listado', [DenunciaRealizadaController::class,'index'])->name('denuncia.realizada.index');
    Route::get('/admin/denunciarealizada/listado-tabla', [DenunciaRealizadaController::class,'tablaIndex']);
    Route::post('/admin/denunciarealizada/listado-info', [DenunciaRealizadaController::class,'infoDenunciaRealizada']);
    Route::get('/admin/denunciarealizada/ubicacion/{id}', [DenunciaRealizadaController::class,'mapaUbicacionDenuncia']);
    Route::post('/admin/denunciarealizada/multiple/opcion', [DenunciaRealizadaController::class,'infoMultipleOpcion']);

    // --- DEPARTAMENTO PARA DENUNCIAS ---
    Route::get('/admin/departamentodenuncia/listado', [DepartamentoDenunciaController::class,'index'])->name('departamento.denuncia.index');
    Route::get('/admin/departamentodenuncia/listado-tabla', [DepartamentoDenunciaController::class,'tablaIndex']);
    Route::post('/admin/departamentodenuncia/listado-nuevo', [DepartamentoDenunciaController::class,'nuevoDepartamento']);
    Route::post('/admin/departamentodenuncia/listado-info', [DepartamentoDenunciaController::class,'infoDepartamento']);
    Route::post('/admin/departamentodenuncia/listado-editar', [DepartamentoDenunciaController::class,'editarDepartamento']);

    // --- NOTIFICACIONES ---
    Route::get('/admin/notificaciones/listado', [NotificacionesController::class,'index'])->name('notificaciones.index');
    Route::post('/admin/notificaciones/envio-notificacion', [NotificacionesController::class,'envioNotificacionTelefono']);



    // *************** --- USUARIO INFORMATIVO --- ***********************

    // --- NUEVAS SOLICITUDES ---
    Route::get('/admin2/nuevasolicitud/listado', [NuevaSolicitudController::class,'index'])->name('admin2.nuevas.solicitudes.index');
    Route::get('/admin2/nuevasolicitud/listado-tabla', [NuevaSolicitudController::class,'tablaIndex']);
    Route::post('/admin2/nuevasolicitud/ver-departamento', [NuevaSolicitudController::class,'buscarDepartamento']);
    Route::post('/admin2/nuevasolicitud/verificar-denuncia', [NuevaSolicitudController::class,'verificarDenunciaEstadoEnProceso']);
    Route::post('/admin2/nuevasolicitud/verificar-partida', [NuevaSolicitudController::class,'verificarPartidaEstadoEnProceso']);


    // *************** ---- USUARIOS QUE REVISAN DENUNCIAS ELECTRICAS --- *******************

    // --- NUEVAS SOLICITUDES ---
    Route::get('/admin2/denuncia-electrico/listado', [DenunciaElectricosPendienteController::class,'index'])->name('admin2.nuevas.solicitudes.denuncias.index');
    Route::get('/admin2/denuncia-electrico/listado-tabla', [DenunciaElectricosPendienteController::class,'tablaIndex']);
    Route::get('/admin2/denuncia-electrico/mapa/{id}', [DenunciaElectricosPendienteController::class,'verUbicacionDenuncia']);
    Route::post('/admin2/denuncia-electrico/ver-imagen', [DenunciaElectricosPendienteController::class,'verImagenDenuncia']);
    Route::post('/admin2/denuncia-electrico/completar-denuncia', [DenunciaElectricosPendienteController::class,'finalizarProcesoDenuncia']);

    // --- HISTORIAL DENUNCIAS COMPLETADAS PARA ELECTRICO ---
    Route::get('/admin2/denuncia-histo-electrico/completada/listado', [HistoDenunciaElectricoController::class,'index'])->name('admin2.denuncias.completadas.lista.index');
    Route::get('/admin2/denuncia-histo-electrico/completada/listado-tabla', [HistoDenunciaElectricoController::class,'tablaIndex']);
    Route::post('/admin2/denuncia-histo-electrico/ver-imagen', [HistoDenunciaElectricoController::class,'verImagenDenuncia']);
    Route::get('/admin2/denuncia-histo-electrico/mapa/{id}', [HistoDenunciaElectricoController::class,'verUbicacionDenuncia']);



    // ************** --- USUARIOS QUE REVISAN PARTIDA DE NACIMIENTO --- *******************

    // --- NUEVAS SOLICITUDES ---
    Route::get('/admin2/pendientepartida/listado', [PartidaNacimientoPendienteController::class,'index'])->name('admin2.nuevas.solicitudes.partida.index');
    Route::get('/admin2/pendientepartida/listado-tabla', [PartidaNacimientoPendienteController::class,'tablaIndex']);
    Route::post('/admin2/pendientepartida/informacion', [PartidaNacimientoPendienteController::class,'informacionPartida']);
    Route::post('/admin2/pendientepartida/estado-3', [PartidaNacimientoPendienteController::class,'pasarPartidaEstado3']);
    Route::post('/admin2/pendientepartida/estado-4', [PartidaNacimientoPendienteController::class,'pasarPartidaEstado4']);
    Route::post('/admin2/pendientepartida/estado-6', [PartidaNacimientoPendienteController::class,'pasarPartidaEstado6']);
    Route::post('/admin2/pendientepartida/estado-7', [PartidaNacimientoPendienteController::class,'pasarPartidaEstado7']);

    // --- HISTORIAL SOLICITUDES COMPLETADAS Y CANCELADAS
    Route::get('/admin2/partidacomplecancehistorial/listado', [HistorialPartidaCompleCanceController::class,'index'])->name('admin2.historial.partida.complecance.index');
    Route::get('/admin2/partidacomplecancehistorial/listado-tabla', [HistorialPartidaCompleCanceController::class,'tablaIndex']);
    Route::post('/admin2/partidacomplecancehistorial/informacion', [HistorialPartidaCompleCanceController::class,'informacionPartida']);





