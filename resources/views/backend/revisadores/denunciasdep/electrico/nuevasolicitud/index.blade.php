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
       <h1>Denuncias Pendientes</h1>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Imagen de la Denuncia</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-1">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group" id="contenedor-img" style="display: none">
                                        <center><img style="margin-left: auto; margin-right: auto" id="img-denuncia" src="{{ asset('images/foto-default.png') }}" height="300px" width="300px"></center>
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
            var ruta = "{{ URL::to('/admin2/denuncia-electrico/listado-tabla') }}";
            $('#tablaDatatable').load(ruta);
        });
    </script>

    <script>

        function verMapa(id){
            window.location.href="{{ url('/admin2/denuncia-electrico/mapa/') }}/"+id;
        }

        function recargar(){
            var ruta = "{{ url('/admin2/denuncia-electrico/listado-tabla') }}/";
            $('#tablaDatatable').load(ruta);
        }

        // ver imagen si la hay
        function verImagen(id){
            openLoading();

            var x = document.getElementById("contenedor-img");
            if (x.style.display === "none") {
                x.style.display = "block";
            }

            // defecto
            $('#img-denuncia').prop("src","{{ asset('images/foto-default.png') }}");

            axios.post('/admin2/denuncia-electrico/ver-imagen',{
                'id': id
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success == 1){
                        $('#modal1').modal('show');


                        $('#img-denuncia').prop("src","{{ url('storage/imagenes') }}"+'/'+ response.data.imagen);

                    }else{
                        toastMensaje('error', 'Información no encontrado');
                    }

                })
                .catch((error) => {
                    closeLoading()
                    toastMensaje('error', 'Información no encontrado');
                });
        }


        // completar la denuncia
        function modalInformacion(id){

            Swal.fire({
                title: '¿Completar la Denuncia?',
                text: "Se ha resuelto por complero la Denuncia",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                cancelButtonText: "Cancelar",
                confirmButtonText: 'Completar'
            }).then((result) => {
                if (result.isConfirmed) {
                    editar(id);
                }
            })
        }

        // completar la denuncia
        function editar(id){

            openLoading();

            var formData = new FormData();
            formData.append('id', id);

            axios.post('/admin2/denuncia-electrico/completar-denuncia', formData, {
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        $('#modalEditar').modal('hide');
                        toastMensaje('success', 'Completado');
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
