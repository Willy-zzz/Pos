<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Helper para impresión térmica
 * Compatible con impresoras ESC/POS (Epson, XPrinter, Star)
 */

if (!function_exists('imprimir_ticket_termico')) {
    function imprimir_ticket_termico($venta, $config) {
        // Comandos ESC/POS
        $esc = chr(27);
        $gs = chr(29);
        
        // Inicializar impresora
        $output = $esc . "@"; // Inicializar
        
        // Centrar texto
        $output .= $esc . "a" . chr(1);
        
        // Negrita y tamaño grande
        $output .= $esc . "!" . chr(16);
        $output .= strtoupper($config['nombre_negocio']) . "\n";
        
        // Tamaño normal
        $output .= $esc . "!" . chr(0);
        $output .= $config['direccion'] . "\n";
        $output .= "Tel: " . $config['telefono'] . "\n";
        
        if (!empty($config['rfc'])) {
            $output .= "RFC: " . $config['rfc'] . "\n";
        }
        
        $output .= str_repeat("-", 32) . "\n";
        
        // Alinear a la izquierda
        $output .= $esc . "a" . chr(0);
        
        $output .= "Ticket: #" . $venta['id'] . "\n";
        $output .= "Fecha: " . date('d/m/Y H:i', strtotime($venta['fecha'])) . "\n";
        $output .= "Cajero: " . $venta['usuario'] . "\n";
        $output .= str_repeat("-", 32) . "\n";
        
        $output .= "Cliente: " . $venta['cliente_nombre'] . "\n";
        if (!empty($venta['cliente_telefono'])) {
            $output .= "Tel: " . $venta['cliente_telefono'] . "\n";
        }
        $output .= str_repeat("-", 32) . "\n";
        
        // Productos
        foreach ($venta['detalles'] as $detalle) {
            $producto = substr($detalle['producto'], 0, 20);
            $output .= $producto . "\n";
            
            $cantidad = $detalle['cantidad'] . " x $" . number_format($detalle['precio'], 2);
            $subtotal = "$" . number_format($detalle['subtotal'], 2);
            
            $espacios = 32 - strlen($cantidad) - strlen($subtotal);
            $output .= $cantidad . str_repeat(" ", $espacios) . $subtotal . "\n";
        }
        
        $output .= str_repeat("-", 32) . "\n";
        
        // Total
        $output .= $esc . "!" . chr(16); // Negrita y grande
        $total_text = "TOTAL: $" . number_format($venta['total'], 2);
        $espacios = 32 - strlen($total_text);
        $output .= str_repeat(" ", $espacios) . $total_text . "\n";
        
        $output .= $esc . "!" . chr(0); // Normal
        
        $pago_text = "Pago: $" . number_format($venta['pago'], 2);
        $espacios = 32 - strlen($pago_text);
        $output .= str_repeat(" ", $espacios) . $pago_text . "\n";
        
        $cambio_text = "Cambio: $" . number_format($venta['cambio'], 2);
        $espacios = 32 - strlen($cambio_text);
        $output .= str_repeat(" ", $espacios) . $cambio_text . "\n";
        
        $output .= str_repeat("-", 32) . "\n";
        
        // Centrar
        $output .= $esc . "a" . chr(1);
        $output .= "Gracias por su preferencia\n";
        $output .= "Conserve su ticket\n\n";
        
        // Cortar papel
        $output .= $gs . "V" . chr(66) . chr(0);
        
        return $output;
    }
}

if (!function_exists('enviar_a_impresora')) {
    function enviar_a_impresora($contenido, $impresora = null) {
        // En Windows, enviar directamente a la impresora
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            if ($impresora === null) {
                // Usar impresora predeterminada
                $impresora = 'LPT1'; // o 'COM1' para puerto serial
            }
            
            $handle = fopen($impresora, 'w');
            if ($handle) {
                fwrite($handle, $contenido);
                fclose($handle);
                return true;
            }
        }
        
        return false;
    }
}
