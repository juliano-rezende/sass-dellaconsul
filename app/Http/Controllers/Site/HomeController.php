<?php

namespace App\Http\Controllers\Site;

use App\Models\Slider;
use League\Plates\Engine;

class homeController
{
    
    private Engine $view;
    
    
    public function __construct($router)
    {
        $this->view = new Engine(dirname(__DIR__, 4) . "/".THEME_SITE, "php");
        $this->view->addData(["router" => $router]);
    }
    
    public function index($router): void
    {
        // Busca sliders ativos do banco
        try {
            $sliders = Slider::getActiveOrdered();
            $slidersArray = array_map(fn($slider) => $slider->toArray(), $sliders);
        } catch (\Exception $e) {
            // Se houver erro, usa array vazio
            $slidersArray = [];
        }

        // Busca depoimentos aprovados do banco
        try {
            $testimonials = \App\Models\Testimonial::getApprovedOrdered(10);
            $testimonialsArray = array_map(fn($testimonial) => $testimonial->toArray(), $testimonials);
        } catch (\Exception $e) {
            // Se houver erro, usa array vazio
            $testimonialsArray = [];
        }

        echo $this->view->render("pages/home", [
            "title" => $router,
            "sliders" => $slidersArray,
            "testimonials" => $testimonialsArray
        ]);
    }

    
}