<?php

class CufdController {
 
    public static function save() {
        $cufd = $_POST['cufd'] ?? null;
        $vigencia = $_POST['vigencia'] ?? null;
        $control = $_POST['control'] ?? null;
        if (empty($cufd) || empty($vigencia) || empty($control)) {
            echo json_encode(["status" => "error", "message" => "Todos los datos son requeridos."]);
            return;
        }
        try {
            if (CufdModel::save($cufd, $vigencia, $control)) {
                echo json_encode(["status" => "success", "message"=> "Datos guardados exitosamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "No se pudo guardar los datos."]);
            }
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => "Error al guardar los datos: " . $e->getMessage()]);
        }
    }
    
    public static function info() {
        try {
            $cufdInfo = CufdModel::lastCufd();
            if (isset($cufdInfo['status']) && $cufdInfo['status'] === 'no_data') {
                echo json_encode(["status" => "no_data",  "message" => $cufdInfo["message"]]);
                return;
            }
            echo json_encode(["status" => "success",  "data" => $cufdInfo]);
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => "Error al obtener los datos: " . $e->getMessage()]);
        }
    }
}