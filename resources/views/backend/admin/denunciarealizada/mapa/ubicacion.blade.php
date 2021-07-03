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
            <div class="col-sm-12">
                <h1>Ubicación de la Denuncia</h1>
            </div>
        </div>
    </section>

    <!-- seccion mapa -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Mapa</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="container">
                            <div class="col-md-12">
                                <iframe width="100%" height="400" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q={{$latitud}},{{$longitud}}&amp;key={{$api}}"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>


@extends('backend.menus.footerjs')
@section('archivos-js')

@stop
