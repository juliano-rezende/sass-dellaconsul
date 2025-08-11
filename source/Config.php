<?php

date_default_timezone_set('America/Sao_Paulo');


/** CONFIGURAÇÕES PADRÃO DO SISTEMA*/
const CONFIG_SYSTEM = [
    "nameSysten"   => "Dellaconsul",
    "languageBase" => "pt-br",
    "version"      => "1.0",
    "prefix"        => "del",
    "developed"    => "GUNA Tecnologia",
];

/** URL BASE */
const URL_BASE = 'http://localhost:31000';

/** URL BASE */
const THEME_SITE = "themes/site/default";
const THEME_DASHBOARD = "themes/dashboard/default";

/** FAVICON ICO */
const FAVICON_ICO = "favicon.ico";

function urlBase(string $uri = null): string
{
    if ($uri) {
        return URL_BASE . "/{$uri}";
    }
    return URL_BASE;
}


