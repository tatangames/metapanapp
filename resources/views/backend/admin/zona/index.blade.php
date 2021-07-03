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
        <button type="button" onclick="abrirModalAgregar()" class="btn btn-success btn-sm">
            <i class="fas fa-pencil-alt"></i>
            Nueva Zona
        </button>
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
                    <h3 class="card-title">Listado</h3>
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

    <div class="modal fade" id="modalAgregar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nueva Zona</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-nuevo">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="text" maxlength="50" class="form-control" id="nombre-nuevo">
                                    </div>

                                    <div class="form-group">
                                        <label>Latitud</label>
                                        <input type="text" maxlength="50" class="form-control" id="latitud-nuevo">
                                    </div>

                                    <div class="form-group">
                                        <label>Longitud</label>
                                        <input type="text" maxlength="50" class="form-control" id="longitud-nuevo">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="nuevo()">Agregar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Zona</h4>
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
                                        <input type="hidden" id="id-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="text" maxlength="50" class="form-control" id="nombre-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Latitud</label>
                                        <input type="text" maxlength="50" class="form-control" id="latitud-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Longitud</label>
                                        <input type="text" maxlength="50" class="form-control" id="longitud-editar">
                                    </div>

                                    <div class="form-group" style="margin-left:20px">
                                        <label>Estado</label><br>
                                        <label class="switch" style="margin-top:10px">
                                            <input type="checkbox" id="toggle-estado">
                                            <div class="slider round">
                                                <span class="on">Activo</span>
                                                <span class="off">Inactivo</span>
                                            </div>
                                        </label>
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
            var ruta = "{{ URL::to('/admin/zona/listado-tabla') }}";
            $('#tablaDatatable').load(ruta);
        });
    </script>

    <script>

        function abrirModalAgregar(){
            document.getElementById("formulario-nuevo").reset();
            $('#modalAgregar').modal('show');
        }

        function nuevo(){
            var nombre = document.getElementById('nombre-nuevo').value;
            var latitud = document.getElementById('latitud-nuevo').value;
            var longitud = document.getElementById('longitud-nuevo').value;

            if(nombre === ''){
                toastMensaje('error', 'Nombre es requerido');
                return;
            }

            if(nombre.length > 50){
                toastMensaje('error', '50 caracteres máximo para Nombre');
                return;
            }

            if(latitud === ''){
                toastMensaje('error', 'Latitud es requerido');
                return;
            }

            if(latitud.length > 50){
                toastMensaje('error', '50 caracteres máximo para Latitud');
                return;
            }

            if(longitud === ''){
                toastMensaje('error', 'Longitud es requerido');
                return;
            }

            if(longitud.length > 50){
                toastMensaje('error', '50 caracteres máximo para Longitud');
                return;
            }

            openLoading()
            var formData = new FormData();
            formData.append('nombre', nombre);
            formData.append('latitud', latitud);
            formData.append('longitud', longitud);

            axios.post('/admin/zona/listado-nuevo', formData, {
            })
                .then((response) => {
                    closeLoading()
                    if(response.data.success == 1){
                        $('#modalAgregar').modal('hide');
                        toastMensaje('success', 'Registrado');
                        recargar();
                    }
                })
                .catch((error) => {
                    closeLoading()
                    toastMensaje('error', 'Error al guardar');
                });
        }

        function recargar(){
            var ruta = "{{ url('/admin/zona/listado-tabla') }}/";
            $('#tablaDatatable').load(ruta);
        }

        function vistaPoligonos(id){
            window.location.href="{{ url('/admin/zona/poligono') }}/"+id;
        }

        function verMapa(id){
            window.location.href="{{ url('/admin/zona/mapa') }}/"+id;
        }

        function modalInformacion(id){
            openLoading();
            document.getElementById("formulario-editar").reset();

            axios.post('/admin/zona/listado-info',{
                'id': id
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success == 1){
                        $('#modalEditar').modal('show');
                        $('#id-editar').val(response.data.info.id);
                        $('#nombre-editar').val(response.data.info.nombre);
                        $('#latitud-editar').val(response.data.info.latitud);
                        $('#longitud-editar').val(response.data.info.longitud);

                        if(response.data.info.activo == 0){
                            $("#toggle-estado").prop("checked", false);
                        }else{
                            $("#toggle-estado").prop("checked", true);
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

        function editar(){
            var id = document.getElementById('id-editar').value;

            var nombre = document.getElementById('nombre-editar').value;
            var latitud = document.getElementById('latitud-editar').value;
            var longitud = document.getElementById('longitud-editar').value;
            var t = document.getElementById('toggle-estado').checked;
            var toggle = t ? 1 : 0;

            if(nombre === ''){
                toastMensaje('error', 'Nombre es requerido');
                return;
            }

            if(nombre.length > 50){
                toastMensaje('error', '50 caracteres máximo para Nombre');
                return;
            }

            if(latitud === ''){
                toastMensaje('error', 'Latitud es requerido');
                return;
            }

            if(latitud.length > 50){
                toastMensaje('error', '50 caracteres máximo para Latitud');
                return;
            }

            if(longitud === ''){
                toastMensaje('error', 'Longitud es requerido');
                return;
            }

            if(longitud.length > 50){
                toastMensaje('error', '50 caracteres máximo para Longitud');
                return;
            }

            openLoading();

            var formData = new FormData();
            formData.append('id', id);
            formData.append('nombre', nombre);
            formData.append('latitud', latitud);
            formData.append('longitud', longitud);
            formData.append('toggle', toggle);

            axios.post('/admin/zona/listado-editar', formData, {
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success == 1){
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
