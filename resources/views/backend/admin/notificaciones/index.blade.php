@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/estiloToggle.css') }}" type="text/css" rel="stylesheet" />
@stop

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
                    <h3 class="card-title">Envio de Notificaciones</h3>
                </div>
                <div class="card-body">

                    <form>
                        <div class="col-md-5 form-group">
                            <label>Télefono</label>
                            <input type="text" maxlength="8" class="form-control" id="telefono">
                        </div>

                        <div class="col-md-5 form-group">
                            <label>Titulo</label>
                            <input type="text" maxlength="30" class="form-control" id="titulo" placeholder="Titulo notificacion">
                        </div>

                        <div class="col-md-5 form-group">
                            <label>Mensaje</label>
                            <input type="text" maxlength="50" class="form-control" id="mensaje" placeholder="Mensaje notificacion">
                        </div>
                    </form>

                    <br>
                    <button type="button" class="btn btn-primary" onclick="enviar()">Enviar</button>

                </div>
            </div>
        </div>
    </section>


</div>


@extends('backend.menus.footerjs')
@section('archivos-js')

    <script src="{{ asset('js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/axios.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/alertaPersonalizada.js') }}"></script>


    <script>

        function enviar(){

            var telefono = document.getElementById('telefono').value;
            var titulo = document.getElementById('titulo').value;
            var mensaje = document.getElementById('mensaje').value;

            if(telefono === ''){
                toastr.error('Télefono es requerido');
                return;
            }

            if(titulo === ''){
                toastr.error('Titulo es requerido');
                return;
            }

            if(mensaje === ''){
                toastr.error('Mensaje es requerido');
                return;
            }

            openLoading();

            var formData = new FormData();

            formData.append('telefono', telefono);
            formData.append('titulo', titulo);
            formData.append('mensaje', mensaje);

            axios.post('/admin/notificaciones/envio-notificacion', formData, {
            })
                .then((response) => {
                    closeLoading();

                    if(response.data.success === 1) {
                        toastMensaje('error', "Sin Identificador");
                    }
                    else if(response.data.success === 2) {
                        toastMensaje('success', "Enviado");
                    }
                    else  if(response.data.success === 3) {
                        toastMensaje('error', "Error al Enviar");
                    }
                    else  if(response.data.success === 4) {
                        toastMensaje('error', "Cliente no Encontrado");
                    }
                    else {
                        toastMensaje('error', "Error");
                    }

                })
                .catch((error) => {
                    toastMensaje('error', "Error");
                });
        }

    </script>

@stop
