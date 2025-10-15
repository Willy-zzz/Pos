<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato - <?php echo $venta->folio; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.6;
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
        }
        
        .contrato {
            width: 100%;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px double #000;
            padding-bottom: 20px;
        }
        
        .header h1 {
            font-size: 20pt;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        
        .header p {
            font-size: 11pt;
            color: #666;
        }
        
        .contenido {
            text-align: justify;
            white-space: pre-line;
            margin-bottom: 40px;
        }
        
        .firmas {
            margin-top: 60px;
            display: flex;
            justify-content: space-around;
        }
        
        .firma {
            text-align: center;
            width: 40%;
        }
        
        .firma-linea {
            border-top: 2px solid #000;
            margin-bottom: 10px;
            padding-top: 5px;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10pt;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }
        
        @media print {
            body {
                padding: 20px;
            }
            
            .no-print {
                display: none;
            }
            
            @page {
                margin: 2cm;
            }
        }
    </style>
</head>
<body>
    <div class="contrato">
        <!-- Header -->
        <div class="header">
            <h1><?php echo $config['negocio_nombre']; ?></h1>
            <p><?php echo $config['negocio_direccion']; ?></p>
            <p>Tel: <?php echo $config['negocio_telefono']; ?> | RFC: <?php echo $config['negocio_rfc']; ?></p>
        </div>

        <!-- Contenido del contrato -->
        <div class="contenido">
            <?php echo nl2br($contenido_contrato); ?>
        </div>

        <!-- Firmas -->
        <div class="firmas">
            <div class="firma">
                <div class="firma-linea">
                    <strong><?php echo $config['negocio_nombre']; ?></strong>
                </div>
                <p>Firma del Prestador</p>
            </div>
            
            <div class="firma">
                <div class="firma-linea">
                    <strong><?php echo $venta->nombre; ?></strong>
                </div>
                <p>Firma del Cliente</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Folio: <?php echo $venta->folio; ?> | Fecha de emisión: <?php echo date('d/m/Y', strtotime($venta->fecha_venta)); ?></p>
            <p>Este documento es válido como comprobante de servicio</p>
        </div>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 30px;">
        <button onclick="window.print()" style="padding: 12px 24px; font-size: 14px; cursor: pointer; background: #667eea; color: white; border: none; border-radius: 5px;">
            Imprimir Contrato
        </button>
        <button onclick="window.close()" style="padding: 12px 24px; font-size: 14px; cursor: pointer; margin-left: 10px; background: #6c757d; color: white; border: none; border-radius: 5px;">
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
