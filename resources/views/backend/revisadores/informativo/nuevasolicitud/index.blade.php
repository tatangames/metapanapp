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
        <h1>Solicitudes Pendientes</h1>
    </div>
    <br>
    <div class="form-group" style="width: 25%">
        <label>Cronometro</label>
        <label id="contador"></label>
    </div>
</section>

<div class="content-wrapper">

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
                    <h4 class="modal-title">Verificar Denuncia</h4>
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
                                        <input type="hidden" id="id-denuncia">
                                    </div>

                                    <div class="form-group">
                                        <label id="texto-denuncia"></label>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="responderDenuncia()">Verificar</button>
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
            var ruta = "{{ URL::to('/admin2/nuevasolicitud/listado-tabla') }}";
            $('#tablaDatatable').load(ruta);
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            var ruta = "{{ URL::to('admin2/nuevasolicitud/listado-tabla') }}";
            $('#tablaDatatable').load(ruta);
            countdown();
        });

    </script>

    <script>

        function countdown() {
            var seconds = 60;
            function tick() {
                var counter = document.getElementById("contador");
                seconds--;
                counter.innerHTML = "0:" + (seconds < 10 ? "0" : "") + String(seconds);
                if( seconds > 0 ) {
                    setTimeout(tick, 1000);
                } else {
                    recargar();
                    countdown();
                }
            }
            tick();
        }


        // verificar denuncia,
        function infoDenuncia(id){

            openLoading();
            document.getElementById("formulario-1").reset();

            axios.post('/admin2/nuevasolicitud/ver-departamento',{
                'id': id
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success == 1){
                        $('#modal1').modal('show');

                        $('#id-denuncia').val(id);

                        document.getElementById("texto-denuncia").innerHTML = "Notificar al Departamento: " + response.data.departamento;

                    }else{
                        toastMensaje('error', 'Información no encontrado');
                    }

                })
                .catch((error) => {
                    closeLoading()
                    toastMensaje('error', 'Información no encontrado');
                });
        }

        // verificar partida
        function verificarPartida(id){
            Swal.fire({
                title: '¿Verificar Solicitud?',
                text: "Al Verificar se debera Notificar, para iniciar busqueda de Partida de Nacimiento",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                cancelButtonText: "Cancelar",
                confirmButtonText: 'Completar'
            }).then((result) => {
                if (result.isConfirmed) {
                    responderPartida(id);
                }
            })
        }

        function responderDenuncia(){
            openLoading();

            var id = document.getElementById('id-denuncia').value;
            axios.post('/admin2/nuevasolicitud/verificar-denuncia',{
                'id': id
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success == 1){
                        $('#modal1').modal('hide');
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

        function responderPartida(id){
            openLoading();

            axios.post('/admin2/nuevasolicitud/verificar-partida',{
                'id': id
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success == 1){
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

        function recargar(){
            var ruta = "{{ url('/admin2/nuevasolicitud/listado-tabla') }}/";
            $('#tablaDatatable').load(ruta);
        }

    </script>

@stop
