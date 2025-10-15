<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Ventas del Mes</h6>
                        <h3 class="mb-0">$<?php echo number_format($total_ventas_mes, 2); ?></h3>
                    </div>
                    <div class="text-success" style="font-size: 40px;">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Ventas Hoy</h6>
                        <h3 class="mb-0">$<?php echo number_format($total_ventas_dia, 2); ?></h3>
                    </div>
                    <div class="text-primary" style="font-size: 40px;">
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
                        <h6 class="text-muted mb-1">Ventas del Mes</h6>
                        <h3 class="mb-0"><?php echo $num_ventas_mes; ?></h3>
                    </div>
                    <div class="text-info" style="font-size: 40px;">
                        <i class="fas fa-receipt"></i>
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
                        <h6 class="text-muted mb-1">Total Clientes</h6>
                        <h3 class="mb-0"><?php echo $num_clientes; ?></h3>
                    </div>
                    <div class="text-warning" style="font-size: 40px;">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-trophy me-2"></i>Productos/Servicios Más Vendidos
            </div>
            <div class="card-body">
                <?php if (!empty($productos_top)): ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($productos_top as $index => $producto): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-primary me-2">#<?php echo $index + 1; ?></span>
                                <strong><?php echo $producto->nombre; ?></strong>
                            </div>
                            <span class="badge bg-success"><?php echo $producto->total_vendido; ?> vendidos</span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-4">No hay datos disponibles</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-file-alt me-2"></i>Accesos Rápidos
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <a href="<?php echo base_url('reportes/ventas'); ?>" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-chart-bar me-2"></i>Reporte de Ventas por Fecha
                    </a>
                    <a href="<?php echo base_url('reportes/ventas?fecha_inicio=' . date('Y-m-01') . '&fecha_fin=' . date('Y-m-d')); ?>" class="btn btn-outline-success btn-lg">
                        <i class="fas fa-calendar-alt me-2"></i>Ventas del Mes Actual
                    </a>
                    <a href="<?php echo base_url('reportes/ventas?fecha_inicio=' . date('Y-m-d') . '&fecha_fin=' . date('Y-m-d')); ?>" class="btn btn-outline-info btn-lg">
                        <i class="fas fa-calendar-day me-2"></i>Ventas de Hoy
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
