<?php

namespace App\Http\Middlewares;

use App\Http\Controllers\AuthController;
use App\Helpers\ACL;

/**
 * Middleware de Autenticação e Validação de ACL
 */
class AuthMiddleware
{
    /**
     * Mapeamento de rotas para módulos/ações
     */
    private const ROUTE_PERMISSIONS = [
        'dashboard' => ['module' => 'dashboard', 'action' => 'view'],
        'dashboard/sliders' => ['module' => 'sliders', 'action' => 'view'],
        'dashboard/curriculos' => ['module' => 'curriculos', 'action' => 'view'],
        'dashboard/usuarios' => ['module' => 'usuarios', 'action' => 'view'],
        'dashboard/configuracoes' => ['module' => 'configuracoes', 'action' => 'view'],
        'dashboard/whatsapp' => ['module' => 'whatsapp', 'action' => 'view'],
    ];

    /**
     * Handle do middleware
     */
    public function handle(): bool
    {
        // Verifica se está autenticado
        if (!AuthController::check()) {
            $this->redirectToLogin();
            return false;
        }

        // Verifica timeout da sessão (30 minutos padrão)
        $timeout = 1800; // 30 minutos
        if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > $timeout) {
            session_destroy();
            $this->redirectToLogin('Sessão expirada. Faça login novamente.');
            return false;
        }

        // Atualiza tempo de atividade
        $_SESSION['last_activity'] = time();

        // Valida ACL para a rota atual
        $currentRoute = $this->getCurrentRoute();
        if (!$this->checkPermission($currentRoute)) {
            $this->error403();
            return false;
        }

        return true;
    }

    /**
     * Obtém rota atual
     */
    private function getCurrentRoute(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = trim($uri, '/');
        
        return $uri;
    }

    /**
     * Verifica permissão para rota
     */
    private function checkPermission(string $route): bool
    {
        // Rota raiz do dashboard sempre permite
        if ($route === 'dashboard' || $route === 'dashboard/') {
            return true;
        }

        // Busca permissão necessária
        $permission = self::ROUTE_PERMISSIONS[$route] ?? null;
        
        if (!$permission) {
            // Se não está mapeada, permite (pode ser rota pública)
            return true;
        }

        $userRole = AuthController::role();
        
        return ACL::can($userRole, $permission['module'], $permission['action']);
    }

    /**
     * Redireciona para login
     */
    private function redirectToLogin(string $message = ''): void
    {
        if ($message) {
            $_SESSION['login_error'] = $message;
        }
        
        header('Location: ' . urlBase('area-segura'));
        exit;
    }

    /**
     * Erro 403 - Sem permissão
     */
    private function error403(): void
    {
        http_response_code(403);
        echo '<h1>403 - Acesso Negado</h1>';
        echo '<p>Você não tem permissão para acessar este recurso.</p>';
        echo '<a href="' . urlBase('dashboard') . '">Voltar ao Dashboard</a>';
        exit;
    }
}
