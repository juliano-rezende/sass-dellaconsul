<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Curriculum;
use App\Models\CareerArea;
use App\Helpers\ACL;
use League\Plates\Engine;

class CurriculumController
{
    private Engine $view;

    public function __construct($router)
    {
        $this->view = new Engine(dirname(__DIR__, 4) . "/" . THEME_DASHBOARD, "php");
        $this->view->addData(["router" => $router]);
    }

    /**
     * Lista currículos
     */
    public function index($router): void
    {
        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'curriculos', 'view')) {
            http_response_code(403);
            echo "Acesso negado";
            return;
        }

        try {
            // Busca currículos usando o Model
            $curriculums = Curriculum::orderBy('created_at', 'DESC')->get();
            
            // Busca áreas de carreira para filtros
            $careerAreas = CareerArea::orderBy('name', 'ASC')->get();
            
            // Converte para array
            $curriculumsArray = array_map(fn($curriculum) => $curriculum->toArray(), $curriculums);
            $careerAreasArray = array_map(fn($area) => $area->toArray(), $careerAreas);

            echo $this->view->render("pages/curriculum", [
                "title" => "Currículos",
                "curriculums" => $curriculumsArray,
                "careerAreas" => $careerAreasArray
            ]);
        } catch (\Exception $e) {
            echo "Erro ao carregar currículos: " . $e->getMessage();
        }
    }

    /**
     * Atualiza status do currículo
     */
    public function update(): void
    {
        header('Content-Type: application/json');

        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'curriculos', 'update')) {
            echo json_encode(['success' => false, 'message' => 'Sem permissão para atualizar currículos']);
            return;
        }

        try {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $status = $_POST['status'] ?? null;
            $action = $_POST['action'] ?? null;

            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID inválido']);
                return;
            }

            // Busca currículo usando o Model
            $curriculum = Curriculum::findById($id);

            if (!$curriculum) {
                echo json_encode(['success' => false, 'message' => 'Currículo não encontrado']);
                return;
            }

            // Processa ação ou status
            if ($action) {
                switch ($action) {
                    case 'approve':
                        if (!ACL::can($_SESSION['user_role'], 'curriculos', 'approve')) {
                            echo json_encode(['success' => false, 'message' => 'Sem permissão para aprovar']);
                            return;
                        }
                        $curriculum->approve();
                        break;
                    case 'reject':
                        if (!ACL::can($_SESSION['user_role'], 'curriculos', 'reject')) {
                            echo json_encode(['success' => false, 'message' => 'Sem permissão para reprovar']);
                            return;
                        }
                        $curriculum->reject();
                        break;
                    case 'interview':
                        if (!ACL::can($_SESSION['user_role'], 'curriculos', 'schedule')) {
                            echo json_encode(['success' => false, 'message' => 'Sem permissão para agendar entrevista']);
                            return;
                        }
                        $curriculum->markForInterview();
                        break;
                    case 'analysis':
                        $curriculum->markAsAnalysis();
                        break;
                }
            } elseif ($status) {
                $curriculum->status = $status;
                $curriculum->save();
            } else {
                echo json_encode(['success' => false, 'message' => 'Ação ou status não informado']);
                return;
            }

            echo json_encode([
                'success' => true,
                'message' => 'Status atualizado com sucesso',
                'status' => $curriculum->status,
                'status_label' => $curriculum->getStatusLabel()
            ]);

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar currículo: ' . $e->getMessage()]);
        }
    }

    /**
     * Deleta currículo (soft delete)
     */
    public function delete(): void
    {
        header('Content-Type: application/json');

        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'curriculos', 'delete')) {
            echo json_encode(['success' => false, 'message' => 'Sem permissão para deletar currículos']);
            return;
        }

        try {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID inválido']);
                return;
            }

            // Busca e deleta currículo usando o Model (soft delete)
            $curriculum = Curriculum::findById($id);

            if (!$curriculum) {
                echo json_encode(['success' => false, 'message' => 'Currículo não encontrado']);
                return;
            }

            // Remove arquivo físico
            $filePath = $curriculum->file_path;
            if ($filePath && file_exists(__DIR__ . '/../../../public/' . $filePath)) {
                unlink(__DIR__ . '/../../../public/' . $filePath);
            }

            if ($curriculum->delete()) {
                echo json_encode(['success' => true, 'message' => 'Currículo deletado com sucesso']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro ao deletar currículo']);
            }

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao deletar currículo: ' . $e->getMessage()]);
        }
    }
}
