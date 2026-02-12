<?php $this->layout("_theme"); ?>

<?php $this->start("css"); ?>
<style>
    /* Page Header */
    .dashboard-content h4 {
        font-weight: 600;
        color: #1e293b;
    }
    
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
        font-size: 0.875rem;
    }
    
    .breadcrumb-item a {
        color: #64748b;
        text-decoration: none;
    }
    
    .breadcrumb-item a:hover {
        color: #2563eb;
    }
    
    .breadcrumb-item.active {
        color: #94a3b8;
    }
    
    /* Padding para modals */
    #userModal .modal-body,
    #permissionsModal .modal-body {
        padding: 2rem !important;
    }
    
    #userModal .modal-header,
    #permissionsModal .modal-header {
        padding: 1.5rem 2rem;
    }
    
    #userModal .modal-footer,
    #permissionsModal .modal-footer {
        padding: 1rem 2rem 1.5rem;
    }
</style>
<?php $this->end("css"); ?>

<?php $this->start("container"); ?>

<!-- Page Content -->
<div class="dashboard-content">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Gerenciamento de Usuários</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= urlBase('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Usuários</li>
                </ol>
            </nav>
        </div>
        <div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal" onclick="openUserModal()">
                <i class="fas fa-plus me-2"></i>
                Adicionar Novo Usuário
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4 g-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-color: #2563eb; --card-color-light: #60a5fa;">
                <div class="stat-icon bg-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $stats['total'] ?? 0 ?></h3>
                    <p>Total de Usuários</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-color: #10b981; --card-color-light: #34d399;">
                <div class="stat-icon bg-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $stats['active'] ?? 0 ?></h3>
                    <p>Ativos</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-color: #f59e0b; --card-color-light: #fbbf24;">
                <div class="stat-icon bg-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $stats['pending'] ?? 0 ?></h3>
                    <p>Pendentes</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-color: #0ea5e9; --card-color-light: #38bdf8;">
                <div class="stat-icon bg-info">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $stats['admins'] ?? 0 ?></h3>
                    <p>Administradores</p>
                </div>
            </div>
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
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="7" class="text-center">
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Nenhum usuário cadastrado ainda.
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php 
                        foreach ($users as $user): 
                            // Define badge de role
                            $roleBadges = [
                                'admin' => 'bg-danger',
                                'manager' => 'bg-warning',
                                'operator' => 'bg-info',
                                'viewer' => 'bg-secondary'
                            ];
                            $roleBadge = $roleBadges[$user['role'] ?? 'viewer'] ?? 'bg-secondary';
                            
                            // Define badge de status
                            $statusBadges = [
                                'active' => 'bg-success',
                                'inactive' => 'bg-danger',
                                'pending' => 'bg-warning'
                            ];
                            $statusBadge = $statusBadges[$user['status'] ?? 'pending'] ?? 'bg-secondary';
                            
                            // Define labels
                            $roleLabels = [
                                'admin' => 'Administrador',
                                'manager' => 'Gerente',
                                'operator' => 'Operador',
                                'viewer' => 'Visualizador'
                            ];
                            $roleLabel = $roleLabels[$user['role'] ?? 'viewer'] ?? 'Visualizador';
                            
                            $statusLabels = [
                                'active' => 'Ativo',
                                'inactive' => 'Inativo',
                                'pending' => 'Pendente'
                            ];
                            $statusLabel = $statusLabels[$user['status'] ?? 'pending'] ?? 'Pendente';
                            
                            // Departamentos
                            $deptLabels = [
                                'administrativo' => 'Administrativo',
                                'financeiro' => 'Financeiro',
                                'manutencao' => 'Manutenção',
                                'seguranca' => 'Segurança',
                                'ti' => 'TI'
                            ];
                            $deptLabel = $deptLabels[$user['department'] ?? 'administrativo'] ?? ucfirst($user['department'] ?? '-');
                            
                            // Formata datas
                            if (!empty($user['created_at'])) {
                                $createdAt = $user['created_at'] instanceof \DateTime 
                                    ? $user['created_at']->format('d/m/Y')
                                    : date('d/m/Y', strtotime($user['created_at']));
                            } else {
                                $createdAt = '-';
                            }
                            
                            if (!empty($user['last_login'])) {
                                $lastLogin = $user['last_login'] instanceof \DateTime 
                                    ? $user['last_login']->format('d/m/Y H:i')
                                    : date('d/m/Y H:i', strtotime($user['last_login']));
                            } else {
                                $lastLogin = 'Nunca';
                            }
                        ?>
                        <tr data-user-id="<?= $user['id'] ?>">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">
                                        <?php if (!empty($user['avatar'])): ?>
                                            <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                        <?php else: ?>
                                            <i class="fas fa-user-circle fa-2x text-primary"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <h6 class="mb-0"><?= htmlspecialchars($user['name'] ?? 'Sem nome') ?></h6>
                                        <small class="text-muted">Criado em <?= $createdAt ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($user['email'] ?? '') ?></td>
                            <td><span class="badge <?= $roleBadge ?>"><?= $roleLabel ?></span></td>
                            <td><?= $deptLabel ?></td>
                            <td><span class="badge <?= $statusBadge ?>"><?= $statusLabel ?></span></td>
                            <td><?= $lastLogin ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-primary" title="Editar" onclick="editUser(<?= $user['id'] ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" title="Deletar" onclick="deleteUser(<?= $user['id'] ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
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

<!-- Modal Adicionar/Editar Usuário -->
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalTitle">
                    <i class="fas fa-user-plus me-2"></i>
                    Adicionar Novo Usuário
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="userForm" class="user-form">
                    <input type="hidden" id="userId" name="id" value="">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="userName" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control" id="userName" name="name" placeholder="Digite o nome completo" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="userEmail" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="userEmail" name="email" placeholder="Digite o e-mail" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="userRole" class="form-label">Perfil</label>
                            <select class="form-select" id="userRole" name="role" required>
                                <option value="">Selecione o perfil</option>
                                <option value="admin">Administrador</option>
                                <option value="manager">Gerente</option>
                                <option value="operator">Operador</option>
                                <option value="viewer">Visualizador</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="userDepartment" class="form-label">Departamento</label>
                            <select class="form-select" id="userDepartment" name="department" required>
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
                            <select class="form-select" id="userStatus" name="status" required>
                                <option value="active">Ativo</option>
                                <option value="inactive">Inativo</option>
                                <option value="pending">Pendente</option>
                            </select>
                        </div>
                    </div>

                    <div class="row" id="passwordFields">
                        <div class="col-md-6 mb-3">
                            <label for="userPassword" class="form-label">Senha <span id="passwordRequired">(obrigatório)</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="userPassword" name="password" placeholder="Digite a senha">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">Mínimo 6 caracteres</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="userConfirmPassword" class="form-label">Confirmar Senha</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="userConfirmPassword" name="password_confirm" placeholder="Confirme a senha">
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Perfil e Permissões</label>
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            As permissões são definidas automaticamente pelo <strong>Perfil</strong> selecionado acima.
                            <a href="#" data-bs-toggle="modal" data-bs-target="#permissionsModal">Ver matriz de permissões</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="userForm" class="btn btn-primary" id="btnSaveUser">
                    <i class="fas fa-save me-2"></i>
                    Salvar Usuário
                </button>
            </div>
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

            const userId = $('#userId').val();
            const isEdit = userId && userId !== '';
            const password = $('#userPassword').val();
            const confirmPassword = $('#userConfirmPassword').val();

            // Validação de senha
            if (!isEdit || password) {
                if (!isEdit && !password) {
                    showToast('A senha é obrigatória!', 'error');
                    return;
                }
                
                if (password && password !== confirmPassword) {
                    showToast('As senhas não coincidem!', 'error');
                    return;
                }

                if (password && password.length < 6) {
                    showToast('A senha deve ter pelo menos 6 caracteres!', 'error');
                    return;
                }
            }

            // Mostra loading
            const submitBtn = $('#btnSaveUser');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Salvando...');

            // Envia dados via AJAX
            const formData = new FormData(this);
            const url = isEdit ? '<?= urlBase("dashboard/usuarios/update"); ?>' : '<?= urlBase("dashboard/usuarios/create"); ?>';
            
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    submitBtn.prop('disabled', false).html(originalText);
                    
                    if (response.success) {
                        showToast(response.message || (isEdit ? 'Usuário atualizado com sucesso!' : 'Usuário criado com sucesso!'), 'success');
                        $('#userModal').modal('hide');
                        // Recarrega página após 1.5s para mostrar mudanças
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showToast(response.message, 'error');
                    }
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).html(originalText);
                    
                    let message = 'Erro ao salvar usuário';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        message = response.message || message;
                    } catch(e) {}
                    showToast(message, 'error');
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
                    const roleMap = {
                        'admin': 'administrador',
                        'manager': 'gerente',
                        'operator': 'operador',
                        'viewer': 'visualizador'
                    };
                    if (cardRole !== roleMap[role]) {
                        show = false;
                    }
                }

                if (status) {
                    const cardStatus = $(this).find('td:nth-child(5) .badge').text().toLowerCase();
                    const statusMap = {
                        'active': 'ativo',
                        'inactive': 'inativo',
                        'pending': 'pendente'
                    };
                    if (cardStatus !== statusMap[status]) {
                        show = false;
                    }
                }

                $(this).toggle(show);
            });
        }
    });

    // Função para abrir modal vazio (criar)
    window.openUserModal = function() {
        $('#userId').val('');
        $('#userForm')[0].reset();
        $('#userModalTitle').html('<i class="fas fa-user-plus me-2"></i>Adicionar Novo Usuário');
        $('#passwordRequired').text('(obrigatório)');
        $('#userPassword').prop('required', true);
        $('#userConfirmPassword').prop('required', true);
    };

    // Função para editar usuário
    window.editUser = function(id) {
        // Busca dados do usuário via AJAX
        const formData = new FormData();
        formData.append('id', id);
        
        $.ajax({
            url: '<?= urlBase("dashboard/usuarios/get"); ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success && response.user) {
                    const user = response.user;
                    
                    // Preenche formulário
                    $('#userId').val(user.id);
                    $('#userName').val(user.name || '');
                    $('#userEmail').val(user.email || '');
                    $('#userRole').val(user.role || 'viewer');
                    $('#userDepartment').val(user.department || 'administrativo');
                    $('#userStatus').val(user.status || 'pending');
                    
                    // Limpa campos de senha
                    $('#userPassword').val('').prop('required', false);
                    $('#userConfirmPassword').val('').prop('required', false);
                    
                    // Atualiza UI do modal
                    $('#userModalTitle').html('<i class="fas fa-edit me-2"></i>Editar Usuário');
                    $('#passwordRequired').text('(opcional - deixe em branco para manter)');
                    
                    // Abre modal
                    $('#userModal').modal('show');
                } else {
                    showToast(response.message || 'Erro ao buscar usuário', 'error');
                }
            },
            error: function() {
                showToast('Erro ao buscar dados do usuário', 'error');
            }
        });
    };

    // Função para deletar usuário
    window.deleteUser = function(id) {
        showConfirm('Tem certeza que deseja deletar este usuário?', function() {
            const formData = new FormData();
            formData.append('id', id);
            
            $.ajax({
                url: '<?= urlBase("dashboard/usuarios/delete"); ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showToast(response.message || 'Usuário deletado com sucesso!', 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showToast(response.message || 'Erro ao deletar usuário', 'error');
                    }
                },
                error: function() {
                    showToast('Erro ao deletar usuário', 'error');
                }
            });
        });
    };
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
