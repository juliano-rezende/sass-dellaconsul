<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Adiciona campos de rastreamento de consentimento LGPD na tabela testimonials
 */
final class Version20260211160000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adiciona campos de rastreamento de consentimento LGPD (consent_given, consent_ip, consent_date, privacy_policy_version)';
    }

    public function up(Schema $schema): void
    {
        // Adiciona campos de consentimento LGPD
        $this->addSql("
            ALTER TABLE testimonials 
            ADD COLUMN consent_given TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Se o usuário deu consentimento' AFTER status,
            ADD COLUMN consent_ip VARCHAR(45) NULL COMMENT 'IP de origem do consentimento' AFTER consent_given,
            ADD COLUMN consent_date TIMESTAMP NULL COMMENT 'Data/hora do consentimento' AFTER consent_ip,
            ADD COLUMN privacy_policy_version VARCHAR(20) DEFAULT '1.0' COMMENT 'Versão da política aceita' AFTER consent_date
        ");
        
        // Adiciona índice para consultas de auditoria
        $this->addSql("
            ALTER TABLE testimonials 
            ADD INDEX idx_consent_date (consent_date)
        ");
    }

    public function down(Schema $schema): void
    {
        // Remove índice
        $this->addSql("
            ALTER TABLE testimonials 
            DROP INDEX idx_consent_date
        ");
        
        // Remove campos de consentimento
        $this->addSql("
            ALTER TABLE testimonials 
            DROP COLUMN consent_given,
            DROP COLUMN consent_ip,
            DROP COLUMN consent_date,
            DROP COLUMN privacy_policy_version
        ");
    }
}
