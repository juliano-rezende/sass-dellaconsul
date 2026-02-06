<?php

require_once __DIR__ . "/vendor/autoload.php";

// Configura sessão ANTES de iniciar
ini_set('session.gc_maxlifetime', 3600);
session_start();

use CoffeeCode\Router\Router;
use App\Http\Middlewares\AuthMiddleware;

$router = new Router(URL_BASE);

// Rotas públicas do site
$router->group(null)->namespace("App\Http\Controllers\Site");
$router->get("/", "HomeController:index", "home.index");
$router->get("/contatos", "ContactController:index", "contact.index");
$router->get("/clientes", "MemberAreaController:index", "member.area.index");
$router->get("/trabalhe-conosco", "CareersController:index", "careers.index");

// Rotas de autenticação
$router->group(null)->namespace("App\Http\Controllers");
$router->post("/auth/login", "AuthController:login", "auth.login");
$router->get("/auth/logout", "AuthController:logout", "auth.logout");

// Rotas protegidas do dashboard (requer autenticação)
$router->group('dashboard')->namespace("App\Http\Controllers\Dashboard");

// Aplica middleware de autenticação para rotas /dashboard
$authMiddleware = new AuthMiddleware();
if (strpos($_SERVER['REQUEST_URI'], '/dashboard') !== false) {
    if (!$authMiddleware->handle()) {
        exit; // Middleware já fez redirect/erro
    }
}

$router->get("/", "DashboardController:index", "dashboard.index");
$router->get("/sliders", "SliderController:index", "slider.index");
$router->get("/curriculos", "CurriculumController:index", "curriculum.index");

// Rotas de usuários (CRUD)
$router->get("/usuarios", "UsersController:index", "users.index");
$router->post("/usuarios/create", "UsersController:create", "users.create");
$router->post("/usuarios/update", "UsersController:update", "users.update");
$router->post("/usuarios/delete", "UsersController:delete", "users.delete");
$router->post("/usuarios/reset-password", "UsersController:resetPassword", "users.reset");

$router->get("/configuracoes", "ConfigsController:index", "configs.index");


/*
 * ERROS
 */
$router->group("error")->namespace("App\Helpers");
$router->get("/{errorCode}", "Errors:run");

$router->dispatch();

if ($router->error()) {
    $router->redirect("/error/{$router->error()}");
}