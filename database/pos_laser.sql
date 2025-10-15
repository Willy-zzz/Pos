-- Base de datos para Sistema POS - Depilación Láser
-- Versión: 1.0
-- Compatible con MySQL 5.7+

CREATE DATABASE IF NOT EXISTS pos_laser_depilacion CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pos_laser_depilacion;

-- Tabla de usuarios del sistema
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nombre_completo VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    rol ENUM('admin', 'usuario') DEFAULT 'usuario',
    activo TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ultima_sesion DATETIME NULL,
    INDEX idx_username (username),
    INDEX idx_rol (rol)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de clientes
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    direccion TEXT,
    correo VARCHAR(100),
    rfc VARCHAR(13),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    activo TINYINT(1) DEFAULT 1,
    notas TEXT,
    INDEX idx_nombre (nombre),
    INDEX idx_telefono (telefono),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de categorías de productos/servicios
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    activo TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de productos/servicios
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) UNIQUE,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    categoria_id INT,
    precio DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    tipo ENUM('producto', 'servicio') DEFAULT 'servicio',
    activo TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL,
    INDEX idx_codigo (codigo),
    INDEX idx_nombre (nombre),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de ventas
CREATE TABLE IF NOT EXISTS ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    folio VARCHAR(20) NOT NULL UNIQUE,
    cliente_id INT NOT NULL,
    usuario_id INT NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    descuento DECIMAL(10,2) DEFAULT 0.00,
    total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    metodo_pago ENUM('efectivo', 'tarjeta') NOT NULL,
    monto_pagado DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    cambio DECIMAL(10,2) DEFAULT 0.00,
    fecha_venta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ticket_impreso TINYINT(1) DEFAULT 0,
    contrato_impreso TINYINT(1) DEFAULT 0,
    notas TEXT,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE RESTRICT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE RESTRICT,
    INDEX idx_folio (folio),
    INDEX idx_cliente (cliente_id),
    INDEX idx_fecha (fecha_venta),
    INDEX idx_usuario (usuario_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de detalle de ventas
CREATE TABLE IF NOT EXISTS ventas_detalle (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venta_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL DEFAULT 1,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (venta_id) REFERENCES ventas(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE RESTRICT,
    INDEX idx_venta (venta_id),
    INDEX idx_producto (producto_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de configuración del negocio
CREATE TABLE IF NOT EXISTS configuracion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clave VARCHAR(50) NOT NULL UNIQUE,
    valor TEXT,
    descripcion VARCHAR(255),
    tipo ENUM('texto', 'numero', 'boolean', 'imagen') DEFAULT 'texto',
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_clave (clave)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de plantillas de contratos
CREATE TABLE IF NOT EXISTS plantillas_contrato (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    contenido TEXT NOT NULL,
    activo TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar usuario administrador por defecto (password: admin123)
INSERT INTO usuarios (username, password, nombre_completo, email, rol) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador', 'admin@laser.com', 'admin');

-- Insertar configuración inicial del negocio
INSERT INTO configuracion (clave, valor, descripcion, tipo) VALUES
('negocio_nombre', 'Depilación Láser Premium', 'Nombre del negocio', 'texto'),
('negocio_direccion', 'Av. Principal #123, Col. Centro', 'Dirección del negocio', 'texto'),
('negocio_telefono', '555-1234-5678', 'Teléfono del negocio', 'texto'),
('negocio_rfc', 'XAXX010101000', 'RFC del negocio', 'texto'),
('negocio_email', 'contacto@laser.com', 'Email del negocio', 'texto'),
('ticket_mensaje_footer', 'Gracias por su preferencia', 'Mensaje al pie del ticket', 'texto'),
('impresion_automatica', '1', 'Imprimir automáticamente ticket y contrato', 'boolean');

-- Insertar plantilla de contrato por defecto
INSERT INTO plantillas_contrato (nombre, contenido, activo) VALUES
('Contrato Estándar', 'CONTRATO DE PRESTACIÓN DE SERVICIOS DE DEPILACIÓN LÁSER

En la ciudad de [CIUDAD], siendo el día [FECHA], se celebra el presente contrato entre:

PRESTADOR: [NEGOCIO_NOMBRE]
RFC: [NEGOCIO_RFC]
Domicilio: [NEGOCIO_DIRECCION]

CLIENTE: [CLIENTE_NOMBRE]
RFC: [CLIENTE_RFC]
Domicilio: [CLIENTE_DIRECCION]
Teléfono: [CLIENTE_TELEFONO]
Email: [CLIENTE_EMAIL]

CLÁUSULAS:

PRIMERA: El prestador se compromete a proporcionar el servicio de depilación láser en las áreas acordadas.

SEGUNDA: El cliente acepta el servicio descrito:
[SERVICIOS_DETALLE]

TERCERA: El monto total del servicio es de: $[TOTAL] MXN
Método de pago: [METODO_PAGO]

CUARTA: El cliente declara haber sido informado sobre los cuidados pre y post tratamiento.

QUINTA: El cliente acepta que los resultados pueden variar según características individuales.

Ambas partes manifiestan su conformidad firmando el presente contrato.


_________________________                    _________________________
Firma del Prestador                          Firma del Cliente
[NEGOCIO_NOMBRE]                             [CLIENTE_NOMBRE]

Folio: [FOLIO]
Fecha: [FECHA]', 1);

-- Insertar categorías de ejemplo
INSERT INTO categorias (nombre, descripcion) VALUES
('Depilación Facial', 'Servicios de depilación en área facial'),
('Depilación Corporal', 'Servicios de depilación en cuerpo'),
('Paquetes', 'Paquetes de sesiones múltiples'),
('Productos', 'Productos para el cuidado post-tratamiento');

-- Insertar productos/servicios de ejemplo
INSERT INTO productos (codigo, nombre, descripcion, categoria_id, precio, tipo) VALUES
('SRV001', 'Depilación Láser - Axilas', 'Sesión de depilación láser en axilas', 2, 350.00, 'servicio'),
('SRV002', 'Depilación Láser - Piernas Completas', 'Sesión de depilación láser en piernas completas', 2, 1200.00, 'servicio'),
('SRV003', 'Depilación Láser - Bikini', 'Sesión de depilación láser en zona bikini', 2, 500.00, 'servicio'),
('SRV004', 'Depilación Láser - Labio Superior', 'Sesión de depilación láser en labio superior', 1, 250.00, 'servicio'),
('SRV005', 'Depilación Láser - Espalda Completa', 'Sesión de depilación láser en espalda completa', 2, 1500.00, 'servicio'),
('PKG001', 'Paquete 6 Sesiones - Axilas', 'Paquete de 6 sesiones para axilas', 3, 1800.00, 'servicio'),
('PKG002', 'Paquete 6 Sesiones - Piernas', 'Paquete de 6 sesiones para piernas completas', 3, 6000.00, 'servicio'),
('PRD001', 'Gel Post-Tratamiento', 'Gel calmante para después del tratamiento', 4, 150.00, 'producto');

-- Insertar cliente de ejemplo
INSERT INTO clientes (nombre, telefono, direccion, correo, rfc) VALUES
('Cliente de Prueba', '555-9876-5432', 'Calle Ejemplo #456', 'cliente@ejemplo.com', 'XAXX010101000');
