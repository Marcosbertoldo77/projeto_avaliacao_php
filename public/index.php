<?php

session_start();

spl_autoload_register(function ($class) {

    $directories = [
        __DIR__ . '/../app/core/',
        __DIR__ . '/../app/controllers/',
        __DIR__ . '/../app/models/',
        __DIR__ . '/../app/helpers/'
    ];

    foreach ($directories as $directory) {

        $file = $directory . $class . '.php';

        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$router = new Router();

// Dashboard as home (requires authentication)
$router->get('/', 'ServiceController', 'index');

// Auth
$router->get('/login', 'AuthController', 'showLogin');
$router->post('/login', 'AuthController', 'login');
$router->get('/logout', 'AuthController', 'logout');

// Services
$router->get('/service/create', 'ServiceController', 'create');
$router->get('/service/edit', 'ServiceController', 'edit');
$router->post('/service/store', 'ServiceController', 'store');
$router->post('/service/update', 'ServiceController', 'update');
$router->post('/service/delete', 'ServiceController', 'delete');
$router->post('/service/finalize', 'ServiceController', 'finalize');

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$basePath = '/public';

if (str_starts_with($path, $basePath)) {
    $path = substr($path, strlen($basePath));
}

$path = $path ?: '/';

$router->dispatch($path, $_SERVER['REQUEST_METHOD']);