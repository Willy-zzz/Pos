<!-- Tarjetas de estadísticas -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Ventas Hoy</h6>
                        <h3 class="mb-0"><?php echo $ventas_hoy; ?></h3>
                    </div>
                    <div class="text-primary" style="font-size: 40px;">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Hoy</h6>
                        <h3 class="mb-0">$<?php echo number_format($total_hoy, 2); ?></h3>
                    </div>
                    <div class="text-success" style="font-size: 40px;">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Clientes</h6>
                        <h3 class="mb-0"><?php echo $total_clientes; ?></h3>
                    </div>
                    <div class="text-info" style="font-size: 40px;">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Productos/Servicios</h6>
                        <h3 class="mb-0"><?php echo $total_productos; ?></h3>
                    </div>
                    <div class="text-warning" style="font-size: 40px;">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Accesos rápidos -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-bolt me-2"></i>Accesos Rápidos
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo base_url('ventas/nueva'); ?>" class="btn btn-lg btn-primary w-100" style="height: 100px;">
                            <i class="fas fa-cash-register fa-2x mb-2"></i><br>
                            <strong>Nueva Venta</strong>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo base_url('clientes/crear'); ?>" class="btn btn-lg btn-outline-primary w-100" style="height: 100px;">
                            <i class="fas fa-user-plus fa-2x mb-2"></i><br>
                            <strong>Nuevo Cliente</strong>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo base_url('ventas'); ?>" class="btn btn-lg btn-outline-primary w-100" style="height: 100px;">
                            <i class="fas fa-receipt fa-2x mb-2"></i><br>
                            <strong>Ver Ventas</strong>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo base_url('reportes'); ?>" class="btn btn-lg btn-outline-primary w-100" style="height: 100px;">
                            <i class="fas fa-chart-bar fa-2x mb-2"></i><br>
                            <strong>Reportes</strong>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Últimas ventas -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-history me-2"></i>Últimas Ventas
            </div>
            <div class="card-body">
                <?php if (!empty($ultimas_ventas)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Método Pago</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ultimas_ventas as $venta): ?>
                            <tr>
                                <td><strong><?php echo $venta->folio; ?></strong></td>
                                <td><?php echo $venta->cliente_nombre; ?></td>
                                <td><strong>$<?php echo number_format($venta->total, 2); ?></strong></td>
                                <td>
                                    <?php if ($venta->metodo_pago == 'efectivo'): ?>
                                        <span class="badge bg-success">Efectivo</span>
                                    <?php else: ?>
                                        <span class="badge bg-info">Tarjeta</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($venta->fecha_venta)); ?></td>
                                <td>
                                    <a href="<?php echo base_url('ventas/ver/' . $venta->id); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No hay ventas registradas aún</p>
                    <a href="<?php echo base_url('ventas/nueva'); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Realizar Primera Venta
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
