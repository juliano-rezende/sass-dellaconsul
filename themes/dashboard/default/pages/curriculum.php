<?php $this->layout("_theme"); ?>

<?php $this->start("css"); ?>
<style>
    /* Estilos para a modal de currículo */
    #viewCurriculumModal .modal-lg {
        max-width: 900px;
    }
    
    #viewCurriculumModal .modal-body {
        background-color: #f8f9fa;
    }
    
    /* Avatar Circle */
    .avatar-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    /* Info Item */
    .info-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem;
        background-color: #fff;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    
    .info-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    
    .info-icon {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    
    .info-content {
        flex-grow: 1;
        min-width: 0;
    }
    
    .info-content small {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        margin-bottom: 2px;
    }
    
    .info-content span {
        font-size: 0.95rem;
        word-break: break-word;
    }
    
    /* Card Styles */
    #viewCurriculumModal .card {
        border-radius: 12px;
        overflow: hidden;
    }
    
    #viewCurriculumModal .card-header {
        padding: 1rem 1.25rem;
        background: linear-gradient(135deg, #f0f7ff 0%, #e0f0ff 100%);
        border: none;
        border-bottom: 2px solid #dbeafe;
    }
    
    #viewCurriculumModal .card-header h6 {
        color: #1e40af;
        font-size: 0.95rem;
    }
    
    #viewCurriculumModal .card-header i {
        color: #3b82f6;
    }
    
    #viewCurriculumModal .card-body {
        padding: 1.25rem;
    }
    
    /* Text Purple */
    .text-purple {
        color: #6f42c1 !important;
    }
    
    .bg-purple {
        background-color: #6f42c1 !important;
    }
    
    /* Badge Styles */
    #viewCurriculumModal .badge {
        padding: 0.5rem 1rem;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    
    /* File Viewer */
    #curriculumFileViewer iframe {
        width: 100%;
        min-height: 500px;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        background: white;
    }
    
    #curriculumModalTabs .nav-link.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* Tabs */
    #curriculumModalTabs .nav-link {
        border-radius: 8px 8px 0 0;
        font-weight: 600;
        color: #6c757d;
    }
    
    #curriculumModalTabs .nav-link.active {
        color: #2563eb;
        background-color: #f8f9fa;
    }

    /* Estilos para área de ações */
    #curriculumActionGroup {
        transition: all 0.3s ease;
    }

    #curriculumActionGroup button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    #curriculumActionGroup button:not(:disabled):hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    /* Animações */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    #viewCurriculumModal .card {
        animation: fadeInUp 0.3s ease;
    }
    
    @media (max-width: 768px) {
        #viewCurriculumModal .modal-lg {
            max-width: 95%;
        }
        
        #viewCurriculumModal .modal-body {
            padding: 1rem !important;
        }
        
        #curriculumFileViewer iframe {
            min-height: 400px;
        }

        #curriculumActionGroup .btn-group {
            flex-direction: column;
            width: 100%;
        }

        #curriculumActionGroup .btn-group button {
            width: 100%;
            margin-bottom: 0.25rem;
        }
        
        .avatar-circle {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }
        
        .info-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
    }
</style>
<?php $this->end("css"); ?>

<?php $this->start("container"); ?>

<!-- Page Content -->
<div class="dashboard-content">
    <!-- Stats Cards -->
    <div class="row mb-4 g-4">
        <?php
        $total = count($curriculums ?? []);
        $aprovados = count(array_filter($curriculums ?? [], fn($c) => ($c['status'] ?? '') === 'aprovado'));
        $emAnalise = count(array_filter($curriculums ?? [], fn($c) => ($c['status'] ?? '') === 'analise'));
        $entrevistas = count(array_filter($curriculums ?? [], fn($c) => ($c['status'] ?? '') === 'entrevista'));
        $novos = count(array_filter($curriculums ?? [], fn($c) => ($c['status'] ?? '') === 'novo'));
        ?>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-color: #2563eb; --card-color-light: #60a5fa;">
                <div class="stat-icon bg-primary">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $total ?></h3>
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
                    <h3><?= $novos ?></h3>
                    <p>Novos</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-color: #f59e0b; --card-color-light: #fbbf24;">
                <div class="stat-icon bg-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $emAnalise ?></h3>
                    <p>Em Análise</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-color: #10b981; --card-color-light: #34d399;">
                <div class="stat-icon bg-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $aprovados ?></h3>
                    <p>Aprovados</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="searchInput" class="form-label">Buscar Candidatos</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput" placeholder="Nome, email ou cargo...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="filterStatus" class="form-label">Status</label>
                    <select class="form-select" id="filterStatus">
                        <option value="">Todos os status</option>
                        <option value="novo">Novo</option>
                        <option value="analise">Em Análise</option>
                        <option value="aprovado">Aprovado</option>
                        <option value="reprovado">Reprovado</option>
                        <option value="entrevista">Entrevista Agendada</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="filterCargo" class="form-label">Áreas</label>
                    <select class="form-select" id="filterCargo">
                        <option value="">Todas as áreas</option>
                        <?php if (!empty($careerAreas)): ?>
                            <?php foreach ($careerAreas as $area): ?>
                                <option value="<?= $area['id'] ?>"><?= htmlspecialchars($area['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="filterDate" class="form-label">Data</label>
                    <select class="form-select" id="filterDate">
                        <option value="">Todas as datas</option>
                        <option value="hoje">Hoje</option>
                        <option value="semana">Esta semana</option>
                        <option value="mes">Este mês</option>
                        <option value="meses">Últimos 3 meses</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Currículos List -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>
                Lista de Currículos
            </h5>
        </div>
        
        <!-- Action Group - Sempre visível, botões desabilitados quando não há seleção -->
        <div id="curriculumActionGroup" class="card-body border-bottom bg-light">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <strong id="selectedCount">0</strong> currículo(s) selecionado(s)
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-sm btn-success" id="bulkApproveBtn" title="Aprovar Selecionados" disabled>
                        <i class="fas fa-check me-2"></i>Aprovar
                    </button>
                    <button type="button" class="btn btn-sm btn-warning" id="bulkInterviewBtn" title="Agendar Entrevista" disabled>
                        <i class="fas fa-calendar me-2"></i>Agendar Entrevista
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" id="bulkRejectBtn" title="Reprovar Selecionados" disabled>
                        <i class="fas fa-times me-2"></i>Reprovar
                    </button>
                    <button type="button" class="btn btn-sm btn-dark" id="bulkDeleteBtn" title="Deletar Selecionados" disabled>
                        <i class="fas fa-trash me-2"></i>Deletar
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs mb-4" id="curriculumTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">
                        <i class="fas fa-list me-2"></i>Todos
                        <span class="badge bg-secondary ms-2"><?= $total ?></span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="new-tab" data-bs-toggle="tab" data-bs-target="#new" type="button" role="tab" aria-controls="new" aria-selected="false">
                        <i class="fas fa-plus-circle me-2"></i>Novos
                        <span class="badge bg-info ms-2"><?= $novos ?></span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="analysis-tab" data-bs-toggle="tab" data-bs-target="#analysis" type="button" role="tab" aria-controls="analysis" aria-selected="false">
                        <i class="fas fa-clock me-2"></i>Em Análise
                        <span class="badge bg-warning ms-2"><?= $emAnalise ?></span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab" aria-controls="approved" aria-selected="false">
                        <i class="fas fa-check-circle me-2"></i>Aprovados
                        <span class="badge bg-success ms-2"><?= $aprovados ?></span>
                    </button>
                </li>
            </ul>

            <!-- Tabs Content -->
            <div class="tab-content" id="curriculumTabsContent">
                <?php 
                // Função helper para renderizar linha (definida antes das abas)
                $renderCurriculumRow = function($curriculum, $careerAreas) {
                    $status = $curriculum['status'] ?? 'novo';
                    $statusLabels = [
                        'novo' => ['label' => 'Novo', 'class' => 'bg-info'],
                        'analise' => ['label' => 'Em Análise', 'class' => 'bg-warning'],
                        'aprovado' => ['label' => 'Aprovado', 'class' => 'bg-success'],
                        'reprovado' => ['label' => 'Reprovado', 'class' => 'bg-danger'],
                        'entrevista' => ['label' => 'Entrevista', 'class' => 'bg-primary']
                    ];
                    $statusInfo = $statusLabels[$status] ?? ['label' => 'Desconhecido', 'class' => 'bg-secondary'];
                    
                    $createdAt = $curriculum['created_at'] ?? '';
                    if ($createdAt instanceof \DateTime) {
                        $createdAt = $createdAt->format('d/m/Y');
                    } elseif (is_string($createdAt)) {
                        $createdAt = date('d/m/Y', strtotime($createdAt));
                    }
                    
                    // Busca área de carreira
                    $careerAreaName = 'Não especificado';
                    if (!empty($curriculum['career_area_id']) && !empty($careerAreas)) {
                        foreach ($careerAreas as $area) {
                            if ($area['id'] == $curriculum['career_area_id']) {
                                $careerAreaName = $area['name'];
                                break;
                            }
                        }
                    }
                    ?>
                    <tr data-curriculum-id="<?= $curriculum['id'] ?>" data-status="<?= $status ?>" data-career-area="<?= $curriculum['career_area_id'] ?? '' ?>">
                        <td class="text-center">
                            <input type="checkbox" class="form-check-input" value="<?= $curriculum['id'] ?>">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-user-circle fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold"><?= htmlspecialchars($curriculum['name'] ?? 'Sem nome') ?></h6>
                                    <small class="text-muted"><?= htmlspecialchars($curriculum['email'] ?? '') ?></small>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-secondary"><?= htmlspecialchars($curriculum['position'] ?? $careerAreaName) ?></span>
                        </td>
                        <td class="text-center"><?= ($curriculum['experience_years'] ?? 0) ?> <?= ($curriculum['experience_years'] ?? 0) == 1 ? 'ano' : 'anos' ?></td>
                        <td class="text-center">
                            <span class="badge <?= $statusInfo['class'] ?>"><?= $statusInfo['label'] ?></span>
                        </td>
                        <td class="text-center"><?= $createdAt ?></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-primary" 
                                    title="Visualizar"
                                    onclick="viewCurriculum(<?= $curriculum['id'] ?>)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <?php
                };
                ?>
                
                <!-- Tab: Todos -->
                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">
                                    <input type="checkbox" class="form-check-input selectAllCheckbox">
                                </th>
                                <th style="width: 280px;">Candidato</th>
                                <th class="text-center" style="width: 150px;">Cargo</th>
                                <th class="text-center" style="width: 120px;">Experiência</th>
                                <th class="text-center" style="width: 130px;">Status</th>
                                <th class="text-center" style="width: 140px;">Data de Envio</th>
                                <th class="text-center" style="width: 100px;">Ações</th>
                            </tr>
                            </thead>
                            <tbody class="curriculosTableBody" data-status-filter="">
                                <?php if (empty($curriculums)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Nenhum currículo cadastrado ainda.</p>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($curriculums as $curriculum): ?>
                                        <?php $renderCurriculumRow($curriculum, $careerAreas ?? []); ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab: Novos -->
                <div class="tab-pane fade" id="new" role="tabpanel" aria-labelledby="new-tab">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">
                                    <input type="checkbox" class="form-check-input selectAllCheckbox">
                                </th>
                                <th style="width: 280px;">Candidato</th>
                                <th class="text-center" style="width: 150px;">Cargo</th>
                                <th class="text-center" style="width: 120px;">Experiência</th>
                                <th class="text-center" style="width: 130px;">Status</th>
                                <th class="text-center" style="width: 140px;">Data de Envio</th>
                                <th class="text-center" style="width: 100px;">Ações</th>
                            </tr>
                            </thead>
                            <tbody class="curriculosTableBody" data-status-filter="novo">
                                <?php if (empty($curriculums) || $novos == 0): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Nenhum currículo novo.</p>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php 
                                    foreach ($curriculums as $curriculum) {
                                        if (($curriculum['status'] ?? '') === 'novo') {
                                            $renderCurriculumRow($curriculum, $careerAreas ?? []);
                                        }
                                    }
                                    ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab: Em Análise -->
                <div class="tab-pane fade" id="analysis" role="tabpanel" aria-labelledby="analysis-tab">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">
                                    <input type="checkbox" class="form-check-input selectAllCheckbox">
                                </th>
                                <th style="width: 280px;">Candidato</th>
                                <th class="text-center" style="width: 150px;">Cargo</th>
                                <th class="text-center" style="width: 120px;">Experiência</th>
                                <th class="text-center" style="width: 130px;">Status</th>
                                <th class="text-center" style="width: 140px;">Data de Envio</th>
                                <th class="text-center" style="width: 100px;">Ações</th>
                            </tr>
                            </thead>
                            <tbody class="curriculosTableBody" data-status-filter="analise">
                                <?php if (empty($curriculums) || $emAnalise == 0): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Nenhum currículo em análise.</p>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php 
                                    foreach ($curriculums as $curriculum) {
                                        if (($curriculum['status'] ?? '') === 'analise') {
                                            $renderCurriculumRow($curriculum, $careerAreas ?? []);
                                        }
                                    }
                                    ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab: Aprovados -->
                <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">
                                    <input type="checkbox" class="form-check-input selectAllCheckbox">
                                </th>
                                <th style="width: 280px;">Candidato</th>
                                <th class="text-center" style="width: 150px;">Cargo</th>
                                <th class="text-center" style="width: 120px;">Experiência</th>
                                <th class="text-center" style="width: 130px;">Status</th>
                                <th class="text-center" style="width: 140px;">Data de Envio</th>
                                <th class="text-center" style="width: 100px;">Ações</th>
                            </tr>
                            </thead>
                            <tbody class="curriculosTableBody" data-status-filter="aprovado">
                                <?php if (empty($curriculums) || $aprovados == 0): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Nenhum currículo aprovado.</p>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php 
                                    foreach ($curriculums as $curriculum) {
                                        if (($curriculum['status'] ?? '') === 'aprovado') {
                                            $renderCurriculumRow($curriculum, $careerAreas ?? []);
                                        }
                                    }
                                    ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination (só mostra se houver registros) -->
            <?php if (!empty($curriculums) && count($curriculums) > 0): ?>
                <nav aria-label="Navegação de páginas" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Anterior</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <?php if (count($curriculums) > 10): ?>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <?php endif; ?>
                        <li class="page-item">
                            <a class="page-link" href="#">Próximo</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal para Visualizar Currículo -->
<div class="modal fade" id="viewCurriculumModal" tabindex="-1" aria-labelledby="viewCurriculumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCurriculumModalLabel">
                    <i class="fas fa-user-circle me-2"></i>Detalhes do Currículo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Tabs para alternar entre informações e visualização do arquivo -->
                <ul class="nav nav-tabs mb-4" id="curriculumModalTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#curriculumInfo" type="button" role="tab" aria-controls="curriculumInfo" aria-selected="true">
                            <i class="fas fa-info-circle me-2"></i>Informações
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="file-tab" data-bs-toggle="tab" data-bs-target="#curriculumFile" type="button" role="tab" aria-controls="curriculumFile" aria-selected="false">
                            <i class="fas fa-file-pdf me-2"></i>Currículo
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="curriculumModalTabContent">
                    <!-- Tab: Informações -->
                    <div class="tab-pane fade show active" id="curriculumInfo" role="tabpanel" aria-labelledby="info-tab">
                        <div id="curriculumModalContent">
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Carregando...</span>
                                </div>
                                <p class="mt-3">Carregando informações...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Visualização do Arquivo -->
                    <div class="tab-pane fade" id="curriculumFile" role="tabpanel" aria-labelledby="file-tab">
                        <div id="curriculumFileViewer" style="min-height: 600px;">
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Carregando arquivo...</span>
                                </div>
                                <p class="mt-3">Carregando currículo...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <a id="viewCurriculumFileBtn" href="#" target="_blank" class="btn btn-outline-primary" style="display: none;">
                    <i class="fas fa-external-link-alt me-2"></i>Abrir em Nova Aba
                </a>
                <button type="button" class="btn btn-primary" id="downloadCurriculumBtn" style="display: none;">
                    <i class="fas fa-download me-2"></i>Download
                </button>
            </div>
        </div>
    </div>
</div>

<?php $this->end("container"); ?>

<?php $this->start("js"); ?>
<script>
    // Currículos specific JavaScript
    $(document).ready(function () {
        // Select all functionality (para cada tabela)
        $('.selectAllCheckbox').on('change', function () {
            const tableBody = $(this).closest('table').find('tbody');
            tableBody.find('.form-check-input').prop('checked', this.checked);
            updateActionGroup();
        });

        // Atualiza área de ações quando checkboxes mudam
        function updateActionGroup() {
            const selected = $('.curriculosTableBody .form-check-input:checked').length;
            const selectedCount = $('#selectedCount');
            const buttons = $('#bulkApproveBtn, #bulkInterviewBtn, #bulkRejectBtn, #bulkDeleteBtn');
            
            selectedCount.text(selected);
            
            if (selected > 0) {
                buttons.prop('disabled', false);
            } else {
                buttons.prop('disabled', true);
            }
        }

        // Listener para checkboxes individuais
        $(document).on('change', '.curriculosTableBody .form-check-input', function() {
            updateActionGroup();
            
            // Atualiza o "select all" baseado na seleção
            const table = $(this).closest('table');
            const totalCheckboxes = table.find('tbody .form-check-input').length;
            const checkedCheckboxes = table.find('tbody .form-check-input:checked').length;
            table.find('.selectAllCheckbox').prop('checked', totalCheckboxes === checkedCheckboxes && totalCheckboxes > 0);
        });

        // Função para obter IDs selecionados
        function getSelectedIds() {
            const ids = [];
            $('.curriculosTableBody .form-check-input:checked').each(function() {
                ids.push($(this).val());
            });
            return ids;
        }

        // Ação em lote: Aprovar
        $('#bulkApproveBtn').on('click', function() {
            const ids = getSelectedIds();
            if (ids.length === 0) {
                if (typeof showToast !== 'undefined') {
                    showToast('Selecione pelo menos um currículo', 'warning');
                }
                return;
            }

            showConfirm(`Tem certeza que deseja aprovar ${ids.length} currículo(s)?`, function() {
                let completed = 0;
                let failed = 0;

                ids.forEach(function(id) {
                const formData = new FormData();
                formData.append('id', id);
                formData.append('action', 'approve');

                $.ajax({
                    url: '<?= urlBase("dashboard/curriculos/update") ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        completed++;
                        if (completed + failed === ids.length) {
                            if (typeof showToast !== 'undefined') {
                                showToast(`${completed} currículo(s) aprovado(s) com sucesso!`, 'success');
                            }
                            setTimeout(() => location.reload(), 1000);
                        }
                    },
                    error: function() {
                        failed++;
                        if (completed + failed === ids.length) {
                            if (typeof showToast !== 'undefined') {
                                showToast(`${completed} aprovado(s), ${failed} erro(s)`, failed > 0 ? 'error' : 'success');
                            }
                            setTimeout(() => location.reload(), 1000);
                        }
                    }
                });
            });
            });
        });

        // Ação em lote: Agendar Entrevista
        $('#bulkInterviewBtn').on('click', function() {
            const ids = getSelectedIds();
            if (ids.length === 0) {
                if (typeof showToast !== 'undefined') {
                    showToast('Selecione pelo menos um currículo', 'warning');
                }
                return;
            }

            showConfirm(`Tem certeza que deseja agendar entrevista para ${ids.length} currículo(s)?`, function() {
                let completed = 0;
                let failed = 0;

            ids.forEach(function(id) {
                const formData = new FormData();
                formData.append('id', id);
                formData.append('action', 'interview');

                $.ajax({
                    url: '<?= urlBase("dashboard/curriculos/update") ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        completed++;
                        if (completed + failed === ids.length) {
                            if (typeof showToast !== 'undefined') {
                                showToast(`${completed} entrevista(s) agendada(s) com sucesso!`, 'success');
                            }
                            setTimeout(() => location.reload(), 1000);
                        }
                    },
                    error: function() {
                        failed++;
                        if (completed + failed === ids.length) {
                            if (typeof showToast !== 'undefined') {
                                showToast(`${completed} agendada(s), ${failed} erro(s)`, failed > 0 ? 'error' : 'success');
                            }
                            setTimeout(() => location.reload(), 1000);
                        }
                    }
                });
            });
            });
        });

        // Ação em lote: Reprovar
        $('#bulkRejectBtn').on('click', function() {
            const ids = getSelectedIds();
            if (ids.length === 0) {
                if (typeof showToast !== 'undefined') {
                    showToast('Selecione pelo menos um currículo', 'warning');
                }
                return;
            }

            showConfirm(`Tem certeza que deseja reprovar ${ids.length} currículo(s)?`, function() {
                let completed = 0;
                let failed = 0;

                ids.forEach(function(id) {
                const formData = new FormData();
                formData.append('id', id);
                formData.append('action', 'reject');

                $.ajax({
                    url: '<?= urlBase("dashboard/curriculos/update") ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        completed++;
                        if (completed + failed === ids.length) {
                            if (typeof showToast !== 'undefined') {
                                showToast(`${completed} currículo(s) reprovado(s)!`, 'error');
                            }
                            setTimeout(() => location.reload(), 1000);
                        }
                    },
                    error: function() {
                        failed++;
                        if (completed + failed === ids.length) {
                            if (typeof showToast !== 'undefined') {
                                showToast(`${completed} reprovado(s), ${failed} erro(s)`, failed > 0 ? 'error' : 'error');
                            }
                            setTimeout(() => location.reload(), 1000);
                        }
                    }
                });
            });
            });
        });

        // Ação em lote: Deletar
        $('#bulkDeleteBtn').on('click', function() {
            const ids = getSelectedIds();
            if (ids.length === 0) {
                if (typeof showToast !== 'undefined') {
                    showToast('Selecione pelo menos um currículo', 'warning');
                }
                return;
            }

            showConfirm(`Tem certeza que deseja deletar ${ids.length} currículo(s)? Esta ação não pode ser desfeita.`, function() {
                let completed = 0;
                let failed = 0;

                ids.forEach(function(id) {
                const formData = new FormData();
                formData.append('id', id);

                $.ajax({
                    url: '<?= urlBase("dashboard/curriculos/delete") ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        completed++;
                        if (completed + failed === ids.length) {
                            if (typeof showToast !== 'undefined') {
                                showToast(`${completed} currículo(s) deletado(s) com sucesso!`, 'success');
                            }
                            setTimeout(() => location.reload(), 1000);
                        }
                    },
                    error: function() {
                        failed++;
                        if (completed + failed === ids.length) {
                            if (typeof showToast !== 'undefined') {
                                showToast(`${completed} deletado(s), ${failed} erro(s)`, failed > 0 ? 'error' : 'success');
                            }
                            setTimeout(() => location.reload(), 1000);
                        }
                    }
                });
            });
            });
        });


        // Função para visualizar currículo
        window.viewCurriculum = function(id) {
            // Abre a modal
            const modalElement = document.getElementById('viewCurriculumModal');
            if (!modalElement) {
                showToast('Modal não encontrada', 'error');
                return;
            }
            
            const modal = new bootstrap.Modal(modalElement);
            modal.show();

            // Mostra loading
            $('#curriculumModalContent').html(`
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                    <p class="mt-3">Carregando informações...</p>
                </div>
            `);
            $('#curriculumFileViewer').html(`
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                    <p class="mt-3">Carregando currículo...</p>
                </div>
            `);
            $('#viewCurriculumFileBtn').hide();
            $('#downloadCurriculumBtn').hide();
            $('#file-tab').addClass('disabled');

            // Busca dados do currículo
            $.ajax({
                url: '<?= urlBase("dashboard/curriculos/get") ?>/' + id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    let result = typeof response === 'string' ? JSON.parse(response) : response;
                    
                    if (result.success && result.data) {
                        const data = result.data;
                        
                        // Formata data
                        let createdAt = data.created_at || '';
                        if (createdAt) {
                            const date = new Date(createdAt);
                            createdAt = date.toLocaleDateString('pt-BR') + ' ' + date.toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'});
                        }

                        // Status badge
                        const statusLabels = {
                            'novo': {label: 'Novo', class: 'bg-info'},
                            'analise': {label: 'Em Análise', class: 'bg-warning'},
                            'aprovado': {label: 'Aprovado', class: 'bg-success'},
                            'reprovado': {label: 'Reprovado', class: 'bg-danger'},
                            'entrevista': {label: 'Entrevista', class: 'bg-primary'}
                        };
                        const statusInfo = statusLabels[data.status] || {label: 'Desconhecido', class: 'bg-secondary'};

                        // Monta HTML do conteúdo com design melhorado
                        let html = `
                            <!-- Header Card -->
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="avatar-circle bg-primary bg-opacity-10 text-primary me-3">
                                                    <i class="fas fa-user fa-lg"></i>
                                                </div>
                                                <div>
                                                    <h4 class="mb-0 fw-bold">${escapeHtml(data.name || 'Sem nome')}</h4>
                                                    <p class="text-muted mb-0 small"><i class="fas fa-envelope me-1"></i>${escapeHtml(data.email || '')}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="badge ${statusInfo.class} px-3 py-2 fs-6">${statusInfo.label}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Dados de Contato -->
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0 fw-semibold"><i class="fas fa-address-card me-2"></i>Dados de Contato</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <div class="info-icon bg-info bg-opacity-10 text-info">
                                                    <i class="fas fa-phone"></i>
                                                </div>
                                                <div class="info-content">
                                                    <small class="text-muted d-block">Telefone</small>
                                                    <span class="fw-medium">${escapeHtml(data.phone || 'Não informado')}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <div class="info-icon bg-success bg-opacity-10 text-success">
                                                    <i class="fas fa-briefcase"></i>
                                                </div>
                                                <div class="info-content">
                                                    <small class="text-muted d-block">Cargo Pretendido</small>
                                                    <span class="fw-medium">${escapeHtml(data.position || 'Não especificado')}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informações Profissionais -->
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0 fw-semibold"><i class="fas fa-user-tie me-2"></i>Informações Profissionais</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <div class="info-icon bg-warning bg-opacity-10 text-warning">
                                                    <i class="fas fa-building"></i>
                                                </div>
                                                <div class="info-content">
                                                    <small class="text-muted d-block">Área de Carreira</small>
                                                    <span class="fw-medium">${escapeHtml(data.career_area ? data.career_area.name : 'Não especificado')}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <div class="info-icon bg-purple bg-opacity-10 text-purple">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </div>
                                                <div class="info-content">
                                                    <small class="text-muted d-block">Experiência</small>
                                                    <span class="fw-medium">${data.experience_years || 0} ${(data.experience_years || 0) == 1 ? 'ano' : 'anos'}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informações do Envio -->
                            <div class="card border-0 shadow-sm">
                                <div class="card-header">
                                    <h6 class="mb-0 fw-semibold"><i class="fas fa-info-circle me-2"></i>Informações do Envio</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <div class="info-icon bg-secondary bg-opacity-10 text-secondary">
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                                <div class="info-content">
                                                    <small class="text-muted d-block">Data de Envio</small>
                                                    <span class="fw-medium">${createdAt || 'Não informado'}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <div class="info-icon ${data.file_path ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger'}">
                                                    <i class="fas fa-file-pdf"></i>
                                                </div>
                                                <div class="info-content">
                                                    <small class="text-muted d-block">Status do Arquivo</small>
                                                    <span class="fw-medium ${data.file_path ? 'text-success' : 'text-danger'}">
                                                        ${data.file_path ? '<i class="fas fa-check-circle me-1"></i>Arquivo anexado' : '<i class="fas fa-times-circle me-1"></i>Nenhum arquivo'}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        // Adiciona mensagem se houver
                        if (data.message) {
                            html += `
                                <div class="card border-0 shadow-sm mt-3">
                                    <div class="card-header">
                                        <h6 class="mb-0 fw-semibold text-white"><i class="fas fa-comment-dots me-2"></i>Mensagem do Candidato</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-light mb-0" role="alert" style="background-color: #f8f9fa; border-left: 4px solid #2563eb;">
                                            <i class="fas fa-quote-left text-primary me-2"></i>
                                            <span style="white-space: pre-wrap;">${escapeHtml(data.message)}</span>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }

                        $('#curriculumModalContent').html(html);

                        // Configura visualização do arquivo
                        if (data.file_path) {
                            // O path já vem como 'public/arquivos/curriculuns/...'
                            // Constrói URL completa usando URL_BASE
                            const baseUrl = '<?= URL_BASE ?>';
                            // Remove barra inicial se existir
                            let filePath = data.file_path.startsWith('/') ? data.file_path.substring(1) : data.file_path;
                            // Garante que não tenha barras duplicadas
                            const fileUrl = baseUrl + (baseUrl.endsWith('/') ? '' : '/') + filePath;
                            
                            console.log('File path:', data.file_path);
                            console.log('Base URL:', baseUrl);
                            console.log('Final URL:', fileUrl);
                            
                            // Carrega o PDF no iframe
                            const fileViewer = `
                                <div style="width: 100%; height: 500px; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                                    <iframe 
                                        src="${fileUrl}" 
                                        style="width: 100%; height: 100%; border: none;"
                                        type="application/pdf"
                                        title="Visualização do Currículo">
                                        <p class="p-3">Seu navegador não suporta visualização de PDF. Use os botões abaixo para abrir ou baixar o arquivo.</p>
                                    </iframe>
                                </div>
                            `;
                            $('#curriculumFileViewer').html(fileViewer);
                            
                            // Mostra botões no footer
                            $('#viewCurriculumFileBtn').attr('href', fileUrl).show();
                            $('#downloadCurriculumBtn').attr('onclick', `window.location.href='${fileUrl}'`).show();
                            
                            // Habilita a aba de arquivo
                            $('#file-tab').removeClass('disabled');
                        } else {
                            // Sem arquivo
                            $('#curriculumFileViewer').html(`
                                <div class="text-center py-5">
                                    <i class="fas fa-file-times fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Nenhum arquivo de currículo disponível.</p>
                                </div>
                            `);
                            $('#viewCurriculumFileBtn').hide();
                            $('#downloadCurriculumBtn').hide();
                            $('#file-tab').addClass('disabled');
                        }
                    } else {
                        $('#curriculumModalContent').html(`
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                ${result.message || 'Erro ao carregar dados do currículo'}
                            </div>
                        `);
                    }
                },
                error: function(xhr) {
                    let message = 'Erro ao carregar currículo';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        message = response.message || message;
                    } catch(e) {}
                    
                    $('#curriculumModalContent').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            ${message}
                        </div>
                    `);
                }
            });
        };

        // Função helper para escapar HTML
        function escapeHtml(text) {
            if (!text) return '';
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.toString().replace(/[&<>"']/g, m => map[m]);
        }

        // ============================================
        // FILTROS E BUSCA DE CURRÍCULOS
        // ============================================

        // Função para aplicar todos os filtros
        function applyFilters() {
            const searchTerm = $('#searchInput').val().toLowerCase();
            const statusFilter = $('#filterStatus').val();
            const cargoFilter = $('#filterCargo').val();
            const dateFilter = $('#filterDate').val();
            
            // Obtém a aba ativa atual
            const activeTab = $('.tab-pane.active');
            const tableBody = activeTab.find('.curriculosTableBody');
            const rows = tableBody.find('tr[data-curriculum-id]');
            
            let visibleCount = 0;
            
            rows.each(function() {
                const row = $(this);
                const rowText = row.text().toLowerCase();
                const rowStatus = row.data('status');
                const rowCareerArea = row.data('career-area');
                const rowDate = row.find('td:nth-last-child(2)').text().trim(); // Data de envio
                
                // Aplica filtros
                let matchesSearch = !searchTerm || rowText.includes(searchTerm);
                let matchesStatus = !statusFilter || rowStatus === statusFilter;
                let matchesCareerArea = !cargoFilter || rowCareerArea == cargoFilter;
                let matchesDate = !dateFilter || checkDateFilter(rowDate, dateFilter);
                
                // Mostra ou esconde a linha
                if (matchesSearch && matchesStatus && matchesCareerArea && matchesDate) {
                    row.show();
                    visibleCount++;
                } else {
                    row.hide();
                }
            });
            
            // Remove mensagem de "nenhum currículo" se houver linhas
            const emptyRow = tableBody.find('tr:not([data-curriculum-id])');
            if (rows.length > 0) {
                emptyRow.hide();
                
                // Se não houver resultados visíveis, mostra mensagem de filtro vazio
                if (visibleCount === 0) {
                    if (tableBody.find('.filter-empty-message').length === 0) {
                        tableBody.append(`
                            <tr class="filter-empty-message">
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Nenhum currículo encontrado com os filtros aplicados.</p>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="clearFilters()">
                                        <i class="fas fa-times me-2"></i>Limpar Filtros
                                    </button>
                                </td>
                            </tr>
                        `);
                    }
                    tableBody.find('.filter-empty-message').show();
                } else {
                    tableBody.find('.filter-empty-message').remove();
                }
            } else {
                emptyRow.show();
            }
        }
        
        // Função para verificar filtro de data
        function checkDateFilter(dateStr, filter) {
            if (!filter || !dateStr) return true;
            
            try {
                // Converte string dd/mm/yyyy para Date
                const parts = dateStr.split('/');
                if (parts.length !== 3) return true;
                
                const rowDate = new Date(parts[2], parts[1] - 1, parts[0]);
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                
                switch(filter) {
                    case 'hoje':
                        const todayStr = rowDate.toDateString();
                        return todayStr === today.toDateString();
                    
                    case 'semana':
                        const weekAgo = new Date(today);
                        weekAgo.setDate(today.getDate() - 7);
                        return rowDate >= weekAgo && rowDate <= today;
                    
                    case 'mes':
                        const monthAgo = new Date(today);
                        monthAgo.setMonth(today.getMonth() - 1);
                        return rowDate >= monthAgo && rowDate <= today;
                    
                    case 'meses':
                        const threeMonthsAgo = new Date(today);
                        threeMonthsAgo.setMonth(today.getMonth() - 3);
                        return rowDate >= threeMonthsAgo && rowDate <= today;
                    
                    default:
                        return true;
                }
            } catch(e) {
                console.error('Erro ao processar data:', e);
                return true;
            }
        }
        
        // Função para limpar todos os filtros
        window.clearFilters = function() {
            $('#searchInput').val('');
            $('#filterStatus').val('');
            $('#filterCargo').val('');
            $('#filterDate').val('');
            applyFilters();
        };
        
        // Event listeners para os filtros
        $('#searchInput').on('keyup', function() {
            applyFilters();
        });
        
        $('#filterStatus').on('change', function() {
            applyFilters();
        });
        
        $('#filterCargo').on('change', function() {
            applyFilters();
        });
        
        $('#filterDate').on('change', function() {
            applyFilters();
        });
        
        // Quando trocar de aba, reaplica os filtros
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            applyFilters();
        });
        
        // ============================================
        // CARDS CLICÁVEIS (FILTRO RÁPIDO)
        // ============================================
        
        // Torna os cards de estatísticas clicáveis para filtrar
        $('.stat-card').on('click', function() {
            const card = $(this);
            const icon = card.find('.stat-icon i');
            
            // Remove destaque de todos os cards
            $('.stat-card').removeClass('border border-primary');
            
            // Limpa filtros
            $('#searchInput').val('');
            $('#filterCargo').val('');
            $('#filterDate').val('');
            
            // Identifica qual card foi clicado e aplica o filtro correspondente
            if (icon.hasClass('fa-file-alt')) {
                // Total - mostra todos
                $('#filterStatus').val('');
                card.addClass('border border-primary');
            } else if (icon.hasClass('fa-plus-circle')) {
                // Novos
                $('#filterStatus').val('novo');
                card.addClass('border border-primary');
            } else if (icon.hasClass('fa-clock')) {
                // Em Análise
                $('#filterStatus').val('analise');
                card.addClass('border border-primary');
            } else if (icon.hasClass('fa-check-circle')) {
                // Aprovados
                $('#filterStatus').val('aprovado');
                card.addClass('border border-primary');
            }
            
            // Muda para a aba "Todos" e aplica o filtro
            $('#all-tab').tab('show');
            applyFilters();
        });
        
        // Adiciona cursor pointer nos cards
        $('.stat-card').css('cursor', 'pointer');

    });
</script>
<?php $this->end("js"); ?>
