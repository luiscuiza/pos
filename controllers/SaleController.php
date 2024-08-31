<?php

class SaleController {

    /* Quitar */
    static public function renderSales() {
        $sales = SaleModel::alls();
        $data = [
            'title' => 'POS - Ventas',
            'sales' => $sales
        ];
        TemplateController::render('./views/sales/list.php', './views/layout/sidebar.php', $data);
    }


    static public function renderEmit() {
        $customers = CustomerModel::alls();
        $nFactura = FacturaModel::getNumFactura();
        $productos = ProductModel::alls();
        $data = [
            'title' => 'POS - Emitir Factura',
            'customers' => $customers,
            'nFactura' => $nFactura,
            'productos' => $productos
        ];
        TemplateController::render('./views/sales/emit.php', './views/layout/sidebar.php', $data);
    }

}
