<?php

namespace App\Http\Middlewares;

use CoffeeCode\Router\Router;

/**
 * SessionMiddleware
 * 
 * Gerencia o ciclo de vida completo das sessões com foco em segurança
 * 
 * Responsabilidades:
 * - Iniciar e configurar sessões com parâmetros seguros
 * - Regenerar session_id periodicamente (prevenção de session fixation)
 * - Validar IP e User-Agent (prevenção de session hijacking)
 * - Implementar timeout de inatividade
 * - Configurar cookies de sessão com flags de segurança
 * - Logging de atividades suspeitas
 */
class SessionMiddleware
{
    /**
     * Tempo máximo de inatividade em segundos (30 minutos)
     */
    private const INACTIVITY_TIMEOUT = 1800;

    /**
     * Intervalo para regeneração de session_id em segundos (15 minutos)
     */
    private const REGENERATION_INTERVAL = 900;

    /**
     * Tempo de vida máximo da sessão em segundos (1 hora)
     */
    private const SESSION_LIFETIME = 3600;

    /**
     * Handle session management
     *
     * @param Router $router
     * @return bool
     */
    public function handle(Router $router): bool
    {
        // 1. Inicializa sessão com configurações seguras
        $this->initializeSession();

        // 2. Valida a sessão existente
        if (!$this->validateSession()) {
            $this->destroySession();
            return true; // Permite continuar, mas sem sessão
        }

        // 3. Regenera session_id periodicamente
        $this->regenerateSessionId();

        // 4. Verifica timeout de inatividade
        if (!$this->checkInactivityTimeout()) {
            $this->destroySession();
            
            // Redireciona para login com mensagem de timeout
            if (strpos($_SERVER['REQUEST_URI'], '/dashboard') !== false) {
                header('Location: ' . urlBase('login?timeout=1'));
                exit;
            }
            
            return true;
        }

        // 5. Atualiza timestamp de última atividade
        $this->updateLastActivity();

        // 6. Log de atividade (apenas em produção se necessário)
        $this->logActivity();

        return true;
    }

    /**
     * Inicializa a sessão com configurações seguras
     */
    private function initializeSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            // Configurações de segurança do cookie de sessão
            ini_set('session.cookie_httponly', '1');  // Previne acesso via JavaScript
            ini_set('session.cookie_secure', '1');     // Apenas HTTPS (ajuste se necessário)
            ini_set('session.cookie_samesite', 'Strict'); // Proteção CSRF
            ini_set('session.use_only_cookies', '1'); // Não permite session_id via URL
            ini_set('session.use_strict_mode', '1');  // Rejeita session_id não inicializados
            ini_set('session.gc_maxlifetime', (string) self::SESSION_LIFETIME);

            // Nome customizado da sessão (mais difícil de identificar)
            session_name('DELLACONSUL_SID');

            session_start();

            // Inicializa fingerprint na primeira vez
            if (!isset($_SESSION['initialized'])) {
                $this->initializeSessionFingerprint();
                $_SESSION['initialized'] = true;
                $_SESSION['created_at'] = time();
            }
        }
    }

    /**
     * Inicializa o fingerprint da sessão para validação
     */
    private function initializeSessionFingerprint(): void
    {
        $_SESSION['user_ip'] = $this->getUserIP();
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
        $_SESSION['last_regeneration'] = time();
        $_SESSION['last_activity'] = time();
    }

    /**
     * Valida a sessão atual
     *
     * @return bool
     */
    private function validateSession(): bool
    {
        // Se não há dados de sessão, é válida (nova sessão)
        if (!isset($_SESSION['user_ip'])) {
            return true;
        }

        // 1. Valida IP do usuário
        if (!$this->validateIP()) {
            $this->logSecurityEvent('IP mismatch detected');
            return false;
        }

        // 2. Valida User-Agent
        if (!$this->validateUserAgent()) {
            $this->logSecurityEvent('User-Agent mismatch detected');
            return false;
        }

        // 3. Verifica tempo de vida máximo da sessão
        if (isset($_SESSION['created_at'])) {
            $sessionAge = time() - $_SESSION['created_at'];
            if ($sessionAge > self::SESSION_LIFETIME) {
                $this->logSecurityEvent('Session lifetime exceeded');
                return false;
            }
        }

        return true;
    }

    /**
     * Valida se o IP do usuário permanece o mesmo
     *
     * @return bool
     */
    private function validateIP(): bool
    {
        if (!isset($_SESSION['user_ip'])) {
            return true;
        }

        $currentIP = $this->getUserIP();
        
        // Em ambientes com proxy/load balancer, pode haver variação no último octeto
        // Ajuste conforme sua infraestrutura
        return $_SESSION['user_ip'] === $currentIP;
    }

    /**
     * Valida se o User-Agent permanece o mesmo
     *
     * @return bool
     */
    private function validateUserAgent(): bool
    {
        if (!isset($_SESSION['user_agent'])) {
            return true;
        }

        $currentUserAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
        return $_SESSION['user_agent'] === $currentUserAgent;
    }

    /**
     * Obtém o IP real do usuário (considera proxies)
     *
     * @return string
     */
    private function getUserIP(): string
    {
        // Lista de headers comuns para IP real em ordem de prioridade
        $headers = [
            'HTTP_CF_CONNECTING_IP', // Cloudflare
            'HTTP_X_REAL_IP',        // Nginx
            'HTTP_X_FORWARDED_FOR',  // Proxy padrão
            'REMOTE_ADDR'            // IP direto
        ];

        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $ip = $_SERVER[$header];
                
                // Se for X-Forwarded-For, pega o primeiro IP
                if (strpos($ip, ',') !== false) {
                    $ip = trim(explode(',', $ip)[0]);
                }
                
                // Valida se é um IP válido
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }

        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    /**
     * Regenera o session_id periodicamente
     */
    private function regenerateSessionId(): void
    {
        if (!isset($_SESSION['last_regeneration'])) {
            $_SESSION['last_regeneration'] = time();
            return;
        }

        $timeSinceRegeneration = time() - $_SESSION['last_regeneration'];

        if ($timeSinceRegeneration > self::REGENERATION_INTERVAL) {
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = time();
            
            $this->logActivity('Session ID regenerated');
        }
    }

    /**
     * Verifica timeout de inatividade
     *
     * @return bool True se sessão ainda é válida, false se expirou
     */
    private function checkInactivityTimeout(): bool
    {
        if (!isset($_SESSION['last_activity'])) {
            $_SESSION['last_activity'] = time();
            return true;
        }

        $inactiveTime = time() - $_SESSION['last_activity'];

        if ($inactiveTime > self::INACTIVITY_TIMEOUT) {
            $this->logSecurityEvent("Session timeout - inactive for {$inactiveTime}s");
            return false;
        }

        return true;
    }

    /**
     * Atualiza o timestamp de última atividade
     */
    private function updateLastActivity(): void
    {
        $_SESSION['last_activity'] = time();
    }

    /**
     * Destrói a sessão completamente
     */
    private function destroySession(): void
    {
        // Remove todas as variáveis de sessão
        $_SESSION = [];

        // Remove o cookie de sessão
        if (isset($_COOKIE[session_name()])) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        // Destrói a sessão
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }

    /**
     * Log de atividade normal (apenas se usuário logado)
     *
     * @param string $message
     */
    private function logActivity(string $message = ''): void
    {
        // Só loga se houver usuário autenticado
        if (!isset($_SESSION['user_id'])) {
            return;
        }

        // Em produção, você pode querer desabilitar isso ou enviar para um sistema de log
        if (getenv('APP_ENV') === 'development') {
            $logMessage = sprintf(
                "[Session Activity] User: %s | IP: %s | Message: %s",
                $_SESSION['user_id'],
                $this->getUserIP(),
                $message ?: 'Active'
            );
            
            error_log($logMessage);
        }
    }

    /**
     * Log de eventos de segurança (sempre ativo)
     *
     * @param string $message
     */
    private function logSecurityEvent(string $message): void
    {
        $logMessage = sprintf(
            "[SECURITY ALERT] %s | IP: %s | User-Agent: %s | Session: %s",
            $message,
            $this->getUserIP(),
            $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            session_id()
        );

        error_log($logMessage);

        // Aqui você pode adicionar integração com sistema de alertas
        // Ex: Slack, Email, Sentry, etc.
    }

    /**
     * Obtém informações da sessão atual (para debug)
     *
     * @return array
     */
    public static function getSessionInfo(): array
    {
        if (session_status() === PHP_SESSION_NONE) {
            return ['status' => 'No active session'];
        }

        return [
            'session_id' => session_id(),
            'session_name' => session_name(),
            'created_at' => $_SESSION['created_at'] ?? null,
            'last_activity' => $_SESSION['last_activity'] ?? null,
            'last_regeneration' => $_SESSION['last_regeneration'] ?? null,
            'user_ip' => $_SESSION['user_ip'] ?? null,
            'user_id' => $_SESSION['user_id'] ?? null,
            'is_authenticated' => isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true,
        ];
    }
}
