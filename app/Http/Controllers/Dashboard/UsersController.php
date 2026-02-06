<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
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
            // Busca usuários usando o Model
            $users = User::orderBy('created_at', 'DESC')->get();
            
            // Converte para array para manter compatibilidade com a view
            $usersArray = array_map(fn($user) => $user->toArray(), $users);

            echo $this->view->render("pages/users", [
                "title" => "Usuários",
                "users" => $usersArray
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

            // Validações básicas
            if (empty($name) || empty($email) || empty($password)) {
                echo json_encode(['success' => false, 'message' => 'Preencha todos os campos obrigatórios']);
                return;
            }

            if (!ACL::isValidRole($role)) {
                echo json_encode(['success' => false, 'message' => 'Role inválido']);
                return;
            }

            // Cria usuário usando o Model
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password, // Hash automático no beforeSave
                'role' => $role,
                'department' => $department,
                'status' => $status,
                'phone' => $phone
            ]);

            if ($user) {
                echo json_encode(['success' => true, 'message' => 'Usuário criado com sucesso']);
            } else {
                // Pega erros de validação do model
                $errors = (new User())->errors();
                $errorMessage = !empty($errors) ? implode(', ', array_map(fn($e) => implode(', ', $e), $errors)) : 'Erro ao criar usuário';
                echo json_encode(['success' => false, 'message' => $errorMessage]);
            }

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

            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID inválido']);
                return;
            }

            // Busca usuário usando o Model
            $user = User::findById($id);

            if (!$user) {
                echo json_encode(['success' => false, 'message' => 'Usuário não encontrado']);
                return;
            }

            // Atualiza campos
            $user->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            $user->email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $user->role = $_POST['role'] ?? $user->role;
            $user->department = $_POST['department'] ?? $user->department;
            $user->status = $_POST['status'] ?? $user->status;
            
            if (!empty($_POST['phone'])) {
                $user->phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
            }

            // Atualiza senha se fornecida
            if (!empty($_POST['password'])) {
                $user->password = $_POST['password']; // Hash automático no beforeSave
            }

            if ($user->save()) {
                echo json_encode(['success' => true, 'message' => 'Usuário atualizado com sucesso']);
            } else {
                $errors = $user->errors();
                $errorMessage = !empty($errors) ? implode(', ', array_map(fn($e) => implode(', ', $e), $errors)) : 'Erro ao atualizar usuário';
                echo json_encode(['success' => false, 'message' => $errorMessage]);
            }

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar usuário: ' . $e->getMessage()]);
        }
    }

    /**
     * Deleta usuário (soft delete)
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

            // Busca e deleta usuário usando o Model (soft delete)
            $user = User::findById($id);

            if (!$user) {
                echo json_encode(['success' => false, 'message' => 'Usuário não encontrado']);
                return;
            }

            if ($user->delete()) {
                echo json_encode(['success' => true, 'message' => 'Usuário deletado com sucesso']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro ao deletar usuário']);
            }

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao deletar usuário: ' . $e->getMessage()]);
        }
    }
}
