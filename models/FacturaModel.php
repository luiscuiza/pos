<?php

class FacturaModel {

    /* Obtener todas las facturas */
    public static function alls() {
        $pdo = Connection::connect();
        $stmt = $pdo->query("SELECT * FROM factura");
        $facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $facturas;
    }

    /* Obtener una factura por su ID */
    public static function getFacturaById($id) {
        try {
            $pdo = Connection::connect();
            $stmt = $pdo->prepare("SELECT * FROM factura WHERE id = :id LIMIT 1");
            $stmt->execute(['id' => $id]);
            $factura = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $factura ? $factura : null;
        } catch (Exception $e) {
            throw new Exception("Error al obtener los datos de la factura: " . $e->getMessage());
        }
    }

    /* Crear una nueva factura */
    public static function createFactura($cod_factura, $id_cliente, $detalle, $neto, $descuento, $total, $fecha_emicion, $cufd, $cuf, $xml, $id_punto_venta, $id_usuario, $usuario, $leyenda) {
        try {
            $pdo = Connection::connect();
            $stmt = $pdo->prepare("INSERT INTO factura (cod_factura, id_cliente, detalle, neto, descuento, total, fecha_emicion, cufd, cuf, xml, id_punto_venta, id_usuario, usuario, leyenda) VALUES (:cod_factura, :id_cliente, :detalle, :neto, :descuento, :total, :fecha_emicion, :cufd, :cuf, :xml, :id_punto_venta, :id_usuario, :usuario, :leyenda)");
            $stmt->bindParam(':cod_factura', $cod_factura, PDO::PARAM_STR);
            $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
            $stmt->bindParam(':detalle', $detalle, PDO::PARAM_STR);
            $stmt->bindParam(':neto', $neto, PDO::PARAM_STR);
            $stmt->bindParam(':descuento', $descuento, PDO::PARAM_STR);
            $stmt->bindParam(':total', $total, PDO::PARAM_STR);
            $stmt->bindParam(':fecha_emicion', $fecha_emicion, PDO::PARAM_STR);
            $stmt->bindParam(':cufd', $cufd, PDO::PARAM_STR);
            $stmt->bindParam(':cuf', $cuf, PDO::PARAM_STR);
            $stmt->bindParam(':xml', $xml, PDO::PARAM_STR);
            $stmt->bindParam(':id_punto_venta', $id_punto_venta, PDO::PARAM_INT);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $stmt->bindParam(':leyenda', $leyenda, PDO::PARAM_INT);
            $result = $stmt->execute();
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            var_dump($e);
            return false;
        }
    }

    /* Eliminar una factura */
    public static function removeFactura($id) {
        try {
            $pdo = Connection::connect();
            $stmt = $pdo->prepare("DELETE FROM factura WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $result = $stmt->execute();
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            return false;
        }
    }

    /* Actualizar una factura */
    public static function updateFactura($id, $cod_factura, $id_cliente, $detalle, $neto, $descuento, $total, $fecha_emicion, $cufd, $cuf, $xml, $id_punto_venta, $id_usuario, $usuario, $leyenda) {
        try {
            $pdo = Connection::connect();
            $stmt = $pdo->prepare("UPDATE factura SET cod_factura = :cod_factura, id_cliente = :id_cliente, detalle = :detalle, neto = :neto, descuento = :descuento, total = :total, fecha_emicion = :fecha_emicion, cufd = :cufd, cuf = :cuf, xml = :xml, id_punto_venta = :id_punto_venta, id_usuario = :id_usuario, usuario = :usuario, leyenda = :leyenda WHERE id = :id");
            $stmt->bindParam(':cod_factura', $cod_factura, PDO::PARAM_STR);
            $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
            $stmt->bindParam(':detalle', $detalle, PDO::PARAM_STR);
            $stmt->bindParam(':neto', $neto, PDO::PARAM_STR);
            $stmt->bindParam(':descuento', $descuento, PDO::PARAM_STR);
            $stmt->bindParam(':total', $total, PDO::PARAM_STR);
            $stmt->bindParam(':fecha_emicion', $fecha_emicion, PDO::PARAM_STR);
            $stmt->bindParam(':cufd', $cufd, PDO::PARAM_STR);
            $stmt->bindParam(':cuf', $cuf, PDO::PARAM_STR);
            $stmt->bindParam(':xml', $xml, PDO::PARAM_STR);
            $stmt->bindParam(':id_punto_venta', $id_punto_venta, PDO::PARAM_INT);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $stmt->bindParam(':leyenda', $leyenda, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $result = $stmt->execute();
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar la factura: " . $e->getMessage());
        }
    }
}
