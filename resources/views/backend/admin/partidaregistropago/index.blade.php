@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/estiloToggle.css') }}" type="text/css" rel="stylesheet" />

@stop

<style>
    table{
        table-layout:fixed;
    }
</style>

<section class="content-header">
    <div class="container-fluid">
    </div>
</section>

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Partida Registro Pago</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="tablaDatatable"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade" id="modal1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Información Registro Pago</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-1">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label>Fecha</label>
                                        <input type="text" disabled class="form-control" id="fecha-1">
                                    </div>

                                    <div class="form-group">
                                        <label>Pago Total</label>
                                        <input type="text" disabled class="form-control" id="pagototal-1">
                                    </div>

                                    <div class="form-group">
                                        <label>Comisión</label>
                                        <input type="text" disabled class="form-control" id="comision-1">
                                    </div>

                                    <div class="form-group">
                                        <label>ID Transacción</label>
                                        <input type="text" disabled class="form-control" id="transaccion-1">
                                    </div>

                                    <div class="form-group">
                                        <label>Código Transacción</label>
                                        <input type="text" disabled class="form-control" id="codigo-1">
                                    </div>

                                    <div class="form-group">
                                        <label>Es Real</label>
                                        <input type="text" disabled class="form-control" id="real-1">
                                    </div>

                                    <div class="form-group">
                                        <label>Esta Aprobada</label>
                                        <input type="text" disabled class="form-control" id="aprobada-1">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="modal2">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Información Solicitud Partida Nacimiento</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label>Fecha</label>
                                        <input type="text" disabled class="form-control" id="fecha-2">
                                    </div>

                                    <div class="form-group">
                                        <label>Estado Partida</label>
                                        <input type="text" disabled class="form-control" id="estado-2">
                                    </div>

                                    <div class="form-group">
                                        <label>Tipo Partida</label>
                                        <input type="text" disabled class="form-control" id="tipo-2">
                                    </div>

                                    <div class="form-group">
                                        <label>Cantidad Partida</label>
                                        <input type="text" disabled class="form-control" id="cantidad-2">
                                    </div>

                                    <div class="form-group">
                                        <label>Solicito</label>
                                        <input type="text" disabled class="form-control" id="solicito-2">
                                    </div>

                                    <div class="form-group">
                                        <label>Persona</label>
                                        <input type="text" disabled class="form-control" id="persona-2">
                                    </div>

                                    <div class="form-group">
                                        <label>Fecha Nacimiento</label>
                                        <input type="text" disabled class="form-control" id="fechanacimiento-2">
                                    </div>

                                    <div class="form-group">
                                        <label>Nombre Padre</label>
                                        <input type="text" disabled class="form-control" id="padre-2">
                                    </div>

                                    <div class="form-group">
                                        <label>Nombre Madre</label>
                                        <input type="text" disabled class="form-control" id="madre-2">
                                    </div>

                                    <div class="form-group">
                                        <label>Visible Cliente</label>
                                        <input type="text" disabled class="form-control" id="visible-2">
                                    </div>


                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

</div>


@extends('backend.menus.footerjs')
@section('archivos-js')

    <script src="{{ asset('js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/axios.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/alertaPersonalizada.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function(){
            var ruta = "{{ URL::to('/admin/partidaregistropago/listado-tabla') }}";
            $('#tablaDatatable').load(ruta);
        });
    </script>

    <script>

        // informacion de registro pago
        function verRegistroPago(id){
            openLoading();
            document.getElementById("formulario-1").reset();

            axios.post('/admin/partidaregistropago/info-registropago',{
                'id': id
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success == 1){
                        $('#modal1').modal('show');

                        $('#fecha-1').val(response.data.fecha);
                        $('#pagototal-1').val(response.data.info.pago_total);

                        $('#comision-1').val(response.data.info.comision);
                        $('#transaccion-1').val(response.data.info.idtransaccion);
                        $('#codigo-1').val(response.data.info.codigo);

                        if(response.data.info.esreal === 0){
                            $('#real-1').val('NO');
                        }else{
                            $('#real-1').val('SI');
                        }

                        if(response.data.info.esaprobada === 0){
                            $('#aprobada-1').val('NO');
                        }else{
                            $('#aprobada-1').val('SI');
                        }

                    }else{
                        toastMensaje('error', 'Información no encontrado');
                    }

                })
                .catch((error) => {
                    closeLoading()
                    toastMensaje('error', 'Información no encontrado');
                });
        }

        // ver informacion de partida
        function verInfoPartida(id){
            openLoading();
            document.getElementById("formulario-1").reset();

            axios.post('/admin/partidaregistropago/info-partida',{
                'id': id
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success == 1){
                        $('#modal2').modal('show');

                        $('#fecha-2').val(response.data.fecha);
                        $('#estado-2').val(response.data.estado);

                        $('#tipo-2').val(response.data.tipo);
                        $('#cantidad-2').val(response.data.info.cantidad);
                        $('#solicito-2').val(response.data.info.solicito);
                        $('#persona-2').val(response.data.info.persona);

                        $('#fechanacimiento-2').val(response.data.info.fecha_nacimiento);

                        $('#padre-2').val(response.data.info.nombre_padre);
                        $('#madre-2').val(response.data.info.nombre_madre);

                        if(response.data.info.visible_cliente === 0){
                            $('#visible-2').val('NO');
                        }else{
                            $('#visible-2').val('SI');
                        }

                    }else{
                        toastMensaje('error', 'Información no encontrado');
                    }

                })
                .catch((error) => {
                    closeLoading()
                    toastMensaje('error', 'Información no encontrado');
                });
        }

        // ver toda info del cliente
        function verCliente(id){

        }



        function modalInformacion(id){
            openLoading();
            document.getElementById("formulario-editar").reset();

            axios.post('/admin/solipartidanacimiento/listado-info',{
                'id': id
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success == 1){
                        $('#modalEditar').modal('show');

                        $('#persona-editar').val(response.data.info.persona);
                        $('#fecha-editar').val(response.data.info.fecha_nacimiento);

                        $('#padre-editar').val(response.data.info.nombre_padre);
                        $('#madre-editar').val(response.data.info.nombre_madre);

                        if(response.data.info.visible_cliente === 0){
                            $('#visible-editar').val('NO');
                        }else{
                            $('#visible-editar').val('SI');
                        }

                        if(response.data.info.cancelado === 0){
                            $('#cancelado-editar').val('NO');
                        }
                        else if(response.data.info.cancelado === 1){
                            $('#cancelado-editar').val('CLIENTE');
                        }
                        else if(response.data.info.cancelado === 2){
                            $('#cancelado-editar').val('ADMIN');
                        }

                        $('#fechacancelado-editar').val(response.data.fechacancelado);
                        $('#notacancelado-editar').val(response.data.info.nota_cancelada);

                    }else{
                        toastMensaje('error', 'Información no encontrado');
                    }

                })
                .catch((error) => {
                    closeLoading()
                    toastMensaje('error', 'Información no encontrado');
                });
        }

    </script>

@stop
