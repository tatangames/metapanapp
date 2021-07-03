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
                    <h3 class="card-title">Solicitudes Partida de Nacimiento</h3>
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


    <div class="modal fade" id="modalEditar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Información</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-editar">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label>Persona</label>
                                        <input type="text" disabled class="form-control" id="persona-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Fecha Nacimiento</label>
                                        <input type="text" disabled class="form-control" id="fecha-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Nombre Padre</label>
                                        <input type="text" disabled class="form-control" id="padre-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Nombre Madre</label>
                                        <input type="text" disabled class="form-control" id="madre-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Visible Cliente</label>
                                        <input type="text" disabled class="form-control" id="visible-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Cancelado</label>
                                        <input type="text" disabled class="form-control" id="cancelado-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Fecha Cancelado</label>
                                        <input type="text" disabled class="form-control" id="fechacancelado-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Nota Cancelado</label>
                                        <input type="text" disabled class="form-control" id="notacancelado-editar">
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
            var ruta = "{{ URL::to('/admin/solipartidanacimiento/listado-tabla') }}";
            $('#tablaDatatable').load(ruta);
        });
    </script>

    <script>

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
