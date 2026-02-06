<?php

namespace App\Helpers;

/**
 * Sistema de ACL (Access Control List) com Permissões Granulares
 * Gerencia roles, permissões CRUD e menu dinâmico
 */
class ACL
{
    /**
     * Ações padrão disponíveis
     */
    public const ACTIONS = [
        'view' => 'Visualizar',
        'create' => 'Criar',
        'update' => 'Editar',
        'delete' => 'Excluir',
        'export' => 'Exportar',
        'import' => 'Importar',
        'print' => 'Imprimir',
    ];

    /**
     * Ações específicas por módulo
     */
    public const MODULE_ACTIONS = [
        'curriculos' => ['approve' => 'Aprovar', 'reject' => 'Reprovar', 'schedule' => 'Agendar Entrevista'],
        'usuarios' => ['reset_password' => 'Resetar Senha', 'activate' => 'Ativar', 'deactivate' => 'Desativar'],
        'whatsapp' => ['send' => 'Enviar Mensagem', 'connect' => 'Conectar', 'disconnect' => 'Desconectar'],
        'sliders' => ['reorder' => 'Reordenar', 'toggle_status' => 'Ativar/Desativar'],
    ];

    /**
     * Definição de Roles com Permissões Granulares
     */
    private const ROLES = [
        'admin' => [
            'label' => 'Administrador',
            'description' => 'Acesso total ao sistema',
            'permissions' => [
                'dashboard' => ['view'],
                'sliders' => ['view', 'create', 'update', 'delete', 'reorder', 'toggle_status'],
                'curriculos' => ['view', 'create', 'update', 'delete', 'export', 'approve', 'reject', 'schedule'],
                'usuarios' => ['view', 'create', 'update', 'delete', 'reset_password', 'activate', 'deactivate'],
                'configuracoes' => ['view', 'update'],
                'whatsapp' => ['view', 'create', 'update', 'delete', 'send', 'connect', 'disconnect'],
            ]
        ],
        'manager' => [
            'label' => 'Gerente',
            'description' => 'Gerencia conteúdo e equipe',
            'permissions' => [
                'dashboard' => ['view'],
                'sliders' => ['view', 'create', 'update', 'reorder'],
                'curriculos' => ['view', 'update', 'export', 'approve', 'reject', 'schedule'],
                'whatsapp' => ['view', 'send'],
            ]
        ],
        'operator' => [
            'label' => 'Operador',
            'description' => 'Opera funcionalidades básicas',
            'permissions' => [
                'dashboard' => ['view'],
                'curriculos' => ['view', 'update', 'schedule'],
                'whatsapp' => ['view', 'send'],
            ]
        ],
        'viewer' => [
            'label' => 'Visualizador',
            'description' => 'Apenas visualização',
            'permissions' => [
                'dashboard' => ['view'],
            ]
        ]
    ];

    /**
     * Estrutura do Menu do Dashboard
     */
    private const MENU_ITEMS = [
        [
            'slug' => 'dashboard',
            'label' => 'Início',
            'icon' => 'fa-tachometer-alt',
            'url' => 'dashboard',
            'module' => 'dashboard'
        ],
        [
            'slug' => 'sliders',
            'label' => 'Sliders',
            'icon' => 'fa-images',
            'url' => 'dashboard/sliders',
            'module' => 'sliders'
        ],
        [
            'slug' => 'curriculos',
            'label' => 'Currículos',
            'icon' => 'fa-user-tie',
            'url' => 'dashboard/curriculos',
            'module' => 'curriculos'
        ],
        [
            'slug' => 'whatsapp',
            'label' => 'WhatsApp',
            'icon' => 'fa-whatsapp',
            'url' => 'dashboard/whatsapp',
            'module' => 'whatsapp'
        ],
        [
            'slug' => 'usuarios',
            'label' => 'Usuários',
            'icon' => 'fa-users',
            'url' => 'dashboard/usuarios',
            'module' => 'usuarios'
        ],
        [
            'slug' => 'configuracoes',
            'label' => 'Configurações',
            'icon' => 'fa-cog',
            'url' => 'dashboard/configuracoes',
            'module' => 'configuracoes'
        ]
    ];

    /**
     * Verifica se um role pode executar uma ação em um módulo
     * 
     * @param string $role Role do usuário
     * @param string $module Módulo (ex: 'sliders', 'curriculos')
     * @param string $action Ação (ex: 'create', 'delete', 'approve')
     * @return bool
     */
    public static function can(string $role, string $module, string $action): bool
    {
        if (!isset(self::ROLES[$role])) {
            return false;
        }

        $modulePermissions = self::ROLES[$role]['permissions'][$module] ?? [];
        
        return in_array($action, $modulePermissions);
    }

    /**
     * Verifica se role tem acesso ao módulo (qualquer ação)
     */
    public static function hasModuleAccess(string $role, string $module): bool
    {
        if (!isset(self::ROLES[$role])) {
            return false;
        }

        return isset(self::ROLES[$role]['permissions'][$module]);
    }

    /**
     * Retorna todas as ações permitidas para um módulo
     */
    public static function getModuleActions(string $role, string $module): array
    {
        return self::ROLES[$role]['permissions'][$module] ?? [];
    }

    /**
     * Retorna todas as permissões de um role
     */
    public static function getAllPermissions(string $role): array
    {
        return self::ROLES[$role]['permissions'] ?? [];
    }

    /**
     * Retorna o label de um role
     */
    public static function getRoleLabel(string $role): string
    {
        return self::ROLES[$role]['label'] ?? $role;
    }

    /**
     * Retorna a descrição de um role
     */
    public static function getRoleDescription(string $role): string
    {
        return self::ROLES[$role]['description'] ?? '';
    }

    /**
     * Retorna todos os roles disponíveis
     */
    public static function getAllRoles(): array
    {
        return array_map(fn($role, $data) => [
            'value' => $role,
            'label' => $data['label'],
            'description' => $data['description']
        ], array_keys(self::ROLES), self::ROLES);
    }

    /**
     * Retorna menu filtrado por role do usuário
     * Só mostra itens de módulos que o usuário tem acesso
     */
    public static function getMenuForRole(string $role): array
    {
        return array_filter(self::MENU_ITEMS, function($item) use ($role) {
            return self::hasModuleAccess($role, $item['module']);
        });
    }

    /**
     * Retorna todos os itens do menu (sem filtro)
     */
    public static function getAllMenuItems(): array
    {
        return self::MENU_ITEMS;
    }

    /**
     * Valida se role existe
     */
    public static function isValidRole(string $role): bool
    {
        return isset(self::ROLES[$role]);
    }

    /**
     * Retorna lista de módulos disponíveis
     */
    public static function getAvailableModules(): array
    {
        return array_unique(array_column(self::MENU_ITEMS, 'module'));
    }

    /**
     * Retorna todas as ações disponíveis para um módulo
     */
    public static function getModuleAvailableActions(string $module): array
    {
        $actions = self::ACTIONS;
        
        // Adiciona ações específicas do módulo
        if (isset(self::MODULE_ACTIONS[$module])) {
            $actions = array_merge($actions, self::MODULE_ACTIONS[$module]);
        }
        
        return $actions;
    }

    /**
     * Gera matriz de permissões para exibição (útil para debug/admin)
     */
    public static function getPermissionsMatrix(): array
    {
        $matrix = [];
        
        foreach (self::ROLES as $role => $data) {
            $matrix[$role] = [
                'label' => $data['label'],
                'description' => $data['description'],
                'modules' => []
            ];
            
            foreach ($data['permissions'] as $module => $actions) {
                $matrix[$role]['modules'][$module] = $actions;
            }
        }
        
        return $matrix;
    }

    /**
     * Valida múltiplas permissões de uma vez (AND)
     * Útil para ações que requerem múltiplas permissões
     */
    public static function canAll(string $role, string $module, array $actions): bool
    {
        foreach ($actions as $action) {
            if (!self::can($role, $module, $action)) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Valida se tem pelo menos uma das permissões (OR)
     */
    public static function canAny(string $role, string $module, array $actions): bool
    {
        foreach ($actions as $action) {
            if (self::can($role, $module, $action)) {
                return true;
            }
        }
        
        return false;
    }
}
