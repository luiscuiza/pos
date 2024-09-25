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

    static public function emitirFactura($client, $cart, $totales) {
        global $env;
        try {
            $url = "http://localhost:5000/api/CompraVenta/recepcion";

            $nit         = $env->get('nit');
            $cuis        = $env->get('cuis');
            $phone       = $env->get('phone');
            $codsys      = $env->get('codsys');
            $address     = $env->get('address');
            $razonsocial = $env->get('razonsocial');
            $user        = $_SESSION['user'] ?? null;
            $cufd        = $_SESSION['cufd'] ?? null;
            $userID      = $_SESSION['user_id'] ?? null;
            $cufdControl = $_SESSION['cufdControl'] ?? null;
    
            if (empty($nit) || empty($cuis) || empty($phone) || empty($codsys) || empty($address) || 
                empty($razonsocial) || empty($user) || empty($cufd) || empty($cufdControl) || empty($userID)) {
                throw new Exception('No se pudo leer los datos del emisor.');
            }

            $data = json_encode([
                "codigoAmbiente" => 2,
                "codigoDocumentSector" => 1,
                "codigoEmision" => 1,
                "codigoModalidad" => 2,
                "codigoPuntoVenta" => 0,
                "codigoPuntoVentaSpecified" => true,
                "codigoSistema" => $codsys,
                "codigoSucursal" => 0,
                "cufd" => $cufd,
                "cuis" => $cuis,
                "nit" => 338794023,
                "tipoFacturaDocumento" => 1,
                "archivo" => null,
                "fechaEnvio" => $client['fecha'],
                "hashArchivo" => "",
                "codigoControl" => $cufdControl,
                "factura" => [
                    "cabecera" => [
                        "nitEmisor" => $nit,
                        "razonSocialEmisor" => $razonsocial,
                        "municipio" => "Santa Cruz",
                        "telefono" => $phone,
                        "numeroFactura" => $client['nFact'],
                        "cuf" => "String",
                        "cufd" => "$cufd",
                        "codigoSucursal" => 0,
                        "direccion" => $address,
                        "codigoPuntoVenta" => 0,
                        "fechaEmision" => $client['fecha'],
                        "nombreRazonSocial" => $client['rsCliente'],
                        "codigoTipoDocumentoIdentidad" => 1,
                        "numeroDocumento" => $client['nitCliente'],
                        "complemento" => "",
                        "codigoCliente" => $client['nitCliente'],
                        "codigoMetodoPago" => $client['metPago'],
                        "numeroTarjeta" => null,
                        "montoTotal" => $totales['neto'],
                        "montoTotalSujetoIva" => $totales['total'],
                        "codigoMoneda" => 1,
                        "tipoCambio" => 1,
                        "montoTotalMoneda" => $totales['total'],
                        "montoGiftCard" => 0,
                        "descuentoAdicional" => $totales['descuento'],
                        "codigoExcepcion" => 0,
                        "cafc" => null,
                        "leyenda" => $client['leyenda'],
                        "usuario" => $user,
                        "codigoDocumentoSector" => 1
                    ],
                    "detalle" => $cart,
                ]
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
                curl_close($ch);
                throw new Exception('No se pudo establecer la conexion...');
                
            }
            curl_close($ch);
            $resp = json_decode($response, true);
            if (!$resp) {
                throw new Exception('No se pudo obtener una respuesta valida...');
            }
            if (!$resp['codigoResultado'] != 908) {
                $codigoResultado = $resp['codigoResultado'] ?? null;
                $codigoRecepcion = $resp['codigoReceptcion'] ?? null;
                $cuf = $resp['datoAdicional']['cuf'] ?? null;
                $sentDate = $resp['datoAdicional']['sentDate'] ?? null;
                $xml = $resp['datoAdicional']['xml'] ?? null;

                if(!isset($xml, $cuf, $sentDate, $codigoRecepcion, $codigoResultado)) {
                    throw new Exception('No se pudo obtener los datos de la respuesta...');
                }

                $date = (new DateTime($sentDate))->format('Y-m-d H:i:s');

                if(SaleModel::add([
                    'cod_factura' => $client['nFact'],
                    'id_cliente' => $client['idCliente'],
                    'detalle' => json_encode($cart),
                    'neto' => $totales['neto'],
                    'descuento' => $totales['descuento'],
                    'total' => $totales['total'],
                    'fecha_emision' => $date,
                    'cufd' => $cufd,
                    'cuf' => $cuf,
                    'xml' => $xml,
                    'id_punto_venta' => 0,
                    'id_usuario' => $userID,
                    'usuario' => $user,
                    'leyenda' => $client['leyenda']
                ])) {
                    CartModel::clear();
                    echo json_encode([
                        'success' => true,
                        'message' => 'Factura emitida correctamente.'
                    ]);   
                } else {
                    throw new Exception('Ocurrio un error al guardar la factura.');
                }
            } else {
                $message = $resp['datoAdicional'][0]['descripcion'] ?? 'Ocurrio un error en la consulta...';
                throw new Exception($message);
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}

