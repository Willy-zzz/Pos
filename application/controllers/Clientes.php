<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Cliente_model');
        $this->load->library('form_validation');
    }

    /**
     * Listar todos los clientes
     */
    public function index() {
        $data['titulo'] = 'Clientes';
        $data['usuario'] = $this->usuario_actual();
        $data['clientes'] = $this->Cliente_model->obtener_todos();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('clientes/index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Crear nuevo cliente
     */
    public function crear() {
        $data['titulo'] = 'Nuevo Cliente';
        $data['usuario'] = $this->usuario_actual();

        if ($this->input->post()) {
            $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
            $this->form_validation->set_rules('telefono', 'Teléfono', 'trim');
            $this->form_validation->set_rules('correo', 'Correo', 'trim|valid_email');
            $this->form_validation->set_rules('rfc', 'RFC', 'trim|max_length[13]');

            if ($this->form_validation->run() == TRUE) {
                $datos = array(
                    'nombre' => $this->input->post('nombre'),
                    'telefono' => $this->input->post('telefono'),
                    'direccion' => $this->input->post('direccion'),
                    'correo' => $this->input->post('correo'),
                    'rfc' => strtoupper($this->input->post('rfc')),
                    'notas' => $this->input->post('notas')
                );

                if ($this->Cliente_model->crear($datos)) {
                    $this->session->set_flashdata('success', 'Cliente creado exitosamente');
                    redirect('clientes');
                } else {
                    $this->session->set_flashdata('error', 'Error al crear el cliente');
                }
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('clientes/form', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Editar cliente existente
     */
    public function editar($id) {
        $data['titulo'] = 'Editar Cliente';
        $data['usuario'] = $this->usuario_actual();
        $data['cliente'] = $this->Cliente_model->obtener_por_id($id);

        if (!$data['cliente']) {
            $this->session->set_flashdata('error', 'Cliente no encontrado');
            redirect('clientes');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
            $this->form_validation->set_rules('telefono', 'Teléfono', 'trim');
            $this->form_validation->set_rules('correo', 'Correo', 'trim|valid_email');
            $this->form_validation->set_rules('rfc', 'RFC', 'trim|max_length[13]');

            if ($this->form_validation->run() == TRUE) {
                $datos = array(
                    'nombre' => $this->input->post('nombre'),
                    'telefono' => $this->input->post('telefono'),
                    'direccion' => $this->input->post('direccion'),
                    'correo' => $this->input->post('correo'),
                    'rfc' => strtoupper($this->input->post('rfc')),
                    'notas' => $this->input->post('notas')
                );

                if ($this->Cliente_model->actualizar($id, $datos)) {
                    $this->session->set_flashdata('success', 'Cliente actualizado exitosamente');
                    redirect('clientes');
                } else {
                    $this->session->set_flashdata('error', 'Error al actualizar el cliente');
                }
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('clientes/form', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Eliminar cliente (soft delete)
     */
    public function eliminar($id) {
        $cliente = $this->Cliente_model->obtener_por_id($id);

        if (!$cliente) {
            $this->session->set_flashdata('error', 'Cliente no encontrado');
            redirect('clientes');
        }

        if ($this->Cliente_model->eliminar($id)) {
            $this->session->set_flashdata('success', 'Cliente eliminado exitosamente');
        } else {
            $this->session->set_flashdata('error', 'Error al eliminar el cliente');
        }

        redirect('clientes');
    }

    /**
     * Obtener cliente por ID (AJAX)
     */
    public function obtener_ajax($id) {
        $cliente = $this->Cliente_model->obtener_por_id($id);
        
        if ($cliente) {
            echo json_encode($cliente);
        } else {
            echo json_encode(array('error' => 'Cliente no encontrado'));
        }
    }

    /**
     * Buscar clientes (AJAX para select2)
     */
    public function buscar_ajax() {
        $termino = $this->input->get('q');
        $clientes = $this->Cliente_model->buscar($termino);
        
        $resultados = array();
        foreach ($clientes as $cliente) {
            $resultados[] = array(
                'id' => $cliente->id,
                'text' => $cliente->nombre . ' - ' . $cliente->telefono
            );
        }
        
        echo json_encode(array('results' => $resultados));
    }
}
