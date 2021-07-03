@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/estiloToggle.css') }}" type="text/css" rel="stylesheet" />
@stop

<style>
    table{
        /*Ajustar tablas*/
        table-layout:fixed;
    }
</style>

<section class="content-header">
    <div class="container-fluid">
        <h1>Historial Solicitudes Partida de Nacimiento</h1>
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
                    <h3 class="card-title">Listado de Completadas y Canceladas</h3>
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
                    <h4 class="modal-title">Información</h4>
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
                                        <label>Tipo Partida</label>
                                        <input type="text" disabled class="form-control" id="tipo-1">
                                    </div>

                                    <div class="form-group">
                                        <label>Cantidad</label>
                                        <input type="text" disabled class="form-control" id="cantidad-1">
                                    </div>

                                    <div class="form-group">
                                        <label>Solicito</label>
                                        <input type="text" disabled class="form-control" id="solicito-1">
                                    </div>

                                    <div class="form-group">
                                        <label>Persona</label>
                                        <input type="text" disabled class="form-control" id="persona-1">
                                    </div>

                                    <div class="form-group">
                                        <label>Fecha Nacimiento</label>
                                        <input type="text" disabled class="form-control" id="fechanac-1">
                                    </div>

                                    <div class="form-group">
                                        <label>Nombre Padre</label>
                                        <input type="text" disabled class="form-control" id="padre-1">
                                    </div>

                                    <div class="form-group">
                                        <label>Nombre Madre</label>
                                        <input type="text" disabled class="form-control" id="madre-1">
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
                    <h4 class="modal-title">Información</h4>
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
                                        <label>Tipo Partida</label>
                                        <input type="text" disabled class="form-control" id="tipo-2">
                                    </div>

                                    <div class="form-group">
                                        <label>Cantidad</label>
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
                                        <input type="text" disabled class="form-control" id="fechanac-2">
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
                                        <label>Fecha Cancelado</label>
                                        <input type="text" disabled class="form-control" id="fechacancelado-2">
                                    </div>

                                    <div class="form-group">
                                        <label>Nota Cancelado</label>
                                        <input type="text" disabled class="form-control" id="notacancelado-2">
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
            var ruta = "{{ URL::to('/admin2/partidacomplecancehistorial/listado-tabla') }}";
            $('#tablaDatatable').load(ruta);
        });
    </script>

    <script>

        function infoCompletada(id){
            openLoading();
            document.getElementById("formulario-1").reset();

            axios.post('/admin2/partidacomplecancehistorial/informacion',{
                'id': id
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        $('#modal1').modal('show');

                        $('#tipo-1').val(response.data.tipo);
                        $('#cantidad-1').val(response.data.info.cantidad);
                        $('#solicito-1').val(response.data.info.solicito);
                        $('#persona-1').val(response.data.info.persona);
                        $('#fechanac-1').val(response.data.info.fecha_nacimiento);
                        $('#padre-1').val(response.data.info.nombre_padre);
                        $('#madre-1').val(response.data.info.nombre_madre);

                    }else{
                        toastMensaje('error', 'Información no encontrado');
                    }
                })
                .catch((error) => {
                    closeLoading()
                    toastMensaje('error', 'Información no encontrado');
                });
        }


        function infoCancelada(id){
            openLoading();
            document.getElementById("formulario-2").reset();

            axios.post('/admin2/partidacomplecancehistorial/informacion',{
                'id': id
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        $('#modal2').modal('show');

                        $('#tipo-2').val(response.data.tipo);
                        $('#cantidad-2').val(response.data.info.cantidad);
                        $('#solicito-2').val(response.data.info.solicito);
                        $('#persona-2').val(response.data.info.persona);
                        $('#fechanac-2').val(response.data.info.fecha_nacimiento);
                        $('#padre-2').val(response.data.info.nombre_padre);
                        $('#madre-2').val(response.data.info.nombre_madre);

                        $('#fechacancelado-2').val(response.data.info.fecha_cancelado);
                        $('#notacancelado-2').val(response.data.info.nota_cancelada);

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
