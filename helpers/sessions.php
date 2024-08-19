<?php

$max_inactivity = 1800;

session_set_cookie_params([
    'lifetime' => 7200,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax'
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $max_inactivity) {
    session_unset();
    session_destroy();
    header("Location: /");
    exit();
} else {
    $_SESSION['last_activity'] = time();
}
