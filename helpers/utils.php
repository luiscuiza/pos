<?php

if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    require_once 'env.php';
    global $env;
    $env = new Environment('.env');
}

function uuidImage($fileName) {
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $timestamp = round(microtime(true) * 1000);
    $uuid = sprintf(
        '%08x%04x%04x%04x%012x',
        mt_rand(0, 0xffffffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff) & 0x0fff | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        $timestamp
    );
    return "$uuid.$ext";
}

function umSIN() {
    global $env;
    $url = "http://localhost:5000/Sincronizacion/unidadmedida?token={$env->get('token')}";
    $data = [
        "codigoAmbiente" => 2,
        "codigoPuntoVenta" => 0,
        "codigoPuntoVentaSpecified" => true,
        "codigoSucursal" => 0,
        "codigoSistema" => $env->get('codsys'),
        "cuis" => $env->get('cuis'),
        "nit" => $env->get('nit')
    ];
    $ch = curl_init($url);    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);
    $response = curl_exec($ch);
    if(curl_errno($ch)) {
        curl_close($ch);
        return null;
    } else {
        curl_close($ch);
        $jdata = json_decode($response, true);
        return $jdata;
    }
}

function prodSIN() {
    global $env;
    $url = "http://localhost:5000/Sincronizacion/listaproductosservicios?token={$env->get('token')}";
    $data = [
        "codigoAmbiente" => 2,
        "codigoPuntoVenta" => 0,
        "codigoPuntoVentaSpecified" => true,
        "codigoSucursal" => 0,
        "codigoSistema" => $env->get('codsys'),
        "cuis" => $env->get('cuis'),
        "nit" => $env->get('nit')
    ];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);
    $response = curl_exec($ch);
    if(curl_errno($ch)) {
        curl_close($ch);
        return null;
    } else {
        curl_close($ch);
        $jdata = json_decode($response, true);
        return $jdata;
    }
}

?>