# Sistema POS - Depilación Láser

Sistema de Punto de Venta desarrollado en PHP con CodeIgniter 3 para tiendas de depilación láser.

## Características

- Gestión completa de clientes (CRUD)
- Gestión de productos y servicios con categorías
- Sistema de ventas con múltiples métodos de pago (efectivo, tarjeta)
- Generación automática de tickets térmicos (80mm)
- Generación de contratos personalizables en formato A4
- Impresión automática compatible con impresoras térmicas
- Panel de reportes y estadísticas con exportación a Excel
- Sistema de autenticación con roles (Admin/Usuario)
- Configuración personalizable del negocio
- Plantillas de contratos editables con variables dinámicas

## Requisitos del Sistema

- **PHP 7.2 o superior**
- **MySQL 5.7 o superior**
- **Apache con mod_rewrite habilitado**
- **XAMPP (recomendado para Windows)**
- **CodeIgniter 3.1.13** (framework requerido)
- Composer (opcional, para generación avanzada de PDFs)

## Instalación Rápida

### 1. Descargar CodeIgniter 3
\\\
https://codeigniter.com/userguide3/installation/downloads.html
\\\
Descarga CodeIgniter 3.1.13 y extrae el archivo.

### 2. Instalar XAMPP
Descarga e instala XAMPP desde https://www.apachefriends.org/

### 3. Integrar el proyecto
\\\
1. Crea la carpeta: C:\xampp\htdocs\pos-laser\
2. Copia la carpeta "system" de CodeIgniter a pos-laser\
3. Copia todos los archivos de este proyecto a pos-laser\
\\\

Estructura final:
\\\
C:\xampp\htdocs\pos-laser\
├── system/              ← De CodeIgniter
├── application/         ← De este proyecto
├── assets/              ← De este proyecto
├── database/            ← De este proyecto
├── index.php            ← De este proyecto
├── .htaccess            ← De este proyecto
└── composer.json        ← De este proyecto
\\\

### 4. Crear base de datos
1. Abre phpMyAdmin: http://localhost/phpmyadmin
2. Crea una base de datos llamada: `pos_laser_depilacion`
3. Importa el archivo `database/pos_laser.sql`

### 5. Configurar la aplicación
Edita `application/config/database.php`:
\\\php
'hostname' => 'localhost',
'username' => 'root',
'password' => '',
'database' => 'pos_laser_depilacion',
\\\

Edita `application/config/config.php`:
\\\php
$config['base_url'] = 'http://localhost/pos-laser/';
\\\

### 6. Acceder al sistema
Abre tu navegador: **http://localhost/pos-laser/**

**Credenciales por defecto:**
- Usuario: `admin`
- Contraseña: `admin123`

## Estructura del Proyecto

\\\
pos-laser/
├── application/
│   ├── config/          # Configuración (database, routes, autoload)
│   ├── controllers/     # Controladores (Auth, Clientes, Productos, Ventas, etc.)
│   ├── models/          # Modelos (Cliente_model, Producto_model, Venta_model, etc.)
│   ├── views/           # Vistas (templates, clientes, productos, ventas, reportes)
│   ├── core/            # MY_Controller (controlador base con autenticación)
│   └── helpers/         # Helpers personalizados (pdf_helper, impresion_helper)
├── assets/
│   ├── css/            # Estilos personalizados
│   ├── js/             # JavaScript (jQuery, funciones del POS)
│   └── img/            # Imágenes y logos
├── database/           # Scripts SQL (pos_laser.sql)
├── system/             # Core de CodeIgniter (debe copiarse de CI3)
├── index.php           # Punto de entrada
├── .htaccess           # Configuración Apache (URLs amigables)
└── composer.json       # Dependencias PHP
\\\

## Módulos del Sistema

### 1. Dashboard
- Resumen de ventas del día
- Estadísticas generales
- Últimas ventas realizadas
- Acceso rápido a módulos

### 2. Gestión de Clientes
- Registro completo de clientes
- Búsqueda y filtrado
- Edición y eliminación
- Historial de compras por cliente

### 3. Gestión de Productos/Servicios
- Catálogo de productos y servicios
- Organización por categorías
- Control de precios
- Tipos: Producto o Servicio

### 4. Sistema de Ventas (POS)
- Interfaz tipo punto de venta
- Carrito de compras interactivo
- Selección rápida de clientes
- Creación de clientes desde el POS
- Múltiples métodos de pago
- Cálculo automático de cambio
- Generación automática de tickets y contratos

### 5. Tickets y Contratos
- **Tickets térmicos**: Formato 80mm para impresoras térmicas
- **Contratos A4**: Formato profesional con plantillas personalizables
- Variables dinámicas: {cliente}, {fecha}, {total}, {productos}, etc.
- Impresión automática configurable
- Vista previa antes de imprimir

### 6. Reportes
- Reporte de ventas por período
- Filtros por fecha
- Estadísticas de productos más vendidos
- Exportación a Excel
- Gráficos y visualizaciones

### 7. Configuración
- **Datos del negocio**: Nombre, dirección, teléfono, RFC
- **Plantillas de contratos**: Editor de plantillas con variables
- **Gestión de usuarios**: Crear usuarios con roles
- **Configuración de impresión**: Activar/desactivar impresión automática

## Uso del Sistema

### Realizar una Venta
1. Ve a **"Nueva Venta"** en el menú
2. Selecciona un cliente existente o crea uno nuevo
3. Busca y agrega productos/servicios al carrito
4. Verifica el total calculado automáticamente
5. Selecciona el método de pago (Efectivo o Tarjeta)
6. Si es efectivo, ingresa el monto recibido (calcula cambio automático)
7. Haz clic en **"Procesar Venta"**
8. El sistema generará e imprimirá automáticamente:
   - Ticket térmico (80mm)
   - Contrato (A4)

### Personalizar Contratos
1. Ve a **Configuración > Plantillas**
2. Selecciona la plantilla a editar
3. Usa variables dinámicas:
   - `{cliente}` - Nombre del cliente
   - `{fecha}` - Fecha de la venta
   - `{total}` - Total de la venta
   - `{productos}` - Lista de productos/servicios
   - `{negocio}` - Nombre del negocio
   - `{direccion}` - Dirección del negocio
4. Guarda los cambios

### Ver Reportes
1. Ve a **Reportes > Ventas**
2. Selecciona el rango de fechas
3. Haz clic en **"Generar Reporte"**
4. Exporta a Excel si lo necesitas

## Impresión

El sistema es compatible con impresoras térmicas estándar de 80mm:
- Epson TM-T20, TM-T88
- XPrinter XP-80C, XP-58
- Star Micronics TSP100, TSP650
- Bixolon SRP-350
- Cualquier impresora térmica de 80mm con driver Windows

**Configuración de impresora:**
1. Conecta la impresora vía USB
2. Instala los drivers del fabricante
3. Configura como impresora predeterminada en Windows
4. En el sistema, activa la impresión automática desde Configuración

## Seguridad

- Contraseñas encriptadas con `password_hash()` de PHP
- Sesiones seguras con CodeIgniter
- Protección contra SQL Injection (uso de Query Builder)
- Validación de datos en servidor
- Control de acceso por roles (Admin/Usuario)

## Tecnologías Utilizadas

- **Backend**: PHP 7.2+, CodeIgniter 3
- **Base de datos**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript, jQuery
- **UI Framework**: Bootstrap 5
- **Iconos**: Font Awesome 6
- **Generación de PDFs**: TCPDF (opcional vía Composer)

## Solución de Problemas

### Error: "La carpeta del sistema no existe: system"
**Solución**: Descarga CodeIgniter 3 y copia la carpeta `system` al proyecto.

### Error: "404 Not Found"
**Solución**: Habilita `mod_rewrite` en Apache. Edita `httpd.conf` y reinicia Apache.

### Error de conexión a base de datos
**Solución**: Verifica que MySQL esté corriendo y que las credenciales en `config/database.php` sean correctas.

### No imprime tickets
**Solución**: Verifica que la impresora esté conectada, configurada como predeterminada, y que JavaScript esté habilitado en el navegador.

## Licencia

Sistema desarrollado para uso comercial privado.

## Soporte

Para soporte técnico, consulta el archivo `INSTALACION.txt` o contacta al desarrollador.

---

**Desarrollado con ❤️ para tiendas de depilación láser**
