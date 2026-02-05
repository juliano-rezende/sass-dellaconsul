<?php

namespace App\Http\Controllers\Dashboard;

use League\Plates\Engine;

class DashboardController
{

    private Engine $view;


    public function __construct($router)
    {
        $this->view = new Engine(dirname(__DIR__, 4) . "/".THEME_DASHBOARD, "php");
        $this->view->addData(["router" => $router]);
    }

    public function index($router): void
    {
        echo $this->view->render("pages/dashboard", ["title" => $router]);
    }


}