<?php

namespace App\Http\Controllers\Site;

use League\Plates\Engine;

class intranetController
{
    
    private Engine $view;
    
    
    public function __construct($router)
    {
        
        $this->view = new Engine(dirname(__DIR__, 5) . "/".THEME_SITE, "php");
        $this->view->addData(["router" => $router]);
    }
    
    public function index($router): void
    {
        echo $this->view->render("pages/intranet", ["title" => $router]);
    }
}