<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Imagen</th>
                            <th>Fecha</th>
                            <th>Activo</th>
                            <th>Posición</th>
                            <th>Opciones</th>
                        </tr>
                        </thead>
                        <tbody id="tablecontents">
                        @foreach($listado as $dato)
                            <tr class="row1" data-id="{{ $dato->id }}">
                                <td>{{ $dato->nombreestado }}</td>
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

                                <td>{{ $dato->posicion }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-xs" onclick="modalInformacion({{ $dato->id }})">
                                        <i class="fas fa-edit" title="Editar"></i> Editar
                                    </button>

                                    @if($dato->id_tipo_envio_denuncia == 3)
                                        <br><br>
                                        <button type="button" class="btn btn-success btn-xs" onclick="denunciaMultiple({{ $dato->id }})">
                                            <i class="fas fa-edit" title="Opciones"></i> Opciones
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

            axios.post('/admin/listadenuncia/multiple/modificar/posiciones',  {
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
