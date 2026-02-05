<?php

declare(strict_types=1);

namespace Source\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260205153348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Cria tabela curriculum para gerenciamento de currículos';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE curriculum (
                id BIGINT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                phone VARCHAR(20) NOT NULL,
                career_area_id BIGINT NOT NULL,
                position VARCHAR(255) NOT NULL COMMENT 'Cargo pretendido',
                experience_years INT NULL COMMENT 'Anos de experiência',
                file_path VARCHAR(255) NOT NULL COMMENT 'Caminho do arquivo do currículo',
                message TEXT NULL COMMENT 'Mensagem do candidato',
                status ENUM('novo', 'analise', 'aprovado', 'reprovado', 'entrevista') DEFAULT 'novo',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_email (email),
                INDEX idx_status (status),
                INDEX idx_career_area (career_area_id),
                FOREIGN KEY (career_area_id) REFERENCES career_areas(id) ON DELETE RESTRICT
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS curriculum');
    }
}
