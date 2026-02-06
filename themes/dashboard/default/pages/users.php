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
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>12</h3>
                    <p>Total de Usuários</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>10</h3>
                    <p>Ativos</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3>2</h3>
                    <p>Pendentes</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon bg-info">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="stat-info">
                    <h3>3</h3>
                    <p>Administradores</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Add New User Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-user-plus me-2"></i>
                Adicionar Novo Usuário
            </h5>
        </div>
        <div class="card-body">
            <form id="userForm" class="user-form">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="userName" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="userName" placeholder="Digite o nome completo" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="userEmail" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="userEmail" placeholder="Digite o e-mail" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="userRole" class="form-label">Perfil</label>
                        <select class="form-select" id="userRole" required>
                            <option value="">Selecione o perfil</option>
                            <option value="admin">Administrador</option>
                            <option value="manager">Gerente</option>
                            <option value="operator">Operador</option>
                            <option value="viewer">Visualizador</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="userDepartment" class="form-label">Departamento</label>
                        <select class="form-select" id="userDepartment" required>
                            <option value="">Selecione o departamento</option>
                            <option value="administrativo">Administrativo</option>
                            <option value="financeiro">Financeiro</option>
                            <option value="manutencao">Manutenção</option>
                            <option value="seguranca">Segurança</option>
                            <option value="ti">TI</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="userStatus" class="form-label">Status</label>
                        <select class="form-select" id="userStatus" required>
                            <option value="active">Ativo</option>
                            <option value="inactive">Inativo</option>
                            <option value="pending">Pendente</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="userPassword" class="form-label">Senha</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="userPassword" placeholder="Digite a senha" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="userConfirmPassword" class="form-label">Confirmar Senha</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="userConfirmPassword" placeholder="Confirme a senha" required>
                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Perfil e Permissões</label>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        As permissões são definidas automaticamente pelo <strong>Perfil</strong> selecionado acima.
                        <a href="#" data-bs-toggle="modal" data-bs-target="#permissionsModal">Ver matriz de permissões</a>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Salvar Usuário
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Users List Section -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>
                Lista de Usuários
            </h5>
            <div class="d-flex gap-2">
                <div class="input-group" style="width: 300px;">
                    <input type="text" class="form-control" placeholder="Buscar usuários..." id="searchInput">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <select class="form-select" style="width: 150px;" id="filterRole">
                    <option value="">Todos os perfis</option>
                    <option value="admin">Administrador</option>
                    <option value="manager">Gerente</option>
                    <option value="operator">Operador</option>
                    <option value="viewer">Visualizador</option>
                </select>
                <select class="form-select" style="width: 150px;" id="filterStatus">
                    <option value="">Todos os status</option>
                    <option value="active">Ativo</option>
                    <option value="inactive">Inativo</option>
                    <option value="pending">Pendente</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>E-mail</th>
                        <th>Perfil</th>
                        <th>Departamento</th>
                        <th>Status</th>
                        <th>Último Acesso</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody id="usersTableBody">
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3">
                                    <i class="fas fa-user-circle fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">João Silva</h6>
                                    <small class="text-muted">Criado em 15/01/2024</small>
                                </div>
                            </div>
                        </td>
                        <td>joao.silva@dellaconsul.com</td>
                        <td><span class="badge bg-danger">Administrador</span></td>
                        <td>TI</td>
                        <td><span class="badge bg-success">Ativo</span></td>
                        <td>Hoje, 14:30</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning" title="Resetar Senha">
                                    <i class="fas fa-key"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" title="Desativar">
                                    <i class="fas fa-ban"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3">
                                    <i class="fas fa-user-circle fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Maria Santos</h6>
                                    <small class="text-muted">Criado em 14/01/2024</small>
                                </div>
                            </div>
                        </td>
                        <td>maria.santos@dellaconsul.com</td>
                        <td><span class="badge bg-warning">Gerente</span></td>
                        <td>Administrativo</td>
                        <td><span class="badge bg-success">Ativo</span></td>
                        <td>Hoje, 12:15</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning" title="Resetar Senha">
                                    <i class="fas fa-key"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" title="Desativar">
                                    <i class="fas fa-ban"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3">
                                    <i class="fas fa-user-circle fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Pedro Costa</h6>
                                    <small class="text-muted">Criado em 13/01/2024</small>
                                </div>
                            </div>
                        </td>
                        <td>pedro.costa@dellaconsul.com</td>
                        <td><span class="badge bg-info">Operador</span></td>
                        <td>Manutenção</td>
                        <td><span class="badge bg-warning">Pendente</span></td>
                        <td>Nunca</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning" title="Resetar Senha">
                                    <i class="fas fa-key"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" title="Desativar">
                                    <i class="fas fa-ban"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3">
                                    <i class="fas fa-user-circle fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Ana Oliveira</h6>
                                    <small class="text-muted">Criado em 12/01/2024</small>
                                </div>
                            </div>
                        </td>
                        <td>ana.oliveira@dellaconsul.com</td>
                        <td><span class="badge bg-secondary">Visualizador</span></td>
                        <td>Financeiro</td>
                        <td><span class="badge bg-danger">Inativo</span></td>
                        <td>Ontem, 16:45</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning" title="Resetar Senha">
                                    <i class="fas fa-key"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success" title="Ativar">
                                    <i class="fas fa-check"></i>
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
    // Usuários specific JavaScript
    $(document).ready(function() {
        // Password toggle functionality
        $('#togglePassword, #toggleConfirmPassword').on('click', function() {
            const input = $(this).siblings('input');
            const icon = $(this).find('i');

            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        // Form submission
        $('#userForm').on('submit', function(e) {
            e.preventDefault();

            // Password validation
            const password = $('#userPassword').val();
            const confirmPassword = $('#userConfirmPassword').val();

            if (password !== confirmPassword) {
                showToast('As senhas não coincidem!', 'error');
                return;
            }

            if (password.length < 6) {
                showToast('A senha deve ter pelo menos 6 caracteres!', 'error');
                return;
            }

            // Envia dados via AJAX
            const formData = new FormData(this);
            
            $.ajax({
                url: '<?= urlBase("dashboard/usuarios/create"); ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showToast(response.message, 'success');
                        $('#userForm')[0].reset();
                        // Recarrega página após 1.5s para mostrar novo usuário
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showToast(response.message, 'error');
                    }
                },
                error: function() {
                    showToast('Erro ao criar usuário', 'error');
                }
            });
        });

        // Search functionality
        $('#searchInput').on('keyup', function() {
            const query = $(this).val().toLowerCase();
            $('#usersTableBody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(query) > -1);
            });
        });

        // Filter functionality
        $('#filterRole, #filterStatus').on('change', function() {
            applyFilters();
        });

        function applyFilters() {
            const role = $('#filterRole').val();
            const status = $('#filterStatus').val();

            $('#usersTableBody tr').each(function() {
                let show = true;

                if (role) {
                    const cardRole = $(this).find('td:nth-child(3) .badge').text().toLowerCase();
                    if (cardRole !== role.toLowerCase()) {
                        show = false;
                    }
                }

                if (status) {
                    const cardStatus = $(this).find('td:nth-child(5) .badge').text().toLowerCase();
                    if (cardStatus !== status.toLowerCase()) {
                        show = false;
                    }
                }

                $(this).toggle(show);
            });
        }

        // Action buttons
        $(document).on('click', '.btn-outline-primary', function() {
            showToast('Editando usuário...', 'info');
        });

        $(document).on('click', '.btn-outline-success', function() {
            if ($(this).find('i').hasClass('fa-eye')) {
                showToast('Visualizando usuário...', 'info');
            } else {
                showToast('Usuário ativado com sucesso!', 'success');
            }
        });

        $(document).on('click', '.btn-outline-warning', function() {
            if (confirm('Tem certeza que deseja resetar a senha deste usuário?')) {
                showToast('Senha resetada com sucesso!', 'success');
            }
        });

        $(document).on('click', '.btn-outline-danger', function() {
            if (confirm('Tem certeza que deseja desativar este usuário?')) {
                showToast('Usuário desativado com sucesso!', 'success');
            }
        });
    });
</script>

<!-- Modal Matriz de Permissões -->
<div class="modal fade" id="permissionsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-shield-alt me-2"></i>
                    Matriz de Permissões por Perfil
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Módulo</th>
                                <th>Administrador</th>
                                <th>Gerente</th>
                                <th>Operador</th>
                                <th>Visualizador</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $matrix = \App\Helpers\ACL::getPermissionsMatrix();
                            $modules = ['dashboard', 'sliders', 'curriculos', 'whatsapp', 'usuarios', 'configuracoes'];
                            
                            foreach ($modules as $module):
                            ?>
                                <tr>
                                    <td><strong><?= ucfirst($module); ?></strong></td>
                                    <?php foreach (['admin', 'manager', 'operator', 'viewer'] as $role): ?>
                                        <td>
                                            <?php
                                            $actions = $matrix[$role]['modules'][$module] ?? [];
                                            if (empty($actions)) {
                                                echo '<span class="text-muted">-</span>';
                                            } else {
                                                echo '<small>' . implode(', ', $actions) . '</small>';
                                            }
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->end("js"); ?>
