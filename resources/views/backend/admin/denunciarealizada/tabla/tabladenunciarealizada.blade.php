<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabla" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Nombre De.</th>
                                <th>Tipo</th>
                                <th>Tel</th>
                                <th>Fecha</th>
                                <th>Zona</th>
                                <th>Estado</th>
                                <th>Imagen</th>
                                <th>Descrip.</th>
                                <th>Opciones</th>
                            </tr>
                            </thead>
                            <tbody>




                            @foreach($listado as $dato)
                                <tr>
                                    <td>{{ $dato->nombredenuncia }}</td>
                                    <td>{{ $dato->tipodenuncia }}</td>
                                    <td>{{ $dato->telefono }}</td>
                                    <td>{{ $dato->fecha }}</td>
                                    <td>{{ $dato->zona }}</td>
                                    <td>{{ $dato->estado }}</td>

                                    @if($dato->imagen != null)
                                        <td>
                                            <img src="{{ url('storage/imagenes/'.$dato->imagen) }}" width="100px" height="125px" />
                                        </td>
                                    @else
                                        <td>
                                        </td>
                                    @endif

                                    <td>{{ $dato->descripcion }}</td>

                                    <td>
                                        <button type="button" class="btn btn-primary btn-xs" onclick="verMapa({{ $dato->id }})">
                                            <i class="fas fa-edit" title="Mapa"></i> Mapa
                                        </button>

                                        @if($dato->multiple == 1)
                                            <br><br>
                                            <button type="button" class="btn btn-success btn-xs" onclick="verMultiple({{ $dato->id }})">
                                                <i class="fas fa-edit" title="Ver Multiple"></i> Ver Multiple
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
