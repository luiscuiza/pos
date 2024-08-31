<?php

class ProductModel {

    /* Obtener todos los productos */
    static public function alls() {
        $pdo = Connection::connect();
        $stmt = $pdo->query("SELECT * FROM producto");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $products;
    }

    /* Obtener un producto por su ID */
    static public function getProductById($id) {
        try {
            $pdo = Connection::connect();
            $stmt = $pdo->prepare("SELECT * FROM producto WHERE id_producto = :id LIMIT 1");
            $stmt->execute(['id' => $id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $product ? $product : null;
        } catch (Exception $e) {
            throw new Exception("Error al obtener los datos del producto: " . $e->getMessage());
        }
    }

    /* Crear un nuevo producto */
    static public function createProduct($codigo, $codigo_sin, $nombre, $precio, $unidad_medida, $unidad_medida_sin, $imagen, $disponible) {
        try {
            $pdo = Connection::connect();
            $stmt = $pdo->prepare("INSERT INTO producto (cod_producto, cod_producto_sin, nombre_producto, precio_producto, unidad_medida, unidad_medida_sin, imagen_producto, disponible) VALUES (:codigo, :codigo_sin, :nombre, :precio, :unidad_medida, :unidad_medida_sin, :imagen, :disponible)");
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
            $stmt->bindParam(':codigo_sin', $codigo_sin, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':precio', $precio, PDO::PARAM_STR);
            $stmt->bindParam(':unidad_medida', $unidad_medida, PDO::PARAM_STR);
            $stmt->bindParam(':unidad_medida_sin', $unidad_medida_sin, PDO::PARAM_INT);
            $stmt->bindParam(':imagen', $imagen, PDO::PARAM_STR);
            $stmt->bindParam(':disponible', $disponible, PDO::PARAM_INT);
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

    /* Eliminar un producto */
    static public function removeProduct($id) {
        try {
            $pdo = Connection::connect();
            $stmt = $pdo->prepare("DELETE FROM producto WHERE id_producto = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $result = $stmt->execute();
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            return false;
        }
    }

    /* Actualizar un producto */
    static public function updateProduct($id, $codigo, $codigo_sin, $nombre, $precio, $unidad_medida, $unidad_medida_sin, $imagen, $disponible) {
        try {
            $pdo = Connection::connect();
            $query = "UPDATE producto SET cod_producto = :codigo, cod_producto_sin = :codigo_sin, nombre_producto = :nombre, precio_producto = :precio, unidad_medida = :unidad_medida, unidad_medida_sin = :unidad_medida_sin, disponible = :disponible";
            if ($imagen !== null) {
                $query .= ", imagen_producto = :imagen";
            }
            $query .= " WHERE id_producto = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
            $stmt->bindParam(':codigo_sin', $codigo_sin, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':precio', $precio, PDO::PARAM_STR);
            $stmt->bindParam(':unidad_medida', $unidad_medida, PDO::PARAM_STR);
            $stmt->bindParam(':unidad_medida_sin', $unidad_medida_sin, PDO::PARAM_INT);
            $stmt->bindParam(':disponible', $disponible, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($imagen !== null) {
                $stmt->bindParam(':imagen', $imagen, PDO::PARAM_STR);
            }
            $stmt->execute();
            $stmt->closeCursor();
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar el producto: " . $e->getMessage());
        }
    }

    public static function infoProduct ($codprod) {
        try {
            $pdo = Connection::connect();
            $stmt = $pdo->prepare("SELECT * FROM producto WHERE cod_producto = :codpro");
            $stmt->bindParam(':codpro', $codprod, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            throw new Exception("Error al obtener datos del producto: " . $e->getMessage());
        }
    }

}