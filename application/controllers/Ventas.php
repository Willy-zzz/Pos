<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Venta_model');
        $this->load->model('Cliente_model');
        $this->load->model('Producto_model');
        $this->load->library('form_validation');
    }

    /**
     * Listar todas las ventas
     */
    public function index() {
        $data['titulo'] = 'Ventas';
        $data['usuario'] = $this->usuario_actual();
        $data['ventas'] = $this->Venta_model->obtener_todas();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('ventas/index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Nueva venta (POS)
     */
    public function nueva() {
        $data['titulo'] = 'Nueva Venta';
        $data['usuario'] = $this->usuario_actual();
        $data['clientes'] = $this->Cliente_model->obtener_todos();
        $data['productos'] = $this->Producto_model->obtener_todos();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('ventas/nueva', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Procesar venta
     */
    public function procesar() {
        if (!$this->input->post()) {
            redirect('ventas/nueva');
        }

        // Validar datos
        $cliente_id = $this->input->post('cliente_id');
        $metodo_pago = $this->input->post('metodo_pago');
        $items = json_decode($this->input->post('items'), true);
        $subtotal = floatval($this->input->post('subtotal'));
        $descuento = floatval($this->input->post('descuento'));
        $total = floatval($this->input->post('total'));
        $monto_pagado = floatval($this->input->post('monto_pagado'));
        $cambio = floatval($this->input->post('cambio'));

        // Validar que haya items
        if (empty($items)) {
            $this->session->set_flashdata('error', 'Debe agregar al menos un producto o servicio');
            redirect('ventas/nueva');
        }

        // Validar cliente
        if (empty($cliente_id)) {
            $this->session->set_flashdata('error', 'Debe seleccionar un cliente');
            redirect('ventas/nueva');
        }

        // Preparar datos de venta
        $datos_venta = array(
            'cliente_id' => $cliente_id,
            'usuario_id' => $this->session->userdata('user_id'),
            'subtotal' => $subtotal,
            'descuento' => $descuento,
            'total' => $total,
            'metodo_pago' => $metodo_pago,
            'monto_pagado' => $monto_pagado,
            'cambio' => $cambio
        );

        // Preparar items
        $items_venta = array();
        foreach ($items as $item) {
            $items_venta[] = array(
                'producto_id' => $item['producto_id'],
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio'],
                'subtotal' => $item['subtotal']
            );
        }

        // Crear venta
        $venta_id = $this->Venta_model->crear($datos_venta, $items_venta);

        if ($venta_id) {
            $this->session->set_flashdata('success', 'Venta registrada exitosamente');
            $this->session->set_userdata('ultima_venta_id', $venta_id);
            redirect('ventas/ver/' . $venta_id);
        } else {
            $this->session->set_flashdata('error', 'Error al procesar la venta');
            redirect('ventas/nueva');
        }
    }

    /**
     * Ver detalle de venta
     */
    public function ver($id) {
        $data['titulo'] = 'Detalle de Venta';
        $data['usuario'] = $this->usuario_actual();
        $data['venta'] = $this->Venta_model->obtener_por_id($id);
        $data['detalle'] = $this->Venta_model->obtener_detalle($id);

        if (!$data['venta']) {
            $this->session->set_flashdata('error', 'Venta no encontrada');
            redirect('ventas');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('ventas/ver', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Crear cliente rápido desde POS (AJAX)
     */
    public function crear_cliente_rapido() {
        if (!$this->input->post()) {
            echo json_encode(array('success' => false, 'message' => 'Método no permitido'));
            return;
        }

        $datos = array(
            'nombre' => $this->input->post('nombre'),
            'telefono' => $this->input->post('telefono'),
            'correo' => $this->input->post('correo')
        );

        if ($this->Cliente_model->crear($datos)) {
            $cliente_id = $this->db->insert_id();
            $cliente = $this->Cliente_model->obtener_por_id($cliente_id);
            
            echo json_encode(array(
                'success' => true,
                'cliente' => $cliente,
                'message' => 'Cliente creado exitosamente'
            ));
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'Error al crear el cliente'
            ));
        }
    }

    /**
     * Generar e imprimir ticket
     */
    public function ticket($id) {
        $this->load->model('Configuracion_model');
        
        $data['venta'] = $this->Venta_model->obtener_por_id($id);
        $data['detalle'] = $this->Venta_model->obtener_detalle($id);
        $data['config'] = $this->Configuracion_model->obtener_configuracion();

        if (!$data['venta']) {
            show_404();
        }

        $this->load->view('ventas/ticket', $data);
    }

    /**
     * Generar e imprimir contrato
     */
    public function contrato($id) {
        $this->load->model('Configuracion_model');
        $this->load->model('Plantilla_model');
        
        $data['venta'] = $this->Venta_model->obtener_por_id($id);
        $data['detalle'] = $this->Venta_model->obtener_detalle($id);
        $data['config'] = $this->Configuracion_model->obtener_configuracion();
        $data['plantilla'] = $this->Plantilla_model->obtener_activa();

        if (!$data['venta'] || !$data['plantilla']) {
            show_404();
        }

        // Reemplazar variables en la plantilla
        $contenido = $data['plantilla']->contenido;
        
        // Variables del negocio
        $contenido = str_replace('[NEGOCIO_NOMBRE]', $data['config']['negocio_nombre'], $contenido);
        $contenido = str_replace('[NEGOCIO_RFC]', $data['config']['negocio_rfc'], $contenido);
        $contenido = str_replace('[NEGOCIO_DIRECCION]', $data['config']['negocio_direccion'], $contenido);
        
        // Variables del cliente
        $contenido = str_replace('[CLIENTE_NOMBRE]', $data['venta']->nombre, $contenido);
        $contenido = str_replace('[CLIENTE_RFC]', $data['venta']->rfc ?: 'N/A', $contenido);
        $contenido = str_replace('[CLIENTE_DIRECCION]', $data['venta']->direccion ?: 'N/A', $contenido);
        $contenido = str_replace('[CLIENTE_TELEFONO]', $data['venta']->telefono, $contenido);
        $contenido = str_replace('[CLIENTE_EMAIL]', $data['venta']->correo ?: 'N/A', $contenido);
        
        // Variables de la venta
        $contenido = str_replace('[FOLIO]', $data['venta']->folio, $contenido);
        $contenido = str_replace('[FECHA]', date('d/m/Y', strtotime($data['venta']->fecha_venta)), $contenido);
        $contenido = str_replace('[TOTAL]', number_format($data['venta']->total, 2), $contenido);
        $contenido = str_replace('[METODO_PAGO]', ucfirst($data['venta']->metodo_pago), $contenido);
        $contenido = str_replace('[CIUDAD]', 'Ciudad de México', $contenido); // Configurable
        
        // Detalle de servicios
        $servicios_detalle = '';
        foreach ($data['detalle'] as $item) {
            $servicios_detalle .= '- ' . $item->producto_nombre . ' (Cantidad: ' . $item->cantidad . ') - $' . number_format($item->subtotal, 2) . "\n";
        }
        $contenido = str_replace('[SERVICIOS_DETALLE]', $servicios_detalle, $contenido);
        
        $data['contenido_contrato'] = $contenido;

        $this->load->view('ventas/contrato', $data);
    }
}
