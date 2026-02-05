<?php

declare(strict_types=1);

namespace Source\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260205153349 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Cria tabela configs (EAV) e popula com configurações iniciais';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE configs (
                id BIGINT AUTO_INCREMENT PRIMARY KEY,
                config_group VARCHAR(50) NOT NULL COMMENT 'Grupo: general, appearance, security, notifications, backup',
                config_key VARCHAR(100) NOT NULL,
                config_value TEXT NULL,
                config_type ENUM('string', 'integer', 'boolean', 'json', 'color', 'select') DEFAULT 'string',
                description VARCHAR(255) NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                UNIQUE INDEX idx_unique_config (config_group, config_key),
                INDEX idx_group (config_group)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        // Seeds - Configurações Gerais
        $this->addSql("INSERT INTO configs (config_group, config_key, config_value, config_type, description) VALUES 
            ('general', 'company_name', 'Della Consul', 'string', 'Nome da empresa'),
            ('general', 'company_email', 'contato@dellaconsul.com', 'string', 'E-mail da empresa'),
            ('general', 'company_phone', '(11) 9999-9999', 'string', 'Telefone da empresa'),
            ('general', 'timezone', 'America/Sao_Paulo', 'select', 'Fuso horário'),
            ('general', 'language', 'pt-BR', 'select', 'Idioma do sistema'),
            ('general', 'date_format', 'dd/mm/yyyy', 'select', 'Formato de data')
        ");

        // Seeds - Aparência
        $this->addSql("INSERT INTO configs (config_group, config_key, config_value, config_type, description) VALUES 
            ('appearance', 'theme', 'light', 'select', 'Tema do sistema'),
            ('appearance', 'primary_color', '#2563eb', 'color', 'Cor primária'),
            ('appearance', 'sidebar_position', 'left', 'select', 'Posição da sidebar'),
            ('appearance', 'show_animations', '1', 'boolean', 'Mostrar animações')
        ");

        // Seeds - Segurança
        $this->addSql("INSERT INTO configs (config_group, config_key, config_value, config_type, description) VALUES 
            ('security', 'session_timeout', '30', 'integer', 'Timeout da sessão (minutos)'),
            ('security', 'max_login_attempts', '5', 'integer', 'Tentativas máximas de login'),
            ('security', 'password_min_length', '8', 'integer', 'Tamanho mínimo da senha'),
            ('security', 'require_uppercase', '1', 'boolean', 'Exigir letra maiúscula'),
            ('security', 'require_numbers', '1', 'boolean', 'Exigir números')
        ");

        // Seeds - Notificações
        $this->addSql("INSERT INTO configs (config_group, config_key, config_value, config_type, description) VALUES 
            ('notifications', 'email_new_user', '1', 'boolean', 'Email ao cadastrar usuário'),
            ('notifications', 'notification_sound', 'default', 'select', 'Som de notificação'),
            ('notifications', 'notification_position', 'top-right', 'select', 'Posição das notificações')
        ");

        // Seeds - Backup
        $this->addSql("INSERT INTO configs (config_group, config_key, config_value, config_type, description) VALUES 
            ('backup', 'backup_frequency', 'daily', 'select', 'Frequência de backup'),
            ('backup', 'backup_time', '02:00', 'string', 'Horário do backup'),
            ('backup', 'backup_retention', '30', 'integer', 'Dias de retenção'),
            ('backup', 'backup_database', '1', 'boolean', 'Fazer backup do banco')
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS configs');
    }
}
