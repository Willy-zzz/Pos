<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-receipt me-2"></i>Detalle de Venta - <?php echo $venta->folio; ?></span>
                <div class="btn-group btn-group-sm">
                    <a href="<?php echo base_url('ventas/ticket/' . $venta->id); ?>" 
                       class="btn btn-success" 
                       target="_blank">
                        <i class="fas fa-print me-1"></i>Ticket
                    </a>
                    <a href="<?php echo base_url('ventas/contrato/' . $venta->id); ?>" 
                       class="btn btn-info" 
                       target="_blank">
                        <i class="fas fa-file-contract me-1"></i>Contrato
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Información de la venta -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted">Información del Cliente</h6>
                        <p class="mb-1"><strong>Nombre:</strong> <?php echo $venta->nombre; ?></p>
                        <p class="mb-1"><strong>Teléfono:</strong> <?php echo $venta->telefono; ?></p>
                        <p class="mb-1"><strong>Correo:</strong> <?php echo $venta->correo; ?></p>
                        <?php if ($venta->rfc): ?>
                            <p class="mb-1"><strong>RFC:</strong> <?php echo $venta->rfc; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Información de la Venta</h6>
                        <p class="mb-1"><strong>Folio:</strong> <?php echo $venta->folio; ?></p>
                        <p class="mb-1"><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($venta->fecha_venta)); ?></p>
                        <p class="mb-1"><strong>Vendedor:</strong> <?php echo $venta->vendedor; ?></p>
                        <p class="mb-1">
                            <strong>Método de Pago:</strong> 
                            <?php if ($venta->metodo_pago == 'efectivo'): ?>
                                <span class="badge bg-success">Efectivo</span>
                            <?php else: ?>
                                <span class="badge bg-info">Tarjeta</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>

                <!-- Detalle de productos -->
                <h6 class="text-muted mb-3">Productos/Servicios</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Producto/Servicio</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Precio Unit.</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($detalle as $item): ?>
                            <tr>
                                <td>
                                    <strong><?php echo $item->producto_nombre; ?></strong>
                                    <?php if ($item->codigo): ?>
                                        <br><small class="text-muted"><?php echo $item->codigo; ?></small>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?php echo $item->cantidad; ?></td>
                                <td class="text-end">$<?php echo number_format($item->precio_unitario, 2); ?></td>
                                <td class="text-end">$<?php echo number_format($item->subtotal, 2); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                <td class="text-end">$<?php echo number_format($venta->subtotal, 2); ?></td>
                            </tr>
                            <?php if ($venta->descuento > 0): ?>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Descuento:</strong></td>
                                <td class="text-end text-danger">-$<?php echo number_format($venta->descuento, 2); ?></td>
                            </tr>
                            <?php endif; ?>
                            <tr class="table-success">
                                <td colspan="3" class="text-end"><strong>TOTAL:</strong></td>
                                <td class="text-end"><strong>$<?php echo number_format($venta->total, 2); ?></strong></td>
                            </tr>
                            <?php if ($venta->metodo_pago == 'efectivo'): ?>
                            <tr>
                                <td colspan="3" class="text-end">Monto Pagado:</td>
                                <td class="text-end">$<?php echo number_format($venta->monto_pagado, 2); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end">Cambio:</td>
                                <td class="text-end">$<?php echo number_format($venta->cambio, 2); ?></td>
                            </tr>
                            <?php endif; ?>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="<?php echo base_url('ventas'); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Volver
                    </a>
                    <div>
                        <a href="<?php echo base_url('ventas/ticket/' . $venta->id); ?>" 
                           class="btn btn-success" 
                           target="_blank">
                            <i class="fas fa-print me-1"></i>Imprimir Ticket
                        </a>
                        <a href="<?php echo base_url('ventas/contrato/' . $venta->id); ?>" 
                           class="btn btn-info" 
                           target="_blank">
                            <i class="fas fa-file-contract me-1"></i>Ver Contrato
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
