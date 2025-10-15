<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-filter me-2"></i>Filtros de Búsqueda
            </div>
            <div class="card-body">
                <?php echo form_open('reportes/ventas', array('method' => 'get', 'class' => 'row g-3')); ?>
                    <div class="col-md-4">
                        <label class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" name="fecha_inicio" value="<?php echo $fecha_inicio; ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Fecha Fin</label>
                        <input type="date" class="form-control" name="fecha_fin" value="<?php echo $fecha_fin; ?>" required>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-1"></i>Buscar
                        </button>
                        <a href="<?php echo base_url('reportes/exportar?fecha_inicio=' . $fecha_inicio . '&fecha_fin=' . $fecha_fin); ?>" class="btn btn-success">
                            <i class="fas fa-file-excel me-1"></i>Exportar
                        </a>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card stat-card success">
            <div class="card-body">
                <h6 class="text-muted mb-1">Total Ventas</h6>
                <h3 class="mb-0">$<?php echo number_format($total_ventas, 2); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card stat-card info">
            <div class="card-body">
                <h6 class="text-muted mb-1">Efectivo</h6>
                <h3 class="mb-0">$<?php echo number_format($total_efectivo, 2); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card stat-card warning">
            <div class="card-body">
                <h6 class="text-muted mb-1">Tarjeta</h6>
                <h3 class="mb-0">$<?php echo number_format($total_tarjeta, 2); ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-list me-2"></i>Detalle de Ventas
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Vendedor</th>
                                <th>Subtotal</th>
                                <th>Descuento</th>
                                <th>Total</th>
                                <th>Método Pago</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ventas as $venta): ?>
                            <tr>
                                <td><strong><?php echo $venta->folio; ?></strong></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($venta->fecha_venta)); ?></td>
                                <td><?php echo $venta->cliente_nombre; ?></td>
                                <td><?php echo $venta->vendedor; ?></td>
                                <td>$<?php echo number_format($venta->subtotal, 2); ?></td>
                                <td><?php echo $venta->descuento > 0 ? '-$' . number_format($venta->descuento, 2) : '-'; ?></td>
                                <td><strong class="text-success">$<?php echo number_format($venta->total, 2); ?></strong></td>
                                <td>
                                    <?php if ($venta->metodo_pago == 'efectivo'): ?>
                                        <span class="badge bg-success">Efectivo</span>
                                    <?php else: ?>
                                        <span class="badge bg-info">Tarjeta</span>
                                    <?php endif; ?>
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
