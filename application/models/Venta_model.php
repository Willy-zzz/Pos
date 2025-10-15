<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venta_model extends CI_Model {

    private $tabla = 'ventas';
    private $tabla_detalle = 'ventas_detalle';

    /**
     * Obtener todas las ventas con información de cliente
     */
    public function obtener_todas($limite = null, $offset = 0) {
        $this->db->select('ventas.*, clientes.nombre as cliente_nombre, usuarios.nombre_completo as vendedor');
        $this->db->from($this->tabla);
        $this->db->join('clientes', 'clientes.id = ventas.cliente_id');
        $this->db->join('usuarios', 'usuarios.id = ventas.usuario_id');
        $this->db->order_by('ventas.fecha_venta', 'DESC');
        
        if ($limite) {
            $this->db->limit($limite, $offset);
        }
        
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Obtener últimas ventas
     */
    public function obtener_ultimas($limite = 10) {
        return $this->obtener_todas($limite);
    }

    /**
     * Obtener venta por ID con detalles
     */
    public function obtener_por_id($id) {
        $this->db->select('ventas.*, clientes.*, usuarios.nombre_completo as vendedor');
        $this->db->from($this->tabla);
        $this->db->join('clientes', 'clientes.id = ventas.cliente_id');
        $this->db->join('usuarios', 'usuarios.id = ventas.usuario_id');
        $this->db->where('ventas.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * Obtener detalle de venta
     */
    public function obtener_detalle($venta_id) {
        $this->db->select('ventas_detalle.*, productos.nombre as producto_nombre, productos.codigo');
        $this->db->from($this->tabla_detalle);
        $this->db->join('productos', 'productos.id = ventas_detalle.producto_id');
        $this->db->where('ventas_detalle.venta_id', $venta_id);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Contar ventas de hoy
     */
    public function contar_ventas_hoy() {
        $this->db->where('DATE(fecha_venta)', date('Y-m-d'));
        return $this->db->count_all_results($this->tabla);
    }

    /**
     * Total de ventas de hoy
     */
    public function total_ventas_hoy() {
        $this->db->select_sum('total');
        $this->db->where('DATE(fecha_venta)', date('Y-m-d'));
        $query = $this->db->get($this->tabla);
        $result = $query->row();
        return $result->total ? $result->total : 0;
    }

    /**
     * Generar folio único
     */
    public function generar_folio() {
        $fecha = date('Ymd');
        $this->db->like('folio', $fecha, 'after');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get($this->tabla);
        
        if ($query->num_rows() > 0) {
            $ultima_venta = $query->row();
            $ultimo_numero = intval(substr($ultima_venta->folio, -4));
            $nuevo_numero = $ultimo_numero + 1;
        } else {
            $nuevo_numero = 1;
        }
        
        return $fecha . '-' . str_pad($nuevo_numero, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Crear nueva venta con detalle
     */
    public function crear($datos_venta, $items) {
        $this->db->trans_start();
        
        // Generar folio
        $datos_venta['folio'] = $this->generar_folio();
        
        // Insertar venta
        $this->db->insert($this->tabla, $datos_venta);
        $venta_id = $this->db->insert_id();
        
        // Insertar items
        foreach ($items as $item) {
            $item['venta_id'] = $venta_id;
            $this->db->insert($this->tabla_detalle, $item);
        }
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            return false;
        }
        
        return $venta_id;
    }

    /**
     * Obtener ventas por rango de fechas
     */
    public function obtener_por_fechas($fecha_inicio, $fecha_fin) {
        $this->db->select('ventas.*, clientes.nombre as cliente_nombre, usuarios.nombre_completo as vendedor');
        $this->db->from($this->tabla);
        $this->db->join('clientes', 'clientes.id = ventas.cliente_id');
        $this->db->join('usuarios', 'usuarios.id = ventas.usuario_id');
        $this->db->where('DATE(ventas.fecha_venta) >=', $fecha_inicio);
        $this->db->where('DATE(ventas.fecha_venta) <=', $fecha_fin);
        $this->db->order_by('ventas.fecha_venta', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
}
