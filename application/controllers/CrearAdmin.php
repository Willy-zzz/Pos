<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CrearAdmin extends CI_Controller {

    public function index() {
        $this->load->database();

        $username = 'admin2';
        $password = 'admin';
        $nombre_completo = 'Administrador';
        $rol = 'admin';
        $activo = 1;

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'username' => $username,
            'password' => $hash,
            'nombre_completo' => $nombre_completo,
            'rol' => $rol,
            'activo' => $activo
        ];

        $this->db->insert('usuarios', $data);

        echo "Usuario admin creado correctamente. Usuario: admin | Contraseña: admin";
    }
}
