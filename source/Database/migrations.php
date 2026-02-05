<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\Configuration\Connection\ExistingConnection;
use Doctrine\Migrations\DependencyFactory;

// Carrega variáveis de ambiente
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->safeLoad();

// Carrega configurações
require_once __DIR__ . '/../Config.php';

// Cria conexão DBAL
$connectionParams = [
    'dbname' => DB_DATABASE,
    'user' => DB_USERNAME,
    'password' => DB_PASSWORD,
    'host' => DB_HOST,
    'port' => DB_PORT,
    'driver' => 'pdo_mysql',
    'charset' => DB_CHARSET,
];

$connection = DriverManager::getConnection($connectionParams);

// Configuração das migrations
$config = new \Doctrine\Migrations\Configuration\Migration\ConfigurationArray([
    'table_storage' => [
        'table_name' => 'migrations',
        'version_column_name' => 'version',
        'version_column_length' => 191,
        'executed_at_column_name' => 'executed_at',
        'execution_time_column_name' => 'execution_time',
    ],
    'migrations_paths' => [
        'Source\Database\Migrations' => __DIR__ . '/migrations',
    ],
    'all_or_nothing' => true,
    'transactional' => true,
    'check_database_platform' => true,
    'organize_migrations' => 'none',
]);

return DependencyFactory::fromConnection(
    $config,
    new ExistingConnection($connection)
);
