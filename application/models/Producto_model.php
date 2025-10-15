<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto_model extends CI_Model {

    private $tabla = 'productos';

    /**
     * Obtener todos los productos activos
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
     * Obtener todos los productos con información de categoría
     */
    public function obtener_todos_con_categoria($activos_solo = true) {
        $this->db->select('productos.*, categorias.nombre as categoria_nombre');
        $this->db->from($this->tabla);
        $this->db->join('categorias', 'categorias.id = productos.categoria_id', 'left');
        if ($activos_solo) {
            $this->db->where('productos.activo', 1);
        }
        $this->db->order_by('productos.nombre', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Obtener producto por ID
     */
    public function obtener_por_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->tabla);
        return $query->row();
    }

    /**
     * Crear nuevo producto
     */
    public function crear($data) {
        return $this->db->insert($this->tabla, $data);
    }

    /**
     * Actualizar producto
     */
    public function actualizar($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->tabla, $data);
    }

    /**
     * Eliminar producto (soft delete)
     */
    public function eliminar($id) {
        $data = array('activo' => 0);
        $this->db->where('id', $id);
        return $this->db->update($this->tabla, $data);
    }

    /**
     * Buscar productos por nombre o código
     */
    public function buscar($termino, $limite = 20) {
        $this->db->like('nombre', $termino);
        $this->db->or_like('codigo', $termino);
        $this->db->or_like('descripcion', $termino);
        $this->db->where('activo', 1);
        $this->db->limit($limite);
        $this->db->order_by('nombre', 'ASC');
        $query = $this->db->get($this->tabla);
        return $query->result();
    }

    /**
     * Contar total de productos activos
     */
    public function contar_productos() {
        $this->db->where('activo', 1);
        return $this->db->count_all_results($this->tabla);
    }

    /**
     * Obtener productos por categoría
     */
    public function obtener_por_categoria($categoria_id) {
        $this->db->where('categoria_id', $categoria_id);
        $this->db->where('activo', 1);
        $this->db->order_by('nombre', 'ASC');
        $query = $this->db->get($this->tabla);
        return $query->result();
    }

    /**
     * Obtener productos más vendidos
     */
    public function obtener_mas_vendidos($limite = 10) {
        $this->db->select('productos.*, SUM(ventas_detalle.cantidad) as total_vendido');
        $this->db->from($this->tabla);
        $this->db->join('ventas_detalle', 'ventas_detalle.producto_id = productos.id');
        $this->db->where('productos.activo', 1);
        $this->db->group_by('productos.id');
        $this->db->order_by('total_vendido', 'DESC');
        $this->db->limit($limite);
        $query = $this->db->get();
        return $query->result();
    }
}
