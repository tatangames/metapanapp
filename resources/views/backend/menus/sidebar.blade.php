<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <img src="{{ asset('images/logoalcaldia.png') }}" alt="Logo" class="brand-image img-circle elevation-3" >
        <span class="brand-text font-weight-light">Panel Web</span>
    </a>

    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                @can('grupo.admin.roles-y-permisos')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-edit"></i>
                        <p>
                            Roles y Permisos
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.roles.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Permisos y Roles</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.permisos.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Usuarios</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                @can('grupo.admin.registros')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-edit"></i>
                        <p>
                            Registros
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    @can('vista.grupo.admin.registros.clientes')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('cliente.lista.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Clientes</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                </li>
               @endcan

                @can('grupo.admin.estados')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-edit"></i>
                        <p>
                            Estados
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    @can('vista.grupo.admin.estados.estado-partida')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('estado.partida.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Estado Partida</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('vista.grupo.admin.estados.estado-denuncia')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('estado.denuncia.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Estado Denuncia</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('vista.grupo.admin.estados.tipo-envio-denuncia')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('tipo.envio.denuncia.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tipo Envío Denuncia</p>
                            </a>
                        </li>
                    </ul>
                    @endcan


                </li>
                @endcan

                @can('grupo.admin.partida-nacimiento')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-edit"></i>
                        <p>
                            Partida Nacimiento
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    @can('vista.grupo.admin.partida-nacimiento.soli-partida-nacimiento')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('soli.partida.nacimiento.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Soli Partida Nacimiento</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('vista.grupo.admin.partida-nacimiento.partida-registro-pago')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('partida.registro.pago.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Partida Registro Pago</p>
                            </a>
                        </li>
                    </ul>
                    @endcan


                </li>
                @endcan


                @can('grupo.admin.denuncias')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-eye"></i>
                        <p>
                            Denuncias
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    @can('vista.grupo.admin.denuncias.departamento')
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('departamento.denuncia.index') }}" target="frameprincipal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Departamentos</p>
                                </a>
                            </li>
                        </ul>
                    @endcan

                    @can('vista.grupo.admin.denuncias.lista-denuncias')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('lista.denuncia.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lista Denuncia</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('vista.grupo.admin.denuncias.denuncias-realizadas')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('denuncia.realizada.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Denuncia Realizadas</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                </li>
                @endcan


                @can('grupo.admin.zona-mapa')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-globe"></i>
                        <p>
                            Zona Mapa
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    @can('vista.grupo.admin.zona-mapa.zonas')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('zona.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Zonas</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                </li>
                @endcan

                @can('grupo.admin.banco')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-building"></i>
                        <p>
                            Banco
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>


                    @can('vista.grupo.admin.banco.registro-de-pagos')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('registro.pago.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Registro de Pagos</p>
                            </a>
                        </li>
                    </ul>
                    @endcan


                    @can('vista.grupo.admin.banco.banco-estado')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('banco.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Banco Estado</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('vista.grupo.admin.banco.costos')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('costo.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Costos</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                </li>
                @endcan

                @can('grupo.admin.servicios')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-user"></i>
                        <p>
                            Servicios
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    @can('vista.grupo.admin.servicios.tipo-servicios')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('tipo.servicio.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tipo Servicios</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('vista.grupo.admin.servicios.servicios-alcaldia')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('servicio.alcaldia.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Servicios Alcaldía</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('vista.grupo.admin.servicios.notificaciones')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('notificaciones.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Notificaciones</p>
                            </a>
                        </li>
                    </ul>
                    @endcan


                </li>
                @endcan


                @can('grupo.admin2.solicitudes')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-user"></i>
                        <p>
                            Solicitudes
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    @can('vista.grupo.admin2.solicitudes.nueva-solicitud')
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin2.nuevas.solicitudes.index') }}" target="frameprincipal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Nuevas Solicitudes</p>
                                </a>
                            </li>
                        </ul>
                    @endcan
                </li>
                @endcan


                @can('grupo.admin2.denuncias.nuevassolicitudes')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-user"></i>
                            <p>
                                Solicitudes
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        @can('vista.grupo.admin2.denuncia-electrico.nueva-solicitud')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin2.nuevas.solicitudes.denuncias.index') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Nuevas Solicitudes</p>
                                    </a>
                                </li>
                            </ul>
                        @endcan


                        @can('vista.grupo.admin2.denuncia-electrico.historial')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin2.denuncias.completadas.lista.index') }}" target="frameprincipal" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Historial</p>
                                    </a>
                                </li>
                            </ul>
                        @endcan

                    </li>
                @endcan


                @can('grupo.admin2.partidas.nuevassolicitudes')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-user"></i>
                        <p>
                            Solicitudes
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    @can('vista.grupo.admin2.partidas.nueva-solicitud')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin2.nuevas.solicitudes.partida.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Nuevas Solicitudes</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('vista.grupo.admin2.partidas.historial')
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin2.historial.partida.complecance.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Historial</p>
                            </a>
                        </li>
                    </ul>
                    @endcan

                </li>
                @endcan


            </ul>
        </nav>




    </div>
</aside>






