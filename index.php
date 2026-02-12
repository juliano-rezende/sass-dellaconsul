<?php

/**
 * Arquivo de entrada da aplicação
 * Responsável por inicializar o router e carregar as rotas
 */

require_once __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;

// Inicializa o router
$router = new Router(URL_BASE);

// Carrega os arquivos de rotas
$routeFiles = [
    __DIR__ . '/routes/web.php',      // Rotas públicas
    __DIR__ . '/routes/auth.php',     // Rotas de autenticação
    __DIR__ . '/routes/dashboard.php', // Rotas protegidas do dashboard
    __DIR__ . '/routes/errors.php',   // Rotas de erro
];

foreach ($routeFiles as $file) {
    if (file_exists($file)) {
        $routeLoader = require $file;
        if (is_callable($routeLoader)) {
            $routeLoader($router);
        }
    }
}

// Despacha a rota
$router->dispatch();

// Tratamento de erros
if ($router->error()) {
    $router->redirect("/error/{$router->error()}");
}