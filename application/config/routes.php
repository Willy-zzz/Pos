<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
*/

$route['default_controller'] = 'auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Rutas de autenticación
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';
$route['dashboard'] = 'dashboard/index';

// Rutas de clientes
$route['clientes'] = 'clientes/index';
$route['clientes/crear'] = 'clientes/crear';
$route['clientes/editar/(:num)'] = 'clientes/editar/$1';
$route['clientes/eliminar/(:num)'] = 'clientes/eliminar/$1';

// Rutas de productos
$route['productos'] = 'productos/index';
$route['productos/crear'] = 'productos/crear';
$route['productos/editar/(:num)'] = 'productos/editar/$1';
$route['productos/eliminar/(:num)'] = 'productos/eliminar/$1';

// Rutas de ventas
$route['ventas'] = 'ventas/index';
$route['ventas/nueva'] = 'ventas/nueva';
$route['ventas/procesar'] = 'ventas/procesar';
$route['ventas/ver/(:num)'] = 'ventas/ver/$1';
$route['ventas/ticket/(:num)'] = 'ventas/ticket/$1';
$route['ventas/contrato/(:num)'] = 'ventas/contrato/$1';

// Rutas de reportes
$route['reportes'] = 'reportes/index';
$route['reportes/ventas'] = 'reportes/ventas';
$route['reportes/exportar'] = 'reportes/exportar';

// Rutas de configuración
$route['configuracion'] = 'configuracion/index';
$route['configuracion/negocio'] = 'configuracion/negocio';
$route['configuracion/plantillas'] = 'configuracion/plantillas';
$route['configuracion/usuarios'] = 'configuracion/usuarios';
