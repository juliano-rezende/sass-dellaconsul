<?php $this->layout("_theme"); ?>

<?php $this->start("css"); ?>
<?php $this->end("css"); ?>

<?php $this->start("container"); ?>

    <!-- Separador Escuro -->
    <div class="client-separator-dark"></div>

    <!-- Hero Section -->
    <section class="intranet-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="intranet-title">
                        Intranet Corporativa
                    </h1>
                    <p class="intranet-subtitle">
                        Acesso exclusivo para colaboradores. Gerencie condomínios,
                        acompanhe processos e mantenha-se conectado com a equipe.
                    </p>
                    <div class="security-notice">
                        <i class="fas fa-shield-alt"></i>
                        <span>Acesso restrito apenas para funcionários autorizados</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login-card intranet-login">
                        <div class="login-header">
                            <h3>Acesso à Intranet</h3>
                            <p>Identificação de Colaborador</p>
                        </div>

                        <form id="intranetLoginForm" class="login-form">
                            <div class="form-group">
                                <label for="matricula">Usuario</label>
                                <input type="text" class="form-control" id="matricula" required>
                            </div>

                            <div class="form-group">
                                <label for="intranetPassword">Senha</label>
                                <div class="password-input">
                                    <input type="password" class="form-control" id="intranetPassword" required>
                                    <button type="button" class="password-toggle">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="intranetRemember">
                                <label class="form-check-label" for="intranetRemember">
                                    Manter conectado
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-lock me-2"></i>Acessar Sistema
                            </button>
                        </form>

                        <div class="login-footer">
                            <a href="#" class="forgot-password">Esqueceu sua senha?</a>
                            <p class="register-link">
                                Problemas de acesso? <a href="#" class="text-primary">Contate o TI</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Seção de Acesso Interno -->
    <section class="intranet-access-section">
        <div class="intranet-access-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="intranet-access-content">
                            <i class="fas fa-shield-alt intranet-access-icon"></i>
                            <h3>Acesso Restrito</h3>
                            <p>Área exclusiva para profissionais autorizados</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php $this->end("container"); ?>

<?php $this->start("js"); ?>
<?php $this->end("js"); ?>