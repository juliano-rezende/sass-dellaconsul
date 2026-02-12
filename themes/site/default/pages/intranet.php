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

                        <form id="intranetLoginForm" class="login-form" action="<?= urlBase('auth/login'); ?>" method="POST">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="seu@email.com" required>
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
<script>
$(document).ready(function() {
    // Toggle password visibility
    $('.password-toggle').on('click', function() {
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

    // Login form submission
    $('#intranetLoginForm').on('submit', function(e) {
        e.preventDefault();
        
        const email = $('#email').val();
        const password = $('#password').val();
        const submitBtn = $(this).find('button[type="submit"]');
        
        // Desabilita botão
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Entrando...');
        
        $.ajax({
            url: '<?= urlBase("auth/login"); ?>',
            method: 'POST',
            data: { email, password },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Mostra mensagem de sucesso
                    showToast(response.message, 'success');
                    
                    // Redireciona após 500ms
                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 500);
                } else {
                    // Mostra erro
                    showToast(response.message, 'error');
                    
                    // Reabilita botão
                    submitBtn.prop('disabled', false).html('<i class="fas fa-sign-in-alt me-2"></i>Entrar');
                }
            },
            error: function() {
                const msg = 'Erro ao processar login. Tente novamente.';
                showToast(msg, 'error');
                
                // Reabilita botão
                submitBtn.prop('disabled', false).html('<i class="fas fa-sign-in-alt me-2"></i>Entrar');
            }
        });
    });
});
</script>
<?php $this->end("js"); ?>