<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-box me-2"></i>
                <?php echo isset($producto) ? 'Editar Producto/Servicio' : 'Nuevo Producto/Servicio'; ?>
            </div>
            <div class="card-body">
                <?php 
                $action = isset($producto) ? base_url('productos/editar/' . $producto->id) : base_url('productos/crear');
                echo form_open($action); 
                ?>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Código</label>
                        <input type="text" 
                               class="form-control" 
                               name="codigo" 
                               value="<?php echo set_value('codigo', isset($producto) ? $producto->codigo : ''); ?>"
                               placeholder="SRV001">
                        <small class="text-muted">Opcional - Se genera automáticamente si se deja vacío</small>
                    </div>

                    <div class="col-md-8 mb-3">
                        <label class="form-label">Nombre <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?php echo form_error('nombre') ? 'is-invalid' : ''; ?>" 
                               name="nombre" 
                               value="<?php echo set_value('nombre', isset($producto) ? $producto->nombre : ''); ?>" 
                               required>
                        <?php echo form_error('nombre', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea class="form-control" 
                              name="descripcion" 
                              rows="3"
                              placeholder="Descripción detallada del producto o servicio"><?php echo set_value('descripcion', isset($producto) ? $producto->descripcion : ''); ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Categoría</label>
                        <select class="form-select" name="categoria_id">
                            <option value="">Sin categoría</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?php echo $categoria->id; ?>" 
                                        <?php echo set_select('categoria_id', $categoria->id, (isset($producto) && $producto->categoria_id == $categoria->id)); ?>>
                                    <?php echo $categoria->nombre; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipo <span class="text-danger">*</span></label>
                        <select class="form-select <?php echo form_error('tipo') ? 'is-invalid' : ''; ?>" 
                                name="tipo" 
                                required>
                            <option value="">Seleccionar...</option>
                            <option value="servicio" <?php echo set_select('tipo', 'servicio', (isset($producto) && $producto->tipo == 'servicio')); ?>>
                                Servicio
                            </option>
                            <option value="producto" <?php echo set_select('tipo', 'producto', (isset($producto) && $producto->tipo == 'producto')); ?>>
                                Producto
                            </option>
                        </select>
                        <?php echo form_error('tipo', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Precio <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" 
                               class="form-control <?php echo form_error('precio') ? 'is-invalid' : ''; ?>" 
                               name="precio" 
                               value="<?php echo set_value('precio', isset($producto) ? $producto->precio : ''); ?>" 
                               step="0.01"
                               min="0"
                               required>
                        <span class="input-group-text">MXN</span>
                        <?php echo form_error('precio', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="<?php echo base_url('productos'); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        <?php echo isset($producto) ? 'Actualizar' : 'Guardar'; ?> Producto/Servicio
                    </button>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
