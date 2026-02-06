<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260206020358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adiciona coluna deleted_at para soft deletes nas tabelas users, sliders e curriculum';
    }

    public function up(Schema $schema): void
    {
        // Adiciona deleted_at na tabela users
        $this->addSql("
            ALTER TABLE users 
            ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL AFTER updated_at,
            ADD INDEX idx_deleted_at (deleted_at)
        ");
        
        // Adiciona deleted_at na tabela sliders
        $this->addSql("
            ALTER TABLE sliders 
            ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL AFTER updated_at,
            ADD INDEX idx_deleted_at (deleted_at)
        ");
        
        // Adiciona deleted_at na tabela curriculum
        $this->addSql("
            ALTER TABLE curriculum 
            ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL AFTER updated_at,
            ADD INDEX idx_deleted_at (deleted_at)
        ");
    }

    public function down(Schema $schema): void
    {
        // Remove deleted_at da tabela users
        $this->addSql("
            ALTER TABLE users 
            DROP INDEX idx_deleted_at,
            DROP COLUMN deleted_at
        ");
        
        // Remove deleted_at da tabela sliders
        $this->addSql("
            ALTER TABLE sliders 
            DROP INDEX idx_deleted_at,
            DROP COLUMN deleted_at
        ");
        
        // Remove deleted_at da tabela curriculum
        $this->addSql("
            ALTER TABLE curriculum 
            DROP INDEX idx_deleted_at,
            DROP COLUMN deleted_at
        ");
    }
}
