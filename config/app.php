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

/** TEMAS */
const THEME_SITE = "themes/site/default";
const THEME_DASHBOARD = "themes/dashboard/default";

/** FAVICON ICO */
const FAVICON_ICO = "favicon.ico";

/** CONFIGURAÇÕES DE BANCO DE DADOS */
define('DB_HOST', $_ENV['DB_HOST'] ?? 'mariadb');
define('DB_PORT', $_ENV['DB_PORT'] ?? '3306');
define('DB_DATABASE', $_ENV['DB_DATABASE'] ?? 'dellaconsul_db');
define('DB_USERNAME', $_ENV['DB_USERNAME'] ?? 'dellaconsul_user');
define('DB_PASSWORD', $_ENV['DB_PASSWORD'] ?? '');
define('DB_CHARSET', $_ENV['DB_CHARSET'] ?? 'utf8mb4');
define('DB_COLLATION', $_ENV['DB_COLLATION'] ?? 'utf8mb4_unicode_ci');

/** CONFIGURAÇÕES EVOLUTION API (WhatsApp) */
define('EVOLUTION_API_URL', $_ENV['EVOLUTION_API_URL'] ?? '');
define('EVOLUTION_API_KEY', $_ENV['EVOLUTION_API_KEY'] ?? '');
define('EVOLUTION_WEBHOOK_URL', $_ENV['EVOLUTION_WEBHOOK_URL'] ?? '');

function urlBase(?string $uri = null): string
{
    if ($uri) {
        return URL_BASE . "/{$uri}";
    }
    return URL_BASE;
}

/**
 * Helper para obter configuração do .env
 */
function env(string $key, $default = null)
{
    return $_ENV[$key] ?? $default;
}


