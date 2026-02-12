<?php

/**
 * Rotas de Autenticação
 * Responsável por login e logout
 */

use CoffeeCode\Router\Router;

return function (Router $router) {
    $router->group(null)->namespace("App\Http\Controllers");
    
    // Login
    $router->post("/auth/login", "AuthController:login", "auth.login");
    
    // Logout
    $router->get("/auth/logout", "AuthController:logout", "auth.logout");
};
