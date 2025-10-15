<style>
    .pos-container {
        display: flex;
        gap: 20px;
        height: calc(100vh - 200px);
    }
    
    .pos-productos {
        flex: 2;
        overflow-y: auto;
    }
    
    .pos-carrito {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .producto-card {
        cursor: pointer;
        transition: all 0.2s;
        border: 2px solid transparent;
    }
    
    .producto-card:hover {
        border-color: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
    }
    
    .carrito-items {
        flex: 1;
        overflow-y: auto;
        max-height: 400px;
    }
    
    .carrito-total {
        border-top: 3px solid #667eea;
        padding-top: 15px;
        margin-top: 15px;
    }
    
    .item-carrito {
        border-bottom: 1px solid #e0e0e0;
        padding: 10px 0;
    }
</style>

<div class="pos-container">
    <!-- Panel de Productos -->
    <div class="pos-productos">
        <div class="card h-100">
            <div class="card-header">
                <i class="fas fa-box me-2"></i>Productos y Servicios
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <input type="text" 
                           class="form-control" 
                           id="buscar-producto" 
                           placeholder="Buscar producto o servicio...">
                </div>
                
                <div class="row" id="lista-productos">
                    <?php foreach ($productos as $producto): ?>
                    <div class="col-md-6 col-lg-4 mb-3 producto-item">
                        <div class="card producto-card h-100" 
                             onclick="agregarAlCarrito(<?php echo $producto->id; ?>, '<?php echo addslashes($producto->nombre); ?>', <?php echo $producto->precio; ?>)">
                            <div class="card-body">
                                <h6 class="card-title"><?php echo $producto->nombre; ?></h6>
                                <p class="card-text text-muted small mb-2">
                                    <?php echo $producto->descripcion ? character_limiter($producto->descripcion, 50) : 'Sin descripción'; ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-info"><?php echo ucfirst($producto->tipo); ?></span>
                                    <strong class="text-success">$<?php echo number_format($producto->precio, 2); ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel de Carrito -->
    <div class="pos-carrito">
        <div class="card h-100 d-flex flex-column">
            <div class="card-header">
                <i class="fas fa-shopping-cart me-2"></i>Carrito de Venta
            </div>
            <div class="card-body flex-grow-1 d-flex flex-column">
                <!-- Cliente -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Cliente</label>
                    <select class="form-select select2" id="cliente_id" required>
                        <option value="">Seleccionar cliente...</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?php echo $cliente->id; ?>">
                                <?php echo $cliente->nombre; ?> - <?php echo $cliente->telefono; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-2 w-100" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente">
                        <i class="fas fa-plus me-1"></i>Nuevo Cliente
                    </button>
                </div>

                <!-- Items del carrito -->
                <div class="carrito-items flex-grow-1" id="carrito-items">
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                        <p>El carrito está vacío</p>
                    </div>
                </div>

                <!-- Totales -->
                <div class="carrito-total">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <strong id="subtotal">$0.00</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Descuento:</span>
                        <input type="number" 
                               class="form-control form-control-sm w-50" 
                               id="descuento" 
                               value="0" 
                               min="0" 
                               step="0.01"
                               onchange="calcularTotal()">
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <h5>Total:</h5>
                        <h5 class="text-success" id="total">$0.00</h5>
                    </div>

                    <!-- Método de pago -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Método de Pago</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="metodo_pago" id="efectivo" value="efectivo" checked>
                            <label class="btn btn-outline-success" for="efectivo">
                                <i class="fas fa-money-bill me-1"></i>Efectivo
                            </label>

                            <input type="radio" class="btn-check" name="metodo_pago" id="tarjeta" value="tarjeta">
                            <label class="btn btn-outline-info" for="tarjeta">
                                <i class="fas fa-credit-card me-1"></i>Tarjeta
                            </label>
                        </div>
                    </div>

                    <!-- Monto pagado (solo efectivo) -->
                    <div class="mb-3" id="div-monto-pagado">
                        <label class="form-label">Monto Pagado</label>
                        <input type="number" 
                               class="form-control" 
                               id="monto_pagado" 
                               step="0.01" 
                               min="0"
                               onchange="calcularCambio()">
                    </div>

                    <!-- Cambio -->
                    <div class="mb-3" id="div-cambio" style="display: none;">
                        <div class="alert alert-info mb-0">
                            <strong>Cambio: <span id="cambio">$0.00</span></strong>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary w-100 btn-lg" onclick="procesarVenta()">
                        <i class="fas fa-check me-2"></i>Procesar Venta
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nuevo Cliente -->
<div class="modal fade" id="modalNuevoCliente" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Cliente Rápido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nombre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nuevo_cliente_nombre" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="nuevo_cliente_telefono">
                </div>
                <div class="mb-3">
                    <label class="form-label">Correo</label>
                    <input type="email" class="form-control" id="nuevo_cliente_correo">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarClienteRapido()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
let carrito = [];

// Agregar producto al carrito
function agregarAlCarrito(id, nombre, precio) {
    const itemExistente = carrito.find(item => item.producto_id === id);
    
    if (itemExistente) {
        itemExistente.cantidad++;
        itemExistente.subtotal = itemExistente.cantidad * itemExistente.precio;
    } else {
        carrito.push({
            producto_id: id,
            nombre: nombre,
            precio: precio,
            cantidad: 1,
            subtotal: precio
        });
    }
    
    actualizarCarrito();
}

// Actualizar vista del carrito
function actualizarCarrito() {
    const container = document.getElementById('carrito-items');
    
    if (carrito.length === 0) {
        container.innerHTML = `
            <div class="text-center text-muted py-5">
                <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                <p>El carrito está vacío</p>
            </div>
        `;
    } else {
        let html = '';
        carrito.forEach((item, index) => {
            html += `
                <div class="item-carrito">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <strong>${item.nombre}</strong>
                        <button class="btn btn-sm btn-outline-danger" onclick="eliminarItem(${index})">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary" onclick="cambiarCantidad(${index}, -1)">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button class="btn btn-outline-secondary" disabled>${item.cantidad}</button>
                            <button class="btn btn-outline-secondary" onclick="cambiarCantidad(${index}, 1)">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <strong class="text-success">$${item.subtotal.toFixed(2)}</strong>
                    </div>
                </div>
            `;
        });
        container.innerHTML = html;
    }
    
    calcularTotal();
}

// Cambiar cantidad
function cambiarCantidad(index, cambio) {
    carrito[index].cantidad += cambio;
    
    if (carrito[index].cantidad <= 0) {
        carrito.splice(index, 1);
    } else {
        carrito[index].subtotal = carrito[index].cantidad * carrito[index].precio;
    }
    
    actualizarCarrito();
}

// Eliminar item
function eliminarItem(index) {
    carrito.splice(index, 1);
    actualizarCarrito();
}

// Calcular total
function calcularTotal() {
    const subtotal = carrito.reduce((sum, item) => sum + item.subtotal, 0);
    const descuento = parseFloat(document.getElementById('descuento').value) || 0;
    const total = subtotal - descuento;
    
    document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('total').textContent = '$' + total.toFixed(2);
    
    calcularCambio();
}

// Calcular cambio
function calcularCambio() {
    const metodoPago = document.querySelector('input[name="metodo_pago"]:checked').value;
    
    if (metodoPago === 'efectivo') {
        const total = parseFloat(document.getElementById('total').textContent.replace('$', ''));
        const montoPagado = parseFloat(document.getElementById('monto_pagado').value) || 0;
        const cambio = montoPagado - total;
        
        document.getElementById('cambio').textContent = '$' + cambio.toFixed(2);
        
        if (montoPagado > 0) {
            document.getElementById('div-cambio').style.display = 'block';
        } else {
            document.getElementById('div-cambio').style.display = 'none';
        }
    }
}

// Mostrar/ocultar monto pagado según método de pago
document.querySelectorAll('input[name="metodo_pago"]').forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.value === 'efectivo') {
            document.getElementById('div-monto-pagado').style.display = 'block';
        } else {
            document.getElementById('div-monto-pagado').style.display = 'none';
            document.getElementById('div-cambio').style.display = 'none';
        }
    });
});

// Procesar venta
function procesarVenta() {
    if (carrito.length === 0) {
        alert('El carrito está vacío');
        return;
    }
    
    const clienteId = document.getElementById('cliente_id').value;
    if (!clienteId) {
        alert('Debe seleccionar un cliente');
        return;
    }
    
    const metodoPago = document.querySelector('input[name="metodo_pago"]:checked').value;
    const subtotal = carrito.reduce((sum, item) => sum + item.subtotal, 0);
    const descuento = parseFloat(document.getElementById('descuento').value) || 0;
    const total = subtotal - descuento;
    
    let montoPagado = total;
    let cambio = 0;
    
    if (metodoPago === 'efectivo') {
        montoPagado = parseFloat(document.getElementById('monto_pagado').value) || 0;
        
        if (montoPagado < total) {
            alert('El monto pagado es insuficiente');
            return;
        }
        
        cambio = montoPagado - total;
    }
    
    // Crear formulario y enviar
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?php echo base_url('ventas/procesar'); ?>';
    
    const campos = {
        'cliente_id': clienteId,
        'metodo_pago': metodoPago,
        'items': JSON.stringify(carrito),
        'subtotal': subtotal,
        'descuento': descuento,
        'total': total,
        'monto_pagado': montoPagado,
        'cambio': cambio,
        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
    };
    
    for (const [key, value] of Object.entries(campos)) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        form.appendChild(input);
    }
    
    document.body.appendChild(form);
    form.submit();
}

// Buscar productos
document.getElementById('buscar-producto').addEventListener('input', function(e) {
    const termino = e.target.value.toLowerCase();
    const productos = document.querySelectorAll('.producto-item');
    
    productos.forEach(producto => {
        const texto = producto.textContent.toLowerCase();
        if (texto.includes(termino)) {
            producto.style.display = 'block';
        } else {
            producto.style.display = 'none';
        }
    });
});

// Guardar cliente rápido
function guardarClienteRapido() {
    const nombre = document.getElementById('nuevo_cliente_nombre').value;
    
    if (!nombre) {
        alert('El nombre es obligatorio');
        return;
    }
    
    const datos = {
        nombre: nombre,
        telefono: document.getElementById('nuevo_cliente_telefono').value,
        correo: document.getElementById('nuevo_cliente_correo').value,
        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
    };
    
    fetch('<?php echo base_url('ventas/crear_cliente_rapido'); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams(datos)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Agregar al select
            const select = document.getElementById('cliente_id');
            const option = new Option(data.cliente.nombre + ' - ' + data.cliente.telefono, data.cliente.id, true, true);
            select.add(option);
            
            // Cerrar modal
            bootstrap.Modal.getInstance(document.getElementById('modalNuevoCliente')).hide();
            
            // Limpiar campos
            document.getElementById('nuevo_cliente_nombre').value = '';
            document.getElementById('nuevo_cliente_telefono').value = '';
            document.getElementById('nuevo_cliente_correo').value = '';
            
            alert('Cliente creado exitosamente');
        } else {
            alert('Error: ' + data.message);
        }
    });
}
</script>
