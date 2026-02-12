<?php

namespace App\Models;

use Database\Connection;

/**
 * Config Model
 * Gerencia configurações do sistema usando padrão EAV (Entity-Attribute-Value)
 */
class Config
{
    /**
     * Busca todas as configurações agrupadas por config_group
     * 
     * @return array Array associativo [group => [key => value]]
     */
    public static function getAllGrouped(): array
    {
        $conn = Connection::getInstance();
        $stmt = $conn->prepare("
            SELECT config_group, config_key, config_value, config_type 
            FROM configs 
            ORDER BY config_group, config_key
        ");
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $grouped = [];
        foreach ($results as $row) {
            $group = $row['config_group'];
            $key = $row['config_key'];
            $value = self::castValue($row['config_value'], $row['config_type']);
            
            if (!isset($grouped[$group])) {
                $grouped[$group] = [];
            }
            $grouped[$group][$key] = $value;
        }
        
        return $grouped;
    }
    
    /**
     * Busca configurações de um grupo específico
     * 
     * @param string $group Nome do grupo (general, appearance, security, etc)
     * @return array Array associativo [key => value]
     */
    public static function getByGroup(string $group): array
    {
        $conn = Connection::getInstance();
        $stmt = $conn->prepare("
            SELECT config_key, config_value, config_type 
            FROM configs 
            WHERE config_group = :group
            ORDER BY config_key
        ");
        $stmt->execute(['group' => $group]);
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $configs = [];
        foreach ($results as $row) {
            $key = $row['config_key'];
            $value = self::castValue($row['config_value'], $row['config_type']);
            $configs[$key] = $value;
        }
        
        return $configs;
    }
    
    /**
     * Busca uma configuração específica
     * 
     * @param string $group Grupo da configuração
     * @param string $key Chave da configuração
     * @param mixed $default Valor padrão se não encontrado
     * @return mixed
     */
    public static function get(string $group, string $key, $default = null)
    {
        $conn = Connection::getInstance();
        $stmt = $conn->prepare("
            SELECT config_value, config_type 
            FROM configs 
            WHERE config_group = :group AND config_key = :key
            LIMIT 1
        ");
        $stmt->execute(['group' => $group, 'key' => $key]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if (!$result) {
            return $default;
        }
        
        return self::castValue($result['config_value'], $result['config_type']);
    }
    
    /**
     * Salva ou atualiza uma configuração
     * 
     * @param string $group Grupo da configuração
     * @param string $key Chave da configuração
     * @param mixed $value Valor a ser salvo
     * @return bool
     */
    public static function set(string $group, string $key, $value): bool
    {
        $conn = Connection::getInstance();
        
        // Converte boolean para string
        if (is_bool($value)) {
            $value = $value ? '1' : '0';
        }
        
        $stmt = $conn->prepare("
            INSERT INTO configs (config_group, config_key, config_value, updated_at)
            VALUES (:group, :key, :value, NOW())
            ON DUPLICATE KEY UPDATE 
                config_value = :value2,
                updated_at = NOW()
        ");
        
        return $stmt->execute([
            'group' => $group,
            'key' => $key,
            'value' => $value,
            'value2' => $value
        ]);
    }
    
    /**
     * Salva múltiplas configurações de um grupo
     * 
     * @param string $group Grupo das configurações
     * @param array $configs Array associativo [key => value]
     * @return bool
     */
    public static function setGroup(string $group, array $configs): bool
    {
        $success = true;
        foreach ($configs as $key => $value) {
            if (!self::set($group, $key, $value)) {
                $success = false;
            }
        }
        return $success;
    }
    
    /**
     * Converte o valor de acordo com o tipo
     * 
     * @param mixed $value
     * @param string $type
     * @return mixed
     */
    private static function castValue($value, string $type)
    {
        switch ($type) {
            case 'integer':
                return (int) $value;
            case 'boolean':
                return (bool) $value || $value === '1';
            case 'json':
                return json_decode($value, true);
            default:
                return $value;
        }
    }
}
