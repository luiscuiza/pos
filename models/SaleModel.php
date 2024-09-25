<?php

class SaleModel {

    static public function alls() {
        try {
            $pdo = Connection::connect();
            $stmt = $pdo->query("SELECT id_factura, codigo_factura, razon_social_cliente, fecha_emicion, total, estado_factura FROM factura JOIN cliente ON cliente.id_cliente = factura.id_cliente;");
            $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $sales;
        } catch (PDOException $e) {
            return false;
        }
    }

    static public function getById($saleID) {
        try {
            $pdo = Connection::connect();
            $stmt = $pdo->prepare("SELECT * FROM factura JOIN cliente ON cliente.id_cliente = factura.id_cliente WHERE id_factura= :id;");
            $stmt->bindParam(':id', $saleID, PDO::PARAM_INT);
            $sale = $stmt->execute();
            $sale = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $sale ? $sale : null;
        } catch (PDOException $e) {
            return false;
        }
    }

    static public function add($data) {
        try {
            $cod_factura = $data['cod_factura'];
            $id_cliente = $data['id_cliente'];
            $detalle = $data['detalle'];
            $neto = $data['neto'];
            $descuento = $data['descuento'];
            $total = $data['total'];
            $fecha_emision = $data['fecha_emision'];
            $cufd = $data['cufd'];
            $cuf = $data['cuf'];
            $xml = $data['xml'];
            $id_punto_venta = $data['id_punto_venta'];
            $id_usuario = $data['id_usuario'];
            $usuario = $data['usuario'];
            $leyenda = $data['leyenda'];

            $pdo = Connection::connect();
            $stmt = $pdo->prepare("INSERT INTO factura (cod_factura, id_cliente, detalle, neto, descuento, total, fecha_emision, cufd, cuf, xml, id_punto_venta, id_usuario, usuario, leyenda	) VALUES (:cod_factura, :id_cliente, :detalle, :neto, :descuento, :total, :fecha_emision, :cufd, :cuf, :xml, :id_punto_venta, :id_usuario, :usuario, :leyenda)");
            
            $stmt->bindParam(':cod_factura', $cod_factura, PDO::PARAM_STR);
            $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
            $stmt->bindParam(':detalle', $detalle, PDO::PARAM_STR);
            $stmt->bindParam(':neto', $neto, PDO::PARAM_STR);
            $stmt->bindParam(':descuento', $descuento, PDO::PARAM_STR);
            $stmt->bindParam(':total', $total, PDO::PARAM_STR);
            $stmt->bindParam(':fecha_emision', $fecha_emision, PDO::PARAM_STR);
            $stmt->bindParam(':cufd', $cufd, PDO::PARAM_STR);
            $stmt->bindParam(':cuf', $cuf, PDO::PARAM_STR);
            $stmt->bindParam(':xml', $xml, PDO::PARAM_STR);
            $stmt->bindParam(':id_punto_venta', $id_punto_venta, PDO::PARAM_INT);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $stmt->bindParam(':leyenda', $leyenda, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                $stmt->closeCursor();
                return true;
            } else {
                $stmt->closeCursor();
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

}