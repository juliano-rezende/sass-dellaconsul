<?php

namespace App\Http\Middlewares;

use App\Http\Controllers\AuthController;
use App\Helpers\ACL;
use CoffeeCode\Router\Router;

/**
 * Middleware de Autenticação e Validação de ACL
 * Compatível com CoffeeCode Router
 * 
 * Nota: SessionMiddleware deve ser executado ANTES deste middleware
 */
class AuthMiddleware
{
    /**
     * Valida autenticação e permissões
     * 
     * @param Router $router Instância do Router
     * @return bool
     */
    public function handle(Router $router): bool
    {
        // SessionMiddleware já inicializou a sessão
        // Mantém verificação como fallback de segurança
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verifica se está autenticado
        if (!AuthController::isAuthenticated()) {
            $this->redirectToLogin();
            return false;
        }

        // Obtém usuário e rota atual
        $user = AuthController::user();
        $currentUri = $_SERVER['REQUEST_URI'] ?? '';
        
        // Extrai módulo da URL (ex: /dashboard/sliders → sliders)
        $module = $this->extractModuleFromUri($currentUri);

        // Se não conseguiu extrair módulo, permite (é dashboard home)
        if ($module === 'dashboard' || $module === null) {
            return true;
        }

        // Valida se tem acesso ao módulo
        if (!ACL::hasModuleAccess($user['role'], $module)) {
            $this->error403();
            return false;
        }

        return true;
    }

    /**
     * Extrai nome do módulo da URI
     */
    private function extractModuleFromUri(string $uri): ?string
    {
        // Remove query string
        $uri = strtok($uri, '?');
        
        // Remove base URL se houver
        $basePath = parse_url(URL_BASE, PHP_URL_PATH) ?? '';
        if (!empty($basePath)) {
            $uri = str_replace($basePath, '', $uri);
        }
        
        // Extrai partes da URL
        $parts = array_filter(explode('/', trim($uri, '/')));
        
        // Se é /dashboard/algo, retorna 'algo'
        if (isset($parts[0]) && $parts[0] === 'dashboard') {
            return $parts[1] ?? 'dashboard';
        }
        
        return null;
    }

    /**
     * Redireciona para login
     */
    private function redirectToLogin(): void
    {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'] ?? '';
        header('Location: ' . urlBase('login'));
        exit;
    }

    /**
     * Retorna erro 403
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
