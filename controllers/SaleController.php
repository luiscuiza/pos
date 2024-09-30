<?php

class SaleController {

    static public function renderSales() {
        $sales = SaleModel::alls();
        $data = [
            'title' => 'POS - Facturas',
            'sales' => $sales
        ];
        TemplateController::render('./views/sales/list.php', './views/layout/sidebar.php', $data);
    }

    static public function renderEmit() {
        $customers = CustomerModel::alls();
        $nFactura = SaleModel::getNumSale();
        $productos = ProductModel::alls();
        $cart = CartModel::get();
        $data = [
            'title' => 'POS - Emitir Factura',
            'customers' => $customers,
            'nFactura' => $nFactura,
            'productos' => $productos,
            'cart' => $cart['cart'],
            'totales' => $cart['totales']
        ];
        TemplateController::render('./views/sales/emit.php', './views/layout/sidebar.php', $data);
    }

    static public function renderPrint() {
        $facturaID = $_GET['id'] ?? null;
        if (!$facturaID) {
            ErrorController::render(400,'Parámetro Inválido: No se puede imprimir la factura.');
            exit;
        }
        $factura = SaleModel::getById($facturaID);
        $data = [
            'title' => 'POS - Facturas',
            'factura' => $factura
        ];
        TemplateController::render('./views/sales/print.php', null, $data);
    }

    public static function renderViewForm() {
        $saleId = $_GET['id'] ?? null;
        if (!$saleId) {
            return;
        }
        $sale = SaleModel::getById($saleId);
        if (!$sale) {
            return;
        }
        include 'views/sales/formView.php';
    }

    static public function emitSale() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            if (!$data || !isset($data['numFactura'], $data['fechaFactura'], $data['rsCliente'], 
                 $data['tpDocumento'], $data['actEconomica'], $data['emailCliente'], $data['leyenda'],
                 $data['nitCliente'], $data['metPago'], $data['idCliente'])) {
                throw new Exception('Faltan algunos datos de la factura.');
            }
            $cart = CartModel::get();
            $totales = $cart['totales'];
            $detalles = [];
            foreach ($cart['cart'] as $detalle) {
                $detalles[] = $detalle;
            }
            $client = [
                'fecha' => $data['fechaFactura'],
                'leyenda' => $data['leyenda'],
                'metPago' => $data['metPago'],
                'nFact' => $data['numFactura'],
                'rsCliente' => $data['rsCliente'], 
                'idCliente' => $data['idCliente'],
                'nitCliente' => $data['nitCliente'],
                'tpDocumento' => $data['tpDocumento'],
                'actEconomica' => $data['actEconomica'],
                'emailCliente' => $data['emailCliente']
            ];
            echo json_encode(SIATController::emitirFactura($client, $detalles, $totales));
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    static public function removeSale() {
        $id = $_POST['id'] ?? null;
        $cuf = $_POST['cuf'] ?? null;
        
        if (empty($cuf) || empty($id)) {
            echo json_encode(["status" => "ERROR", "message" => "El CUF de la factura es requerido."]);
            return;
        }
        try {
            $result = SIATController::anularFactura($cuf);
            if($result['success']) {
                echo json_encode(["status" => "OK", "message" => $result['message']]);
            } else {
                echo json_encode(["status" => "ERROR", "message" => $result['message']]);
            }
        } catch (Exception $e) {
            echo json_encode(["status" => "ERROR", "message" => "Error al anular la factura: " . $e->getMessage()]);
        }
    }
}
