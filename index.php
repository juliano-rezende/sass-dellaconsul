<?php

require_once __DIR__ . "/vendor/autoload.php";

ini_set('session.gc_maxlifetime', 3600);

use CoffeeCode\Router\Router;
$router = new Router(URL_BASE);


$router->group(null)->namespace("App\Http\Controllers\Site");
$router->get("/", "HomeController:index", "home.index");
$router->get("/contatos", "ContactController:index", "contact.index");
$router->get("/clientes", "MemberAreaController:index", "member.area.index");
$router->get("/area-segura", "IntranetController:index", "intranet.index");
$router->get("/trabalhe-conosco", "CareersController:index", "careers.index");


$router->group('dashboard')->namespace("App\Http\Controllers\Dashboard");
$router->get("/", "DashboardController:index", "dashboard.index");
$router->get("/formularios", "FormController:index", "form.index");
$router->get("/sliders", "SliderController:index", "slider.index");
$router->get("/curriculos", "CurriculumController:index", "curriculum.index");
$router->get("/arquivos-condominio", "ArquivosCondominiumController:index", "curriculum.index");
$router->get("/usuarios", "UsersController:index", "user.index");
$router->get("/configuracoes", "ConfigsController:index", "user.index");


/*
 * ERROS
 */
$router->group("error")->namespace("App\Helpers");
$router->get("/{errorCode}", "Errors:run");

$router->dispatch();

if ($router->error()) {
    $router->redirect("/error/{$router->error()}");
}