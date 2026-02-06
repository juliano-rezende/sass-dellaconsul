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
            
            // Converte para array e formata datas para string
            $slidersArray = array_map(function($slider) {
                $array = $slider->toArray();
                // Converte DateTime para string formatada
                if (isset($array['created_at']) && $array['created_at'] instanceof \DateTime) {
                    $array['created_at'] = $array['created_at']->format('Y-m-d H:i:s');
                }
                if (isset($array['updated_at']) && $array['updated_at'] instanceof \DateTime) {
                    $array['updated_at'] = $array['updated_at']->format('Y-m-d H:i:s');
                }
                return $array;
            }, $sliders);

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
            $uploadResult = $this->handleImageUpload();
            if (!$uploadResult['success']) {
                echo json_encode(['success' => false, 'message' => $uploadResult['message']]);
                return;
            }
            $imagePath = $uploadResult['path']; // Já vem como 'public/images/sliders/filename.jpg'

            // Busca último order_position
            if ($orderPosition == 0) {
                $lastSlider = Slider::make()->orderBy('order_position', 'DESC')->first();
                $orderPosition = $lastSlider ? ($lastSlider->getAttribute('order_position') + 1) : 1;
            }

            // Cria slider usando o Model (salva apenas o caminho relativo)
            $slider = Slider::create([
                'title' => $title,
                'subtitle' => $subtitle ?? '',
                'description' => $description ?? '',
                'image' => $imagePath, // Salva apenas o caminho relativo
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
     * Busca um slider específico
     */
    public function get(): void
    {
        header('Content-Type: application/json');

        // Valida permissão
        if (!ACL::can($_SESSION['user_role'], 'sliders', 'view')) {
            echo json_encode(['success' => false, 'message' => 'Sem permissão para visualizar sliders']);
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

            // Converte para array e formata datas
            $sliderArray = $slider->toArray();
            if (isset($sliderArray['created_at']) && $sliderArray['created_at'] instanceof \DateTime) {
                $sliderArray['created_at'] = $sliderArray['created_at']->format('Y-m-d H:i:s');
            }
            if (isset($sliderArray['updated_at']) && $sliderArray['updated_at'] instanceof \DateTime) {
                $sliderArray['updated_at'] = $sliderArray['updated_at']->format('Y-m-d H:i:s');
            }

            echo json_encode(['success' => true, 'slider' => $sliderArray]);

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao buscar slider: ' . $e->getMessage()]);
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
                if ($oldImage) {
                    // Se for URL completa (dados antigos), extrai o caminho
                    if (str_starts_with($oldImage, 'http')) {
                        $baseUrl = urlBase('');
                        $oldImagePath = str_replace($baseUrl . '/', '', $oldImage);
                    } else {
                        $oldImagePath = $oldImage;
                    }
                    
                    // Garante que tem 'public/' no início (remove 'app/' se existir)
                    $oldImagePath = preg_replace('#^app/public/#', 'public/', $oldImagePath);
                    if (!str_starts_with($oldImagePath, 'public/')) {
                        $oldImagePath = 'public/' . ltrim($oldImagePath, '/');
                    }
                    
                    // Tenta remover o arquivo físico
                    $rootDir = dirname(__DIR__, 4);
                    $fullPath = $rootDir . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $oldImagePath);
                    
                    if (file_exists($fullPath)) {
                        @unlink($fullPath);
                    }
                }
                
                $uploadResult = $this->handleImageUpload();
                if (!$uploadResult['success']) {
                    echo json_encode(['success' => false, 'message' => $uploadResult['message']]);
                    return;
                }
                // Salva apenas o caminho relativo
                $slider->image = $uploadResult['path'];
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

            // Busca slider usando o Model
            $slider = Slider::findById($id);

            if (!$slider) {
                echo json_encode(['success' => false, 'message' => 'Slider não encontrado']);
                return;
            }

            // Remove imagem física
            $imagePath = $slider->image;
            if ($imagePath) {
                // O caminho já vem como 'public/images/sliders/filename.jpg'
                // Se por algum motivo vier URL completa (dados antigos), extrai o caminho
                if (str_starts_with($imagePath, 'http')) {
                    $baseUrl = urlBase('');
                    $relativePath = str_replace($baseUrl . '/', '', $imagePath);
                } else {
                    $relativePath = $imagePath;
                }
                
                // Remove 'app/' se existir e garante que tem 'public/' no início
                $relativePath = preg_replace('#^app/public/#', 'public/', $relativePath);
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

            // Realiza delete permanente (hard delete)
            try {
                $result = $slider->delete();
                
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Slider deletado permanentemente com sucesso']);
                } else {
                    $errors = $slider->errors();
                    $errorMessage = 'Erro ao deletar slider';
                    
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
            } catch (\Exception $deleteException) {
                echo json_encode(['success' => false, 'message' => 'Erro ao deletar slider: ' . $deleteException->getMessage()]);
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
     * @return array ['success' => bool, 'path' => string|null, 'message' => string]
     */
    private function handleImageUpload(): array
    {
        if (!isset($_FILES['image'])) {
            return ['success' => false, 'path' => null, 'message' => 'Nenhuma imagem foi enviada'];
        }

        $file = $_FILES['image'];
        
        // Verifica erros de upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE => 'O arquivo excede o tamanho máximo permitido pelo servidor',
                UPLOAD_ERR_FORM_SIZE => 'O arquivo excede o tamanho máximo permitido pelo formulário',
                UPLOAD_ERR_PARTIAL => 'O arquivo foi enviado parcialmente',
                UPLOAD_ERR_NO_FILE => 'Nenhum arquivo foi enviado',
                UPLOAD_ERR_NO_TMP_DIR => 'Falta uma pasta temporária',
                UPLOAD_ERR_CANT_WRITE => 'Falha ao escrever o arquivo no disco',
                UPLOAD_ERR_EXTENSION => 'Uma extensão PHP interrompeu o upload do arquivo',
            ];
            $message = $errorMessages[$file['error']] ?? 'Erro desconhecido no upload (código: ' . $file['error'] . ')';
            return ['success' => false, 'path' => null, 'message' => $message];
        }
        
        // Valida tipo de arquivo
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes)) {
            return ['success' => false, 'path' => null, 'message' => 'Tipo de arquivo não permitido. Use apenas JPG, PNG ou WebP'];
        }

        // Valida tamanho (max 5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            return ['success' => false, 'path' => null, 'message' => 'O arquivo é muito grande. Tamanho máximo: 5MB'];
        }

        // Cria diretório se não existir
        // O controller está em app/Http/Controllers/Dashboard/
        // Precisamos ir para public/images/sliders/ na raiz do projeto
        // Usa a mesma lógica do construtor: dirname(__DIR__, 4) = raiz do projeto
        $rootDir = dirname(__DIR__, 4); // Raiz do projeto
        $uploadDir = $rootDir . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'sliders' . DIRECTORY_SEPARATOR;
        
        // Cria diretório se não existir
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                return ['success' => false, 'path' => null, 'message' => 'Não foi possível criar o diretório de upload: ' . $uploadDir];
            }
        }

        // Verifica se o diretório é gravável
        if (!is_writable($uploadDir)) {
            // Tenta corrigir permissões
            @chmod($uploadDir, 0755);
            if (!is_writable($uploadDir)) {
                return ['success' => false, 'path' => null, 'message' => 'O diretório de upload não tem permissão de escrita: ' . $uploadDir];
            }
        }

        // Verifica se o arquivo temporário existe
        if (!file_exists($file['tmp_name'])) {
            return ['success' => false, 'path' => null, 'message' => 'Arquivo temporário não encontrado'];
        }

        // Verifica se o arquivo temporário é válido
        if (!is_uploaded_file($file['tmp_name'])) {
            return ['success' => false, 'path' => null, 'message' => 'Arquivo não é um upload válido'];
        }

        // Gera nome único
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = uniqid('slider_', true) . '.' . $extension;
        $filepath = $uploadDir . $filename;

        // Move arquivo
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            // Verifica se o arquivo foi realmente salvo
            if (file_exists($filepath) && filesize($filepath) > 0) {
                return ['success' => true, 'path' => 'public/images/sliders/' . $filename, 'message' => 'Upload realizado com sucesso'];
            } else {
                return ['success' => false, 'path' => null, 'message' => 'Arquivo foi movido mas não foi encontrado no destino'];
            }
        }

        // Se falhou, tenta descobrir o motivo
        $error = error_get_last();
        $errorMsg = 'Falha ao mover o arquivo para o diretório de destino';
        if ($error) {
            $errorMsg .= ': ' . $error['message'];
        }
        $errorMsg .= ' | Caminho: ' . $filepath . ' | Temp: ' . $file['tmp_name'];
        
        return ['success' => false, 'path' => null, 'message' => $errorMsg];
    }
}
