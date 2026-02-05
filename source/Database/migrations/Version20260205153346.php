<?php

declare(strict_types=1);

namespace Source\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260205153346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Cria tabela sliders para carrossel da página inicial';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE sliders (
                id BIGINT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(20) NOT NULL COMMENT 'Título do slide (max 20 chars)',
                subtitle VARCHAR(50) NULL COMMENT 'Subtítulo do slide (max 50 chars)',
                description TEXT NULL COMMENT 'Descrição interna para identificação',
                image VARCHAR(255) NOT NULL COMMENT 'Caminho da imagem',
                button_text VARCHAR(100) NULL COMMENT 'Texto do botão',
                button_link VARCHAR(255) NULL COMMENT 'Link do botão',
                order_position INT DEFAULT 0 COMMENT 'Ordem de exibição',
                status ENUM('active', 'inactive') DEFAULT 'active',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_status (status),
                INDEX idx_order (order_position)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS sliders');
    }
}
