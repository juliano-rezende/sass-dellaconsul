<?php

namespace App\Http\Controllers\Dashboard;

use League\Plates\Engine;

class FormController
{

    private Engine $view;


    public function __construct($router)
    {
        $this->view = new Engine(dirname(__DIR__, 5) . "/".THEME_DASHBOARD, "php");
        $this->view->addData(["router" => $router]);
    }

    public function index($router): void
    {
        echo $this->view->render("pages/forms", ["title" => $router]);
    }


}