<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="tabla" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Fecha</th>
                                <th>Informar A</th>
                                <th>Detalle</th>

                                <th>Opciones</th>

                            </tr>
                            </thead>
                            <tbody>

                            @foreach($dataArray as $dato)
                                <tr>
                                    <td>{{ $dato['tipo'] }}</td>
                                    <td>{{ $dato['fecha'] }}</td>
                                    <td>{{ $dato['informar'] }}</td>
                                    <td>{{ $dato['nombre'] }}</td>

                                    <td>

                                        @if( $dato['identificador'] == 1 )
                                            <button type="button" class="btn btn-primary btn-xs" onclick="infoDenuncia({{ $dato['id'] }})">
                                                <i class="fas fa-eye" title="Verificar Denuncia"></i> Verificar Denuncia
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-primary btn-xs" onclick="verificarPartida({{ $dato['id'] }})">
                                                <i class="fas fa-eye" title="Verificar Partida Nacimiento"></i> Verificar Partida
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
