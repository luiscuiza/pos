<?php

require_once 'Connection.php';

class UserModel {

    static public function authorize($username, $password) {
        try {
            $pdo = Connection::connect();
            $stmt = $pdo->prepare("SELECT * FROM usuario WHERE login_usuario = :login_usuario LIMIT 1");
            $stmt->execute(['login_usuario' => $username]);
            $user = $stmt->fetch();
            $stmt->closeCursor();
            if ($user && $user['estado_usuario']) {
                if (password_verify($password, $user['password'])) {
                    $updateStmt = $pdo->prepare("UPDATE usuario SET ultimo_login = NOW() WHERE id_usuario = :id_usuario");
                    $updateStmt->execute(['id_usuario' => $user['id_usuario']]);
                    $updateStmt->closeCursor();
                    return $user;
                }
            }
            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    static public function alls() {
        $pdo = Connection::connect();
        $stmt = $pdo->query("SELECT * FROM usuario");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $users;
    }

    static public function getUserById($id_usuario) {
        try {
            $pdo = Connection::connect();
            $stmt = $pdo->prepare("SELECT * FROM usuario WHERE id_usuario = :id_usuario LIMIT 1");
            $stmt->execute(['id_usuario' => $id_usuario]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $user ? $user : null;
        } catch (Exception $e) {
            throw new Exception("Error al obtener los datos del usuario: " . $e->getMessage());
        }
    }

    static public function createUser($username, $password, $profile) {
        try {
            $pdo = Connection::connect();
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuario (login_usuario, password, perfil) VALUES (:login_usuario, :password, :perfil)");
            $stmt->bindParam(':login_usuario', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hash, PDO::PARAM_STR);
            $stmt->bindParam(':perfil', $profile, PDO::PARAM_STR);
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

    static public function removeUser($id_usuario) {
        try {
            $pdo = Connection::connect();
            $stmt = $pdo->prepare("DELETE FROM usuario WHERE id_usuario = :id_usuario");
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $result = $stmt->execute();
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            return false;
        }
    }

    static public function updateUser($userId, $username, $password, $profile, $estado) {
        try {
            $pdo = Connection::connect();
            $query = "UPDATE usuario SET login_usuario = :login_usuario, perfil = :perfil, estado_usuario = :estado_usuario";
            
            if ($password !== null) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $query .= ", password = :password";
            }
            
            $query .= " WHERE id_usuario = :id_usuario";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':login_usuario', $username, PDO::PARAM_STR);
            $stmt->bindParam(':perfil', $profile, PDO::PARAM_STR);
            $stmt->bindParam(':estado_usuario', $estado, PDO::PARAM_INT);
            $stmt->bindParam(':id_usuario', $userId, PDO::PARAM_INT);
            if ($password !== null) {
                $stmt->bindParam(':password', $hash, PDO::PARAM_STR);
            }
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar el usuario: " . $e->getMessage());
        }
    }
}
