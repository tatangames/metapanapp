<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="tabla" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>ID Reg. Pago</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Pago Total</th>
                                <th>Tel</th>
                                <th>Solicito</th>
                                <th>Opciones</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($listado as $dato)
                                <tr>
                                    <td>{{ $dato->id }}</td>
                                    <td>{{ $dato->id_registro_pago }}</td>
                                    <td>{{ $dato->fecha }}</td>
                                    <td>{{ $dato->estado }}</td>
                                    <td>$ {{ $dato->pago_total }}</td>
                                    <td>{{ $dato->telefono }}</td>
                                    <td>{{ $dato->solicito }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-xs" onclick="verRegistroPago({{ $dato->id_registro_pago }})">
                                            <i class="fas fa-eye" title="Registro Pago"></i> Registro Pago
                                        </button>
                                        <br>
                                        <br>

                                        <button type="button" class="btn btn-primary btn-xs" onclick="verInfoPartida({{ $dato->id }})">
                                            <i class="fas fa-eye" title="Partida"></i> Partida
                                        </button>

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
