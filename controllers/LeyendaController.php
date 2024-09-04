<?php 

class LeyendaController {
    
    public static function random() {
        try {
            $leyenda = LeyendaModel::getRandom();
            if ($leyenda) {
                echo json_encode(["status" => "success", "data" => $leyenda]);
            } else {
                echo json_encode(["status" => "error", "message" => "No se pudo obtener la leyenda."]);
            }
        } catch (Exception $e) {
            echo json_encode(["status" => "success", "message" => "Error al obtener la leyenda: " . $e->getMessage()]);
        }
    }

}