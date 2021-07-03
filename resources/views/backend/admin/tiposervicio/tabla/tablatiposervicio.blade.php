<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Imagen</th>
                            <th>Fecha</th>
                            <th>Activo</th>
                            <th>Visible</th>
                            <th>Posición</th>
                            <th>Opciones</th>
                        </tr>
                        </thead>
                        <tbody id="tablecontents">
                        @foreach($listado as $dato)
                            <tr class="row1" data-id="{{ $dato->id }}">
                                <td>{{ $dato->nombre }}</td>
                                <td>{{ $dato->descripcion }}</td>
                                <td>
                                    <img src="{{ url('storage/imagenes/'.$dato->imagen) }}" width="100px" height="125px" />
                                </td>

                                <td>{{ $dato->fecha }}</td>
                                @if($dato->activo == 1)
                                    <td><span class="badge bg-success">Activo</span></td>
                                @else
                                    <td><span class="badge bg-warning">Inactivo</span></td>
                                @endif

                                @if($dato->visible == 1)
                                    <td><span class="badge bg-success">Visible</span></td>
                                @else
                                    <td><span class="badge bg-warning">Inactivo</span></td>
                                @endif
                                <td>{{ $dato->posicion }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-xs" onclick="modalInformacion({{ $dato->id }})">
                                        <i class="fas fa-edit" title="Editar"></i> Editar
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
</section>

<script type="text/javascript">
    $(document).ready(function() {

        $( "#tablecontents" ).sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.6,
            update: function() {
                sendOrderToServer();
            }
        });

        function sendOrderToServer() {
            openLoading();
            var order = [];
            $('tr.row1').each(function(index,element) {
                order.push({
                    id: $(this).attr('data-id'),
                    posicion: index+1
                });
            });

            axios.post('/admin/tiposervicio/modificar/posiciones',  {
                'order': order
            })
                .then((response) => {

                    closeLoading();
                    toastMensaje('success', 'Actualizado');
                    recargar();
                })
                .catch((error) => {
                    closeLoading();
                    toastMensaje('error', 'Error al actualizar');
                });
        }

    });
</script>
