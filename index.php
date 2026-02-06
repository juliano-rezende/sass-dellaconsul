<?php

require_once __DIR__ . "/vendor/autoload.php";

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
$router->get("/area-segura", "IntranetController:index", "intranet.index");
$router->get("/trabalhe-conosco", "CareersController:index", "careers.index");

// Rotas de autenticação
$router->group(null)->namespace("App\Http\Controllers");
$router->post("/auth/login", "AuthController:login", "auth.login");
$router->get("/auth/logout", "AuthController:logout", "auth.logout");

// Rotas protegidas do dashboard (com middleware nativo do Router)
$router->group('dashboard', AuthMiddleware::class)->namespace("App\Http\Controllers\Dashboard");
$router->get("/", "DashboardController:index", "dashboard.index");
$router->get("/sliders", "SliderController:index", "slider.index");
$router->get("/curriculos", "CurriculumController:index", "curriculum.index");
$router->get("/usuarios", "UsersController:index", "users.index");
$router->post("/usuarios/create", "UsersController:create", "users.create");
$router->post("/usuarios/update", "UsersController:update", "users.update");
$router->post("/usuarios/delete", "UsersController:delete", "users.delete");
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