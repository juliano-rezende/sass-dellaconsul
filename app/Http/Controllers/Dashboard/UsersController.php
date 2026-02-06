<?php

namespace App\Http\Controllers\Dashboard;

use League\Plates\Engine;
use Database\Connection;
use App\Helpers\ACL;
use App\Http\Controllers\AuthController;
use PDO;

class UsersController
{
    private Engine $view;

    public function __construct($router)
    {
        $this->view = new Engine(dirname(__DIR__, 4) . "/".THEME_DASHBOARD, "php");
        $this->view->addData(["router" => $router]);
    }

    /**
     * Lista usuários
     */
    public function index($router): void
    {
        // Verifica permissão
        if (!ACL::can(AuthController::role(), 'usuarios', 'view')) {
            http_response_code(403);
            echo "Sem permissão";
            return;
        }

        // Busca usuários do banco
        try {
            $db = Connection::getInstance();
            $stmt = $db->query("
                SELECT id, name, email, role, department, status, last_login, created_at
                FROM users
                ORDER BY created_at DESC
            ");
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo $this->view->render("pages/users", [
                "title" => "Usuários",
                "users" => $users
            ]);
        } catch (\Exception $e) {
            echo "Erro ao carregar usuários: " . $e->getMessage();
        }
    }

    /**
     * Cria novo usuário
     */
    public function create(): void
    {
        header('Content-Type: application/json');

        try {
            // Verifica permissão
            if (!ACL::can(AuthController::role(), 'usuarios', 'create')) {
                echo json_encode(['success' => false, 'message' => 'Sem permissão para criar usuários']);
                return;
            }

            // Validações
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'viewer';
            $department = $_POST['department'] ?? 'administrativo';
            $status = $_POST['status'] ?? 'pending';

            if (empty($name) || empty($email) || empty($password)) {
                echo json_encode(['success' => false, 'message' => 'Preencha todos os campos obrigatórios']);
                return;
            }

            // Valida role
            if (!ACL::isValidRole($role)) {
                echo json_encode(['success' => false, 'message' => 'Role inválido']);
                return;
            }

            // Valida email único
            $db = Connection::getInstance();
            $stmt = $db->prepare("SELECT id FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            if ($stmt->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Email já cadastrado']);
                return;
            }

            // Cria usuário
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("
                INSERT INTO users (name, email, password, role, department, status)
                VALUES (:name, :email, :password, :role, :department, :status)
            ");
            
            $stmt->execute([
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
                'role' => $role,
                'department' => $department,
                'status' => $status
            ]);

            echo json_encode([
                'success' => true,
                'message' => 'Usuário criado com sucesso!',
                'user_id' => $db->lastInsertId()
            ]);

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao criar usuário: ' . $e->getMessage()]);
        }
    }

    /**
     * Atualiza usuário
     */
    public function update(): void
    {
        header('Content-Type: application/json');

        try {
            // Verifica permissão
            if (!ACL::can(AuthController::role(), 'usuarios', 'update')) {
                echo json_encode(['success' => false, 'message' => 'Sem permissão para editar usuários']);
                return;
            }

            $id = $_POST['id'] ?? 0;
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $role = $_POST['role'] ?? '';
            $department = $_POST['department'] ?? '';
            $status = $_POST['status'] ?? '';

            if (empty($id) || empty($name) || empty($email)) {
                echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
                return;
            }

            $db = Connection::getInstance();
            
            // Valida email único (exceto próprio usuário)
            $stmt = $db->prepare("SELECT id FROM users WHERE email = :email AND id != :id");
            $stmt->execute(['email' => $email, 'id' => $id]);
            if ($stmt->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Email já cadastrado']);
                return;
            }

            // Atualiza usuário
            $stmt = $db->prepare("
                UPDATE users 
                SET name = :name, email = :email, role = :role, department = :department, status = :status
                WHERE id = :id
            ");
            
            $stmt->execute([
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'role' => $role,
                'department' => $department,
                'status' => $status
            ]);

            echo json_encode(['success' => true, 'message' => 'Usuário atualizado com sucesso!']);

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar: ' . $e->getMessage()]);
        }
    }

    /**
     * Deleta usuário
     */
    public function delete(): void
    {
        header('Content-Type: application/json');

        try {
            // Verifica permissão
            if (!ACL::can(AuthController::role(), 'usuarios', 'delete')) {
                echo json_encode(['success' => false, 'message' => 'Sem permissão para excluir usuários']);
                return;
            }

            $id = $_POST['id'] ?? 0;

            if (empty($id)) {
                echo json_encode(['success' => false, 'message' => 'ID inválido']);
                return;
            }

            // Não permite deletar próprio usuário
            if ($id == ($_SESSION['user_id'] ?? 0)) {
                echo json_encode(['success' => false, 'message' => 'Você não pode excluir seu próprio usuário']);
                return;
            }

            $db = Connection::getInstance();
            $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]);

            echo json_encode(['success' => true, 'message' => 'Usuário excluído com sucesso!']);

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao excluir: ' . $e->getMessage()]);
        }
    }

    /**
     * Reseta senha do usuário
     */
    public function resetPassword(): void
    {
        header('Content-Type: application/json');

        try {
            // Verifica permissão
            if (!ACL::can(AuthController::role(), 'usuarios', 'reset_password')) {
                echo json_encode(['success' => false, 'message' => 'Sem permissão para resetar senhas']);
                return;
            }

            $id = $_POST['id'] ?? 0;
            $newPassword = $_POST['new_password'] ?? '';

            if (empty($id) || empty($newPassword)) {
                echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
                return;
            }

            if (strlen($newPassword) < 6) {
                echo json_encode(['success' => false, 'message' => 'Senha deve ter no mínimo 6 caracteres']);
                return;
            }

            $db = Connection::getInstance();
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            $stmt = $db->prepare("UPDATE users SET password = :password WHERE id = :id");
            $stmt->execute(['password' => $hashedPassword, 'id' => $id]);

            echo json_encode(['success' => true, 'message' => 'Senha resetada com sucesso!']);

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao resetar senha: ' . $e->getMessage()]);
        }
    }
}
