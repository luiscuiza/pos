<?php

$max_inactivity = 3600;
$session_regeneration = 1800;

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

if (!isset($_SESSION['created'])) {
    $_SESSION['created'] = time();
} elseif (time() - $_SESSION['created'] > $session_regeneration) {
    session_regenerate_id(true);
    $_SESSION['created'] = time();
}

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $max_inactivity) {
    session_unset();
    session_destroy();
    setcookie(session_name(), '', time() - $max_inactivity , '/');
    header("Location: /");
    exit();
} else {
    $_SESSION['last_activity'] = time();
}
