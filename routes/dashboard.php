<?php

/**
 * Rotas do Dashboard (Protegidas)
 * Todas as rotas aqui requerem SessionMiddleware + AuthMiddleware
 * 
 * Ordem de execução:
 * 1. SessionMiddleware - Gerencia sessão com segurança
 * 2. AuthMiddleware - Verifica autenticação
 */

use CoffeeCode\Router\Router;
use App\Http\Middlewares\SessionMiddleware;
use App\Http\Middlewares\AuthMiddleware;

return function (Router $router) {
    // SessionMiddleware gerencia a sessão automaticamente
    // Não é mais necessário chamar session_start() manualmente
    
    // Aplica SessionMiddleware + AuthMiddleware em todas as rotas do dashboard
    $sessionMiddleware = new SessionMiddleware();
    $sessionMiddleware->handle($router);
    
    $router->group('dashboard', AuthMiddleware::class)->namespace("App\Http\Controllers\Dashboard");
    
    // Dashboard principal
    $router->get("/", "DashboardController:index", "dashboard.index");
    
    // Gerenciamento de Sliders
    $router->get("/sliders", "SliderController:index", "slider.index");
    $router->post("/sliders/create", "SliderController:create", "slider.create");
    $router->post("/sliders/update", "SliderController:update", "slider.update");
    $router->post("/sliders/get", "SliderController:get", "slider.get");
    $router->post("/sliders/delete", "SliderController:delete", "slider.delete");
    $router->post("/sliders/reorder", "SliderController:reorder", "slider.reorder");
    $router->post("/sliders/toggle-status", "SliderController:toggleStatus", "slider.toggleStatus");
    
    // Gerenciamento de Currículos
    $router->get("/curriculos", "CurriculumController:index", "curriculum.index");
    $router->get("/curriculos/get/{id}", "CurriculumController:get", "curriculum.get");
    $router->post("/curriculos/update", "CurriculumController:update", "curriculum.update");
    $router->post("/curriculos/delete", "CurriculumController:delete", "curriculum.delete");
    
    // Gerenciamento de Usuários
    $router->get("/usuarios", "UsersController:index", "users.index");
    $router->post("/usuarios/get", "UsersController:get", "users.get");
    $router->post("/usuarios/create", "UsersController:create", "users.create");
    $router->post("/usuarios/update", "UsersController:update", "users.update");
    $router->post("/usuarios/delete", "UsersController:delete", "users.delete");
    
    // Configurações
    $router->get("/configuracoes", "ConfigsController:index", "configs.index");
    $router->post("/configuracoes/save", "ConfigsController:save", "configs.save");
    
    // Gerenciamento de Depoimentos
    $router->get("/depoimentos", "TestimonialController:index", "testimonials.index");
    $router->post("/depoimentos/get", "TestimonialController:get", "testimonials.get");
    $router->post("/depoimentos/approve", "TestimonialController:approve", "testimonials.approve");
    $router->post("/depoimentos/reject", "TestimonialController:reject", "testimonials.reject");
    $router->post("/depoimentos/delete", "TestimonialController:delete", "testimonials.delete");
};
