<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Venta_model');
        $this->load->model('Cliente_model');
        $this->load->model('Producto_model');
    }

    /**
     * Dashboard de reportes
     */
    public function index() {
        $data['titulo'] = 'Reportes';
        $data['usuario'] = $this->usuario_actual();

        // Estadísticas generales
        $data['total_ventas_mes'] = $this->obtener_total_mes();
        $data['total_ventas_dia'] = $this->Venta_model->total_ventas_hoy();
        $data['num_ventas_mes'] = $this->contar_ventas_mes();
        $data['num_clientes'] = $this->Cliente_model->contar_clientes();

        // Productos más vendidos
        $data['productos_top'] = $this->Producto_model->obtener_mas_vendidos(5);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('reportes/index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Reporte de ventas por fecha
     */
    public function ventas() {
        $data['titulo'] = 'Reporte de Ventas';
        $data['usuario'] = $this->usuario_actual();

        // Obtener fechas del formulario o usar valores por defecto
        $fecha_inicio = $this->input->get('fecha_inicio') ?: date('Y-m-01');
        $fecha_fin = $this->input->get('fecha_fin') ?: date('Y-m-d');

        $data['fecha_inicio'] = $fecha_inicio;
        $data['fecha_fin'] = $fecha_fin;
        $data['ventas'] = $this->Venta_model->obtener_por_fechas($fecha_inicio, $fecha_fin);

        // Calcular totales
        $data['total_ventas'] = 0;
        $data['total_efectivo'] = 0;
        $data['total_tarjeta'] = 0;

        foreach ($data['ventas'] as $venta) {
            $data['total_ventas'] += $venta->total;
            if ($venta->metodo_pago == 'efectivo') {
                $data['total_efectivo'] += $venta->total;
            } else {
                $data['total_tarjeta'] += $venta->total;
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('reportes/ventas', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Exportar reporte a Excel (CSV)
     */
    public function exportar() {
        $fecha_inicio = $this->input->get('fecha_inicio') ?: date('Y-m-01');
        $fecha_fin = $this->input->get('fecha_fin') ?: date('Y-m-d');
        
        $ventas = $this->Venta_model->obtener_por_fechas($fecha_inicio, $fecha_fin);

        // Configurar headers para descarga
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=reporte_ventas_' . date('Y-m-d') . '.csv');

        // Crear archivo CSV
        $output = fopen('php://output', 'w');
        
        // BOM para UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        // Encabezados
        fputcsv($output, array('Folio', 'Fecha', 'Cliente', 'Vendedor', 'Subtotal', 'Descuento', 'Total', 'Método Pago'));

        // Datos
        foreach ($ventas as $venta) {
            fputcsv($output, array(
                $venta->folio,
                date('d/m/Y H:i', strtotime($venta->fecha_venta)),
                $venta->cliente_nombre,
                $venta->vendedor,
                number_format($venta->subtotal, 2),
                number_format($venta->descuento, 2),
                number_format($venta->total, 2),
                ucfirst($venta->metodo_pago)
            ));
        }

        fclose($output);
        exit;
    }

    /**
     * Obtener total de ventas del mes actual
     */
    private function obtener_total_mes() {
        $this->db->select_sum('total');
        $this->db->where('MONTH(fecha_venta)', date('m'));
        $this->db->where('YEAR(fecha_venta)', date('Y'));
        $query = $this->db->get('ventas');
        $result = $query->row();
        return $result->total ? $result->total : 0;
    }

    /**
     * Contar ventas del mes actual
     */
    private function contar_ventas_mes() {
        $this->db->where('MONTH(fecha_venta)', date('m'));
        $this->db->where('YEAR(fecha_venta)', date('Y'));
        return $this->db->count_all_results('ventas');
    }
}
