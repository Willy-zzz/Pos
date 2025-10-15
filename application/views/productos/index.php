<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-box me-2"></i>Lista de Productos y Servicios</span>
                <a href="<?php echo base_url('productos/crear'); ?>" class="btn btn-light btn-sm">
                    <i class="fas fa-plus me-1"></i>Nuevo Producto/Servicio
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Tipo</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td>
                                    <?php if ($producto->codigo): ?>
                                        <code><?php echo $producto->codigo; ?></code>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo $producto->nombre; ?></strong>
                                    <?php if ($producto->descripcion): ?>
                                        <br><small class="text-muted"><?php echo character_limiter($producto->descripcion, 50); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($producto->categoria_nombre): ?>
                                        <span class="badge bg-secondary"><?php echo $producto->categoria_nombre; ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">Sin categoría</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($producto->tipo == 'servicio'): ?>
                                        <span class="badge bg-info"><i class="fas fa-spa me-1"></i>Servicio</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning"><i class="fas fa-box me-1"></i>Producto</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong class="text-success">$<?php echo number_format($producto->precio, 2); ?></strong>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?php echo base_url('productos/editar/' . $producto->id); ?>" 
                                           class="btn btn-outline-primary" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?php echo base_url('productos/eliminar/' . $producto->id); ?>" 
                                           class="btn btn-outline-danger" 
                                           title="Eliminar"
                                           onclick="return confirm('¿Estás seguro de eliminar este producto/servicio?');">
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
