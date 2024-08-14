<?php

require_once 'models/Connection.php';
require_once 'models/UserModel.php';

require_once 'controllers/TemplateController.php';
require_once 'controllers/DashboardController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/ErrorController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function resolveRoute(string $uri, string $method, array $routes) {
    if (isset($routes[$method])) {
        foreach ($routes[$method] as $route => $handler) {
            if ($uri === $route) {
                call_user_func($handler);
                return true;
            }
        }
    }
    return false;
}

$URI = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$METHOD = $_SERVER['REQUEST_METHOD'];

if (isset($_SESSION['user_id'])) {
    $routes = [
        'GET' => [
            '/'             => [DashboardController::class, 'render'],
            '/logout'       => [UserController::class, 'logout'],
            '/dashboard'    => [DashboardController::class, 'render'],

            '/users'        => [UserController::class, 'renderUsers'],
            '/users/new'    => [UserController::class, 'renderNewForm'],
            '/users/edit'   => [UserController::class, 'renderEditForm'],
        ],
        'POST' => [
            '/users/add'    => [UserController::class, 'createUser'],
            '/users/remove' => [UserController::class, 'removeUser'],
            '/users/edit'   => [UserController::class, 'editUser'],
        ]
    ]; 

    if (!resolveRoute($URI, $METHOD, $routes)) {
        ErrorController::render(404, 'Página no encontrada.');
    }
} else {
    $routes = [
        'GET' => [
            '/'      => [UserController::class, 'renderLoging']
        ],
        'POST' => [
            '/login' => [UserController::class, 'login']
        ],
    ];

    if (!resolveRoute($URI, $METHOD, $routes)) {
        ErrorController::render(404, 'Página no encontrada.');
    }
}