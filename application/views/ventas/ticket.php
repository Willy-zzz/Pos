<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket - <?php echo $venta->folio; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            padding: 10px;
            max-width: 300px;
            margin: 0 auto;
        }
        
        .ticket {
            width: 100%;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
        }
        
        .header h2 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 11px;
            margin: 2px 0;
        }
        
        .info-section {
            margin-bottom: 15px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }
        
        .items {
            margin-bottom: 15px;
        }
        
        .item {
            margin-bottom: 8px;
        }
        
        .item-name {
            font-weight: bold;
        }
        
        .item-details {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
        }
        
        .totals {
            border-top: 2px solid #000;
            padding-top: 10px;
            margin-bottom: 15px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }
        
        .total-row.grand-total {
            font-size: 16px;
            font-weight: bold;
            border-top: 2px solid #000;
            padding-top: 5px;
            margin-top: 5px;
        }
        
        .footer {
            text-align: center;
            margin-top: 15px;
            border-top: 2px dashed #000;
            padding-top: 10px;
            font-size: 11px;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="ticket">
        <!-- Header -->
        <div class="header">
            <h2><?php echo $config['negocio_nombre']; ?></h2>
            <p><?php echo $config['negocio_direccion']; ?></p>
            <p>Tel: <?php echo $config['negocio_telefono']; ?></p>
            <?php if (!empty($config['negocio_rfc'])): ?>
                <p>RFC: <?php echo $config['negocio_rfc']; ?></p>
            <?php endif; ?>
        </div>

        <!-- Información de la venta -->
        <div class="info-section">
            <div class="info-row">
                <span>Folio:</span>
                <strong><?php echo $venta->folio; ?></strong>
            </div>
            <div class="info-row">
                <span>Fecha:</span>
                <span><?php echo date('d/m/Y H:i', strtotime($venta->fecha_venta)); ?></span>
            </div>
            <div class="info-row">
                <span>Vendedor:</span>
                <span><?php echo $venta->vendedor; ?></span>
            </div>
        </div>

        <!-- Información del cliente -->
        <div class="info-section">
            <div class="info-row">
                <span>Cliente:</span>
                <strong><?php echo $venta->nombre; ?></strong>
            </div>
            <?php if ($venta->telefono): ?>
            <div class="info-row">
                <span>Tel:</span>
                <span><?php echo $venta->telefono; ?></span>
            </div>
            <?php endif; ?>
        </div>

        <!-- Items -->
        <div class="items">
            <?php foreach ($detalle as $item): ?>
            <div class="item">
                <div class="item-name"><?php echo $item->producto_nombre; ?></div>
                <div class="item-details">
                    <span><?php echo $item->cantidad; ?> x $<?php echo number_format($item->precio_unitario, 2); ?></span>
                    <strong>$<?php echo number_format($item->subtotal, 2); ?></strong>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Totales -->
        <div class="totals">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>$<?php echo number_format($venta->subtotal, 2); ?></span>
            </div>
            
            <?php if ($venta->descuento > 0): ?>
            <div class="total-row">
                <span>Descuento:</span>
                <span>-$<?php echo number_format($venta->descuento, 2); ?></span>
            </div>
            <?php endif; ?>
            
            <div class="total-row grand-total">
                <span>TOTAL:</span>
                <span>$<?php echo number_format($venta->total, 2); ?></span>
            </div>
            
            <div class="total-row">
                <span>Método de Pago:</span>
                <span><?php echo ucfirst($venta->metodo_pago); ?></span>
            </div>
            
            <?php if ($venta->metodo_pago == 'efectivo'): ?>
            <div class="total-row">
                <span>Pagado:</span>
                <span>$<?php echo number_format($venta->monto_pagado, 2); ?></span>
            </div>
            <div class="total-row">
                <span>Cambio:</span>
                <span>$<?php echo number_format($venta->cambio, 2); ?></span>
            </div>
            <?php endif; ?>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><?php echo $config['ticket_mensaje_footer']; ?></p>
            <p style="margin-top: 10px;">www.<?php echo strtolower(str_replace(' ', '', $config['negocio_nombre'])); ?>.com</p>
        </div>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 14px; cursor: pointer;">
            Imprimir Ticket
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 14px; cursor: pointer; margin-left: 10px;">
            Cerrar
        </button>
    </div>

    <script>
        // Auto-imprimir si está configurado
        <?php if ($config['impresion_automatica'] == '1'): ?>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
        <?php endif; ?>
    </script>
</body>
</html>
