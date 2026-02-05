<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260205153347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Cria tabela career_areas e popula com áreas iniciais';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE career_areas (
                id BIGINT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                description TEXT NULL,
                status ENUM('active', 'inactive') DEFAULT 'active',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_status (status)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        // Seeds - Áreas iniciais
        $this->addSql("INSERT INTO career_areas (name, description, status) VALUES 
            ('Administrativa', 'Área administrativa e gestão de condomínios', 'active'),
            ('Manutenção Predial', 'Manutenção, reparos e zeladoria', 'active'),
            ('Limpeza', 'Serviços de limpeza e conservação', 'active')
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS career_areas');
    }
}
