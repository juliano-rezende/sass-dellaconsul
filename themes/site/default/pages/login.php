<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Della Consul</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        
        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }
        
        .login-left {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-right {
            padding: 3rem;
        }
        
        .login-logo {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="row g-0">
                <!-- Left Side -->
                <div class="col-md-5 login-left">
                    <div class="login-logo">
                        <i class="fas fa-building"></i>
                        Della Consul
                    </div>
                    <h3>Bem-vindo de volta!</h3>
                    <p class="mb-4">Sistema de Gestão Condominial</p>
                    <div class="mt-5">
                        <i class="fas fa-shield-alt fa-3x mb-3"></i>
                        <p><small>Acesso seguro e criptografado</small></p>
                    </div>
                </div>
                
                <!-- Right Side - Login Form -->
                <div class="col-md-7 login-right">
                    <h4 class="mb-4">Fazer Login</h4>
                    
                    <?php if (isset($_SESSION['login_error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?= $_SESSION['login_error']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['login_error']); ?>
                    <?php endif; ?>
                    
                    <form id="loginForm">
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>E-mail
                            </label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email" 
                                   placeholder="seu@email.com" required autofocus>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Senha
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg" id="password" name="password" 
                                       placeholder="••••••••" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">
                                Lembrar-me
                            </label>
                        </div>
                        
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg btn-login">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Entrar
                            </button>
                        </div>
                        
                        <div class="text-center">
                            <small class="text-muted">
                                Credenciais padrão: admin@dellaconsul.com / admin123
                            </small>
                        </div>
                    </form>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <a href="<?= urlBase(); ?>" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-2"></i>
                            Voltar ao site
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Toggle password visibility
            $('#togglePassword').on('click', function() {
                const passwordInput = $('#password');
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
            $('#loginForm').on('submit', function(e) {
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
</body>
</html>
