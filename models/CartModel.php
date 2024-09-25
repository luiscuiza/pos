<?php

class CartModel {

    private static function uuid() {
        do {
            $timestamp = round(microtime(true) * 1000);
            $uuid = sprintf(
                '%08x%04x%04x%04x%012x',
                random_int(0, 0xffffffff),
                random_int(0, 0xffff),
                random_int(0, 0xffff) & 0x0fff | 0x4000,
                random_int(0, 0x3fff) | 0x8000,
                $timestamp
            );
        } while (isset($_SESSION['cart'][$uuid]));
        return $uuid;
    }

    public static function get() {
        $neto = 0;
        $descuento = 0;
        $total = 0;
        foreach ($_SESSION['cart'] as &$item) {
            $neto += $item['cantidad'] * $item['precioUnitario'];
            $descuento += $item['montoDescuento'];
            $total += $item['subTotal'];
        }
        return [
            'cart' => $_SESSION['cart'] ?? [],
            'totales' => [
                'neto' => $neto,
                'descuento' => $descuento,
                'total' => $total
            ]
        ];
    }

    public static function add($data) {
        try {
            $codigo = $data['codigoProducto'];
            $cantidad = $data['cantidad'];
            $precio = $data['precioUnitario'];
            $descuento = $data['montoDescuento'];
    
            $productFound = false;
    
            if ($descuento == 0) {
                foreach ($_SESSION['cart'] as &$item) {
                    if ($item['codigoProducto'] === $codigo && $item['montoDescuento'] == 0) {
                        $item['cantidad'] += $cantidad;
                        $item['subTotal'] = $item['cantidad'] * $precio;
                        $productFound = true;
                        break;
                    }
                }
            }
    
            if (!$productFound) {
                $uuid = self::uuid();
                $_SESSION['cart'][$uuid] = [
                    'actividadEconomica' => $data['actividadEconomica'],
                    'codigoProductoSin' => $data['codigoProductoSin'],
                    'codigoProducto' => $data['codigoProducto'],
                    'precioUnitario' => $precio,
                    'montoDescuento' => $descuento,
                    'descripcion' => $data['descripcion'],
                    'unidadMedida' => $data['unidadMedidaSin'],
                    //'unidadMedida' => $data['unidadMedida'],
                    //'unidadMedidaSin' => $data['unidadMedidaSin'],
                    'cantidad' => $cantidad,
                    'subTotal' => ($cantidad * $precio) - $descuento
                ];
            }
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    public static function remove($uuid) {
        if (isset($_SESSION['cart'][$uuid])) {
            unset($_SESSION['cart'][$uuid]);
            return true;
        }
        return false;
    }

    public static function clear() {
        $_SESSION['cart'] = [];
    }
}
