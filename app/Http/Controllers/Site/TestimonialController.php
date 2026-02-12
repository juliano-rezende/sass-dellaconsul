<?php

namespace App\Http\Controllers\Site;

use App\Models\Testimonial;

class TestimonialController
{
    /**
     * Recebe e salva depoimento enviado pelo formulário
     */
    public function submit(): void
    {
        header('Content-Type: application/json');
        
        try {
            // Valida método
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode(['success' => false, 'message' => 'Método não permitido']);
                return;
            }
            
            // Captura e sanitiza dados
            $name = trim(htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8'));
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $companyRole = trim(htmlspecialchars($_POST['company_role'] ?? '', ENT_QUOTES, 'UTF-8'));
            
            // Para a mensagem, preserva quebras de linha mas remove tags HTML
            $message = $_POST['message'] ?? '';
            $message = strip_tags($message); // Remove tags HTML
            $message = trim($message);
            
            $rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
            $consent = filter_input(INPUT_POST, 'consent', FILTER_VALIDATE_BOOLEAN);
            
            // Validações básicas
            if (empty($name) || strlen($name) < 3) {
                echo json_encode(['success' => false, 'message' => 'Nome deve ter no mínimo 3 caracteres']);
                return;
            }
            
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['success' => false, 'message' => 'Email inválido']);
                return;
            }
            
            if (empty($message) || strlen($message) < 10) {
                echo json_encode(['success' => false, 'message' => 'Depoimento deve ter no mínimo 10 caracteres']);
                return;
            }
            
            if (!$rating || $rating < 1 || $rating > 5) {
                echo json_encode(['success' => false, 'message' => 'Por favor, selecione uma avaliação de 1 a 5 estrelas']);
                return;
            }
            
            // Valida consentimento LGPD
            if (!$consent) {
                echo json_encode(['success' => false, 'message' => 'É necessário aceitar a Política de Privacidade e os Termos de Uso']);
                return;
            }
            
            // Captura IP do usuário para registro de consentimento (LGPD)
            $consentIp = $_SERVER['REMOTE_ADDR'] ?? null;
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $consentIp = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
            }
            $consentDate = date('Y-m-d H:i:s');
            
            // Proteção contra spam - verifica se já existe depoimento recente deste email
            // Ignora registros com soft delete (deleted_at preenchido)
            $recentTestimonials = Testimonial::make()
                ->where('email', $email)
                ->where('created_at', '>', date('Y-m-d H:i:s', strtotime('-1 hour')))
                ->whereNull('deleted_at')  // Ignora registros soft deleted
                ->get();
            
            if (count($recentTestimonials) > 0) {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Você já enviou um depoimento recentemente. Por favor, aguarde antes de enviar outro.'
                ]);
                return;
            }
            
            // Cria depoimento com status pending e registro de consentimento LGPD
            $testimonial = Testimonial::create([
                'name' => $name,
                'email' => $email,
                'company_role' => $companyRole ?? '',
                'message' => $message,
                'rating' => $rating,
                'status' => 'pending',
                'consent_given' => true,
                'consent_ip' => $consentIp,
                'consent_date' => $consentDate,
                'privacy_policy_version' => '1.0' // Versão atual da política
            ]);
            
            if ($testimonial) {
                echo json_encode([
                    'success' => true, 
                    'message' => 'Obrigado pelo seu depoimento! Ele será analisado e publicado em breve.'
                ]);
            } else {
                // Pega erros de validação do model
                $errors = (new Testimonial())->errors();
                $errorMessage = 'Erro ao salvar depoimento';
                
                if (!empty($errors)) {
                    $errorMessages = [];
                    foreach ($errors as $field => $fieldErrors) {
                        $errorMessages = array_merge($errorMessages, $fieldErrors);
                    }
                    $errorMessage = implode(', ', $errorMessages);
                }
                
                echo json_encode(['success' => false, 'message' => $errorMessage]);
            }
            
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false, 
                'message' => 'Erro ao processar depoimento. Por favor, tente novamente.'
            ]);
        }
    }
}
