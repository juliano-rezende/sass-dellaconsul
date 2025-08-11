<?php $this->layout("_theme"); ?>

<?php $this->start("css"); ?>
<?php $this->end("css"); ?>

<?php $this->start("container"); ?>

<!-- Hero Slideshow -->
<section id="home" class="hero-slideshow">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')">
                    <div class="hero-content">
                        <div class="container">
                            <div class="row align-items-center min-vh-100">
                                <div class="col-lg-6">
                                    <h1 class="hero-title">
                                        Gestão Profissional de Condomínios
                                    </h1>
                                    <p class="hero-subtitle">
                                        Oferecemos soluções completas para a administração condominial,
                                        garantindo tranquilidade e eficiência para síndicos e moradores.
                                    </p>
                                    <div class="hero-buttons">
                                        <a href="#servicos" class="btn btn-primary">Nossos Serviços</a>
                                        <a href="contato.html" class="btn btn-outline">Fale Conosco</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')">
                    <div class="hero-content">
                        <div class="container">
                            <div class="row align-items-center min-vh-100">
                                <div class="col-lg-6">
                                    <h1 class="hero-title">
                                        Tecnologia e Inovação
                                    </h1>
                                    <p class="hero-subtitle">
                                        Sistemas modernos de gestão, aplicativos e comunicação digital
                                        para facilitar a vida dos condôminos.
                                    </p>
                                    <div class="hero-buttons">
                                        <a href="#servicos" class="btn btn-primary">Conheça Nossas Soluções</a>
                                        <a href="contato.html" class="btn btn-outline">Solicitar Demo</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')">
                    <div class="hero-content">
                        <div class="container">
                            <div class="row align-items-center min-vh-100">
                                <div class="col-lg-6">
                                    <h1 class="hero-title">
                                        Equipe Especializada
                                    </h1>
                                    <p class="hero-subtitle">
                                        Profissionais certificados com mais de 15 anos de experiência
                                        em gestão condominial.
                                    </p>
                                    <div class="hero-buttons">
                                        <a href="#sobre" class="btn btn-primary">Conheça Nossa Equipe</a>
                                        <a href="contato.html" class="btn btn-outline">Entre em Contato</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</section>

<!-- Serviços -->
<section id="servicos" class="services-section">
    <div class="container">
        <div class="section-header">
            <h2>Nossos Serviços</h2>
            <p>Oferecemos uma gama completa de serviços para atender todas as necessidades do seu condomínio</p>
        </div>

        <div class="services-grid">
            <div class="service-item">
                <div class="service-icon">
                    <i class="fas fa-calculator"></i>
                </div>
                <h3>Gestão Financeira</h3>
                <p>Controle completo de receitas, despesas, rateios e prestação de contas detalhada.</p>
            </div>

            <div class="service-item">
                <div class="service-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <h3>Manutenção Preventiva</h3>
                <p>Programas de manutenção preventiva e corretiva para todas as áreas comuns.</p>
            </div>

            <div class="service-item">
                <div class="service-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Segurança</h3>
                <p>Gestão de portaria, controle de acesso e monitoramento de segurança 24h.</p>
            </div>

            <div class="service-item">
                <div class="service-icon">
                    <i class="fas fa-file-contract"></i>
                </div>
                <h3>Gestão Legal</h3>
                <p>Assessoria jurídica, elaboração de regimentos e compliance condominial.</p>
            </div>

            <div class="service-item">
                <div class="service-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Gestão de Pessoal</h3>
                <p>Recrutamento, treinamento e gestão de funcionários condominiais.</p>
            </div>

            <div class="service-item">
                <div class="service-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Tecnologia</h3>
                <p>Sistemas modernos de gestão, aplicativos e comunicação digital.</p>
            </div>
        </div>
    </div>
</section>

<!-- Sobre Nós -->
<section id="sobre" class="about-section">
    <div class="container">
        <div class="about-content">
            <div class="about-text">
                <h2>A Dellaconsul</h2>
                <p>
                    Estabelecer metas ousadas exige muita imaginação e coragem.
                    ás vezes, a imaginação é chamada de loucura. Tão a frente de seu tempo em determinado momento está a história... No entanto, depois de conquistadas as metas, elas ficam registradas em seu tempo, de forma marcante, na mente de todos nós... A criação da Della Consul foi uma dessas metas. A princípio, tida como loucura... Objetivos quase inatingíveis não constituem apenas grandes obras da engenharia, como pontes, túneis, viadutos ou hidrelétricas... O Brasil há alguns anos pediu eleições diretas, para presidente lutou e conseguiu... Depois, ousou exigir a queda deste mesmo presidente. Também conseguiu. O país quis mudar a sua história... e mudou Hoje, temos muitos outros exemplos:
                </p>
                <div class="features-list">
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>15+ anos de experiência</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>500+ condomínios atendidos</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Equipe certificada</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Suporte 24/7</span>
                    </div>
                </div>
            </div>
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                     alt="Equipe trabalhando">
            </div>
        </div>
    </div>
</section>

<!-- Estatísticas -->
<section class="py-5 text-white statistics-section">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <div class="stat-item">
                    <h3 class="display-4 fw-bold counter" data-target="500">0</h3>
                    <p class="mb-0">Condomínios Atendidos</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-item">
                    <h3 class="display-4 fw-bold counter" data-target="15000">0</h3>
                    <p class="mb-0">Famílias Satisfeitas</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-item">
                    <h3 class="display-4 fw-bold counter" data-target="15">0</h3>
                    <p class="mb-0">Anos de Experiência</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-item">
                    <h3 class="display-4 fw-bold counter" data-target="98">0</h3>
                    <p class="mb-0">% de Satisfação</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Depoimentos -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="display-5 fw-bold mb-3">O que nossos clientes dizem</h2>
                <p class="lead text-muted">
                    Depoimentos de síndicos e moradores que confiam em nossos serviços
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="testimonial-card text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                        </div>
                                        <p class="lead mb-3">
                                            "A CondomínioPro transformou completamente a gestão do nosso condomínio.
                                            Agora temos transparência total e os moradores estão muito mais satisfeitos."
                                        </p>
                                        <h6 class="fw-bold">Maria Silva</h6>
                                        <small class="text-muted">Síndica - Residencial Solar</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="testimonial-card text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                        </div>
                                        <p class="lead mb-3">
                                            "Profissionalismo e eficiência são as palavras que definem a CondomínioPro.
                                            Recomendo para qualquer condomínio que queira qualidade."
                                        </p>
                                        <h6 class="fw-bold">João Santos</h6>
                                        <small class="text-muted">Síndico - Edifício Central</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->end("container"); ?>

<?php $this->start("js"); ?>
    <!-- Home -->
    <script src="<?=urlBase(THEME_SITE ."/assets/js/home.js");?>"></script>
<?php $this->end("js"); ?>