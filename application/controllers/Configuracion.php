<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracion extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->verificar_admin();
        $this->load->model('Configuracion_model');
        $this->load->model('Plantilla_model');
        $this->load->model('Usuario_model');
        $this->load->library('form_validation');
    }

    /**
     * Panel principal de configuración
     */
    public function index() {
        $data['titulo'] = 'Configuración';
        $data['usuario'] = $this->usuario_actual();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('configuracion/index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Configuración del negocio
     */
    public function negocio() {
        $data['titulo'] = 'Configuración del Negocio';
        $data['usuario'] = $this->usuario_actual();
        $data['config'] = $this->Configuracion_model->obtener_configuracion();

        if ($this->input->post()) {
            $datos = array(
                'negocio_nombre' => $this->input->post('negocio_nombre'),
                'negocio_direccion' => $this->input->post('negocio_direccion'),
                'negocio_telefono' => $this->input->post('negocio_telefono'),
                'negocio_rfc' => $this->input->post('negocio_rfc'),
                'negocio_email' => $this->input->post('negocio_email'),
                'ticket_mensaje_footer' => $this->input->post('ticket_mensaje_footer'),
                'impresion_automatica' => $this->input->post('impresion_automatica') ? '1' : '0'
            );

            if ($this->Configuracion_model->actualizar_multiple($datos)) {
                $this->session->set_flashdata('success', 'Configuración actualizada exitosamente');
            } else {
                $this->session->set_flashdata('error', 'Error al actualizar la configuración');
            }

            redirect('configuracion/negocio');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('configuracion/negocio', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Gestión de plantillas de contratos
     */
    public function plantillas() {
        $data['titulo'] = 'Plantillas de Contratos';
        $data['usuario'] = $this->usuario_actual();
        $data['plantillas'] = $this->Plantilla_model->obtener_todas();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('configuracion/plantillas', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Editar plantilla de contrato
     */
    public function editar_plantilla($id) {
        $data['titulo'] = 'Editar Plantilla';
        $data['usuario'] = $this->usuario_actual();
        $data['plantilla'] = $this->Plantilla_model->obtener_por_id($id);

        if (!$data['plantilla']) {
            $this->session->set_flashdata('error', 'Plantilla no encontrada');
            redirect('configuracion/plantillas');
        }

        if ($this->input->post()) {
            $datos = array(
                'nombre' => $this->input->post('nombre'),
                'contenido' => $this->input->post('contenido')
            );

            if ($this->Plantilla_model->actualizar($id, $datos)) {
                $this->session->set_flashdata('success', 'Plantilla actualizada exitosamente');
                redirect('configuracion/plantillas');
            } else {
                $this->session->set_flashdata('error', 'Error al actualizar la plantilla');
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('configuracion/editar_plantilla', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Activar plantilla
     */
    public function activar_plantilla($id) {
        if ($this->Plantilla_model->activar($id)) {
            $this->session->set_flashdata('success', 'Plantilla activada exitosamente');
        } else {
            $this->session->set_flashdata('error', 'Error al activar la plantilla');
        }

        redirect('configuracion/plantillas');
    }

    /**
     * Gestión de usuarios
     */
    public function usuarios() {
        $data['titulo'] = 'Gestión de Usuarios';
        $data['usuario'] = $this->usuario_actual();
        $data['usuarios'] = $this->Usuario_model->obtener_todos(false);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('configuracion/usuarios', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Crear nuevo usuario
     */
    public function crear_usuario() {
        $data['titulo'] = 'Nuevo Usuario';
        $data['usuario'] = $this->usuario_actual();

        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Usuario', 'required|trim|is_unique[usuarios.username]');
            $this->form_validation->set_rules('password', 'Contraseña', 'required|min_length[6]');
            $this->form_validation->set_rules('nombre_completo', 'Nombre Completo', 'required|trim');
            $this->form_validation->set_rules('rol', 'Rol', 'required|in_list[admin,usuario]');

            if ($this->form_validation->run() == TRUE) {
                $datos = array(
                    'username' => $this->input->post('username'),
                    'password' => $this->input->post('password'),
                    'nombre_completo' => $this->input->post('nombre_completo'),
                    'email' => $this->input->post('email'),
                    'rol' => $this->input->post('rol')
                );

                if ($this->Usuario_model->crear($datos)) {
                    $this->session->set_flashdata('success', 'Usuario creado exitosamente');
                    redirect('configuracion/usuarios');
                } else {
                    $this->session->set_flashdata('error', 'Error al crear el usuario');
                }
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('configuracion/form_usuario', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Editar usuario
     */
    public function editar_usuario($id) {
        $data['titulo'] = 'Editar Usuario';
        $data['usuario'] = $this->usuario_actual();
        $data['usuario_editar'] = $this->Usuario_model->obtener_por_id($id);

        if (!$data['usuario_editar']) {
            $this->session->set_flashdata('error', 'Usuario no encontrado');
            redirect('configuracion/usuarios');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('nombre_completo', 'Nombre Completo', 'required|trim');
            $this->form_validation->set_rules('rol', 'Rol', 'required|in_list[admin,usuario]');

            if ($this->form_validation->run() == TRUE) {
                $datos = array(
                    'nombre_completo' => $this->input->post('nombre_completo'),
                    'email' => $this->input->post('email'),
                    'rol' => $this->input->post('rol')
                );

                // Solo actualizar contraseña si se proporciona
                if ($this->input->post('password')) {
                    $datos['password'] = $this->input->post('password');
                }

                if ($this->Usuario_model->actualizar($id, $datos)) {
                    $this->session->set_flashdata('success', 'Usuario actualizado exitosamente');
                    redirect('configuracion/usuarios');
                } else {
                    $this->session->set_flashdata('error', 'Error al actualizar el usuario');
                }
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('configuracion/form_usuario', $data);
        $this->load->view('templates/footer');
    }
}
