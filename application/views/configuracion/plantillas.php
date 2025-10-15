<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-file-contract me-2"></i>Plantillas de Contratos
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Variables disponibles:</strong> [NEGOCIO_NOMBRE], [NEGOCIO_RFC], [NEGOCIO_DIRECCION], [CLIENTE_NOMBRE], [CLIENTE_RFC], [CLIENTE_DIRECCION], [CLIENTE_TELEFONO], [CLIENTE_EMAIL], [FOLIO], [FECHA], [TOTAL], [METODO_PAGO], [SERVICIOS_DETALLE], [CIUDAD]
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Última Modificación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($plantillas as $plantilla): ?>
                            <tr>
                                <td><strong><?php echo $plantilla->nombre; ?></strong></td>
                                <td>
                                    <?php if ($plantilla->activo): ?>
                                        <span class="badge bg-success">Activa</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactiva</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($plantilla->fecha_modificacion)); ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?php echo base_url('configuracion/editar_plantilla/' . $plantilla->id); ?>" class="btn btn-outline-primary">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <?php if (!$plantilla->activo): ?>
                                        <a href="<?php echo base_url('configuracion/activar_plantilla/' . $plantilla->id); ?>" class="btn btn-outline-success">
                                            <i class="fas fa-check"></i> Activar
                                        </a>
                                        <?php endif; ?>
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
