<?php

class CustomerModel {
    
    static public function alls() {
        $pdo = Connection::connect();
        $stmt = $pdo->query("SELECT * FROM cliente");
        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $customers;
    }

    static public function getCustomerById($id) {
        try {
            $pdo = Connection::connect();
            $stmt = $pdo->prepare("SELECT * FROM cliente WHERE id = :id LIMIT 1");
            $stmt->execute(['id' => $id]);
            $customer = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $customer ? $customer : null;
        } catch (Exception $e) {
            throw new Exception("Error al obtener los datos del cliente: " . $e->getMessage());
        }
    }

    static public function createCustomer($razon_social, $nit_ci, $direccion, $nombre, $telefono, $email) {
        try {
            $pdo = Connection::connect();
            $stmt = $pdo->prepare("INSERT INTO cliente (razon_social, nit_ci, direccion, nombre, telefono, email) VALUES (:razon_social, :nit_ci, :direccion, :nombre, :telefono, :email)");
            $stmt->bindParam(':razon_social', $razon_social, PDO::PARAM_STR);
            $stmt->bindParam(':nit_ci', $nit_ci, PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
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

    static public function removeCustomer($id) {
        try {
            $pdo = Connection::connect();
            $stmt = $pdo->prepare("DELETE FROM cliente WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $result = $stmt->execute();
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            return false;
        }
    }

    static public function updateCustomer($id, $razon_social, $nit_ci, $direccion, $nombre, $telefono, $email) {
        try {
            $pdo = Connection::connect();
            $stmt = $pdo->prepare("UPDATE cliente SET razon_social = :razon_social, nit_ci = :nit_ci, direccion = :direccion, nombre = :nombre, telefono = :telefono, email = :email WHERE id = :id");
            $stmt->bindParam(':razon_social', $razon_social, PDO::PARAM_STR);
            $stmt->bindParam(':nit_ci', $nit_ci, PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar el cliente: " . $e->getMessage());
        }
    }
    
}
