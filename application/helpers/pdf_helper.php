<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Helper para generar PDFs
 * Usa TCPDF para generar documentos PDF
 */

if (!function_exists('generar_pdf_ticket')) {
    function generar_pdf_ticket($venta, $config) {
        require_once(APPPATH . 'third_party/tcpdf/tcpdf.php');
        
        // Crear nuevo PDF
        $pdf = new TCPDF('P', 'mm', array(80, 200), true, 'UTF-8', false);
        
        // Configuración del documento
        $pdf->SetCreator('POS Laser');
        $pdf->SetAuthor($config['nombre_negocio']);
        $pdf->SetTitle('Ticket #' . $venta['id']);
        
        // Remover header y footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        
        // Configurar márgenes
        $pdf->SetMargins(5, 5, 5);
        $pdf->SetAutoPageBreak(TRUE, 5);
        
        // Agregar página
        $pdf->AddPage();
        
        // Configurar fuente
        $pdf->SetFont('helvetica', '', 9);
        
        // Contenido del ticket
        $html = '<div style="text-align: center;">';
        $html .= '<strong style="font-size: 12px;">' . strtoupper($config['nombre_negocio']) . '</strong><br>';
        $html .= $config['direccion'] . '<br>';
        $html .= 'Tel: ' . $config['telefono'] . '<br>';
        if (!empty($config['rfc'])) {
            $html .= 'RFC: ' . $config['rfc'] . '<br>';
        }
        $html .= '<hr>';
        $html .= '</div>';
        
        $html .= '<div style="font-size: 8px;">';
        $html .= 'Ticket: #' . $venta['id'] . '<br>';
        $html .= 'Fecha: ' . date('d/m/Y H:i', strtotime($venta['fecha'])) . '<br>';
        $html .= 'Cajero: ' . $venta['usuario'] . '<br>';
        $html .= '<hr>';
        $html .= '</div>';
        
        $html .= '<div style="font-size: 8px;">';
        $html .= '<strong>Cliente:</strong><br>';
        $html .= $venta['cliente_nombre'] . '<br>';
        if (!empty($venta['cliente_telefono'])) {
            $html .= 'Tel: ' . $venta['cliente_telefono'] . '<br>';
        }
        $html .= '<hr>';
        $html .= '</div>';
        
        $html .= '<table style="width: 100%; font-size: 8px;" cellpadding="2">';
        $html .= '<tr><th align="left">Producto</th><th align="right">Total</th></tr>';
        
        foreach ($venta['detalles'] as $detalle) {
            $html .= '<tr>';
            $html .= '<td>' . $detalle['producto'] . '<br>';
            $html .= $detalle['cantidad'] . ' x $' . number_format($detalle['precio'], 2) . '</td>';
            $html .= '<td align="right">$' . number_format($detalle['subtotal'], 2) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</table>';
        $html .= '<hr>';
        
        $html .= '<div style="font-size: 9px;">';
        $html .= '<table style="width: 100%;" cellpadding="1">';
        $html .= '<tr><td><strong>TOTAL:</strong></td><td align="right"><strong>$' . number_format($venta['total'], 2) . '</strong></td></tr>';
        $html .= '<tr><td>Pago:</td><td align="right">$' . number_format($venta['pago'], 2) . '</td></tr>';
        $html .= '<tr><td>Cambio:</td><td align="right">$' . number_format($venta['cambio'], 2) . '</td></tr>';
        $html .= '</table>';
        $html .= '</div>';
        
        $html .= '<hr>';
        $html .= '<div style="text-align: center; font-size: 8px;">';
        $html .= '<strong>¡Gracias por su preferencia!</strong><br>';
        $html .= 'Conserve su ticket';
        $html .= '</div>';
        
        $pdf->writeHTML($html, true, false, true, false, '');
        
        return $pdf->Output('ticket_' . $venta['id'] . '.pdf', 'I');
    }
}

if (!function_exists('generar_pdf_contrato')) {
    function generar_pdf_contrato($venta, $plantilla, $config) {
        require_once(APPPATH . 'third_party/tcpdf/tcpdf.php');
        
        // Crear nuevo PDF
        $pdf = new TCPDF('P', 'mm', 'LETTER', true, 'UTF-8', false);
        
        // Configuración del documento
        $pdf->SetCreator('POS Laser');
        $pdf->SetAuthor($config['nombre_negocio']);
        $pdf->SetTitle('Contrato - ' . $venta['cliente_nombre']);
        
        // Remover header y footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        
        // Configurar márgenes
        $pdf->SetMargins(20, 20, 20);
        $pdf->SetAutoPageBreak(TRUE, 20);
        
        // Agregar página
        $pdf->AddPage();
        
        // Configurar fuente
        $pdf->SetFont('helvetica', '', 11);
        
        // Reemplazar variables en la plantilla
        $contenido = $plantilla['contenido'];
        $contenido = str_replace('{cliente_nombre}', $venta['cliente_nombre'], $contenido);
        $contenido = str_replace('{cliente_telefono}', $venta['cliente_telefono'], $contenido);
        $contenido = str_replace('{cliente_email}', $venta['cliente_email'], $contenido);
        $contenido = str_replace('{cliente_direccion}', $venta['cliente_direccion'], $contenido);
        $contenido = str_replace('{fecha}', date('d/m/Y', strtotime($venta['fecha'])), $contenido);
        $contenido = str_replace('{total}', '$' . number_format($venta['total'], 2), $contenido);
        $contenido = str_replace('{negocio_nombre}', $config['nombre_negocio'], $contenido);
        $contenido = str_replace('{negocio_direccion}', $config['direccion'], $contenido);
        $contenido = str_replace('{negocio_telefono}', $config['telefono'], $contenido);
        
        // Agregar servicios
        $servicios = '';
        foreach ($venta['detalles'] as $detalle) {
            $servicios .= '- ' . $detalle['producto'] . ' ($' . number_format($detalle['subtotal'], 2) . ')<br>';
        }
        $contenido = str_replace('{servicios}', $servicios, $contenido);
        
        $pdf->writeHTML($contenido, true, false, true, false, '');
        
        // Espacio para firma
        $pdf->Ln(20);
        $pdf->Cell(0, 5, '_________________________________', 0, 1, 'C');
        $pdf->Cell(0, 5, 'Firma del Cliente', 0, 1, 'C');
        
        return $pdf->Output('contrato_' . $venta['id'] . '.pdf', 'I');
    }
}
