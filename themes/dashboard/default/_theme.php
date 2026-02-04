<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Della Consul Intranet</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom CSS -->
    <link href="<?= urlBase(THEME_DASHBOARD . "/assets/css/style.css"); ?>" rel="stylesheet">

    <!-- Import css -->
    <?php if ($this->section("css")):
        echo $this->section("css");
    endif;
    ?>
</head>
<body class="intranet-body">


<!-- section navbar -->
<?php if ($this->section("sidebar")):
    echo $this->section("sidebar");
else:?>
    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <div class="d-flex align-items-center">
                <img src="<?= urlBase(THEME_DASHBOARD . "/assets/images/logo-3d.jpeg"); ?>" alt="Della Consul"
                     height="20" width="40px" class="me-2">
                <span class="sidebar-title">Della Consul</span>
            </div>
        </div>

        <div class="sidebar-user">
            <div class="user-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="user-info">
                <h6 class="user-name">Darci</h6>
                <span class="user-role">Administrador</span>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-item">
                <a href="<?= urlBase("dashboard"); ?>" class="menu-link">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Inicio</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="<?= urlBase("dashboard/formularios"); ?>" class="menu-link">
                    <i class="fas fa-file-alt"></i>
                    <span>Formulários</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="<?= urlBase("dashboard/sliders"); ?>" class="menu-link">
                    <i class="fas fa-images"></i>
                    <span>Sliders</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="<?= urlBase("dashboard/curriculos"); ?>" class="menu-link">
                    <i class="fas fa-user-tie"></i>
                    <span>Currículos</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="<?= urlBase("dashboard/arquivos-condominio"); ?>" class="menu-link">
                    <i class="fas fa-folder-open"></i>
                    <span>Arquivos de Condomínio</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="<?= urlBase("dashboard/usuarios"); ?>" class="menu-link">
                    <i class="fas fa-users"></i>
                    <span>Usuários</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="<?= urlBase("dashboard/configuracoes"); ?>" class="menu-link">
                    <i class="fas fa-cog"></i>
                    <span>Configurações</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <a href="../index.html" class="menu-link">
                <i class="fas fa-home"></i>
                <span>Voltar ao Site</span>
            </a>
            <a href="#" class="menu-link" id="logoutBtn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Sair</span>
            </a>
        </div>
    </nav>
<?php endif; ?>

<!-- Main Content -->
<div id="content" class="main-content">
    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button id="sidebarToggle" class="btn btn-link me-3">
                    <i class="fas fa-bars"></i>
                </button>
                <h4 class="mb-0">Dashboard</h4>
            </div>
            <div class="d-flex align-items-center">
                <div class="dropdown me-3">
                    <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-danger">3</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Nova manutenção agendada</a></li>
                        <li><a class="dropdown-item" href="#">Relatório mensal disponível</a></li>
                        <li><a class="dropdown-item" href="#">Atualização do sistema</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i>
                        João Silva
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Perfil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Configurações</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- Section container -->
    <?php if ($this->section("container")):
        echo $this->section("container");
    endif;
    ?>
</div>

<!-- section navbar -->
<?php if ($this->section("footer")):
    echo $this->section("footer");
endif; ?>


<!-- jQuery -->
<script src="<?= urlBase(THEME_DASHBOARD . "/assets/jquery/jquery-4.0.0.min.js"); ?>"></script>
<!-- Bootstrap JS -->
<script src="<?= urlBase(THEME_DASHBOARD . "/assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"); ?>"></script>
<script>
    $(document).ready(function () {
        // Sidebar Toggle
        $('#sidebarToggle, #sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('collapsed');
            $('#content').toggleClass('expanded');
        });

        // Mobile sidebar toggle
        $('#sidebarToggle').on('click', function () {
            if ($(window).width() <= 768) {
                $('#sidebar').toggleClass('show');
            }
        });

        // Close sidebar on mobile when clicking outside
        $(document).on('click', function (e) {
            if ($(window).width() <= 768) {
                if (!$(e.target).closest('#sidebar, #sidebarToggle').length) {
                    $('#sidebar').removeClass('show');
                }
            }
        });

        // // Active menu item
        $('.menu-link').on('click', function () {
            $('.menu-link').removeClass('active');
            $(this).addClass('active');
        });

        // Logout functionality
        $('#logoutBtn').on('click', function (e) {
            e.preventDefault();
            if (confirm('Tem certeza que deseja sair?')) {
                // Simulate logout
                showToast('Logout realizado com sucesso!', 'success');
                setTimeout(function () {
                    window.location.href = '../intranet.html';
                }, 1500);
            }
        });

    });
</script>
<!-- Import js -->
<?php if ($this->section("js")):
    echo $this->section("js");
endif;
?>
</body>
</html>