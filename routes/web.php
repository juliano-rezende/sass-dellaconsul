<?php

/**
 * Rotas Públicas do Site
 * Estas rotas não requerem autenticação
 */

use CoffeeCode\Router\Router;

return function (Router $router) {
    $router->group(null)->namespace("App\Http\Controllers\Site");
    
    // Página inicial
    $router->get("/", "HomeController:index", "home.index");
    
    // Contatos
    $router->get("/contatos", "ContactController:index", "contact.index");
    
    // Área de membros
    $router->get("/clientes", "MemberAreaController:index", "member.area.index");
    
    // Login/Intranet
    $router->get("/login", "IntranetController:index", "login.index");
    $router->get("/area-segura", "IntranetController:index", "login.index"); // Alias para compatibilidade
    
    // Trabalhe Conosco
    $router->get("/trabalhe-conosco", "CareersController:index", "careers.index");
    $router->post("/trabalhe-conosco", "CareersController:submit", "careers.submit");
    
    // Depoimentos
    $router->post("/depoimentos/enviar", "TestimonialController:submit", "testimonials.submit");
    
    // Páginas legais
    $router->get("/politica-privacidade", "LegalController:privacyPolicy", "legal.privacy");
    $router->get("/termos-uso", "LegalController:termsOfUse", "legal.terms");
};
