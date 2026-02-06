<?php $this->layout("_theme"); ?>

<?php $this->start("css"); ?>
<style>
    /* Estilos para a modal de currículo */
    #viewCurriculumModal .modal-xl {
        max-width: 95%;
    }
    
    #curriculumFileViewer iframe {
        width: 100%;
        min-height: 600px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
    }
    
    #curriculumModalTabs .nav-link.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }
    
    @media (max-width: 768px) {
        #viewCurriculumModal .modal-xl {
            max-width: 100%;
        }
        
        #curriculumFileViewer iframe {
            min-height: 400px;
        }
    }
</style>
<?php $this->end("css"); ?>

<?php $this->start("container"); ?>

<!-- Page Content -->
<div class="dashboard-content">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <?php
        $total = count($curriculums ?? []);
        $aprovados = count(array_filter($curriculums ?? [], fn($c) => ($c['status'] ?? '') === 'aprovado'));
        $emAnalise = count(array_filter($curriculums ?? [], fn($c) => ($c['status'] ?? '') === 'analise'));
        $entrevistas = count(array_filter($curriculums ?? [], fn($c) => ($c['status'] ?? '') === 'entrevista'));
        $novos = count(array_filter($curriculums ?? [], fn($c) => ($c['status'] ?? '') === 'novo'));
        ?>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon bg-primary">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $total ?></h3>
                    <p>Total de Currículos</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon bg-info">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $novos ?></h3>
                    <p>Novos</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $emAnalise ?></h3>
                    <p>Em Análise</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card">
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
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-download me-2"></i>
                    Exportar
                </button>
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
                        <td>
                            <input type="checkbox" class="form-check-input" value="<?= $curriculum['id'] ?>">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar me-3">
                                    <i class="fas fa-user-circle fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0"><?= htmlspecialchars($curriculum['name'] ?? 'Sem nome') ?></h6>
                                    <small class="text-muted"><?= htmlspecialchars($curriculum['email'] ?? '') ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-secondary"><?= htmlspecialchars($curriculum['position'] ?? $careerAreaName) ?></span>
                        </td>
                        <td><?= ($curriculum['experience_years'] ?? 0) ?> <?= ($curriculum['experience_years'] ?? 0) == 1 ? 'ano' : 'anos' ?></td>
                        <td>
                            <span class="badge <?= $statusInfo['class'] ?>"><?= $statusInfo['label'] ?></span>
                        </td>
                        <td><?= $createdAt ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary" 
                                        title="Visualizar"
                                        onclick="viewCurriculum(<?= $curriculum['id'] ?>)">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <?php if ($status !== 'aprovado'): ?>
                                    <button class="btn btn-sm btn-outline-success" 
                                            title="Aprovar"
                                            onclick="approveCurriculum(<?= $curriculum['id'] ?>)">
                                        <i class="fas fa-check"></i>
                                    </button>
                                <?php endif; ?>
                                <button class="btn btn-sm btn-outline-warning" 
                                        title="Agendar Entrevista"
                                        onclick="scheduleInterview(<?= $curriculum['id'] ?>)">
                                    <i class="fas fa-calendar"></i>
                                </button>
                                <?php if ($status !== 'reprovado'): ?>
                                    <button class="btn btn-sm btn-outline-danger" 
                                            title="Reprovar"
                                            onclick="rejectCurriculum(<?= $curriculum['id'] ?>)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                <?php endif; ?>
                                <button class="btn btn-sm btn-outline-dark" 
                                        title="Deletar"
                                        onclick="deleteCurriculum(<?= $curriculum['id'] ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
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
                                <th>
                                    <input type="checkbox" class="form-check-input selectAllCheckbox">
                                </th>
                                <th>Candidato</th>
                                <th>Cargo</th>
                                <th>Experiência</th>
                                <th>Status</th>
                                <th>Data de Envio</th>
                                <th>Ações</th>
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
                                <th>
                                    <input type="checkbox" class="form-check-input selectAllCheckbox">
                                </th>
                                <th>Candidato</th>
                                <th>Cargo</th>
                                <th>Experiência</th>
                                <th>Status</th>
                                <th>Data de Envio</th>
                                <th>Ações</th>
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
                                <th>
                                    <input type="checkbox" class="form-check-input selectAllCheckbox">
                                </th>
                                <th>Candidato</th>
                                <th>Cargo</th>
                                <th>Experiência</th>
                                <th>Status</th>
                                <th>Data de Envio</th>
                                <th>Ações</th>
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
                                <th>
                                    <input type="checkbox" class="form-check-input selectAllCheckbox">
                                </th>
                                <th>Candidato</th>
                                <th>Cargo</th>
                                <th>Experiência</th>
                                <th>Status</th>
                                <th>Data de Envio</th>
                                <th>Ações</th>
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
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCurriculumModalLabel">
                    <i class="fas fa-user-circle me-2"></i>Detalhes do Currículo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tabs para alternar entre informações e visualização do arquivo -->
                <ul class="nav nav-tabs mb-3" id="curriculumModalTabs" role="tablist">
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
        });

        // Search functionality
        $('#searchInput').on('keyup', function () {
            const query = $(this).val().toLowerCase();
            $('#curriculosTableBody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(query) > -1);
            });
        });

        // Filter functionality
        $('#filterStatus, #filterCargo, #filterDate').on('change', function () {
            applyFilters();
        });

        function applyFilters() {
            const status = $('#filterStatus').val();
            const careerArea = $('#filterCargo').val();
            const date = $('#filterDate').val();

            $('#curriculosTableBody tr').each(function () {
                if ($(this).find('td').length === 1) {
                    // Linha de "nenhum currículo"
                    return;
                }
                
                let show = true;

                // Filtro por status
                if (status) {
                    const rowStatus = $(this).data('status');
                    if (rowStatus !== status) {
                        show = false;
                    }
                }

                // Filtro por área de carreira
                if (careerArea) {
                    const rowCareerArea = $(this).data('career-area');
                    if (rowCareerArea != careerArea) {
                        show = false;
                    }
                }

                // Filtro por data (TODO: implementar lógica de data)
                if (date) {
                    // Implementar filtro de data se necessário
                }

                $(this).toggle(show);
            });
        }

        // Função para visualizar currículo
        window.viewCurriculum = function(id) {
            // Abre a modal
            const modalElement = document.getElementById('viewCurriculumModal');
            if (!modalElement) {
                alert('Modal não encontrada');
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

                        // Monta HTML do conteúdo
                        let html = `
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">${escapeHtml(data.name || 'Sem nome')}</h5>
                                        <span class="badge ${statusInfo.class}">${statusInfo.label}</span>
                                    </div>
                                    <p class="text-muted mb-0">${escapeHtml(data.email || '')}</p>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong><i class="fas fa-phone me-2 text-primary"></i>Telefone:</strong>
                                    <p class="mb-0">${escapeHtml(data.phone || 'Não informado')}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong><i class="fas fa-briefcase me-2 text-primary"></i>Cargo:</strong>
                                    <p class="mb-0">${escapeHtml(data.position || (data.career_area ? data.career_area.name : 'Não especificado'))}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong><i class="fas fa-building me-2 text-primary"></i>Área de Carreira:</strong>
                                    <p class="mb-0">${escapeHtml(data.career_area ? data.career_area.name : 'Não especificado')}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong><i class="fas fa-calendar-alt me-2 text-primary"></i>Experiência:</strong>
                                    <p class="mb-0">${data.experience_years || 0} ${(data.experience_years || 0) == 1 ? 'ano' : 'anos'}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong><i class="fas fa-clock me-2 text-primary"></i>Data de Envio:</strong>
                                    <p class="mb-0">${createdAt || 'Não informado'}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong><i class="fas fa-file-alt me-2 text-primary"></i>Arquivo:</strong>
                                    <p class="mb-0">
                                        ${data.file_path ? '<i class="fas fa-check-circle text-success"></i> Arquivo anexado' : '<i class="fas fa-times-circle text-danger"></i> Nenhum arquivo'}
                                    </p>
                                </div>
                            </div>
                        `;

                        // Adiciona mensagem se houver
                        if (data.message) {
                            html += `
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <strong><i class="fas fa-comment me-2 text-primary"></i>Mensagem/Observações:</strong>
                                        <p class="mt-2 p-3 bg-light rounded">${escapeHtml(data.message)}</p>
                                    </div>
                                </div>
                            `;
                        }

                        $('#curriculumModalContent').html(html);

                        // Configura visualização do arquivo
                        if (data.file_path) {
                            // O path já vem como 'public/arquivos/curriculuns/...'
                            // Usa urlBase do PHP passando o path como parâmetro
                            // Como estamos no JavaScript, precisamos construir a URL manualmente
                            // mas usando o mesmo padrão do urlBase
                            const baseUrl = '<?= URL_BASE ?>';
                            const filePath = data.file_path.startsWith('/') ? data.file_path.substring(1) : data.file_path;
                            const fileUrl = baseUrl + '/' + filePath;
                            
                            // Carrega o PDF no iframe
                            const fileViewer = `
                                <div style="width: 100%; height: 600px; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                                    <iframe 
                                        src="${fileUrl}" 
                                        style="width: 100%; height: 100%; border: none;"
                                        type="application/pdf"
                                        title="Visualização do Currículo">
                                        <p>Seu navegador não suporta visualização de PDF. 
                                            <a href="${fileUrl}" target="_blank" class="btn btn-primary">
                                                <i class="fas fa-download me-2"></i>Baixar Currículo
                                            </a>
                                        </p>
                                    </iframe>
                                </div>
                                <div class="mt-3 text-center">
                                    <a href="${fileUrl}" target="_blank" class="btn btn-outline-primary me-2">
                                        <i class="fas fa-external-link-alt me-2"></i>Abrir em Nova Aba
                                    </a>
                                    <a href="${fileUrl}" download class="btn btn-outline-success">
                                        <i class="fas fa-download me-2"></i>Download
                                    </a>
                                </div>
                            `;
                            $('#curriculumFileViewer').html(fileViewer);
                            
                            // Mostra botões no footer
                            $('#viewCurriculumFileBtn').attr('href', fileUrl).show();
                            $('#downloadCurriculumBtn').attr('onclick', `window.open('${fileUrl}', '_blank')`).show();
                            
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

        // Função para aprovar currículo
        window.approveCurriculum = function(id) {
            if (!confirm('Tem certeza que deseja aprovar este candidato?')) {
                return;
            }

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
                    let result = typeof response === 'string' ? JSON.parse(response) : response;
                    if (result.success) {
                        if (typeof showToast !== 'undefined') {
                            showToast(result.message || 'Candidato aprovado com sucesso!', 'success');
                        } else {
                            alert(result.message || 'Candidato aprovado com sucesso!');
                        }
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        if (typeof showToast !== 'undefined') {
                            showToast(result.message || 'Erro ao aprovar candidato', 'error');
                        } else {
                            alert(result.message || 'Erro ao aprovar candidato');
                        }
                    }
                },
                error: function(xhr) {
                    let message = 'Erro ao aprovar candidato';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        message = response.message || message;
                    } catch(e) {}
                    if (typeof showToast !== 'undefined') {
                        showToast(message, 'error');
                    } else {
                        alert(message);
                    }
                }
            });
        };

        // Função para agendar entrevista
        window.scheduleInterview = function(id) {
            if (typeof showToast !== 'undefined') {
                showToast('Abrindo agenda para entrevista...', 'info');
            } else {
                alert('Abrindo agenda para entrevista...');
            }
            
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
                    let result = typeof response === 'string' ? JSON.parse(response) : response;
                    if (result.success) {
                        if (typeof showToast !== 'undefined') {
                            showToast(result.message || 'Entrevista agendada!', 'success');
                        } else {
                            alert(result.message || 'Entrevista agendada!');
                        }
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        if (typeof showToast !== 'undefined') {
                            showToast(result.message || 'Erro ao agendar entrevista', 'error');
                        } else {
                            alert(result.message || 'Erro ao agendar entrevista');
                        }
                    }
                },
                error: function(xhr) {
                    let message = 'Erro ao agendar entrevista';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        message = response.message || message;
                    } catch(e) {}
                    if (typeof showToast !== 'undefined') {
                        showToast(message, 'error');
                    } else {
                        alert(message);
                    }
                }
            });
        };

        // Função para reprovar currículo
        window.rejectCurriculum = function(id) {
            if (!confirm('Tem certeza que deseja reprovar este candidato?')) {
                return;
            }

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
                    let result = typeof response === 'string' ? JSON.parse(response) : response;
                    if (result.success) {
                        if (typeof showToast !== 'undefined') {
                            showToast(result.message || 'Candidato reprovado!', 'error');
                        } else {
                            alert(result.message || 'Candidato reprovado!');
                        }
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        if (typeof showToast !== 'undefined') {
                            showToast(result.message || 'Erro ao reprovar candidato', 'error');
                        } else {
                            alert(result.message || 'Erro ao reprovar candidato');
                        }
                    }
                },
                error: function(xhr) {
                    let message = 'Erro ao reprovar candidato';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        message = response.message || message;
                    } catch(e) {}
                    if (typeof showToast !== 'undefined') {
                        showToast(message, 'error');
                    } else {
                        alert(message);
                    }
                }
            });
        };

        // Função para deletar currículo
        window.deleteCurriculum = function(id) {
            if (!confirm('Tem certeza que deseja deletar este currículo? Esta ação não pode ser desfeita.')) {
                return;
            }

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
                    let result = typeof response === 'string' ? JSON.parse(response) : response;
                    if (result.success) {
                        if (typeof showToast !== 'undefined') {
                            showToast(result.message || 'Currículo deletado com sucesso!', 'success');
                        } else {
                            alert(result.message || 'Currículo deletado com sucesso!');
                        }
                        $(`[data-curriculum-id="${id}"]`).fadeOut(300, function() {
                            $(this).remove();
                            if ($('#curriculosTableBody tr').length === 0) {
                                $('#curriculosTableBody').html(`
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Nenhum currículo cadastrado ainda.</p>
                                        </td>
                                    </tr>
                                `);
                            }
                        });
                    } else {
                        if (typeof showToast !== 'undefined') {
                            showToast(result.message || 'Erro ao deletar currículo', 'error');
                        } else {
                            alert(result.message || 'Erro ao deletar currículo');
                        }
                    }
                },
                error: function(xhr) {
                    let message = 'Erro ao deletar currículo';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        message = response.message || message;
                    } catch(e) {}
                    if (typeof showToast !== 'undefined') {
                        showToast(message, 'error');
                    } else {
                        alert(message);
                    }
                }
            });
        };

        // Export functionality
        $('.btn-outline-primary').on('click', function () {
            if ($(this).find('i').hasClass('fa-download')) {
                showToast('Exportando currículos...', 'info');
            }
        });

        // New curriculum button
        $('.btn-primary').on('click', function () {
            if ($(this).find('i').hasClass('fa-plus')) {
                showToast('Abrindo formulário de novo currículo...', 'info');
            }
        });
    });
</script>
<?php $this->end("js"); ?>
