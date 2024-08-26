<?php

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

// Ejemplo de uso
echo uuidImage('imange.jpg');
?>