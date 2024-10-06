<?php

class DashboardController {

    static public function render() {
        $user = UserModel::count();
        $customer = CustomerModel::count();
        $producto = ProductModel::count();
        $factura = SaleModel::count();
        $data = [
            'title' => 'POS - Dashboard',
            'users' => $user['count'] ?? 0,
            'customers' => $customer['count'] ?? 0,
            'productos' => $producto['count'] ?? 0,
            'facturas' => $factura['todos'] ?? 0,
            'anulados' => $factura['anulados'] ?? 0,
            'emitidos' => $factura['emitidos'] ?? 0
        ];
        TemplateController::render('./views/dashboard.php', './views/layout/sidebar.php', $data);
    }
    
}
