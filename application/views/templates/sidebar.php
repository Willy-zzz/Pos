<div class="wrapper">
    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-spa me-2"></i>POS Láser</h3>
            <p class="mb-0"><small><?php echo $usuario['nombre']; ?></small></p>
            <small class="badge bg-light text-dark"><?php echo ucfirst($usuario['rol']); ?></small>
        </div>

        <ul class="list-unstyled components">
            <li>
                <a href="<?php echo base_url('dashboard'); ?>" <?php echo ($this->uri->segment(1) == 'dashboard') ? 'class="active"' : ''; ?>>
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            
            <li>
                <a href="<?php echo base_url('ventas/nueva'); ?>" <?php echo ($this->uri->segment(1) == 'ventas' && $this->uri->segment(2) == 'nueva') ? 'class="active"' : ''; ?>>
                    <i class="fas fa-cash-register"></i> Nueva Venta
                </a>
            </li>
            
            <li>
                <a href="<?php echo base_url('ventas'); ?>" <?php echo ($this->uri->segment(1) == 'ventas' && $this->uri->segment(2) != 'nueva') ? 'class="active"' : ''; ?>>
                    <i class="fas fa-receipt"></i> Ventas
                </a>
            </li>
            
            <li>
                <a href="<?php echo base_url('clientes'); ?>" <?php echo ($this->uri->segment(1) == 'clientes') ? 'class="active"' : ''; ?>>
                    <i class="fas fa-users"></i> Clientes
                </a>
            </li>
            
            <li>
                <a href="<?php echo base_url('productos'); ?>" <?php echo ($this->uri->segment(1) == 'productos') ? 'class="active"' : ''; ?>>
                    <i class="fas fa-box"></i> Productos/Servicios
                </a>
            </li>
            
            <li>
                <a href="<?php echo base_url('reportes'); ?>" <?php echo ($this->uri->segment(1) == 'reportes') ? 'class="active"' : ''; ?>>
                    <i class="fas fa-chart-bar"></i> Reportes
                </a>
            </li>
            
            <?php if ($usuario['rol'] == 'admin'): ?>
            <li>
                <a href="<?php echo base_url('configuracion'); ?>" <?php echo ($this->uri->segment(1) == 'configuracion') ? 'class="active"' : ''; ?>>
                    <i class="fas fa-cog"></i> Configuración
                </a>
            </li>
            <?php endif; ?>
            
            <li>
                <a href="<?php echo base_url('logout'); ?>" onclick="return confirm('¿Estás seguro de cerrar sesión?');">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </a>
            </li>
        </ul>
    </nav>

    <!-- Page Content -->
    <div id="content">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <h4 class="mb-0"><?php echo isset($titulo) ? $titulo : 'Sistema POS'; ?></h4>
                <div class="ms-auto">
                    <span class="text-muted">
                        <i class="far fa-clock me-1"></i>
                        <span id="fecha-hora"></span>
                    </span>
                </div>
            </div>
        </nav>

        <div class="main-content">
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php echo $this->session->flashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
