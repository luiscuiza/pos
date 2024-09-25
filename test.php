<?php

/*
require_once 'models/Connection.php';
require_once 'models/UserModel.php';

UserModel::createUser('admin', 'admin', 'Administrador');

*/


$now = new DateTime("now", new DateTimeZone("UTC"));
$milliseconds = round(microtime(true) * 1000) % 1000;
$formattedDate = $now->format("Y-m-d\TH:i:s") . '.' . str_pad($milliseconds, 3, '0', STR_PAD_LEFT) . 'Z';



var_dump(
    $formattedDate
);