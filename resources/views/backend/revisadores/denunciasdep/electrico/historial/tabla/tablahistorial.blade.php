<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="tabla" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Tel</th>
                                <th>Fecha</th>
                                <th>Zona</th>
                                <th>Tipo</th>
                                <th>Nota</th>
                                <th>Opciones</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($listado as $dato)
                                <tr>
                                    <td>{{ $dato->telefono }}</td>
                                    <td>{{ $dato->fecha }}</td>
                                    <td>{{ $dato->zona }}</td>
                                    <td>{{ $dato->nombre }}</td>
                                    <td>{{ $dato->descripcion }}</td>

                                    <td>
                                        <button type="button" class="btn btn-primary btn-xs" onclick="verMapa({{ $dato->id }})">
                                            <i class="fas fa-globe" title="Mapa"></i> Mapa
                                        </button>

                                        @if($dato->imagen != null)
                                            <br><br>
                                            <button type="button" class="btn btn-primary btn-xs" onclick="verImagen({{ $dato->id }})">
                                                <i class="fas fa-image" title="Ver Imagen"></i> Ver Imagen
                                            </button>
                                        @endif
                                    </td>

                                </tr>

                            @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    $(function () {
        $("#tabla").DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,

            "language": {

                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            "responsive": true, "lengthChange": false, "autoWidth": false,
        });
    });

</script>
