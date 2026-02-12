<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration para criar tabela de depoimentos/testemunhos
 */
final class Version20260211150000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Cria tabela testimonials para gerenciar depoimentos de clientes';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE testimonials (
                id BIGINT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL COMMENT 'Nome do cliente',
                email VARCHAR(255) NOT NULL COMMENT 'Email do cliente',
                company_role VARCHAR(255) NULL COMMENT 'Cargo/Empresa (ex: Síndico - Edifício Central)',
                message TEXT NOT NULL COMMENT 'Conteúdo do depoimento',
                rating TINYINT(1) NOT NULL DEFAULT 5 COMMENT 'Avaliação de 1 a 5 estrelas',
                status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending' COMMENT 'Status do depoimento',
                approved_by BIGINT NULL COMMENT 'ID do usuário que aprovou',
                approved_at TIMESTAMP NULL COMMENT 'Data de aprovação',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP NULL COMMENT 'Soft delete timestamp',
                INDEX idx_status (status),
                INDEX idx_created_at (created_at),
                INDEX idx_deleted_at (deleted_at),
                INDEX idx_rating (rating),
                FOREIGN KEY (approved_by) REFERENCES users(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS testimonials');
    }
}
