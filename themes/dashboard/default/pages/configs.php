<?php $this->layout("_theme"); ?>

<?php $this->start("css"); ?>
<style>
    .system-info .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #e9ecef;
    }

    .system-info .info-item:last-child {
        border-bottom: none;
    }

    .system-info .label {
        font-weight: 500;
        color: #6c757d;
    }

    .system-info .value {
        font-weight: 600;
        color: #1e293b;
    }

    .backup-status .status-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.25rem 0;
    }

    .backup-status .label {
        font-weight: 500;
        color: #6c757d;
    }

    .backup-status .value {
        font-weight: 600;
        color: #1e293b;
    }

    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 500;
    }

    .nav-tabs .nav-link.active {
        color: #2563eb;
        border-bottom: 2px solid #2563eb;
        background: none;
    }

    .form-control-color {
        width: 100%;
        height: 38px;
    }
</style>
<?php $this->end("css"); ?>

<?php $this->start("container"); ?>

<!-- Page Content -->
<div class="dashboard-content">
    <!-- Settings Navigation -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                                <i class="fas fa-cog me-2"></i>Geral
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="appearance-tab" data-bs-toggle="tab" data-bs-target="#appearance" type="button" role="tab">
                                <i class="fas fa-palette me-2"></i>Aparência
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab">
                                <i class="fas fa-shield-alt me-2"></i>Segurança
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button" role="tab">
                                <i class="fas fa-bell me-2"></i>Notificações
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="backup-tab" data-bs-toggle="tab" data-bs-target="#backup" type="button" role="tab">
                                <i class="fas fa-database me-2"></i>Backup
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Content -->
    <div class="tab-content" id="settingsTabContent">
        <!-- General Settings -->
        <div class="tab-pane fade show active" id="general" role="tabpanel">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-cog me-2"></i>
                                Configurações Gerais
                            </h5>
                        </div>
                        <div class="card-body">
                            <form id="generalForm">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="companyName" class="form-label">Nome da Empresa</label>
                                        <input type="text" class="form-control" id="companyName" value="Della Consul">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="companyEmail" class="form-label">E-mail da Empresa</label>
                                        <input type="email" class="form-control" id="companyEmail" value="contato@dellaconsul.com">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="companyPhone" class="form-label">Telefone</label>
                                        <input type="tel" class="form-control" id="companyPhone" value="(11) 9999-9999">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="companyAddress" class="form-label">Endereço</label>
                                        <input type="text" class="form-control" id="companyAddress" value="Rua das Flores, 123 - Centro, São Paulo/SP">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="timezone" class="form-label">Fuso Horário</label>
                                        <select class="form-select" id="timezone">
                                            <option value="America/Sao_Paulo" selected>America/Sao_Paulo (GMT-3)</option>
                                            <option value="America/Manaus">America/Manaus (GMT-4)</option>
                                            <option value="America/Belem">America/Belem (GMT-3)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="language" class="form-label">Idioma</label>
                                        <select class="form-select" id="language">
                                            <option value="pt-BR" selected>Português (Brasil)</option>
                                            <option value="en-US">English (US)</option>
                                            <option value="es-ES">Español</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="dateFormat" class="form-label">Formato de Data</label>
                                        <select class="form-select" id="dateFormat">
                                            <option value="dd/mm/yyyy" selected>DD/MM/YYYY</option>
                                            <option value="mm/dd/yyyy">MM/DD/YYYY</option>
                                            <option value="yyyy-mm-dd">YYYY-MM-DD</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="currency" class="form-label">Moeda</label>
                                        <select class="form-select" id="currency">
                                            <option value="BRL" selected>Real (R$)</option>
                                            <option value="USD">Dólar ($)</option>
                                            <option value="EUR">Euro (€)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>
                                        Salvar Configurações
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Informações do Sistema
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="system-info">
                                <div class="info-item">
                                    <span class="label">Versão:</span>
                                    <span class="value">1.0.0</span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Última Atualização:</span>
                                    <span class="value">15/01/2024</span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Status:</span>
                                    <span class="badge bg-success">Online</span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Usuários Ativos:</span>
                                    <span class="value">10</span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Condomínios:</span>
                                    <span class="value">24</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Appearance Settings -->
        <div class="tab-pane fade" id="appearance" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-palette me-2"></i>
                        Configurações de Aparência
                    </h5>
                </div>
                <div class="card-body">
                    <form id="appearanceForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="theme" class="form-label">Tema</label>
                                <select class="form-select" id="theme">
                                    <option value="light" selected>Claro</option>
                                    <option value="dark">Escuro</option>
                                    <option value="auto">Automático</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="primaryColor" class="form-label">Cor Primária</label>
                                <input type="color" class="form-control form-control-color" id="primaryColor" value="#2563eb">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="sidebarPosition" class="form-label">Posição da Sidebar</label>
                                <select class="form-select" id="sidebarPosition">
                                    <option value="left" selected>Esquerda</option>
                                    <option value="right">Direita</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="sidebarBehavior" class="form-label">Comportamento da Sidebar</label>
                                <select class="form-select" id="sidebarBehavior">
                                    <option value="fixed" selected>Fixa</option>
                                    <option value="collapsible">Colapsável</option>
                                    <option value="overlay">Sobreposição</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Opções de Interface</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="showAnimations" checked>
                                        <label class="form-check-label" for="showAnimations">
                                            Mostrar Animações
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="showNotifications" checked>
                                        <label class="form-check-label" for="showNotifications">
                                            Notificações Toast
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="compactMode">
                                        <label class="form-check-label" for="compactMode">
                                            Modo Compacto
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Salvar Aparência
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Security Settings -->
        <div class="tab-pane fade" id="security" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-shield-alt me-2"></i>
                        Configurações de Segurança
                    </h5>
                </div>
                <div class="card-body">
                    <form id="securityForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="sessionTimeout" class="form-label">Timeout da Sessão (minutos)</label>
                                <input type="number" class="form-control" id="sessionTimeout" value="30" min="5" max="480">
                            </div>
                            <div class="col-md-6">
                                <label for="maxLoginAttempts" class="form-label">Tentativas Máximas de Login</label>
                                <input type="number" class="form-control" id="maxLoginAttempts" value="5" min="3" max="10">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="passwordMinLength" class="form-label">Tamanho Mínimo da Senha</label>
                                <input type="number" class="form-control" id="passwordMinLength" value="8" min="6" max="20">
                            </div>
                            <div class="col-md-6">
                                <label for="passwordExpiry" class="form-label">Expiração da Senha (dias)</label>
                                <input type="number" class="form-control" id="passwordExpiry" value="90" min="30" max="365">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Políticas de Senha</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="requireUppercase" checked>
                                        <label class="form-check-label" for="requireUppercase">
                                            Exigir Letra Maiúscula
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="requireLowercase" checked>
                                        <label class="form-check-label" for="requireLowercase">
                                            Exigir Letra Minúscula
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="requireNumbers" checked>
                                        <label class="form-check-label" for="requireNumbers">
                                            Exigir Números
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="requireSpecialChars">
                                        <label class="form-check-label" for="requireSpecialChars">
                                            Exigir Caracteres Especiais
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Autenticação</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="enable2FA">
                                        <label class="form-check-label" for="enable2FA">
                                            Habilitar 2FA (Autenticação em Duas Etapas)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="enableSSO">
                                        <label class="form-check-label" for="enableSSO">
                                            Habilitar SSO (Single Sign-On)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Salvar Segurança
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Notifications Settings -->
        <div class="tab-pane fade" id="notifications" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bell me-2"></i>
                        Configurações de Notificações
                    </h5>
                </div>
                <div class="card-body">
                    <form id="notificationsForm">
                        <div class="mb-3">
                            <label class="form-label">Notificações por E-mail</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="emailNewUser" checked>
                                        <label class="form-check-label" for="emailNewUser">
                                            Novo usuário cadastrado
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="emailNewCondominium" checked>
                                        <label class="form-check-label" for="emailNewCondominium">
                                            Novo condomínio cadastrado
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="emailMaintenance" checked>
                                        <label class="form-check-label" for="emailMaintenance">
                                            Manutenções agendadas
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="emailReports">
                                        <label class="form-check-label" for="emailReports">
                                            Relatórios mensais
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="emailAlerts" checked>
                                        <label class="form-check-label" for="emailAlerts">
                                            Alertas de segurança
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="emailSystem">
                                        <label class="form-check-label" for="emailSystem">
                                            Atualizações do sistema
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Notificações Push</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="pushNewUser" checked>
                                        <label class="form-check-label" for="pushNewUser">
                                            Novo usuário cadastrado
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="pushNewCondominium" checked>
                                        <label class="form-check-label" for="pushNewCondominium">
                                            Novo condomínio cadastrado
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="pushMaintenance" checked>
                                        <label class="form-check-label" for="pushMaintenance">
                                            Manutenções agendadas
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="pushAlerts" checked>
                                        <label class="form-check-label" for="pushAlerts">
                                            Alertas de segurança
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="notificationSound" class="form-label">Som de Notificação</label>
                                <select class="form-select" id="notificationSound">
                                    <option value="default" selected>Padrão</option>
                                    <option value="chime">Sino</option>
                                    <option value="bell">Sino</option>
                                    <option value="none">Sem Som</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="notificationPosition" class="form-label">Posição das Notificações</label>
                                <select class="form-select" id="notificationPosition">
                                    <option value="top-right" selected>Superior Direito</option>
                                    <option value="top-left">Superior Esquerdo</option>
                                    <option value="bottom-right">Inferior Direito</option>
                                    <option value="bottom-left">Inferior Esquerdo</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Salvar Notificações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Backup Settings -->
        <div class="tab-pane fade" id="backup" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-database me-2"></i>
                        Configurações de Backup
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <form id="backupForm">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="backupFrequency" class="form-label">Frequência de Backup</label>
                                        <select class="form-select" id="backupFrequency">
                                            <option value="daily" selected>Diário</option>
                                            <option value="weekly">Semanal</option>
                                            <option value="monthly">Mensal</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="backupTime" class="form-label">Horário do Backup</label>
                                        <input type="time" class="form-control" id="backupTime" value="02:00">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="backupRetention" class="form-label">Retenção de Backups (dias)</label>
                                        <input type="number" class="form-control" id="backupRetention" value="30" min="7" max="365">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="backupCompression" class="form-label">Compressão</label>
                                        <select class="form-select" id="backupCompression">
                                            <option value="gzip" selected>GZIP</option>
                                            <option value="zip">ZIP</option>
                                            <option value="none">Sem Compressão</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Opções de Backup</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="backupDatabase" checked>
                                                <label class="form-check-label" for="backupDatabase">
                                                    Banco de Dados
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="backupFiles" checked>
                                                <label class="form-check-label" for="backupFiles">
                                                    Arquivos
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="backupConfig" checked>
                                                <label class="form-check-label" for="backupConfig">
                                                    Configurações
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="backupLogs">
                                                <label class="form-check-label" for="backupLogs">
                                                    Logs do Sistema
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>
                                        Salvar Backup
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Ações de Backup</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-success" type="button">
                                            <i class="fas fa-download me-2"></i>
                                            Backup Manual
                                        </button>
                                        <button class="btn btn-info" type="button">
                                            <i class="fas fa-upload me-2"></i>
                                            Restaurar Backup
                                        </button>
                                        <button class="btn btn-warning" type="button">
                                            <i class="fas fa-sync me-2"></i>
                                            Verificar Integridade
                                        </button>
                                    </div>

                                    <hr>

                                    <div class="backup-status">
                                        <h6>Status do Último Backup</h6>
                                        <div class="status-item">
                                            <span class="label">Data:</span>
                                            <span class="value">15/01/2024 02:00</span>
                                        </div>
                                        <div class="status-item">
                                            <span class="label">Status:</span>
                                            <span class="badge bg-success">Concluído</span>
                                        </div>
                                        <div class="status-item">
                                            <span class="label">Tamanho:</span>
                                            <span class="value">2.5 GB</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->end("container"); ?>

<?php $this->start("js"); ?>
<script>
    // Configurações specific JavaScript
    $(document).ready(function() {
        // Form submissions
        $('#generalForm, #appearanceForm, #securityForm, #notificationsForm, #backupForm').on('submit', function(e) {
            e.preventDefault();
            const formName = $(this).attr('id').replace('Form', '');
            showToast(`Configurações de ${formName} salvas com sucesso!`, 'success');
        });

        // Theme change preview
        $('#theme').on('change', function() {
            const theme = $(this).val();
            showToast(`Tema alterado para: ${theme}`, 'info');
        });

        // Color picker change
        $('#primaryColor').on('change', function() {
            const color = $(this).val();
            showToast(`Cor primária alterada para: ${color}`, 'info');
        });

        // Backup actions
        $('.btn-success').on('click', function() {
            showToast('Iniciando backup manual...', 'info');
        });

        $('.btn-info').on('click', function() {
            showToast('Abrindo seletor de backup para restauração...', 'info');
        });

        $('.btn-warning').on('click', function() {
            showToast('Verificando integridade dos backups...', 'info');
        });
    });
</script>
<?php $this->end("js"); ?>
