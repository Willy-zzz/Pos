<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_Model {

    private $tabla = 'clientes';

    /**
     * Obtener todos los clientes activos
     */
    public function obtener_todos($activos_solo = true) {
        if ($activos_solo) {
            $this->db->where('activo', 1);
        }
        $this->db->order_by('nombre', 'ASC');
        $query = $this->db->get($this->tabla);
        return $query->result();
    }

    /**
     * Obtener cliente por ID
     */
    public function obtener_por_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->tabla);
        return $query->row();
    }

    /**
     * Crear nuevo cliente
     */
    public function crear($data) {
        return $this->db->insert($this->tabla, $data);
    }

    /**
     * Actualizar cliente
     */
    public function actualizar($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->tabla, $data);
    }

    /**
     * Eliminar cliente (soft delete)
     */
    public function eliminar($id) {
        $data = array('activo' => 0);
        $this->db->where('id', $id);
        return $this->db->update($this->tabla, $data);
    }

    /**
     * Buscar clientes por nombre o teléfono
     */
    public function buscar($termino, $limite = 20) {
        $this->db->like('nombre', $termino);
        $this->db->or_like('telefono', $termino);
        $this->db->or_like('correo', $termino);
        $this->db->where('activo', 1);
        $this->db->limit($limite);
        $this->db->order_by('nombre', 'ASC');
        $query = $this->db->get($this->tabla);
        return $query->result();
    }

    /**
     * Contar total de clientes activos
     */
    public function contar_clientes() {
        $this->db->where('activo', 1);
        return $this->db->count_all_results($this->tabla);
    }

    /**
     * Obtener clientes registrados hoy
     */
    public function obtener_nuevos_hoy() {
        $this->db->where('DATE(fecha_registro)', date('Y-m-d'));
        $this->db->where('activo', 1);
        $query = $this->db->get($this->tabla);
        return $query->result();
    }

    /**
     * Obtener historial de compras del cliente
     */
    public function obtener_historial_compras($cliente_id) {
        $this->db->select('ventas.*, usuarios.nombre_completo as vendedor');
        $this->db->from('ventas');
        $this->db->join('usuarios', 'usuarios.id = ventas.usuario_id');
        $this->db->where('ventas.cliente_id', $cliente_id);
        $this->db->order_by('ventas.fecha_venta', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
}
