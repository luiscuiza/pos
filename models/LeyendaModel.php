<?php 

class LeyendaModel {

    public static function getRandom() {
        try {
            $pdo = Connection::connect();
            $stmt = $pdo->prepare("SELECT * FROM leyenda ORDER BY RAND() limit 1");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            throw new Exception("Error al obtener la leyenda: " . $e->getMessage());
        }
    }
    
}