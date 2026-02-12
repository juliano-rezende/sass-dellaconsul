<?php $this->layout("_theme"); ?>

<?php $this->start("css"); ?>
<style>
    /* Dashboard Grid Spacing */
    .dashboard-content .row.g-4 {
        margin-left: -1rem;
        margin-right: -1rem;
    }
    
    .dashboard-content .row.g-4 > [class*="col-"] {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    /* Activity Items */
    .activity-item {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.2s ease;
    }
    
    .activity-item:hover {
        background-color: #fafafa;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: white;
        flex-shrink: 0;
    }
    
    /* Chart Container */
    .chart-container {
        position: relative;
        height: 320px;
        padding: 1rem 0;
    }
    
    /* Cards Enhancement */
    .card {
        border: 1px solid #f0f0f0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }
    
    .card-header {
        background-color: #fafafa;
        border-bottom: 1px solid #f0f0f0;
    }
</style>
<?php $this->end("css"); ?>

<?php $this->start("container"); ?>

<!-- Page Content -->
<div class="dashboard-content">
    <!-- Stats Cards -->
    <div class="row mb-4 g-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-color: #2563eb; --card-color-light: #60a5fa;">
                <div class="stat-icon bg-primary">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $stats['curriculums']['total'] ?? 0 ?></h3>
                    <p>Total de Currículos</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-color: #0ea5e9; --card-color-light: #38bdf8;">
                <div class="stat-icon bg-info">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $stats['curriculums']['new'] ?? 0 ?></h3>
                    <p>Novos Currículos</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-color: #10b981; --card-color-light: #34d399;">
                <div class="stat-icon bg-success">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $stats['active_users'] ?? 0 ?></h3>
                    <p>Usuários Ativos</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-color: #f59e0b; --card-color-light: #fbbf24;">
                <div class="stat-icon bg-warning">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $stats['pending_testimonials'] ?? 0 ?></h3>
                    <p>Depoimentos Pendentes</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>
                        Currículos Recebidos (Últimos 6 Meses)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="curriculumsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie me-2"></i>
                        Visão Geral
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Currículos Novos</span>
                            <strong><?= $stats['curriculums']['new'] ?? 0 ?></strong>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" role="progressbar" 
                                 style="width: <?= $stats['curriculums']['total'] > 0 ? round(($stats['curriculums']['new'] / $stats['curriculums']['total']) * 100) : 0 ?>%"></div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Em Análise</span>
                            <strong><?= $stats['curriculums']['in_analysis'] ?? 0 ?></strong>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning" role="progressbar" 
                                 style="width: <?= $stats['curriculums']['total'] > 0 ? round(($stats['curriculums']['in_analysis'] / $stats['curriculums']['total']) * 100) : 0 ?>%"></div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Aprovados</span>
                            <strong><?= $stats['curriculums']['approved'] ?? 0 ?></strong>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: <?= $stats['curriculums']['total'] > 0 ? round(($stats['curriculums']['approved'] / $stats['curriculums']['total']) * 100) : 0 ?>%"></div>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-images text-primary me-2"></i>Sliders Ativos</span>
                            <strong><?= $stats['active_sliders'] ?? 0 ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2"></i>
                        Últimos Currículos Recebidos
                    </h5>
                    <a href="<?= urlBase('dashboard/curriculos') ?>" class="btn btn-sm btn-outline-primary">
                        Ver Todos
                    </a>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($recentCurriculums)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Nenhum currículo recebido ainda.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($recentCurriculums as $curriculum): ?>
                            <?php
                            $statusLabels = [
                                'novo' => ['label' => 'Novo', 'class' => 'bg-info'],
                                'analise' => ['label' => 'Em Análise', 'class' => 'bg-warning'],
                                'aprovado' => ['label' => 'Aprovado', 'class' => 'bg-success'],
                                'reprovado' => ['label' => 'Reprovado', 'class' => 'bg-danger'],
                                'entrevista' => ['label' => 'Entrevista', 'class' => 'bg-primary']
                            ];
                            $status = $curriculum->status ?? 'novo';
                            $statusInfo = $statusLabels[$status] ?? ['label' => 'Novo', 'class' => 'bg-info'];
                            
                            $createdAt = $curriculum->created_at ?? null;
                            $dateStr = 'Data desconhecida';
                            if ($createdAt instanceof \DateTime) {
                                $now = new \DateTime();
                                $diff = $now->diff($createdAt);
                                
                                if ($diff->days == 0) {
                                    $dateStr = 'Hoje às ' . $createdAt->format('H:i');
                                } elseif ($diff->days == 1) {
                                    $dateStr = 'Ontem às ' . $createdAt->format('H:i');
                                } elseif ($diff->days < 7) {
                                    $dateStr = 'Há ' . $diff->days . ' dias';
                                } else {
                                    $dateStr = $createdAt->format('d/m/Y H:i');
                                }
                            }
                            ?>
                            <div class="activity-item d-flex align-items-center">
                                <div class="activity-icon bg-<?= $status === 'novo' ? 'info' : ($status === 'aprovado' ? 'success' : 'warning') ?> me-3">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?= htmlspecialchars($curriculum->name ?? 'Sem nome') ?></h6>
                                    <p class="mb-0 text-muted small">
                                        <?= htmlspecialchars($curriculum->email ?? '') ?> • 
                                        <?= htmlspecialchars($curriculum->position ?? 'Cargo não especificado') ?>
                                    </p>
                                </div>
                                <div class="text-end">
                                    <span class="badge <?= $statusInfo['class'] ?> mb-1"><?= $statusInfo['label'] ?></span>
                                    <p class="mb-0 text-muted small"><?= $dateStr ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->end("container"); ?>

<?php $this->start("js"); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    $(document).ready(function() {
        // Gráfico de Currículos
        const ctx = document.getElementById('curriculumsChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?= json_encode($chartData['labels'] ?? []) ?>,
                    datasets: [{
                        label: 'Currículos Recebidos',
                        data: <?= json_encode($chartData['data'] ?? []) ?>,
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }
    });
</script>
<?php $this->end("js"); ?>
