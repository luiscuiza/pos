<?php

class CartController {

    public static function getCart() {
        $cart = CartModel::get();
        return json_encode(['success' => true, 'data' => $cart]);
    }

    public static function addProduct() {
        $jsonInput = file_get_contents('php://input');
        $data = json_decode($jsonInput, true);
        if( isset($data['actividadEconomica']) &&
            isset($data['codigoProducto']) &&
            isset($data['codigoProductoSin']) &&
            isset($data['descripcion']) &&
            isset($data['cantidad']) &&
            isset($data['unidadMedida']) &&
            isset($data['unidadMedidaSin']) &&
            isset($data['precioUnitario']) &&
            isset($data['montoDescuento']) ) {
            if (CartModel::add($data)) {
                $cart = CartModel::get();
                echo json_encode(['success' => true, 'message' => 'Producto añadido al carrito', 'data' => $cart]);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
        }
    }

    public static function removeProduct() {
        $jsonInput = file_get_contents('php://input');
        $data = json_decode($jsonInput, true);
        if(isset($data['uuid'])){
            if (CartModel::remove($data['uuid'])) {
                return json_encode(['success' => true, 'message' => 'Producto eliminado']);
            } else {
                http_response_code(404);
                return json_encode(['success' => false, 'message' => 'Producto no encontrado']);
            }
        } else {
            http_response_code(404);
            return json_encode(['success' => false, 'message' => 'Producto no encontrado']);
        }
    }

    public static function clearCart() {
        CartModel::clear();
        return json_encode(['success' => true, 'message' => 'Carrito vaciado']);
    }
    
}