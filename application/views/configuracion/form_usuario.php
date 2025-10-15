<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-user me-2"></i><?php echo isset($usuario_editar) ? 'Editar Usuario' : 'Nuevo Usuario'; ?>
            </div>
            <div class="card-body">
                <?php 
                $action = isset($usuario_editar) ? base_url('configuracion/editar_usuario/' . $usuario_editar->id) : base_url('configuracion/crear_usuario');
                echo form_open($action); 
                ?>

                <?php if (!isset($usuario_editar)): ?>
                <div class="mb-3">
                    <label class="form-label">Usuario <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?php echo form_error('username') ? 'is-invalid' : ''; ?>" name="username" required>
                    <?php echo form_error('username', '<div class="invalid-feedback">', '</div>'); ?>
                </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nombre_completo" value="<?php echo isset($usuario_editar) ? $usuario_editar->nombre_completo : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo isset($usuario_editar) ? $usuario_editar->email : ''; ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña <?php echo isset($usuario_editar) ? '(dejar vacío para no cambiar)' : '<span class="text-danger">*</span>'; ?></label>
                    <input type="password" class="form-control" name="password" <?php echo !isset($usuario_editar) ? 'required' : ''; ?>>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rol <span class="text-danger">*</span></label>
                    <select class="form-select" name="rol" required>
                        <option value="usuario" <?php echo (isset($usuario_editar) && $usuario_editar->rol == 'usuario') ? 'selected' : ''; ?>>Usuario</option>
                        <option value="admin" <?php echo (isset($usuario_editar) && $usuario_editar->rol == 'admin') ? 'selected' : ''; ?>>Administrador</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="<?php echo base_url('configuracion/usuarios'); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i><?php echo isset($usuario_editar) ? 'Actualizar' : 'Crear'; ?> Usuario
                    </button>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
