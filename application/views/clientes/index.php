<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-users me-2"></i>Lista de Clientes</span>
                <a href="<?php echo base_url('clientes/crear'); ?>" class="btn btn-light btn-sm">
                    <i class="fas fa-plus me-1"></i>Nuevo Cliente
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>RFC</th>
                                <th>Fecha Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td><?php echo $cliente->id; ?></td>
                                <td>
                                    <strong><?php echo $cliente->nombre; ?></strong>
                                </td>
                                <td>
                                    <?php if ($cliente->telefono): ?>
                                        <i class="fas fa-phone me-1"></i><?php echo $cliente->telefono; ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($cliente->correo): ?>
                                        <i class="fas fa-envelope me-1"></i><?php echo $cliente->correo; ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $cliente->rfc ? $cliente->rfc : '<span class="text-muted">-</span>'; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($cliente->fecha_registro)); ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?php echo base_url('clientes/editar/' . $cliente->id); ?>" 
                                           class="btn btn-outline-primary" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?php echo base_url('clientes/eliminar/' . $cliente->id); ?>" 
                                           class="btn btn-outline-danger" 
                                           title="Eliminar"
                                           onclick="return confirm('¿Estás seguro de eliminar este cliente?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
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
