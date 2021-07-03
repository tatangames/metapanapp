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
        <h1>Nuevas Solicitudes Partida Nacimiento</h1>
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
                    <h4 class="modal-title">Partida No Encontrada</h4>
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
                                        <input type="hidden" id="id-2">
                                    </div>

                                    <div class="form-group">
                                        <label>Nota</label>
                                        <input type="text" placeholder="Opcional" maxlength="200" class="form-control" id="nota-2">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="actualizarEstado3()">Verificar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal3">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cancelar Solicitud</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <input type="hidden" id="id-3">
                                    </div>

                                    <div class="form-group">
                                        <label>Nota</label>
                                        <input type="text" placeholder="Campo Requerido" maxlength="200" class="form-control" id="nota-3">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="actualizarEstado7()">Verificar</button>
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
            var ruta = "{{ URL::to('/admin2/pendientepartida/listado-tabla') }}";
            $('#tablaDatatable').load(ruta);
        });
    </script>

    <script>

        function recargar(){
            var ruta = "{{ url('/admin2/pendientepartida/listado-tabla') }}/";
            $('#tablaDatatable').load(ruta);
        }

        function modalInformacion(id){
            openLoading();
            document.getElementById("formulario-1").reset();

            axios.post('/admin2/pendientepartida/informacion',{
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

        // partida encontrada
        function partidaEncontrada(id){

            Swal.fire({
                title: 'Partida Nacimiento Encontrada',
                text: "El Solicitante pasara a realizar el Pago por medio de la App",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                cancelButtonText: "Cancelar",
                confirmButtonText: 'Verificar'
            }).then((result) => {
                if (result.isConfirmed) {
                    partidaEstado4(id);
                }
            })

        }

        // partida no encontrada
        function partidaNoEncontrada(id){
            document.getElementById("formulario-2").reset();
            $('#id-2').val(id);
            $('#modal2').modal('show');
        }

        // pasar a estado no encontrado
        function actualizarEstado3(){
            var id = document.getElementById('id-2').value;

            var nota = document.getElementById('nota-2').value;

            if(nota.length > 200){
                toastMensaje('error', '200 caracteres máximo para Nota');
                return;
            }

            openLoading();

            var formData = new FormData();
            formData.append('id', id);
            formData.append('nota', nota);

            axios.post('/admin2/pendientepartida/estado-3', formData, {
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        $('#modal2').modal('hide');
                        toastMensaje('success', 'Verificado');
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


        // cambiar estado a la solicitud
        // cliente ya podra pagar
        function partidaEstado4(id){
            openLoading();

            axios.post('/admin2/pendientepartida/estado-4',{
                'id': id
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        toastMensaje('success', 'Verificado');
                        recargar();
                    }else{
                        toastMensaje('error', 'Error al verificar');
                    }

                })
                .catch((error) => {
                    closeLoading()
                    toastMensaje('error', 'Error al verificar');
                });
        }


        // info antes de cancelar porque usuario nunca pago
        function infoCancelar(id){
            document.getElementById("formulario-3").reset();
            $('#id-3').val(id);
            $('#modal3').modal('show');
        }

        // cancelar solicitud
        function actualizarEstado7(){
            var id = document.getElementById('id-3').value;
            var nota = document.getElementById('nota-3').value;

            if(nota === ''){
                toastMensaje('error', 'Nota es Requerida');
                return;
            }

            if(nota.length > 200){
                toastMensaje('error', '200 caracteres máximo para Nota');
                return;
            }

            openLoading();

            var formData = new FormData();
            formData.append('id', id);
            formData.append('nota', nota);

            axios.post('/admin2/pendientepartida/estado-7', formData, {
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        // no se puede cancelar
                        $('#modal3').modal('hide');
                        toastMensaje('warning', 'No se puede Cancelar');
                        recargar();
                    }
                    else if(response.data.success === 2){
                        $('#modal3').modal('hide');
                        toastMensaje('success', 'Solicitud Cancelada');
                        recargar();
                    }
                    else{
                        toastMensaje('error', 'Error al editar')
                    }
                })
                .catch((error) => {
                    closeLoading();
                    toastMensaje('error', 'Error al editar');
                });
        }


        // informacion antes de completar
        function infoCompletar(id){
            Swal.fire({
                title: 'Completar Entrega',
                text: "Se ha entregado la Partida de Nacimiento al solicitante",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                cancelButtonText: "Cancelar",
                confirmButtonText: 'Verificar'
            }).then((result) => {
                if (result.isConfirmed) {
                    partidaEstado6(id);
                }
            })
        }

        // completar entrega
        function partidaEstado6(id){
            openLoading();

            axios.post('/admin2/pendientepartida/estado-6',{
                'id': id
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        toastMensaje('success', 'Solicitud Completada');
                        recargar();
                    }else{
                        toastMensaje('error', 'Error al verificar');
                    }
                })
                .catch((error) => {
                    closeLoading()
                    toastMensaje('error', 'Error al verificar');
                });
        }


    </script>

@stop
