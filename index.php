<?php

require_once 'helpers/log.php';
require_once 'helpers/env.php';
require_once 'helpers/sessions.php';

require_once 'models/Connection.php';
require_once 'models/UserModel.php';
require_once 'models/CustomerModel.php';
require_once 'models/ProductModel.php';
require_once 'models/SaleModel.php';
require_once 'models/CufdModel.php';
require_once 'models/LeyendaModel.php';
require_once 'models/CartModel.php';

require_once 'controllers/TemplateController.php';
require_once 'controllers/ErrorController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/DashboardController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/CustomerController.php';
require_once 'controllers/ProductController.php';
require_once 'controllers/SaleController.php';
require_once 'controllers/CufdController.php';
require_once 'controllers/LeyendaController.php';
require_once 'controllers/SIATController.php';
require_once 'controllers/CartController.php';

global $env;
$env = new Environment('.env');
$URI = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$METHOD = $_SERVER['REQUEST_METHOD'];

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

if (isset($_SESSION['user_id'])) {
    $routes = [
        'GET' => [
            '/'                  => [DashboardController::class, 'render'],
            '/dashboard'         => [DashboardController::class, 'render'],

            '/logout'            => [AuthController::class, 'logout'],

            '/users'             => [UserController::class, 'renderUsers'],
            '/users/new'         => [UserController::class, 'renderNewForm'],
            '/users/edit'        => [UserController::class, 'renderEditForm'],

            '/customers'         => [CustomerController::class, 'renderCustomers'],
            '/customers/new'     => [CustomerController::class, 'renderNewForm'],
            '/customers/edit'    => [CustomerController::class, 'renderEditForm'],

            '/products'          => [ProductController::class, 'renderProducts'],
            '/products/new'      => [ProductController::class, 'renderNewForm'],
            '/products/edit'     => [ProductController::class, 'renderEditForm'],
            '/products/view'     => [ProductController::class, 'renderViewForm'],
            '/products/catalog'  => [ProductController::class, 'renderCatalog'],
            '/products/umedsin'  => [ProductController::class, 'renderUMSin'],

            '/sales'             => [SaleController::class, 'renderSales'],
            '/sales/emit'        => [SaleController::class, 'renderEmit'],
            '/sales/view'        => [SaleController::class, 'renderViewForm'],
            '/sales/print'       => [SaleController::class, 'renderPrint'],

            '/cufd/info'         => [CufdController::class, 'info'],

            '/leyenda'           => [LeyendaController::class, 'random'],

            '/siat/medidas'      => [SIATController::class, 'unidadMedidas'],
            '/siat/catalog'      => [SIATController::class, 'sinCatalog'],
            '/siat/connected'    => [SIATController::class, 'isConnected'],
            '/siat/cufd/valid'   => [SIATController::class, 'isValidCufd'],
            '/siat/cufd/renew'   => [SIATController::class, 'renewCufd'],
        ],
        'POST' => [
            '/users/add'         => [UserController::class, 'createUser'],
            '/users/remove'      => [UserController::class, 'removeUser'],
            '/users/edit'        => [UserController::class, 'editUser'],
            
            '/customers/add'     => [CustomerController::class, 'createCustomer'],
            '/customers/edit'    => [CustomerController::class, 'editCustomer'],
            '/customers/info'    => [CustomerController::class, 'infoCustomer'],
            '/customers/remove'  => [CustomerController::class, 'removeCustomer'],

            '/products/add'      => [ProductController::class, 'createProduct'],
            '/products/edit'     => [ProductController::class, 'editProduct'],
            '/products/info'     => [ProductController::class, 'infoProduct'],
            '/products/remove'   => [ProductController::class, 'removeProduct'],

            '/cufd/save'         => [CufdController::class, 'save'],

            '/cart/add'          => [CartController::class, 'addProduct'],
            '/cart/clear'        => [CartController::class, 'clearCart'],
            '/cart/remove'       => [CartController::class, 'removeProduct'],

            '/sales/emit'        => [SaleController::class, 'emitSale'],
            '/sales/remove'      => [SaleController::class, 'removeSale'],
            '/sales/data'        => [SaleController::class, 'data'],
        ]
    ]; 

    if (!resolveRoute($URI, $METHOD, $routes)) {
        ErrorController::render(404, 'Página no encontrada.');
    }
} else {
    $routes = [
        'GET' => [
            '/'      => [AuthController::class, 'renderLoging']
        ],
        'POST' => [
            '/login' => [AuthController::class, 'login']
        ],
    ];

    if (!resolveRoute($URI, $METHOD, $routes)) {
        ErrorController::render(404, 'Página no encontrada.');
    }
}