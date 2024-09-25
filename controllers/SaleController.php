<?php

class SaleController {

    static public function renderEmit() {
        $customers = CustomerModel::alls();
        $nFactura = FacturaModel::getNumFactura();
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
    
}
