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
    
}
