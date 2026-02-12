<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dellaconsul - Conservadora.</title>

    <!-- Bootstrap CSS -->
    <link href="<?=urlBase(THEME_SITE ."/assets/bootstrap-5.3.7-dist/css/bootstrap.min.css");?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?=urlBase(THEME_SITE ."/assets/fontawesome-free-7.0.0-web/css/all.min.css");?>" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?=urlBase(THEME_SITE ."/assets/css/style.css");?>" rel="stylesheet">

    <!-- Import css -->
    <?php if ($this->section("css")):
        echo $this->section("css");
    endif;
    ?>
</head>
<body>
<!-- Navbar -->

<!-- section navbar -->
<?php if ($this->section("navbar")):
    echo $this->section("navbar");
else:?>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="<?=urlBase(THEME_SITE ."/assets/images/logo-bg-cz.png");?>" alt="Della Consul">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?=urlBase();?>#home">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=urlBase();?>#servicos">Serviços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=urlBase();?>#sobre">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=urlBase('contatos');?>">Contato</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=urlBase('clientes');?>">Área do Cliente</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=urlBase('area-segura');?>">Intranet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=urlBase('trabalhe-conosco');?>">Trabalhe Conosco</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php endif; ?>


<!-- Section container -->
<?php if ($this->section("container")):
    echo $this->section("container");
endif;
?>

<!-- section navbar -->
<?php if ($this->section("footer")):
    echo $this->section("footer");
else:?>
    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold mb-3">
                        Della Consul
                    </h5>
                    <p class="text-muted">
                        Especialistas em gestão condominial com mais de 15 anos de experiência no mercado.
                    </p>
                    <div class="social-links">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Serviços</h6>
                    <ul class="list-unstyled">
                        <li><a href="#servicos" class="text-muted text-decoration-none">Gestão Financeira</a></li>
                        <li><a href="#servicos" class="text-muted text-decoration-none">Manutenção</a></li>
                        <li><a href="#servicos" class="text-muted text-decoration-none">Segurança</a></li>
                        <li><a href="#servicos" class="text-muted text-decoration-none">Gestão Legal</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Empresa</h6>
                    <ul class="list-unstyled">
                        <li><a href="#sobre" class="text-muted text-decoration-none">Sobre Nós</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Equipe</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Carreiras</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Blog</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 mb-4">
                    <h6 class="fw-bold mb-3">Contato</h6>
                    <div class="d-flex mb-2">
                        <i class="fas fa-map-marker-alt me-2 mt-1"></i>
                        <span class="text-muted">Av.Carlos Chagas nº 516 - Cidade Nobre Ipatinga-MG, 3º Andar - Recepção 302</span>
                    </div>
                    <div class="d-flex mb-2">
                        <i class="fas fa-phone me-2 mt-1"></i>
                        <span class="text-muted">31 3826-3154 | 31 3827-7590</span>
                    </div>
                    <div class="d-flex mb-2">
                        <i class="fas fa-envelope me-2 mt-1"></i>
                        <span class="text-muted">contato@condominio.com</span>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">&copy; 2024 Della Consul. Todos os direitos reservados.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="<?=urlBase('politica-privacidade');?>" class="text-muted text-decoration-none me-3">Política de Privacidade</a>
                    <a href="<?=urlBase('termos-uso');?>" class="text-muted text-decoration-none">Termos de Uso</a>
                </div>
            </div>
        </div>
    </footer>
<?php endif; ?>

<!-- jQuery -->
<script src="<?=urlBase(THEME_SITE ."/assets/jquery/jquery-4.0.0.min.js");?>"></script>
<!-- Bootstrap JS -->
<script src="<?=urlBase(THEME_SITE ."/assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js");?>"></script>
<!-- Custom JS -->
<script src="<?=urlBase(THEME_SITE ."/assets/js/script.js");?>"></script>
<!-- Import js -->
<?php if ($this->section("js")):
    echo $this->section("js");
endif;
?>
</body>
</html>