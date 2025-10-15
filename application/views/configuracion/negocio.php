<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-store me-2"></i>Configuración del Negocio
            </div>
            <div class="card-body">
                <?php echo form_open('configuracion/negocio'); ?>

                <h6 class="text-muted mb-3">Información General</h6>

                <div class="mb-3">
                    <label class="form-label">Nombre del Negocio</label>
                    <input type="text" class="form-control" name="negocio_nombre" value="<?php echo $config['negocio_nombre']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Dirección</label>
                    <textarea class="form-control" name="negocio_direccion" rows="2" required><?php echo $config['negocio_direccion']; ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" class="form-control" name="negocio_telefono" value="<?php echo $config['negocio_telefono']; ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">RFC</label>
                        <input type="text" class="form-control" name="negocio_rfc" value="<?php echo $config['negocio_rfc']; ?>" maxlength="13">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="negocio_email" value="<?php echo $config['negocio_email']; ?>">
                </div>

                <hr class="my-4">

                <h6 class="text-muted mb-3">Configuración de Tickets</h6>

                <div class="mb-3">
                    <label class="form-label">Mensaje al pie del ticket</label>
                    <input type="text" class="form-control" name="ticket_mensaje_footer" value="<?php echo $config['ticket_mensaje_footer']; ?>">
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="impresion_automatica" id="impresion_automatica" <?php echo $config['impresion_automatica'] == '1' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="impresion_automatica">
                            Imprimir automáticamente ticket y contrato al finalizar venta
                        </label>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="<?php echo base_url('configuracion'); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Volver
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Guardar Cambios
                    </button>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
