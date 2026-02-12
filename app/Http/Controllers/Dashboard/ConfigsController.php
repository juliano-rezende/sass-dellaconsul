<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\ACL;
use App\Models\Config;
use App\Models\User;
use App\Models\Curriculum;
use League\Plates\Engine;

class ConfigsController
{
    private Engine $view;

    public function __construct($router)
    {
        $this->view = new Engine(dirname(__DIR__, 4) . "/".THEME_DASHBOARD, "php");
        $this->view->addData(["router" => $router]);
    }

    public function index($router): void
    {
        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'configuracoes', 'view')) {
            http_response_code(403);
            echo "Acesso negado";
            return;
        }

        try {
            // Busca configurações do banco agrupadas por grupo
            $configs = Config::getAllGrouped();
            
            // Calcula estatísticas reais do sistema
            $systemStats = [
                'version' => '1.0.0',
                'last_update' => date('d/m/Y'),
                'active_users' => count(User::make()->where('status', '=', 'active')->get()),
                'total_curriculum' => count(Curriculum::make()->get())
            ];
            
            echo $this->view->render("pages/configs", [
                "title" => "Configurações",
                "configs" => $configs,
                "systemStats" => $systemStats
            ]);
        } catch (\Exception $e) {
            echo "Erro ao carregar configurações: " . $e->getMessage();
        }
    }
    
    /**
     * Salva configurações
     */
    public function save(): void
    {
        header('Content-Type: application/json');
        
        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'configuracoes', 'update')) {
            echo json_encode(['success' => false, 'message' => 'Sem permissão para atualizar configurações']);
            return;
        }
        
        try {
            $group = $_POST['group'] ?? null;
            $configs = $_POST['configs'] ?? [];
            
            if (!$group || empty($configs)) {
                echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
                return;
            }
            
            // Salva configurações do grupo
            if (Config::setGroup($group, $configs)) {
                echo json_encode(['success' => true, 'message' => 'Configurações salvas com sucesso']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro ao salvar configurações']);
            }
            
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
        }
    }
}