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

                        <?php if (isset($_SESSION['login_error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?= $_SESSION['login_error']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php unset($_SESSION['login_error']); ?>
                        <?php endif; ?>

                        <form id="intranetLoginForm" class="login-form">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       placeholder="seu@email.com" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Senha</label>
                                <div class="password-input">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <button type="button" class="password-toggle">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    Manter conectado
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-lock me-2"></i>Acessar Sistema
                            </button>
                            
                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    Padrão: admin@dellaconsul.com / admin123
                                </small>
                            </div>
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
<script>
    $(document).ready(function() {
        // Toggle password visibility
        $('.password-toggle').on('click', function() {
            const passwordInput = $(this).siblings('input');
            const icon = $(this).find('i');
            
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordInput.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
        
        // Login form submission
        $('#intranetLoginForm').on('submit', function(e) {
            e.preventDefault();
            
            const btn = $(this).find('button[type="submit"]');
            const btnText = btn.html();
            
            // Desabilita botão
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Entrando...');
            
            $.ajax({
                url: '<?= urlBase("auth/login"); ?>',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        window.location.href = response.redirect;
                    } else {
                        alert(response.message);
                        btn.prop('disabled', false).html(btnText);
                    }
                },
                error: function() {
                    alert('Erro ao processar login. Tente novamente.');
                    btn.prop('disabled', false).html(btnText);
                }
            });
        });
    });
</script>
<?php $this->end("js"); ?>