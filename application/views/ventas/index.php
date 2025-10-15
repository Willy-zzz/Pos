<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-receipt me-2"></i>Historial de Ventas</span>
                <a href="<?php echo base_url('ventas/nueva'); ?>" class="btn btn-light btn-sm">
                    <i class="fas fa-plus me-1"></i>Nueva Venta
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Cliente</th>
                                <th>Vendedor</th>
                                <th>Total</th>
                                <th>Método Pago</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ventas as $venta): ?>
                            <tr>
                                <td><strong><?php echo $venta->folio; ?></strong></td>
                                <td><?php echo $venta->cliente_nombre; ?></td>
                                <td><?php echo $venta->vendedor; ?></td>
                                <td><strong class="text-success">$<?php echo number_format($venta->total, 2); ?></strong></td>
                                <td>
                                    <?php if ($venta->metodo_pago == 'efectivo'): ?>
                                        <span class="badge bg-success"><i class="fas fa-money-bill me-1"></i>Efectivo</span>
                                    <?php else: ?>
                                        <span class="badge bg-info"><i class="fas fa-credit-card me-1"></i>Tarjeta</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($venta->fecha_venta)); ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?php echo base_url('ventas/ver/' . $venta->id); ?>" 
                                           class="btn btn-outline-primary" 
                                           title="Ver detalle">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo base_url('ventas/ticket/' . $venta->id); ?>" 
                                           class="btn btn-outline-success" 
                                           title="Imprimir ticket"
                                           target="_blank">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <a href="<?php echo base_url('ventas/contrato/' . $venta->id); ?>" 
                                           class="btn btn-outline-info" 
                                           title="Ver contrato"
                                           target="_blank">
                                            <i class="fas fa-file-contract"></i>
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
