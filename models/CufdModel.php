<?php

class CufdModel {

    public static function save($cufd, $vigencia, $control) {
    try {
        $pdo = Connection::connect();
        //$pdo->exec("TRUNCATE TABLE cufd");
        $pdo->exec("DELETE FROM cufd");
        $stmt = $pdo->prepare("INSERT INTO cufd (codigo_cufd, fecha_vigencia, codigo_control) VALUES (:cufd, :vigencia, :control)");
        $stmt->bindParam(':cufd', $cufd, PDO::PARAM_STR);
        $stmt->bindParam(':vigencia', $vigencia, PDO::PARAM_STR);
        $stmt->bindParam(':control', $control, PDO::PARAM_STR);
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

    public static function lastCufd() {
        try {
            $pdo = Connection::connect();
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM cufd");
            $stmt->execute();
            $count = $stmt->fetchColumn();
            $stmt->closeCursor();
            if ($count == 0) {
                return ["status" => "no_data", "message" => "No se encontraron datos del CUFD."];
            }
            $stmt = $pdo->prepare("SELECT * FROM cufd ORDER BY id_cufd DESC LIMIT 1;");
            $stmt->execute();
            $cufd = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $cufd ?: null;
        } catch (Exception $e) {
            throw new Exception("Error al obtener los datos del CUFD: " . $e->getMessage());
        }
    }

}