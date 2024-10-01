<?php ob_start(); ?>
    <link rel="stylesheet" href="/assets/css/fpdf.css">
<?php $headCss = ob_get_clean(); ?>

<?php
    require_once 'fpdf/fpdf.php';

    function decode($text) {
        if (version_compare(PHP_VERSION, '8.2.0', '<')) {
            return utf8_decode($text);
        } else {
            return mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8');
        }
    }

    class PDF extends FPDF {

        private $footer = "";
        private $header = "";

        public function SetHeader($text) {
            $this->header = $text;
        }

        public function SetFooter($text) {
            $this->footer = $text;
        }

        function Header() {
            $this->SetFont('Arial', 'B', 15);
            $this->SetY(10);
            $this->SetX(25);
            $this->MultiCell(171, 10, decode($this->header)); 
            $this->Line(25, 20, 196, 20);
        }

        function Footer() {
            $this->SetFont('Arial', '', 9);
            $this->SetY(-20);
            $y = $this->GetY();
            $this->Line(25, $y, 196, $y);
            $this->SetX(25);
            $this->MultiCell(171, 8, decode($this->footer), 0, 'C');
        }

    }
?>


<?php
    global $env;

    $pdf = new PDF('P', 'mm', 'Letter');

    $pdf->SetTitle($title);

    // Encabezado y Pie de pagina

    $pdf->SetHeader($env->get('razonsocial'));
    $pdf->SetFooter($factura['leyenda']);

    $pdf->AddPage();

    // Contenido
    $pdf->SetY(30);
    

    $pdf->SetFont('Arial', '', 10);

    $pdf->SetX(25);
    $pdf->Cell(100, 8, decode("NIT:"), 0, 0);
    $pdf->SetX(50);
    $pdf->Cell(100, 8, decode($env->get('nit')), 0, 0);

    $pdf->SetX(110);
    $pdf->Cell(100, 8, decode("N° Factura:"), 0, 0);
    $pdf->SetX(145);
    $pdf->Cell(100, 8, decode($factura['codigo_factura']), 0, 1);

    
    $pdf->SetX(25);
    $pdf->Cell(50, 8, decode("Teléfonos: "), 0, 0);
    $pdf->SetX(50);
    $pdf->Cell(100, 8, decode($factura['telefono_cliente']), 0, 0);

    $pdf->SetX(110);
    $pdf->Cell(100, 8, decode("Fecha de Emisión:"), 0, 0);
    $pdf->SetX(145);
    $pdf->Cell(100, 8, decode($factura['fecha_emision']), 0, 1);

    $pdf->SetX(25);
    $pdf->Cell(100, 8, "Emitido por:", 0, 0);
    $pdf->SetX(50);
    $pdf->Cell(100, 8, $factura['usuario'], 0, 1);

    $pdf->SetX(25);
    $pdf->Cell(100, 8, decode("Dirección:"), 0, 0);
    $pdf->SetX(50);
    $pdf->MultiCell(145, 8, decode($env->get('address')));

    $pdf->SetX(25);
    $pdf->Cell(100, 8, decode("Nombre:"), 0, 0);
    $pdf->SetX(50);
    $pdf->Cell(100, 8, decode($factura["razon_social_cliente"]), 0, 1);

    $pdf->SetX(25);
    $pdf->Cell(100, 8, decode("NIT/CI:"), 0, 0);
    $pdf->SetX(50);
    $pdf->Cell(100, 8, decode($factura["nit_ci_cliente"]), 0, 1);
    
    // Detalles Header

    $pdf->SetX(25);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(170, 20, "Detalle", 0, 1, "C");
    
    $pdf->SetX(25);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(43, 43, 43);
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell(82, 8, decode("Descripción"), 1, 0, "C", true);
    $pdf->Cell(22, 8, "Cantidad", 1, 0, "C", true);
    $pdf->Cell(22, 8, "P.U.", 1, 0, "C", true);
    $pdf->Cell(22, 8, "Descuento", 1, 0, "C", true);
    $pdf->Cell(22, 8, "Subtotal", 1, 1, "C", true);

    // Detalles Body
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);
    $productos = json_decode($factura['detalle'], true);
    foreach($productos as $item){
        $pdf->SetX(25);
        $pdf->Cell(82, 8, decode($item["descripcion"]), 1, 0, "L");
        $pdf->Cell(22, 8, number_format((float)$item["cantidad"],2,'.',','), 1, 0, "R");
        $pdf->Cell(22, 8, number_format((float)$item["precioUnitario"], 2, '.', ','), 1, 0, "R");
        $pdf->Cell(22, 8, number_format((float)$item["montoDescuento"], 2, '.', ','), 1, 0, "R");
        $pdf->Cell(22, 8, number_format((float)$item["subTotal"], 2, '.', ','), 1, 1, "R");
    }

    // Detalle Footer
    

    $pdf->SetX(25);
    $pdf->Cell(148, 8, "Subtotal", 1, 0, "R");
    $pdf->Cell(22, 8, number_format((float)$factura["neto"], 2, '.', ','), 1, 1, "R");
    $pdf->SetX(25);
    $pdf->Cell(148, 8, "Descuento", 1, 0, "R");
    $pdf->Cell(22, 8, number_format((float)$factura["descuento"], 2, '.', ','), 1, 1, "R");
    $pdf->SetX(25);
    $pdf->Cell(148, 8, "Total", 1, 0,"R");
    $pdf->Cell(22, 8, number_format((float)$factura["total"], 2, '.', ','), 1, 1, "R");

    //
    if($factura['estado_factura']==0) {
        $pdf->Image("./assets/dist/img/anulado-i.png", 78, 121, 60, 37);
    }

    $pdf->Output();
?>

