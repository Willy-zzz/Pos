<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracion_model extends CI_Model {

    private $tabla = 'configuracion';

    /**
     * Obtener toda la configuración como array asociativo
     */
    public function obtener_configuracion() {
        $query = $this->db->get($this->tabla);
        $config = array();
        
        foreach ($query->result() as $row) {
            $config[$row->clave] = $row->valor;
        }
        
        return $config;
    }

    /**
     * Obtener valor de configuración por clave
     */
    public function obtener($clave) {
        $this->db->where('clave', $clave);
        $query = $this->db->get($this->tabla);
        
        if ($query->num_rows() > 0) {
            return $query->row()->valor;
        }
        
        return null;
    }

    /**
     * Actualizar valor de configuración
     */
    public function actualizar($clave, $valor) {
        $this->db->where('clave', $clave);
        $query = $this->db->get($this->tabla);
        
        if ($query->num_rows() > 0) {
            $this->db->where('clave', $clave);
            return $this->db->update($this->tabla, array('valor' => $valor));
        } else {
            return $this->db->insert($this->tabla, array(
                'clave' => $clave,
                'valor' => $valor
            ));
        }
    }

    /**
     * Actualizar múltiples configuraciones
     */
    public function actualizar_multiple($datos) {
        $this->db->trans_start();
        
        foreach ($datos as $clave => $valor) {
            $this->actualizar($clave, $valor);
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
