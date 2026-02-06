<?php

namespace App\Http\Controllers\Dashboard;

use Database\Connection;
use App\Helpers\ACL;
use League\Plates\Engine;

class UsersController
{
    private Engine $view;
    
    public function __construct($router)
    {
        $this->view = new Engine(dirname(__DIR__, 4) . "/" . THEME_DASHBOARD, "php");
        $this->view->addData(["router" => $router]);
    }
    
    /**
     * Lista usuários
     */
    public function index($router): void
    {
        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'usuarios', 'view')) {
            http_response_code(403);
            echo "Acesso negado";
            return;
        }

        try {
            $pdo = Connection::getInstance();
            $stmt = $pdo->query("
                SELECT id, name, email, role, department, status, phone, avatar, last_login, created_at
                FROM users
                ORDER BY created_at DESC
            ");
            $users = $stmt->fetchAll();

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

        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'usuarios', 'create')) {
            echo json_encode(['success' => false, 'message' => 'Sem permissão para criar usuários']);
            return;
        }

        try {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'viewer';
            $department = $_POST['department'] ?? 'administrativo';
            $status = $_POST['status'] ?? 'pending';
            $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);

            // Validações
            if (empty($name) || empty($email) || empty($password)) {
                echo json_encode(['success' => false, 'message' => 'Preencha todos os campos obrigatórios']);
                return;
            }

            if (!ACL::isValidRole($role)) {
                echo json_encode(['success' => false, 'message' => 'Role inválido']);
                return;
            }

            // Verifica se email já existe
            $pdo = Connection::getInstance();
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            if ($stmt->fetch()) {
                echo json_encode(['success' => false, 'message' => 'E-mail já cadastrado']);
                return;
            }

            // Insere usuário
            $stmt = $pdo->prepare("
                INSERT INTO users (name, email, password, role, department, status, phone)
                VALUES (:name, :email, :password, :role, :department, :status, :phone)
            ");

            $stmt->execute([
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => $role,
                'department' => $department,
                'status' => $status,
                'phone' => $phone
            ]);

            echo json_encode(['success' => true, 'message' => 'Usuário criado com sucesso']);

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

        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'usuarios', 'update')) {
            echo json_encode(['success' => false, 'message' => 'Sem permissão para atualizar usuários']);
            return;
        }

        try {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $role = $_POST['role'] ?? '';
            $department = $_POST['department'] ?? '';
            $status = $_POST['status'] ?? '';
            $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);

            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID inválido']);
                return;
            }

            $pdo = Connection::getInstance();
            
            // Monta query dinâmica
            $fields = ['name = :name', 'email = :email', 'role = :role', 'department = :department', 'status = :status'];
            $params = ['id' => $id, 'name' => $name, 'email' => $email, 'role' => $role, 'department' => $department, 'status' => $status];
            
            if (!empty($phone)) {
                $fields[] = 'phone = :phone';
                $params['phone'] = $phone;
            }

            // Atualiza senha se fornecida
            if (!empty($_POST['password'])) {
                $fields[] = 'password = :password';
                $params['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);

            echo json_encode(['success' => true, 'message' => 'Usuário atualizado com sucesso']);

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar usuário: ' . $e->getMessage()]);
        }
    }

    /**
     * Deleta usuário
     */
    public function delete(): void
    {
        header('Content-Type: application/json');

        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'usuarios', 'delete')) {
            echo json_encode(['success' => false, 'message' => 'Sem permissão para deletar usuários']);
            return;
        }

        try {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID inválido']);
                return;
            }

            // Não permite deletar a si mesmo
            if ($id == $_SESSION['user_id']) {
                echo json_encode(['success' => false, 'message' => 'Você não pode deletar seu próprio usuário']);
                return;
            }

            $pdo = Connection::getInstance();
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]);

            echo json_encode(['success' => true, 'message' => 'Usuário deletado com sucesso']);

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao deletar usuário: ' . $e->getMessage()]);
        }
    }
}
