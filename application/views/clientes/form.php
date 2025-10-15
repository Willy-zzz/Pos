<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-user-plus me-2"></i>
                <?php echo isset($cliente) ? 'Editar Cliente' : 'Nuevo Cliente'; ?>
            </div>
            <div class="card-body">
                <?php 
                $action = isset($cliente) ? base_url('clientes/editar/' . $cliente->id) : base_url('clientes/crear');
                echo form_open($action); 
                ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?php echo form_error('nombre') ? 'is-invalid' : ''; ?>" 
                               name="nombre" 
                               value="<?php echo set_value('nombre', isset($cliente) ? $cliente->nombre : ''); ?>" 
                               required>
                        <?php echo form_error('nombre', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" 
                               class="form-control <?php echo form_error('telefono') ? 'is-invalid' : ''; ?>" 
                               name="telefono" 
                               value="<?php echo set_value('telefono', isset($cliente) ? $cliente->telefono : ''); ?>"
                               placeholder="555-1234-5678">
                        <?php echo form_error('telefono', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" 
                               class="form-control <?php echo form_error('correo') ? 'is-invalid' : ''; ?>" 
                               name="correo" 
                               value="<?php echo set_value('correo', isset($cliente) ? $cliente->correo : ''); ?>"
                               placeholder="cliente@ejemplo.com">
                        <?php echo form_error('correo', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">RFC</label>
                        <input type="text" 
                               class="form-control <?php echo form_error('rfc') ? 'is-invalid' : ''; ?>" 
                               name="rfc" 
                               value="<?php echo set_value('rfc', isset($cliente) ? $cliente->rfc : ''); ?>"
                               placeholder="XAXX010101000"
                               maxlength="13"
                               style="text-transform: uppercase;">
                        <?php echo form_error('rfc', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Dirección</label>
                    <textarea class="form-control" 
                              name="direccion" 
                              rows="2"
                              placeholder="Calle, número, colonia, ciudad"><?php echo set_value('direccion', isset($cliente) ? $cliente->direccion : ''); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notas</label>
                    <textarea class="form-control" 
                              name="notas" 
                              rows="3"
                              placeholder="Información adicional del cliente"><?php echo set_value('notas', isset($cliente) ? $cliente->notas : ''); ?></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="<?php echo base_url('clientes'); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        <?php echo isset($cliente) ? 'Actualizar' : 'Guardar'; ?> Cliente
                    </button>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Convertir RFC a mayúsculas automáticamente
    document.querySelector('input[name="rfc"]').addEventListener('input', function(e) {
        e.target.value = e.target.value.toUpperCase();
    });
</script>
