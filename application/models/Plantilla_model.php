<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plantilla_model extends CI_Model {

    private $tabla = 'plantillas_contrato';

    /**
     * Obtener plantilla activa
     */
    public function obtener_activa() {
        $this->db->where('activo', 1);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get($this->tabla);
        return $query->row();
    }

    /**
     * Obtener todas las plantillas
     */
    public function obtener_todas() {
        $this->db->order_by('nombre', 'ASC');
        $query = $this->db->get($this->tabla);
        return $query->result();
    }

    /**
     * Obtener plantilla por ID
     */
    public function obtener_por_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->tabla);
        return $query->row();
    }

    /**
     * Crear nueva plantilla
     */
    public function crear($data) {
        return $this->db->insert($this->tabla, $data);
    }

    /**
     * Actualizar plantilla
     */
    public function actualizar($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->tabla, $data);
    }

    /**
     * Activar plantilla (desactiva las demás)
     */
    public function activar($id) {
        $this->db->trans_start();
        
        // Desactivar todas
        $this->db->update($this->tabla, array('activo' => 0));
        
        // Activar la seleccionada
        $this->db->where('id', $id);
        $this->db->update($this->tabla, array('activo' => 1));
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
