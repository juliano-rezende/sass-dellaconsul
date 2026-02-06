<?php

namespace App\Http\Controllers;

use Database\Connection;
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

            // Busca usuário no banco
            $pdo = Connection::getInstance();
            $stmt = $pdo->prepare("
                SELECT id, name, email, password, role, department, status, avatar
                FROM users 
                WHERE email = :email
                LIMIT 1
            ");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if (!$user) {
                echo json_encode(['success' => false, 'message' => 'Usuário não encontrado']);
                return;
            }

            // Verifica status
            if ($user['status'] !== 'active') {
                echo json_encode(['success' => false, 'message' => 'Usuário inativo ou pendente']);
                return;
            }

            // Verifica senha
            if (!password_verify($password, $user['password'])) {
                echo json_encode(['success' => false, 'message' => 'Senha incorreta']);
                return;
            }

            // Inicia sessão
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_department'] = $user['department'];
            $_SESSION['user_avatar'] = $user['avatar'];
            $_SESSION['logged_in'] = true;

            // Atualiza last_login
            $stmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = :id");
            $stmt->execute(['id' => $user['id']]);

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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();
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
