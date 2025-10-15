<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador base para páginas que requieren autenticación
 */
class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Verificar si el usuario está logueado
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    /**
     * Verificar si el usuario es administrador
     */
    protected function verificar_admin() {
        if ($this->session->userdata('rol') != 'admin') {
            $this->session->set_flashdata('error', 'No tienes permisos para acceder a esta sección');
            redirect('dashboard');
        }
    }

    /**
     * Obtener datos del usuario actual
     */
    protected function usuario_actual() {
        return array(
            'id' => $this->session->userdata('user_id'),
            'username' => $this->session->userdata('username'),
            'nombre' => $this->session->userdata('nombre_completo'),
            'rol' => $this->session->userdata('rol')
        );
    }

    /**
     * Verificar si el usuario es admin
     */
    protected function es_admin() {
        return $this->session->userdata('rol') == 'admin';
    }
}

/**
 * Controlador base para páginas públicas (sin autenticación)
 */
class Public_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
}
