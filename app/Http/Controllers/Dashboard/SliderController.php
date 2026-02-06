<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Slider;
use App\Helpers\ACL;
use League\Plates\Engine;

class SliderController
{
    private Engine $view;

    public function __construct($router)
    {
        $this->view = new Engine(dirname(__DIR__, 4) . "/" . THEME_DASHBOARD, "php");
        $this->view->addData(["router" => $router]);
    }

    /**
     * Lista sliders
     */
    public function index($router): void
    {
        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'sliders', 'view')) {
            http_response_code(403);
            echo "Acesso negado";
            return;
        }

        try {
            // Busca sliders usando o Model
            $sliders = Slider::make()->orderBy('order_position', 'ASC')->get();
            
            // Converte para array para manter compatibilidade com a view
            $slidersArray = array_map(fn($slider) => $slider->toArray(), $sliders);

            echo $this->view->render("pages/slider", [
                "title" => "Sliders",
                "sliders" => $slidersArray
            ]);
        } catch (\Exception $e) {
            echo "Erro ao carregar sliders: " . $e->getMessage();
        }
    }

    /**
     * Cria novo slider
     */
    public function create(): void
    {
        header('Content-Type: application/json');

        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'sliders', 'create')) {
            echo json_encode(['success' => false, 'message' => 'Sem permissão para criar sliders']);
            return;
        }

        try {
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
            $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
            $buttonText = filter_input(INPUT_POST, 'button_text', FILTER_SANITIZE_SPECIAL_CHARS);
            $buttonLink = filter_input(INPUT_POST, 'button_link', FILTER_SANITIZE_URL);
            $status = $_POST['status'] ?? 'active';
            $orderPosition = filter_input(INPUT_POST, 'order_position', FILTER_VALIDATE_INT) ?? 0;

            // Validações básicas
            if (empty($title)) {
                echo json_encode(['success' => false, 'message' => 'Título é obrigatório']);
                return;
            }

            // Upload de imagem
            $imagePath = $this->handleImageUpload();
            if (!$imagePath) {
                echo json_encode(['success' => false, 'message' => 'Erro ao fazer upload da imagem']);
                return;
            }

            // Busca último order_position
            if ($orderPosition == 0) {
                $lastSlider = Slider::make()->orderBy('order_position', 'DESC')->first();
                $orderPosition = $lastSlider ? ($lastSlider->getAttribute('order_position') + 1) : 1;
            }

            // Cria slider usando o Model
            $slider = Slider::create([
                'title' => $title,
                'subtitle' => $subtitle ?? '',
                'description' => $description ?? '',
                'image' => $imagePath,
                'button_text' => $buttonText ?? '',
                'button_link' => $buttonLink ?? '',
                'order_position' => $orderPosition,
                'status' => $status
            ]);

            if ($slider) {
                echo json_encode(['success' => true, 'message' => 'Slider criado com sucesso']);
            } else {
                $errors = (new Slider())->errors();
                $errorMessage = !empty($errors) ? implode(', ', array_map(fn($e) => implode(', ', $e), $errors)) : 'Erro ao criar slider';
                echo json_encode(['success' => false, 'message' => $errorMessage]);
            }

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao criar slider: ' . $e->getMessage()]);
        }
    }

    /**
     * Atualiza slider
     */
    public function update(): void
    {
        header('Content-Type: application/json');

        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'sliders', 'update')) {
            echo json_encode(['success' => false, 'message' => 'Sem permissão para atualizar sliders']);
            return;
        }

        try {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID inválido']);
                return;
            }

            // Busca slider usando o Model
            $slider = Slider::findById($id);

            if (!$slider) {
                echo json_encode(['success' => false, 'message' => 'Slider não encontrado']);
                return;
            }

            // Atualiza campos
            $slider->title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
            $slider->subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_SPECIAL_CHARS);
            $slider->description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
            $slider->button_text = filter_input(INPUT_POST, 'button_text', FILTER_SANITIZE_SPECIAL_CHARS);
            $slider->button_link = filter_input(INPUT_POST, 'button_link', FILTER_SANITIZE_URL);
            $slider->status = $_POST['status'] ?? $slider->status;
            
            if (isset($_POST['order_position'])) {
                $slider->order_position = filter_input(INPUT_POST, 'order_position', FILTER_VALIDATE_INT);
            }

            // Upload de nova imagem se fornecida
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // Remove imagem antiga
                $oldImage = $slider->image;
                if ($oldImage && file_exists(__DIR__ . '/../../../public/' . $oldImage)) {
                    unlink(__DIR__ . '/../../../public/' . $oldImage);
                }
                
                $imagePath = $this->handleImageUpload();
                if ($imagePath) {
                    $slider->image = $imagePath;
                }
            }

            if ($slider->save()) {
                echo json_encode(['success' => true, 'message' => 'Slider atualizado com sucesso']);
            } else {
                $errors = $slider->errors();
                $errorMessage = !empty($errors) ? implode(', ', array_map(fn($e) => implode(', ', $e), $errors)) : 'Erro ao atualizar slider';
                echo json_encode(['success' => false, 'message' => $errorMessage]);
            }

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar slider: ' . $e->getMessage()]);
        }
    }

    /**
     * Deleta slider (soft delete)
     */
    public function delete(): void
    {
        header('Content-Type: application/json');

        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'sliders', 'delete')) {
            echo json_encode(['success' => false, 'message' => 'Sem permissão para deletar sliders']);
            return;
        }

        try {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID inválido']);
                return;
            }

            // Busca e deleta slider usando o Model (soft delete)
            $slider = Slider::findById($id);

            if (!$slider) {
                echo json_encode(['success' => false, 'message' => 'Slider não encontrado']);
                return;
            }

            // Remove imagem física
            $imagePath = $slider->image;
            if ($imagePath && file_exists(__DIR__ . '/../../../public/' . $imagePath)) {
                unlink(__DIR__ . '/../../../public/' . $imagePath);
            }

            if ($slider->delete()) {
                echo json_encode(['success' => true, 'message' => 'Slider deletado com sucesso']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro ao deletar slider']);
            }

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao deletar slider: ' . $e->getMessage()]);
        }
    }

    /**
     * Reordena sliders
     */
    public function reorder(): void
    {
        header('Content-Type: application/json');

        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'sliders', 'reorder')) {
            echo json_encode(['success' => false, 'message' => 'Sem permissão para reordenar sliders']);
            return;
        }

        try {
            $order = json_decode($_POST['order'] ?? '[]', true);

            if (empty($order)) {
                echo json_encode(['success' => false, 'message' => 'Ordem inválida']);
                return;
            }

            foreach ($order as $position => $id) {
                $slider = Slider::findById($id);
                if ($slider) {
                    $slider->order_position = $position + 1;
                    $slider->save();
                }
            }

            echo json_encode(['success' => true, 'message' => 'Ordem atualizada com sucesso']);

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao reordenar sliders: ' . $e->getMessage()]);
        }
    }

    /**
     * Alterna status do slider
     */
    public function toggleStatus(): void
    {
        header('Content-Type: application/json');

        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'sliders', 'toggle_status')) {
            echo json_encode(['success' => false, 'message' => 'Sem permissão para alterar status']);
            return;
        }

        try {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID inválido']);
                return;
            }

            $slider = Slider::findById($id);

            if (!$slider) {
                echo json_encode(['success' => false, 'message' => 'Slider não encontrado']);
                return;
            }

            $slider->status = $slider->status === 'active' ? 'inactive' : 'active';

            if ($slider->save()) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Status atualizado com sucesso',
                    'status' => $slider->status
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro ao atualizar status']);
            }

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao alterar status: ' . $e->getMessage()]);
        }
    }

    /**
     * Processa upload de imagem
     */
    private function handleImageUpload(): ?string
    {
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $file = $_FILES['image'];
        
        // Valida tipo de arquivo
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes)) {
            return null;
        }

        // Valida tamanho (max 5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            return null;
        }

        // Cria diretório se não existir
        $uploadDir = __DIR__ . '/../../../public/images/sliders/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Gera nome único
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('slider_', true) . '.' . $extension;
        $filepath = $uploadDir . $filename;

        // Move arquivo
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return 'images/sliders/' . $filename;
        }

        return null;
    }
}
