<?php $this->layout("_theme"); ?>

<?php $this->start("css"); ?>

<?php $this->end("css"); ?>

<?php $this->start("container"); ?>

<!-- Page Content -->
<div class="dashboard-content">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon bg-primary">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-info">
                    <h3>24</h3>
                    <p>Total de Currículos</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>8</h3>
                    <p>Aprovados</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3>12</h3>
                    <p>Em Análise</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon bg-info">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-info">
                    <h3>4</h3>
                    <p>Entrevistas Agendadas</p>
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
                    <label for="filterCargo" class="form-label">Areas</label>
                    <select class="form-select" id="filterCargo">
                        <option value="">Todos as areas</option>
                        <option value="1">Administrativa</option>
                        <option value="2">Manutenção predial</option>
                        <option value="3">Limpeza</option>
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
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th>Candidato</th>
                        <th>Cargo</th>
                        <th>Experiência</th>
                        <th>Status</th>
                        <th>Data de Envio</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody id="curriculosTableBody">
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar me-3">
                                    <i class="fas fa-user-circle fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Maria Silva Santos</h6>
                                    <small class="text-muted">maria.silva@email.com</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-primary">Zeladora</span>
                        </td>
                        <td>5 anos</td>
                        <td>
                            <span class="badge bg-success">Aprovada</span>
                        </td>
                        <td>15/01/2024</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success" title="Aprovar">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning" title="Agendar Entrevista">
                                    <i class="fas fa-calendar"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" title="Reprovar">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar me-3">
                                    <i class="fas fa-user-circle fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">João Carlos Oliveira</h6>
                                    <small class="text-muted">joao.oliveira@email.com</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-info">Porteiro</span>
                        </td>
                        <td>3 anos</td>
                        <td>
                            <span class="badge bg-warning">Em Análise</span>
                        </td>
                        <td>14/01/2024</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success" title="Aprovar">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning" title="Agendar Entrevista">
                                    <i class="fas fa-calendar"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" title="Reprovar">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar me-3">
                                    <i class="fas fa-user-circle fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Ana Paula Costa</h6>
                                    <small class="text-muted">ana.costa@email.com</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-secondary">Administradora</span>
                        </td>
                        <td>8 anos</td>
                        <td>
                            <span class="badge bg-info">Entrevista Agendada</span>
                        </td>
                        <td>13/01/2024</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success" title="Aprovar">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning" title="Agendar Entrevista">
                                    <i class="fas fa-calendar"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" title="Reprovar">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar me-3">
                                    <i class="fas fa-user-circle fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Pedro Henrique Lima</h6>
                                    <small class="text-muted">pedro.lima@email.com</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-warning">Manutenção</span>
                        </td>
                        <td>6 anos</td>
                        <td>
                            <span class="badge bg-danger">Reprovado</span>
                        </td>
                        <td>12/01/2024</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success" title="Aprovar">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning" title="Agendar Entrevista">
                                    <i class="fas fa-calendar"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" title="Reprovar">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Navegação de páginas">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Anterior</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Próximo</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php $this->end("container"); ?>

<?php $this->start("js"); ?>
<script>
    // Currículos specific JavaScript
    $(document).ready(function () {
        // Select all functionality
        $('#selectAll').on('change', function () {
            $('.form-check-input').prop('checked', this.checked);
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
            const cargo = $('#filterCargo').val();
            const date = $('#filterDate').val();

            $('#curriculosTableBody tr').each(function () {
                let show = true;

                if (status && $(this).find('.badge').text().toLowerCase() !== status.toLowerCase()) {
                    show = false;
                }

                if (cargo && $(this).find('td:nth-child(3) .badge').text().toLowerCase() !== cargo.toLowerCase()) {
                    show = false;
                }

                $(this).toggle(show);
            });
        }

        // Action buttons
        $(document).on('click', '.btn-outline-primary', function () {
            showToast('Visualizando currículo...', 'info');
        });

        $(document).on('click', '.btn-outline-success', function () {
            if (confirm('Tem certeza que deseja aprovar este candidato?')) {
                $(this).closest('tr').find('.badge').removeClass().addClass('badge bg-success').text('Aprovado');
                showToast('Candidato aprovado com sucesso!', 'success');
            }
        });

        $(document).on('click', '.btn-outline-warning', function () {
            showToast('Abrindo agenda para entrevista...', 'info');
        });

        $(document).on('click', '.btn-outline-danger', function () {
            if (confirm('Tem certeza que deseja reprovar este candidato?')) {
                $(this).closest('tr').find('.badge').removeClass().addClass('badge bg-danger').text('Reprovado');
                showToast('Candidato reprovado!', 'error');
            }
        });

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
