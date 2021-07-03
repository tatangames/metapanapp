<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="tabla" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Tipo Partida</th>
                                <th>Tel</th>
                                <th>Solicito</th>
                                <th>Opciones</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($listado as $dato)
                                <tr>
                                    <td>{{ $dato->fecha }}</td>
                                    <td>{{ $dato->estado }}</td>
                                    <td>{{ $dato->tipo }}</td>
                                    <td>{{ $dato->telefono }}</td>
                                    <td>{{ $dato->solicito }}</td>

                                    <td>
                                        <button type="button" class="btn btn-success btn-xs" onclick="modalInformacion({{ $dato->id }})">
                                            <i class="fas fa-edit" title="Información"></i> Información
                                        </button>

                                        @if($dato->id_estado_partida == 2)
                                            <br><br>
                                            <button type="button" class="btn btn-success btn-xs" onclick="partidaEncontrada({{ $dato->id }})">
                                                <i class="fas fa-edit" title="Partida Encontrada"></i> Encontrada
                                            </button>

                                            <br><br>
                                            <button type="button" class="btn btn-danger btn-xs" onclick="partidaNoEncontrada({{ $dato->id }})">
                                                <i class="fas fa-edit" title="Partida No Encontrada"></i> No encontrada
                                            </button>

                                        @elseif ($dato->id_estado_partida == 4)
                                            <br><br>
                                            <button type="button" class="btn btn-danger btn-xs" onclick="infoCancelar({{ $dato->id }})">
                                                <i class="fas fa-edit" title="Cancelar"></i> Cancelar
                                            </button>

                                        @elseif ($dato->id_estado_partida == 5)
                                            <br><br>
                                            <button type="button" class="btn btn-success btn-xs" onclick="infoCompletar({{ $dato->id }})">
                                                <i class="fas fa-edit" title="Completar"></i> Completar
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
