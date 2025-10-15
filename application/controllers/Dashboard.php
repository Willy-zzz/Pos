<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Venta_model');
        $this->load->model('Cliente_model');
        $this->load->model('Producto_model');
    }

    /**
     * Página principal del dashboard
     */
    public function index() {
        $data['titulo'] = 'Dashboard';
        $data['usuario'] = $this->usuario_actual();

        // Estadísticas del día
        $data['ventas_hoy'] = $this->Venta_model->contar_ventas_hoy();
        $data['total_hoy'] = $this->Venta_model->total_ventas_hoy();
        $data['total_clientes'] = $this->Cliente_model->contar_clientes();
        $data['total_productos'] = $this->Producto_model->contar_productos();

        // Últimas ventas
        $data['ultimas_ventas'] = $this->Venta_model->obtener_ultimas(10);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }
}
