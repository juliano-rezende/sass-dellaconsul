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
            $curriculums = Curriculum::make()->orderBy('created_at', 'DESC')->get();
            
            // Busca áreas de carreira para filtros
            $careerAreas = CareerArea::make()->orderBy('name', 'ASC')->get();
            
            // Converte para array e formata datas
            $curriculumsArray = array_map(function($curriculum) {
                $array = $curriculum->toArray();
                // Converte DateTime para string formatada
                if (isset($array['created_at']) && $array['created_at'] instanceof \DateTime) {
                    $array['created_at'] = $array['created_at']->format('Y-m-d H:i:s');
                }
                if (isset($array['updated_at']) && $array['updated_at'] instanceof \DateTime) {
                    $array['updated_at'] = $array['updated_at']->format('Y-m-d H:i:s');
                }
                return $array;
            }, $curriculums);
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
     * Busca um currículo específico
     */
    public function get($data): void
    {
        header('Content-Type: application/json');

        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'curriculos', 'view')) {
            echo json_encode(['success' => false, 'message' => 'Sem permissão para visualizar currículos']);
            return;
        }

        try {
            $id = $data['id'] ?? filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

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

            // Busca área de carreira relacionada
            $careerArea = null;
            if ($curriculum->career_area_id) {
                $careerAreaModel = CareerArea::findById($curriculum->career_area_id);
                if ($careerAreaModel) {
                    $careerArea = $careerAreaModel->toArray();
                }
            }

            // Converte para array e formata datas
            $curriculumArray = $curriculum->toArray();
            if (isset($curriculumArray['created_at']) && $curriculumArray['created_at'] instanceof \DateTime) {
                $curriculumArray['created_at'] = $curriculumArray['created_at']->format('Y-m-d H:i:s');
            }
            if (isset($curriculumArray['updated_at']) && $curriculumArray['updated_at'] instanceof \DateTime) {
                $curriculumArray['updated_at'] = $curriculumArray['updated_at']->format('Y-m-d H:i:s');
            }

            // Adiciona path do arquivo (apenas o path relativo, não a URL completa)
            $curriculumArray['file_path'] = $curriculum->file_path;
            $curriculumArray['career_area'] = $careerArea;
            $curriculumArray['status_label'] = $curriculum->getStatusLabel();

            echo json_encode([
                'success' => true,
                'data' => $curriculumArray
            ]);

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao buscar currículo: ' . $e->getMessage()]);
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
            if ($filePath) {
                // Remove 'public/' se existir no início
                $relativePath = preg_replace('#^public/#', '', $filePath);
                if (!str_starts_with($relativePath, 'public/')) {
                    $relativePath = 'public/' . ltrim($relativePath, '/');
                }
                
                // Tenta remover o arquivo físico
                $rootDir = dirname(__DIR__, 4);
                $fullPath = $rootDir . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
                
                if (file_exists($fullPath)) {
                    @unlink($fullPath);
                }
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
