<?php

namespace source\App\Http\Controllers\Site;

use League\Plates\Engine;

class homeController
{
    
    private Engine $view;
    
    
    public function __construct($router)
    {
        $this->view = new Engine(dirname(__DIR__, 5) . "/".THEME_SITE, "php");
        $this->view->addData(["router" => $router]);
    }
    
    public function index($router): void
    {
        echo $this->view->render("pages/home", ["title" => $router]);
    }

    
}