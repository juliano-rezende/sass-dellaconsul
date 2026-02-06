<?php

namespace App\Http\Controllers\Site;

use App\Models\Curriculum;
use App\Models\CareerArea;
use League\Plates\Engine;

class CareersController
{
    private Engine $view;


    public function __construct($router)
    {
        $this->view = new Engine(dirname(__DIR__, 4) . "/".THEME_SITE, "php");
        $this->view->addData(["router" => $router]);
    }

    public function index($router): void
    {
        // Busca áreas de carreira para o formulário
        try {
            $careerAreas = CareerArea::make()->orderBy('name', 'ASC')->get();
            $careerAreasArray = array_map(fn($area) => $area->toArray(), $careerAreas);
        } catch (\Exception $e) {
            $careerAreasArray = [];
        }

        echo $this->view->render("pages/careers", [
            "title" => $router,
            "careerAreas" => $careerAreasArray
        ]);
    }

    /**
     * Processa submissão de currículo
     */
    public function submit(): void
    {
        header('Content-Type: application/json');

        try {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
            $careerAreaId = filter_input(INPUT_POST, 'career_area_id', FILTER_VALIDATE_INT);
            $position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_SPECIAL_CHARS);
            $experienceYears = filter_input(INPUT_POST, 'experience_years', FILTER_VALIDATE_INT) ?? 0;
            $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

            // Validações básicas
            if (empty($name) || empty($email) || empty($phone) || !$careerAreaId) {
                echo json_encode(['success' => false, 'message' => 'Preencha todos os campos obrigatórios']);
                return;
            }

            // Upload de arquivo
            $filePath = $this->handleFileUpload();
            if (!$filePath) {
                echo json_encode(['success' => false, 'message' => 'Erro ao fazer upload do arquivo. Verifique se é PDF e tem no máximo 5MB']);
                return;
            }

            // Cria currículo usando o Model
            $curriculum = Curriculum::create([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'career_area_id' => $careerAreaId,
                'position' => $position ?? '',
                'experience_years' => $experienceYears,
                'file_path' => $filePath,
                'message' => $message ?? '',
                'status' => 'novo'
            ]);

            if ($curriculum) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Currículo enviado com sucesso! Entraremos em contato em breve.'
                ]);
            } else {
                $errors = (new Curriculum())->errors();
                $errorMessage = !empty($errors) ? implode(', ', array_map(fn($e) => implode(', ', $e), $errors)) : 'Erro ao enviar currículo';
                echo json_encode(['success' => false, 'message' => $errorMessage]);
            }

        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao processar currículo: ' . $e->getMessage()]);
        }
    }

    /**
     * Processa upload de arquivo (PDF, DOC, DOCX)
     */
    private function handleFileUpload(): ?string
    {
        // Tenta ambos os nomes de campo
        $fileKey = isset($_FILES['curriculum_file']) ? 'curriculum_file' : (isset($_FILES['curriculo']) ? 'curriculo' : null);
        
        if (!$fileKey || $_FILES[$fileKey]['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $file = $_FILES[$fileKey];
        
        // Valida tipo de arquivo (PDF, DOC, DOCX)
        $allowedTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes)) {
            return null;
        }

        // Valida extensão
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['pdf', 'doc', 'docx'];
        if (!in_array($extension, $allowedExtensions)) {
            return null;
        }

        // Valida tamanho (max 5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            return null;
        }

        // Cria diretório se não existir
        // O controller está em app/Http/Controllers/Site/
        // Precisamos ir para public/arquivos/curriculuns/ na raiz do projeto
        $rootDir = dirname(__DIR__, 4); // Raiz do projeto
        $uploadDir = $rootDir . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'arquivos' . DIRECTORY_SEPARATOR . 'curriculuns' . DIRECTORY_SEPARATOR;
        
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                return null;
            }
        }

        // Verifica se o diretório é gravável
        if (!is_writable($uploadDir)) {
            @chmod($uploadDir, 0755);
            if (!is_writable($uploadDir)) {
                return null;
            }
        }

        // Gera nome único mantendo a extensão original
        $filename = uniqid('curriculum_', true) . '.' . $extension;
        $filepath = $uploadDir . $filename;

        // Move arquivo
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            // Verifica se o arquivo foi realmente salvo
            if (file_exists($filepath) && filesize($filepath) > 0) {
                return 'public/arquivos/curriculuns/' . $filename;
            }
        }

        return null;
    }

}