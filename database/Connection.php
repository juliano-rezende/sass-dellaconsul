<?php

namespace Database;

use PDO;
use PDOException;

/**
 * Classe de Conexão com Banco de Dados (Singleton)
 */
class Connection
{
    private static ?PDO $instance = null;

    /**
     * Obtém instância única da conexão PDO
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                $dsn = sprintf(
                    "mysql:host=%s;port=%s;dbname=%s;charset=%s",
                    DB_HOST,
                    DB_PORT,
                    DB_DATABASE,
                    DB_CHARSET
                );

                self::$instance = new PDO($dsn, DB_USERNAME, DB_PASSWORD, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET . " COLLATE " . DB_COLLATION
                ]);

            } catch (PDOException $e) {
                throw new PDOException(
                    "Erro ao conectar com o banco de dados: " . $e->getMessage(),
                    (int) $e->getCode()
                );
            }
        }

        return self::$instance;
    }

    /**
     * Obtém conexão para Doctrine DBAL
     */
    public static function getDbalConnection(): \Doctrine\DBAL\Connection
    {
        $connectionParams = [
            'dbname' => DB_DATABASE,
            'user' => DB_USERNAME,
            'password' => DB_PASSWORD,
            'host' => DB_HOST,
            'port' => DB_PORT,
            'driver' => 'pdo_mysql',
            'charset' => DB_CHARSET,
        ];

        return \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
    }

    /**
     * Testa a conexão
     */
    public static function test(): bool
    {
        try {
            $pdo = self::getInstance();
            $pdo->query('SELECT 1');
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Previne clonagem
     */
    private function __clone() {}

    /**
     * Previne unserialize
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }
}
