<?php

/**
 * Rotas de Tratamento de Erros
 * Responsável por exibir páginas de erro
 */

use CoffeeCode\Router\Router;

return function (Router $router) {
    $router->group("error")->namespace("App\Helpers");
    $router->get("/{errorCode}", "Errors:run");
};
