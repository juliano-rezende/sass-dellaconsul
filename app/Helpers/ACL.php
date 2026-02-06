<?php

namespace App\Helpers;

/**
 * Sistema de ACL (Access Control List)
 * Gerencia roles, permissões e menu dinâmico
 */
class ACL
{
    /**
     * Definição de Roles e suas Permissões
     */
    private const ROLES = [
        'admin' => [
            'label' => 'Administrador',
            'permissions' => ['dashboard', 'sliders', 'curriculos', 'usuarios', 'configuracoes', 'whatsapp']
        ],
        'manager' => [
            'label' => 'Gerente',
            'permissions' => ['dashboard', 'sliders', 'curriculos', 'whatsapp']
        ],
        'operator' => [
            'label' => 'Operador',
            'permissions' => ['dashboard', 'curriculos', 'whatsapp']
        ],
        'viewer' => [
            'label' => 'Visualizador',
            'permissions' => ['dashboard']
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
            'required_permission' => 'dashboard'
        ],
        [
            'slug' => 'sliders',
            'label' => 'Sliders',
            'icon' => 'fa-images',
            'url' => 'dashboard/sliders',
            'required_permission' => 'sliders'
        ],
        [
            'slug' => 'curriculos',
            'label' => 'Currículos',
            'icon' => 'fa-user-tie',
            'url' => 'dashboard/curriculos',
            'required_permission' => 'curriculos'
        ],
        [
            'slug' => 'whatsapp',
            'label' => 'WhatsApp',
            'icon' => 'fa-whatsapp',
            'url' => 'dashboard/whatsapp',
            'required_permission' => 'whatsapp'
        ],
        [
            'slug' => 'usuarios',
            'label' => 'Usuários',
            'icon' => 'fa-users',
            'url' => 'dashboard/usuarios',
            'required_permission' => 'usuarios'
        ],
        [
            'slug' => 'configuracoes',
            'label' => 'Configurações',
            'icon' => 'fa-cog',
            'url' => 'dashboard/configuracoes',
            'required_permission' => 'configuracoes'
        ]
    ];

    /**
     * Verifica se um role tem uma permissão específica
     */
    public static function hasPermission(string $role, string $permission): bool
    {
        if (!isset(self::ROLES[$role])) {
            return false;
        }

        return in_array($permission, self::ROLES[$role]['permissions']);
    }

    /**
     * Retorna todas as permissões de um role
     */
    public static function getPermissions(string $role): array
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
     * Retorna todos os roles disponíveis
     */
    public static function getAllRoles(): array
    {
        return array_map(fn($role) => [
            'value' => $role,
            'label' => self::ROLES[$role]['label']
        ], array_keys(self::ROLES));
    }

    /**
     * Retorna menu filtrado por role do usuário
     */
    public static function getMenuForRole(string $role): array
    {
        $permissions = self::getPermissions($role);
        
        return array_filter(self::MENU_ITEMS, function($item) use ($permissions) {
            return in_array($item['required_permission'], $permissions);
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
     * Verifica se usuário pode acessar uma rota/recurso
     */
    public static function canAccess(string $role, string $permission): bool
    {
        return self::hasPermission($role, $permission);
    }

    /**
     * Valida se role existe
     */
    public static function isValidRole(string $role): bool
    {
        return isset(self::ROLES[$role]);
    }

    /**
     * Retorna permissões em formato para checkbox (formulário de usuários)
     */
    public static function getPermissionsForForm(): array
    {
        $allPermissions = [];
        
        foreach (self::MENU_ITEMS as $item) {
            $allPermissions[] = [
                'value' => $item['slug'],
                'label' => $item['label'],
                'icon' => $item['icon']
            ];
        }
        
        return $allPermissions;
    }
}
