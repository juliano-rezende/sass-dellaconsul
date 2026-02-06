<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\ACL;

class AuthController
{
    /**
     * Processa login
     */
    public function login(): void
    {
        header('Content-Type: application/json');
        
        try {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                echo json_encode(['success' => false, 'message' => 'Email e senha são obrigatórios']);
                return;
            }

            // Busca usuário usando o Model
            $user = User::where('email', $email)->first();

            if (!$user) {
                echo json_encode(['success' => false, 'message' => 'Usuário não encontrado']);
                return;
            }

            // Verifica status
            if (!$user->isActive()) {
                echo json_encode(['success' => false, 'message' => 'Usuário inativo ou pendente']);
                return;
            }

            // Verifica senha usando método do model
            if (!$user->verifyPassword($password)) {
                echo json_encode(['success' => false, 'message' => 'Senha incorreta']);
                return;
            }

            // Inicia sessão
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_role'] = $user->role;
            $_SESSION['user_department'] = $user->department;
            $_SESSION['user_avatar'] = $user->avatar;
            $_SESSION['logged_in'] = true;

            // Atualiza last_login usando método do model
            $user->updateLastLogin();

            echo json_encode([
                'success' => true,
                'message' => 'Login realizado com sucesso',
                'redirect' => urlBase('dashboard')
            ]);

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao processar login: ' . $e->getMessage()]);
        }
    }

    /**
     * Processa logout
     */
    public function logout(): void
    {
        // Inicia sessão se necessário
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Limpa todas as variáveis de sessão
        $_SESSION = [];

        // Destroi o cookie de sessão se existir
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }

        // Destroi a sessão
        session_destroy();

        // Redireciona para a página de login
        header('Location: ' . urlBase('area-segura'));
        exit;
    }

    /**
     * Verifica se está autenticado
     */
    public static function isAuthenticated(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    /**
     * Obtém usuário logado
     */
    public static function user(): ?array
    {
        if (!self::isAuthenticated()) {
            return null;
        }

        return [
            'id' => $_SESSION['user_id'] ?? null,
            'name' => $_SESSION['user_name'] ?? null,
            'email' => $_SESSION['user_email'] ?? null,
            'role' => $_SESSION['user_role'] ?? 'viewer',
            'department' => $_SESSION['user_department'] ?? null,
            'avatar' => $_SESSION['user_avatar'] ?? null,
        ];
    }
}
