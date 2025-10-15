<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Usuario_model');
        $this->load->library('form_validation');
    }

    /**
     * Página de login
     */
    public function login() {
        // Si ya está logueado, redirigir al dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        // Validar formulario
        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Usuario', 'required|trim');
            $this->form_validation->set_rules('password', 'Contraseña', 'required');

            if ($this->form_validation->run() == TRUE) {
                $username = $this->input->post('username');
                $password = $this->input->post('password');

                // Verificar credenciales
                $usuario = $this->Usuario_model->verificar_login($username, $password);

                if ($usuario) {
                    // Crear sesión
                    $session_data = array(
                        'user_id' => $usuario->id,
                        'username' => $usuario->username,
                        'nombre_completo' => $usuario->nombre_completo,
                        'rol' => $usuario->rol,
                        'logged_in' => TRUE
                    );
                    $this->session->set_userdata($session_data);

                    // Actualizar última sesión
                    $this->Usuario_model->actualizar_ultima_sesion($usuario->id);

                    // Redirigir al dashboard
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Usuario o contraseña incorrectos');
                }
            }
        }

        $this->load->view('auth/login');
    }

    /**
     * Cerrar sesión
     */
    public function logout() {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('nombre_completo');
        $this->session->unset_userdata('rol');
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        
        redirect('login');
    }

    /**
     * Verificar si el usuario está autenticado
     */
    public function verificar_sesion() {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    /**
     * Verificar si el usuario es administrador
     */
    public function verificar_admin() {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('rol') != 'admin') {
            $this->session->set_flashdata('error', 'No tienes permisos para acceder a esta sección');
            redirect('dashboard');
        }
    }
}
