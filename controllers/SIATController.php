<?php

class SIATController {

    static public function isConnected() {
        $url = 'http://localhost:5000/api/CompraVenta/comunicacion';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            curl_close($ch);
            echo json_encode(['success' => false, 'message' => 'SIN - Desconectado']);
            exit;
        }
        curl_close($ch);
        $data = json_decode($response, true);
        if (isset($data['transaccion']) && $data['transaccion']) {
            echo json_encode(['success' => true, 'message' => 'SIN - Conectado']);
        } else {
            echo json_encode(['success' => false, 'message' => 'SIN - Desconectado']);
        }
    }

    static public function isValidCufd() {
        $cufd = CufdModel::lastCufd();
        if($cufd) {
            $_SESSION['cufd'] = $cufd['codigo_cufd'];
            $_SESSION['cufdControl'] = $cufd['codigo_control'];
            $now = new DateTime();
            $now->modify('+10 seconds');
            $vigencia = new DateTime($cufd['fecha_vigencia']);
            if ($vigencia > $now) {
                echo json_encode(['success' => true, 'message' => 'CUFD - Vigente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'CUFD - Caducado']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'CUFD - Caducado']);
        }
    }

    static public function renewCufd() {
        global $env;
        $token = $env->get('token','');
        $codsys = $env->get('codsys','');
        $nit  = $env->get('nit','');
        $cuis  = $env->get('cuis','');
        $url = "http://localhost:5000/api/Codigos/solicitudCufd?token={$token}";
        $obj = array(
            'codigoAmbiente' => 2,
            'codigoModalidad' => 2,
            'codigoPuntoVenta' => 0,
            'codigoPuntoVentaSpecified' => true,
            'codigoSistema' => $codsys,
            'codigoSucursal' => 0,
            'nit' => $nit,
            'cuis' => $cuis
        );
        $data = json_encode($obj);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            echo json_encode(['success' => false, 'message' => $error_msg]);
            exit;
        }
        curl_close($ch);
        $data = json_decode($response, true);
        if (isset($data['codigo']) && isset($data['codigoControl']) && isset($data['fechaVigencia'])) {
            if(CufdModel::save($data['codigo'], $data['fechaVigencia'], $data['codigoControl'])) {
                $_SESSION['cufd'] = $data['codigo'];
                $_SESSION['cufdControl'] = $data['codigoControl'];
                echo json_encode(['success' => true, 'message' => 'Exito al obtener el CUFD']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al obtener el CUFD']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al obtener el CUFD']);
        }
    }

    static public function unidadMedidas() {
        try {
            global $env;
            $token = $env->get('token','');
            $codsys = $env->get('codsys','');
            $nit  = $env->get('nit','');
            $cuis  = $env->get('cuis','');
            
            if (empty($nit) || empty($cuis) || empty($codsys) || empty($token)) {
                throw new Exception('No se pudo leer los datos del emisor.');
            }
            
            $url = "http://localhost:5000/Sincronizacion/unidadmedida?token=$token";

            $data = json_encode([
                'codigoAmbiente' => 2,
                'codigoPuntoVenta' => 0,
                'codigoPuntoVentaSpecified' => true,
                'codigoSucursal' => 0,
                'codigoSistema' => $codsys,
                'cuis' => $cuis,
                'nit' => $nit
            ]);

            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json'
            ));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
                curl_close($ch);
                echo json_encode(['success' => false, 'message' => $error_msg]);
                exit;
            }
            
            curl_close($ch);
            $data = json_decode($response, true);
            
            if(isset($data['listaCodigos'])) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Lista de medidas obtenidas exitosamente',
                    'data' => $data
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'No se pudo obtener la lista de medidas'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    static public function sinCatalog() {
        try {
            global $env;
            $token = $env->get('token','');
            $codsys = $env->get('codsys','');
            $nit  = $env->get('nit','');
            $cuis  = $env->get('cuis','');
            
            if (empty($nit) || empty($cuis) || empty($codsys) || empty($token)) {
                throw new Exception('No se pudo leer los datos del emisor.');
            }
            
            $url = "http://localhost:5000/Sincronizacion/listaproductosservicios?token=$token";

            $data = json_encode([
                'codigoAmbiente' => 2,
                'codigoPuntoVenta' => 0,
                'codigoPuntoVentaSpecified' => true,
                'codigoSucursal' => 0,
                'codigoSistema' => $codsys,
                'cuis' => $cuis,
                'nit' => $nit
            ]);

            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json'
            ));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
                curl_close($ch);
                echo json_encode(['success' => false, 'message' => $error_msg]);
                exit;
            }
            
            curl_close($ch);
            $data = json_decode($response, true);
            
            if(isset($data['listaCodigos'])) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Lista de catalogo obtenidas exitosamente',
                    'data' => $data
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'No se pudo obtener la lista de catalogo'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

}

