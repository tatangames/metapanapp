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
                    <h3 class="card-title">Estados para Partida de Nacimiento</h3>
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
                    <h4 class="modal-title">Editar Estado Partida</h4>
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
                                        <label>Nombre API</label>
                                        <input type="hidden" id="id-editar">
                                        <input type="text" maxlength="200" class="form-control" id="api-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Nombre WEB</label>
                                        <input type="text" maxlength="200" class="form-control" id="web-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Descripci??n</label>
                                        <input type="text" maxlength="200" class="form-control" id="descripcion-editar">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="editar()">Actualizar</button>
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
            var ruta = "{{ URL::to('/admin/estadopartida/listado-tabla') }}";
            $('#tablaDatatable').load(ruta);
        });
    </script>

    <script>

        function recargar(){
            var ruta = "{{ url('/admin/estadopartida/listado-tabla') }}/";
            $('#tablaDatatable').load(ruta);
        }

        function modalInformacion(id){
            openLoading();
            document.getElementById("formulario-editar").reset();

            axios.post('/admin/estadopartida/listado-info',{
                'id': id
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success == 1){
                        $('#modalEditar').modal('show');
                        $('#id-editar').val(response.data.info.id);
                        $('#api-editar').val(response.data.info.nombre_api);
                        $('#web-editar').val(response.data.info.nombre_web);
                        $('#descripcion-editar').val(response.data.info.descripcion);

                    }else{
                        toastMensaje('error', 'Informaci??n no encontrado');
                    }

                })
                .catch((error) => {
                    closeLoading()
                    toastMensaje('error', 'Informaci??n no encontrado');
                });
        }

        function editar(){
            var id = document.getElementById('id-editar').value;
            var nombreapi = document.getElementById('api-editar').value;
            var nombreweb = document.getElementById('web-editar').value;
            var descripcion = document.getElementById('descripcion-editar').value;

            if(nombreapi === ''){
                toastMensaje('error', 'Nombre API es requerido');
                return;
            }
            if(nombreapi.length > 200){
                toastMensaje('error', 'M??ximo 200 caracteres para Nombre API');
                return;
            }

            if(nombreweb === ''){
                toastMensaje('error', 'Nombre WEB es requerido');
                return;
            }
            if(nombreweb.length > 200){
                toastMensaje('error', 'M??ximo 200 caracteres para Nombre WEB');
                return;
            }

            if(descripcion.length > 200){
                toastMensaje('error', 'M??ximo 200 caracteres para Descripci??n');
                return;
            }

            openLoading();

            var formData = new FormData();
            formData.append('id', id);
            formData.append('nombreapi', nombreapi);
            formData.append('nombreweb', nombreweb);
            formData.append('descripcion', descripcion);

            axios.post('/admin/estadopartida/listado-editar', formData, {
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        $('#modalEditar').modal('hide');
                        toastMensaje('success', 'Actualizado');
                        recargar();
                    }else{
                        toastMensaje('error', 'Error al editar')
                    }
                })
                .catch((error) => {
                    closeLoading();
                    toastMensaje('error', 'Error al editar');
                });
        }

    </script>

@stop
