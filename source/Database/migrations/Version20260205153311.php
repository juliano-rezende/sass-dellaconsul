<?php

declare(strict_types=1);

namespace Source\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260205153311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Cria tabela users com roles e permissões';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE users (
                id BIGINT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                role ENUM('admin', 'manager', 'operator', 'viewer') DEFAULT 'viewer',
                department ENUM('administrativo', 'financeiro', 'manutencao', 'seguranca', 'ti') DEFAULT 'administrativo',
                status ENUM('active', 'inactive', 'pending') DEFAULT 'pending',
                phone VARCHAR(20) NULL,
                avatar VARCHAR(255) NULL,
                last_login DATETIME NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_email (email),
                INDEX idx_status (status),
                INDEX idx_role (role)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        // Cria usuário admin padrão (senha: admin123)
        $this->addSql("
            INSERT INTO users (name, email, password, role, department, status)
            VALUES (
                'Administrador',
                'admin@dellaconsul.com',
                '" . password_hash('admin123', PASSWORD_DEFAULT) . "',
                'admin',
                'ti',
                'active'
            )
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS users');
    }
}
