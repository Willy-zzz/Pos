<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria_model extends CI_Model {

    private $tabla = 'categorias';

    /**
     * Obtener todas las categorías activas
     */
    public function obtener_todas($activas_solo = true) {
        if ($activas_solo) {
            $this->db->where('activo', 1);
        }
        $this->db->order_by('nombre', 'ASC');
        $query = $this->db->get($this->tabla);
        return $query->result();
    }

    /**
     * Obtener categoría por ID
     */
    public function obtener_por_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->tabla);
        return $query->row();
    }

    /**
     * Crear nueva categoría
     */
    public function crear($data) {
        return $this->db->insert($this->tabla, $data);
    }

    /**
     * Actualizar categoría
     */
    public function actualizar($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->tabla, $data);
    }

    /**
     * Eliminar categoría (soft delete)
     */
    public function eliminar($id) {
        $data = array('activo' => 0);
        $this->db->where('id', $id);
        return $this->db->update($this->tabla, $data);
    }
}
