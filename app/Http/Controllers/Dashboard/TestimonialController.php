<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Testimonial;
use App\Helpers\ACL;
use League\Plates\Engine;

class TestimonialController
{
    private Engine $view;

    public function __construct($router)
    {
        $this->view = new Engine(dirname(__DIR__, 4) . "/" . THEME_DASHBOARD, "php");
        $this->view->addData(["router" => $router]);
    }

    /**
     * Lista depoimentos
     */
    public function index($router): void
    {
        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'depoimentos', 'view')) {
            http_response_code(403);
            echo "Acesso negado";
            return;
        }

        try {
            // Busca todos os depoimentos (ignora soft deleted)
            $testimonials = Testimonial::make()
                ->whereNull('deleted_at')  // Ignora registros soft deleted
                ->orderBy('created_at', 'DESC')
                ->get();
            
            // Converte para array e formata datas para string
            $testimonialsArray = array_map(function($testimonial) {
                $array = $testimonial->toArray();
                // Converte DateTime para string formatada
                if (isset($array['created_at']) && $array['created_at'] instanceof \DateTime) {
                    $array['created_at'] = $array['created_at']->format('Y-m-d H:i:s');
                }
                if (isset($array['updated_at']) && $array['updated_at'] instanceof \DateTime) {
                    $array['updated_at'] = $array['updated_at']->format('Y-m-d H:i:s');
                }
                if (isset($array['approved_at']) && $array['approved_at'] instanceof \DateTime) {
                    $array['approved_at'] = $array['approved_at']->format('Y-m-d H:i:s');
                }
                return $array;
            }, $testimonials);

            echo $this->view->render("pages/testimonials", [
                "title" => "Depoimentos",
                "testimonials" => $testimonialsArray
            ]);
        } catch (\Exception $e) {
            echo "Erro ao carregar depoimentos: " . $e->getMessage();
        }
    }

    /**
     * Busca um depoimento específico
     */
    public function get(): void
    {
        header('Content-Type: application/json');

        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'depoimentos', 'view')) {
            echo json_encode(['success' => false, 'message' => 'Sem permissão para visualizar depoimentos']);
            return;
        }

        try {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID inválido']);
                return;
            }

            // Busca depoimento usando o Model
            $testimonial = Testimonial::findById($id);

            if (!$testimonial) {
                echo json_encode(['success' => false, 'message' => 'Depoimento não encontrado']);
                return;
            }

            // Converte para array e formata datas
            $testimonialArray = $testimonial->toArray();
            
            // Formata datas para exibição (já prontas para o frontend)
            if (isset($testimonialArray['created_at']) && $testimonialArray['created_at'] instanceof \DateTime) {
                $testimonialArray['created_at_formatted'] = $testimonialArray['created_at']->format('d/m/Y H:i');
                $testimonialArray['created_at'] = $testimonialArray['created_at']->format('Y-m-d H:i:s');
            }
            
            if (isset($testimonialArray['updated_at']) && $testimonialArray['updated_at'] instanceof \DateTime) {
                $testimonialArray['updated_at_formatted'] = $testimonialArray['updated_at']->format('d/m/Y H:i');
                $testimonialArray['updated_at'] = $testimonialArray['updated_at']->format('Y-m-d H:i:s');
            }
            
            if (isset($testimonialArray['approved_at']) && $testimonialArray['approved_at'] instanceof \DateTime) {
                $testimonialArray['approved_at_formatted'] = $testimonialArray['approved_at']->format('d/m/Y H:i');
                $testimonialArray['approved_at'] = $testimonialArray['approved_at']->format('Y-m-d H:i:s');
            }
            
            // Formata consent_date (LGPD)
            if (isset($testimonialArray['consent_date']) && $testimonialArray['consent_date'] instanceof \DateTime) {
                $testimonialArray['consent_date_formatted'] = $testimonialArray['consent_date']->format('d/m/Y H:i');
                $testimonialArray['consent_date'] = $testimonialArray['consent_date']->format('Y-m-d H:i:s');
            } elseif (isset($testimonialArray['consent_date']) && is_string($testimonialArray['consent_date'])) {
                // Se já for string, tenta formatar
                try {
                    $date = new \DateTime($testimonialArray['consent_date']);
                    $testimonialArray['consent_date_formatted'] = $date->format('d/m/Y H:i');
                } catch (\Exception $e) {
                    $testimonialArray['consent_date_formatted'] = null;
                }
            } else {
                $testimonialArray['consent_date_formatted'] = null;
            }

            echo json_encode(['success' => true, 'testimonial' => $testimonialArray]);

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao buscar depoimento: ' . $e->getMessage()]);
        }
    }

    /**
     * Aprova depoimento
     */
    public function approve(): void
    {
        header('Content-Type: application/json');

        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'depoimentos', 'approve')) {
            echo json_encode(['success' => false, 'message' => 'Sem permissão para aprovar depoimentos']);
            return;
        }

        try {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID inválido']);
                return;
            }

            $testimonial = Testimonial::findById($id);

            if (!$testimonial) {
                echo json_encode(['success' => false, 'message' => 'Depoimento não encontrado']);
                return;
            }
            
            // Verifica se o depoimento foi deletado (soft delete)
            if ($testimonial->trashed()) {
                echo json_encode(['success' => false, 'message' => 'Não é possível aprovar um depoimento que foi excluído']);
                return;
            }

            // Aprova usando o método do model que salva também quem aprovou
            if ($testimonial->approve($_SESSION['user_id'])) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Depoimento aprovado com sucesso',
                    'status' => 'approved'
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro ao aprovar depoimento']);
            }

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao aprovar depoimento: ' . $e->getMessage()]);
        }
    }

    /**
     * Rejeita depoimento
     */
    public function reject(): void
    {
        header('Content-Type: application/json');

        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'depoimentos', 'reject')) {
            echo json_encode(['success' => false, 'message' => 'Sem permissão para rejeitar depoimentos']);
            return;
        }

        try {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID inválido']);
                return;
            }

            $testimonial = Testimonial::findById($id);

            if (!$testimonial) {
                echo json_encode(['success' => false, 'message' => 'Depoimento não encontrado']);
                return;
            }
            
            // Verifica se o depoimento foi deletado (soft delete)
            if ($testimonial->trashed()) {
                echo json_encode(['success' => false, 'message' => 'Não é possível rejeitar um depoimento que foi excluído']);
                return;
            }

            // Rejeita usando o método do model
            if ($testimonial->reject()) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Depoimento rejeitado',
                    'status' => 'rejected'
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro ao rejeitar depoimento']);
            }

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao rejeitar depoimento: ' . $e->getMessage()]);
        }
    }

    /**
     * Deleta depoimento (soft delete)
     */
    public function delete(): void
    {
        header('Content-Type: application/json');

        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'depoimentos', 'delete')) {
            echo json_encode(['success' => false, 'message' => 'Sem permissão para deletar depoimentos']);
            return;
        }

        try {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID inválido']);
                return;
            }

            $testimonial = Testimonial::findById($id);

            if (!$testimonial) {
                echo json_encode(['success' => false, 'message' => 'Depoimento não encontrado']);
                return;
            }
            
            // Verifica se já foi deletado (soft delete)
            if ($testimonial->trashed()) {
                echo json_encode(['success' => false, 'message' => 'Este depoimento já foi excluído anteriormente']);
                return;
            }

            // Realiza soft delete
            if ($testimonial->delete()) {
                echo json_encode(['success' => true, 'message' => 'Depoimento deletado com sucesso']);
            } else {
                $errors = $testimonial->errors();
                $errorMessage = 'Erro ao deletar depoimento';
                
                if (!empty($errors)) {
                    if (is_array($errors)) {
                        $errorMessage = implode(', ', array_map(function($e) {
                            return is_array($e) ? implode(', ', $e) : $e;
                        }, $errors));
                    } else {
                        $errorMessage = $errors;
                    }
                }
                
                echo json_encode(['success' => false, 'message' => $errorMessage]);
            }

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao deletar depoimento: ' . $e->getMessage()]);
        }
    }
}
