<?php

namespace App\Http\Controllers;

use Database\Connection;
use App\Helpers\ACL;
use PDO;

class AuthController
{
    /**
     * Exibe página de login
     */
    public function loginPage(): void
    {
        // Se já está logado, redireciona para dashboard
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . urlBase('dashboard'));
            exit;
        }

        // Renderiza página de login
        require_once dirname(__DIR__, 3) . '/themes/site/default/pages/login.php';
    }

    /**
     * Processa login
     */
    public function login(): void
    {
        header('Content-Type: application/json');

        try {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Validações
            if (empty($email) || empty($password)) {
                echo json_encode(['success' => false, 'message' => 'Email e senha são obrigatórios']);
                return;
            }

            // Busca usuário no banco
            $db = Connection::getInstance();
            $stmt = $db->prepare("
                SELECT id, name, email, password, role, status, avatar, department
                FROM users 
                WHERE email = :email
            ");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Valida usuário
            if (!$user) {
                echo json_encode(['success' => false, 'message' => 'Usuário não encontrado']);
                return;
            }

            // Valida senha
            if (!password_verify($password, $user['password'])) {
                echo json_encode(['success' => false, 'message' => 'Senha incorreta']);
                return;
            }

            // Valida status
            if ($user['status'] !== 'active') {
                echo json_encode(['success' => false, 'message' => 'Usuário inativo. Contate o administrador.']);
                return;
            }

            // Cria sessão
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_avatar'] = $user['avatar'];
            $_SESSION['user_department'] = $user['department'];
            $_SESSION['logged_in'] = true;
            $_SESSION['login_time'] = time();

            // Atualiza last_login
            $stmt = $db->prepare("UPDATE users SET last_login = NOW() WHERE id = :id");
            $stmt->execute(['id' => $user['id']]);

            echo json_encode([
                'success' => true,
                'message' => 'Login realizado com sucesso!',
                'redirect' => urlBase('dashboard')
            ]);

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao processar login: ' . $e->getMessage()]);
        }
    }

    /**
     * Logout
     */
    public function logout(): void
    {
        session_destroy();
        header('Location: ' . urlBase('area-segura'));
        exit;
    }

    /**
     * Verifica se está autenticado
     */
    public static function check(): bool
    {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    /**
     * Retorna dados do usuário logado
     */
    public static function user(): ?array
    {
        if (!self::check()) {
            return null;
        }

        return [
            'id' => $_SESSION['user_id'] ?? null,
            'name' => $_SESSION['user_name'] ?? null,
            'email' => $_SESSION['user_email'] ?? null,
            'role' => $_SESSION['user_role'] ?? 'viewer',
            'avatar' => $_SESSION['user_avatar'] ?? null,
            'department' => $_SESSION['user_department'] ?? null,
        ];
    }

    /**
     * Retorna role do usuário logado
     */
    public static function role(): string
    {
        return $_SESSION['user_role'] ?? 'viewer';
    }
}
