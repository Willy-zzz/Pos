<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit me-2"></i>Editar Plantilla: <?php echo $plantilla->nombre; ?>
            </div>
            <div class="card-body">
                <?php echo form_open('configuracion/editar_plantilla/' . $plantilla->id); ?>

                <div class="mb-3">
                    <label class="form-label">Nombre de la Plantilla</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo $plantilla->nombre; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contenido del Contrato</label>
                    <textarea class="form-control" name="contenido" rows="20" required><?php echo $plantilla->contenido; ?></textarea>
                    <small class="text-muted">Usa las variables entre corchetes para datos dinámicos</small>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="<?php echo base_url('configuracion/plantillas'); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Cancelar
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
