<?php

namespace App\Http\Controllers\Site;

use League\Plates\Engine;

class LegalController
{
    private Engine $view;
    
    public function __construct($router)
    {
        $this->view = new Engine(dirname(__DIR__, 4) . "/".THEME_SITE, "php");
        $this->view->addData(["router" => $router]);
    }
    
    /**
     * Exibe a Política de Privacidade
     */
    public function privacyPolicy($router): void
    {
        echo $this->view->render("pages/privacy-policy", [
            "title" => "Política de Privacidade - Della Consul"
        ]);
    }
    
    /**
     * Exibe os Termos de Uso
     */
    public function termsOfUse($router): void
    {
        echo $this->view->render("pages/terms-of-use", [
            "title" => "Termos de Uso - Della Consul"
        ]);
    }
}
