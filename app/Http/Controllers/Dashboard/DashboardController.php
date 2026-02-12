<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\ACL;
use App\Models\User;
use App\Models\Curriculum;
use App\Models\Testimonial;
use App\Models\Slider;
use League\Plates\Engine;

class DashboardController
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
        if (!ACL::can($_SESSION['user_role'], 'dashboard', 'view')) {
            http_response_code(403);
            echo "Acesso negado";
            return;
        }

        try {
            // Busca currículos
            $allCurriculums = Curriculum::make()->get();
            $totalCurriculums = count($allCurriculums);
            $newCurriculums = count(array_filter($allCurriculums, fn($c) => ($c->status ?? '') === 'novo'));
            $inAnalysis = count(array_filter($allCurriculums, fn($c) => ($c->status ?? '') === 'analise'));
            $approved = count(array_filter($allCurriculums, fn($c) => ($c->status ?? '') === 'aprovado'));
            
            // Busca usuários ativos
            $activeUsers = count(User::make()->where('status', '=', 'active')->get());
            
            // Busca depoimentos pendentes
            $pendingTestimonials = count(Testimonial::make()->where('status', '=', 'pending')->get());
            
            // Busca sliders ativos
            $activeSliders = count(Slider::make()->where('status', '=', 'active')->get());
            
            // Currículos recentes (últimos 10)
            $recentCurriculums = Curriculum::make()
                ->orderBy('created_at', 'DESC')
                ->limit(10)
                ->get();
            
            // Prepara dados para gráfico (currículos por mês - últimos 6 meses)
            $chartData = $this->getCurriculumsChartData($allCurriculums);
            
            echo $this->view->render("pages/dashboard", [
                "title" => "Dashboard",
                "stats" => [
                    'curriculums' => [
                        'total' => $totalCurriculums,
                        'new' => $newCurriculums,
                        'in_analysis' => $inAnalysis,
                        'approved' => $approved
                    ],
                    'active_users' => $activeUsers,
                    'pending_testimonials' => $pendingTestimonials,
                    'active_sliders' => $activeSliders
                ],
                "recentCurriculums" => $recentCurriculums,
                "chartData" => $chartData
            ]);
        } catch (\Exception $e) {
            echo "Erro ao carregar dashboard: " . $e->getMessage();
        }
    }
    
    /**
     * Prepara dados para gráfico de currículos por mês
     */
    private function getCurriculumsChartData(array $curriculums): array
    {
        $months = [];
        $counts = [];
        
        // Últimos 6 meses
        for ($i = 5; $i >= 0; $i--) {
            $date = new \DateTime();
            $date->modify("-$i months");
            $monthKey = $date->format('Y-m');
            $monthLabel = $this->getMonthName($date->format('m')) . '/' . $date->format('y');
            
            $months[$monthKey] = $monthLabel;
            $counts[$monthKey] = 0;
        }
        
        // Conta currículos por mês
        foreach ($curriculums as $curriculum) {
            $createdAt = $curriculum->created_at;
            if ($createdAt instanceof \DateTime) {
                $monthKey = $createdAt->format('Y-m');
                if (isset($counts[$monthKey])) {
                    $counts[$monthKey]++;
                }
            }
        }
        
        return [
            'labels' => array_values($months),
            'data' => array_values($counts)
        ];
    }
    
    /**
     * Retorna nome do mês em português
     */
    private function getMonthName(string $month): string
    {
        $names = [
            '01' => 'Jan', '02' => 'Fev', '03' => 'Mar',
            '04' => 'Abr', '05' => 'Mai', '06' => 'Jun',
            '07' => 'Jul', '08' => 'Ago', '09' => 'Set',
            '10' => 'Out', '11' => 'Nov', '12' => 'Dez'
        ];
        return $names[$month] ?? '';
    }
}