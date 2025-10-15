<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-users-cog me-2"></i>Usuarios del Sistema</span>
                <a href="<?php echo base_url('configuracion/crear_usuario'); ?>" class="btn btn-light btn-sm">
                    <i class="fas fa-plus me-1"></i>Nuevo Usuario
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Nombre Completo</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Última Sesión</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usr): ?>
                            <tr>
                                <td><strong><?php echo $usr->username; ?></strong></td>
                                <td><?php echo $usr->nombre_completo; ?></td>
                                <td><?php echo $usr->email; ?></td>
                                <td>
                                    <?php if ($usr->rol == 'admin'): ?>
                                        <span class="badge bg-danger">Administrador</span>
                                    <?php else: ?>
                                        <span class="badge bg-primary">Usuario</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($usr->activo): ?>
                                        <span class="badge bg-success">Activo</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $usr->ultima_sesion ? date('d/m/Y H:i', strtotime($usr->ultima_sesion)) : 'Nunca'; ?></td>
                                <td>
                                    <a href="<?php echo base_url('configuracion/editar_usuario/' . $usr->id); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
