<?php

class FacturaController {

    /* Crear una nueva factura */
    public static function createFactura() {
        $cod_factura = $_POST['cod_factura'] ?? null;
        $id_cliente = $_POST['id_cliente'] ?? null;
        $detalle = $_POST['detalle'] ?? null;
        $neto = $_POST['neto'] ?? null;
        $descuento = $_POST['descuento'] ?? null;
        $total = $_POST['total'] ?? null;
        $fecha_emicion = $_POST['fecha_emicion'] ?? null;
        $cufd = $_POST['cufd'] ?? null;
        $cuf = $_POST['cuf'] ?? null;
        $xml = $_POST['xml'] ?? null;
        $id_punto_venta = $_POST['id_punto_venta'] ?? null;
        $id_usuario = $_POST['id_usuario'] ?? null;
        $usuario = $_POST['usuario'] ?? null;
        $leyenda = $_POST['leyenda'] ?? null;
        
        if (empty($cod_factura) || empty($id_cliente) || empty($detalle) || empty($neto) || empty($total) || 
            empty($fecha_emicion) || empty($cufd) || empty($cuf) || empty($id_punto_venta) || empty($id_usuario) || empty($usuario)) {
            echo json_encode(["status" => "ERROR", "message" => "Todos los campos son obligatorios."]);
            return;
        }

        $result = FacturaModel::createFactura($cod_factura, $id_cliente, $detalle, $neto, $descuento, $total, $fecha_emicion, $cufd, $cuf, $xml, $id_punto_venta, $id_usuario, $usuario, $leyenda);
        if ($result) {
            echo json_encode(["status" => "OK", "message" => "Factura creada exitosamente."]);
        } else {
            echo json_encode(["status" => "ERROR", "message" => "No se pudo crear la factura."]);
        }
    }

    /* Editar factura */
    public static function editFactura() {
        $id = $_POST['id'] ?? null;
        $cod_factura = $_POST['cod_factura'] ?? null;
        $id_cliente = $_POST['id_cliente'] ?? null;
        $detalle = $_POST['detalle'] ?? null;
        $neto = $_POST['neto'] ?? null;
        $descuento = $_POST['descuento'] ?? null;
        $total = $_POST['total'] ?? null;
        $fecha_emicion = $_POST['fecha_emicion'] ?? null;
        $cufd = $_POST['cufd'] ?? null;
        $cuf = $_POST['cuf'] ?? null;
        $xml = $_POST['xml'] ?? null;
        $id_punto_venta = $_POST['id_punto_venta'] ?? null;
        $id_usuario = $_POST['id_usuario'] ?? null;
        $usuario = $_POST['usuario'] ?? null;
        $leyenda = $_POST['leyenda'] ?? null;

        if (empty($id) || empty($cod_factura) || empty($id_cliente) || empty($detalle) || empty($neto) || empty($total) || empty($fecha_emicion) || empty($cufd) || empty($cuf) || empty($id_punto_venta) || empty($id_usuario) || empty($usuario)) {
            echo json_encode(['status' => 'ERROR', 'message' => 'Todos los campos son requeridos']);
            return;
        }

        try {
            FacturaModel::updateFactura($id, $cod_factura, $id_cliente, $detalle, $neto, $descuento, $total, $fecha_emicion, $cufd, $cuf, $xml, $id_punto_venta, $id_usuario, $usuario, $leyenda);
            echo json_encode(['status' => 'OK', 'message' => 'Factura actualizada exitosamente']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'ERROR', 'message' => 'Error al actualizar la factura: ' . $e->getMessage()]);
        }
    }

    /* Eliminar factura */
    public static function removeFactura() {
        $facturaId = $_POST['id'] ?? null;
        if (empty($facturaId)) {
            echo json_encode(["status" => "ERROR", "message" => "El ID de la factura es requerido."]);
            return;
        }

        try {
            $result = FacturaModel::removeFactura($facturaId);
            if ($result) {
                echo json_encode(["status" => "OK", "message" => "Factura eliminada exitosamente."]);
            } else {
                echo json_encode(["status" => "ERROR", "message" => "No se pudo eliminar la factura."]);
            }
        } catch (Exception $e) {
            echo json_encode(["status" => "ERROR", "message" => "Error al eliminar la factura: " . $e->getMessage()]);
        }
    }

}
