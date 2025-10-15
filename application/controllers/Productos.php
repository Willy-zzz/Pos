<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Producto_model');
        $this->load->model('Categoria_model');
        $this->load->library('form_validation');
    }

    /**
     * Listar todos los productos/servicios
     */
    public function index() {
        $data['titulo'] = 'Productos y Servicios';
        $data['usuario'] = $this->usuario_actual();
        $data['productos'] = $this->Producto_model->obtener_todos_con_categoria();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('productos/index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Crear nuevo producto/servicio
     */
    public function crear() {
        $data['titulo'] = 'Nuevo Producto/Servicio';
        $data['usuario'] = $this->usuario_actual();
        $data['categorias'] = $this->Categoria_model->obtener_todas();

        if ($this->input->post()) {
            $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
            $this->form_validation->set_rules('precio', 'Precio', 'required|numeric');
            $this->form_validation->set_rules('tipo', 'Tipo', 'required|in_list[producto,servicio]');

            if ($this->form_validation->run() == TRUE) {
                $datos = array(
                    'codigo' => $this->input->post('codigo'),
                    'nombre' => $this->input->post('nombre'),
                    'descripcion' => $this->input->post('descripcion'),
                    'categoria_id' => $this->input->post('categoria_id') ?: null,
                    'precio' => $this->input->post('precio'),
                    'tipo' => $this->input->post('tipo')
                );

                if ($this->Producto_model->crear($datos)) {
                    $this->session->set_flashdata('success', 'Producto/Servicio creado exitosamente');
                    redirect('productos');
                } else {
                    $this->session->set_flashdata('error', 'Error al crear el producto/servicio');
                }
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('productos/form', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Editar producto/servicio existente
     */
    public function editar($id) {
        $data['titulo'] = 'Editar Producto/Servicio';
        $data['usuario'] = $this->usuario_actual();
        $data['producto'] = $this->Producto_model->obtener_por_id($id);
        $data['categorias'] = $this->Categoria_model->obtener_todas();

        if (!$data['producto']) {
            $this->session->set_flashdata('error', 'Producto/Servicio no encontrado');
            redirect('productos');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
            $this->form_validation->set_rules('precio', 'Precio', 'required|numeric');
            $this->form_validation->set_rules('tipo', 'Tipo', 'required|in_list[producto,servicio]');

            if ($this->form_validation->run() == TRUE) {
                $datos = array(
                    'codigo' => $this->input->post('codigo'),
                    'nombre' => $this->input->post('nombre'),
                    'descripcion' => $this->input->post('descripcion'),
                    'categoria_id' => $this->input->post('categoria_id') ?: null,
                    'precio' => $this->input->post('precio'),
                    'tipo' => $this->input->post('tipo')
                );

                if ($this->Producto_model->actualizar($id, $datos)) {
                    $this->session->set_flashdata('success', 'Producto/Servicio actualizado exitosamente');
                    redirect('productos');
                } else {
                    $this->session->set_flashdata('error', 'Error al actualizar el producto/servicio');
                }
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('productos/form', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Eliminar producto/servicio (soft delete)
     */
    public function eliminar($id) {
        $producto = $this->Producto_model->obtener_por_id($id);

        if (!$producto) {
            $this->session->set_flashdata('error', 'Producto/Servicio no encontrado');
            redirect('productos');
        }

        if ($this->Producto_model->eliminar($id)) {
            $this->session->set_flashdata('success', 'Producto/Servicio eliminado exitosamente');
        } else {
            $this->session->set_flashdata('error', 'Error al eliminar el producto/servicio');
        }

        redirect('productos');
    }

    /**
     * Buscar productos (AJAX para select2)
     */
    public function buscar_ajax() {
        $termino = $this->input->get('q');
        $productos = $this->Producto_model->buscar($termino);
        
        $resultados = array();
        foreach ($productos as $producto) {
            $resultados[] = array(
                'id' => $producto->id,
                'text' => $producto->nombre . ' - $' . number_format($producto->precio, 2),
                'precio' => $producto->precio,
                'nombre' => $producto->nombre
            );
        }
        
        echo json_encode(array('results' => $resultados));
    }
}
