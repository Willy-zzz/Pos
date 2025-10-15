<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {

    private $tabla = 'usuarios';

    /**
     * Verificar credenciales de login
     */
    public function verificar_login($username, $password) {
        $this->db->where('username', $username);
        $this->db->where('activo', 1);
        $query = $this->db->get($this->tabla);

        if ($query->num_rows() == 1) {
            $usuario = $query->row();
            
            // Verificar contraseña
            if (password_verify($password, $usuario->password)) {
                return $usuario;
            }
        }

        return false;
    }

    /**
     * Actualizar última sesión del usuario
     */
    public function actualizar_ultima_sesion($id) {
        $data = array(
            'ultima_sesion' => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $id);
        return $this->db->update($this->tabla, $data);
    }

    /**
     * Obtener todos los usuarios
     */
    public function obtener_todos($activos_solo = true) {
        if ($activos_solo) {
            $this->db->where('activo', 1);
        }
        $this->db->order_by('nombre_completo', 'ASC');
        $query = $this->db->get($this->tabla);
        return $query->result();
    }

    /**
     * Obtener usuario por ID
     */
    public function obtener_por_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->tabla);
        return $query->row();
    }

    /**
     * Crear nuevo usuario
     */
    public function crear($data) {
        // Encriptar contraseña
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        return $this->db->insert($this->tabla, $data);
    }

    /**
     * Actualizar usuario
     */
    public function actualizar($id, $data) {
        // Encriptar contraseña si se está actualizando
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }

        $this->db->where('id', $id);
        return $this->db->update($this->tabla, $data);
    }

    /**
     * Eliminar usuario (soft delete)
     */
    public function eliminar($id) {
        $data = array('activo' => 0);
        $this->db->where('id', $id);
        return $this->db->update($this->tabla, $data);
    }

    /**
     * Verificar si el username ya existe
     */
    public function username_existe($username, $excluir_id = null) {
        $this->db->where('username', $username);
        if ($excluir_id) {
            $this->db->where('id !=', $excluir_id);
        }
        $query = $this->db->get($this->tabla);
        return $query->num_rows() > 0;
    }
}
