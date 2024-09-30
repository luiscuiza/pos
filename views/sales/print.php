<?php ob_start(); ?>
    <link rel="stylesheet" href="/assets/fpdf/fpdf.css">
<?php $headCss = ob_get_clean(); ?>



<?php
    global $env;
    require_once 'fpdf/fpdf.php';

    $pdf = new FPDF();
    $pdf->SetTitle($title);
    $pdf->AddPage();

    // Encabezado
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(100,20,"Sistema POS", 0, 1);
    $pdf->Line(10, 25, 180, 25);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, 8, "NIT: {$env->get('nit')}", 0, 0);
    $pdf->setX(110);
    $pdf->Cell(50, 8, "Nro. Factura: {$factura['codigo_factura']}", 0, 1);
    $pdf->Cell(50, 8, utf8_decode("Teléfonos: {$factura['telefono_cliente']}"), 0, 0);
    $pdf->setX(110);
    $pdf->Cell(50, 8, utf8_decode("Fecha de emisión: {$factura['fecha_emision']}"), 0, 1);
    $pdf->Cell(50, 8, "Emitido por: {$factura['usuario']}", 0, 1);
    $pdf->Cell(50, 8, utf8_decode("Dirección: {$env->get('address')}"), 0, 1);
    $pdf->Cell(100, 8, "Nombre: ".utf8_decode($factura["razon_social_cliente"]), 0, 1);
    $pdf->Cell(100, 8, "NIT/CI: ".$factura["nit_ci_cliente"], 0, 1);

    // Detalles Header
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(120, 15, "", 0, 1);
    $pdf->setX(90);
    $pdf->Cell(30, 20, "Detalle", 0, 1, "C");
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(43, 43, 43);
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell(92, 8, utf8_decode("Descripción"), 1, 0, "C", true);
    $pdf->Cell(22, 8, "Cantidad", 1, 0, "C", true);
    $pdf->Cell(22, 8, "P. Unitario", 1, 0, "C", true);
    $pdf->Cell(22, 8, "Descuento", 1, 0, "C", true);
    $pdf->Cell(22, 8, "P. Total", 1, 1, "C", true);

    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(0,0,0);
    
    // Detalles Body

    $productos = json_decode($factura['detalle'], true);
    
    foreach($productos as $item){
        $pdf->Cell(92, 8, utf8_decode($item["descripcion"]), 1, 0, "L");
        $pdf->Cell(22, 8, number_format((float)$item["cantidad"],2,'.',','), 1, 0, "R");
        $pdf->Cell(22, 8, number_format((float)$item["precioUnitario"], 2, '.', ','), 1, 0, "R");
        $pdf->Cell(22, 8, number_format((float)$item["montoDescuento"], 2, '.', ','), 1, 0, "R");
        $pdf->Cell(22, 8, number_format((float)$item["subTotal"], 2, '.', ','), 1, 1, "R");
    }

    // Detalles Footer

    $pdf->SetFont("Arial", "B", 10);
    $pdf->Cell(158, 8, "Subtotal", 1, 0, "R");
    $pdf->Cell(22, 8, number_format((float)$factura["neto"], 2, '.', ','), 1, 1, "R");
    $pdf->Cell(158, 8, "Descuento", 1, 0, "R");
    $pdf->Cell(22, 8, number_format((float)$factura["descuento"], 2, '.', ','), 1, 1, "R");
    $pdf->Cell(158, 8, "Total", 1, 0,"R");
    $pdf->Cell(22, 8, number_format((float)$factura["total"], 2, '.', ','), 1, 1, "R");

    $pdf->Output();
?>

