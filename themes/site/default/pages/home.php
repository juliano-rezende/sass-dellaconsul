<?php $this->layout("_theme"); ?>

<?php $this->start("css"); ?>
<?php $this->end("css"); ?>

<?php $this->start("container"); ?>

<!-- Hero Slideshow -->
<?php if (!empty($sliders)): ?>
<section id="home" class="hero-slideshow">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <?php if (count($sliders) > 1): ?>
        <div class="carousel-indicators">
            <?php foreach ($sliders as $index => $slider): ?>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $index; ?>" <?= $index === 0 ? 'class="active"' : ''; ?>></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="carousel-inner">
            <?php foreach ($sliders as $index => $slider): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                <div class="hero-slide" style="background-image: url('<?= urlBase($slider['image']); ?>')">
                    <div class="hero-content">
                        <div class="container">
                            <div class="row align-items-center min-vh-100">
                                <div class="col-lg-6">
                                    <?php if (!empty($slider['subtitle'])): ?>
                                    <p class="hero-subtitle-small text-white mb-2"><?= htmlspecialchars($slider['subtitle']); ?></p>
                                    <?php endif; ?>
                                    <h1 class="hero-title">
                                        <?= htmlspecialchars($slider['title']); ?>
                                    </h1>
                                    <?php if (!empty($slider['description'])): ?>
                                    <p class="hero-subtitle">
                                        <?= htmlspecialchars($slider['description']); ?>
                                    </p>
                                    <?php endif; ?>
                                    <?php if (!empty($slider['button_text']) && !empty($slider['button_link'])): ?>
                                    <div class="hero-buttons">
                                        <a href="<?= htmlspecialchars($slider['button_link']); ?>" class="btn btn-primary"><?= htmlspecialchars($slider['button_text']); ?></a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if (count($sliders) > 1): ?>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

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
        <!-- Seção Principal -->
        <div class="about-content mb-5">
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

        <!-- Accordion Horizontal: Nossa Jornada -->
        <div class="journey-section mt-5">
            <div class="section-header text-center mb-5">
                <h3 class="display-6 fw-bold">Nossa Jornada</h3>
                <p class="text-muted">Da inspiração ao compromisso com o futuro</p>
            </div>

            <div class="accordion-horizontal">
                <!-- História -->
                <div class="accordion-panel active" data-panel="historia">
                    <div class="panel-header" onclick="togglePanel('historia')">
                        <div class="panel-icon bg-primary">
                            <i class="fas fa-history"></i>
                        </div>
                        <h3 class="panel-title">História</h3>
                    </div>
                    <div class="panel-content">
                        <div class="panel-image">
                            <img src="https://images.unsplash.com/photo-1560179707-f14e90ef3623?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                 alt="História">
                        </div>
                        <div class="panel-body">
                            <span class="panel-badge bg-primary">
                                <i class="fas fa-history me-2"></i>História
                            </span>
                            <h4 class="panel-heading">O Início de Tudo</h4>
                            <p class="panel-text">
                                Estabelecer metas ousadas exige muita imaginação e coragem.
                                Às vezes, a imaginação é chamada de loucura. Tão a frente de seu tempo em determinado
                                momento está a história... No entanto, depois de conquistadas as metas, elas ficam registradas
                                em seu tempo, de forma marcante, na mente de todos nós... A criação da Della Consul foi uma
                                dessas metas. A princípio, tida como loucura... Objetivos quase inatingíveis não constituem apenas
                                grandes obras da engenharia, como pontes, túneis, viadutos ou hidrelétricas... O Brasil há alguns
                                anos pediu eleições diretas, para presidente lutou e conseguiu... Depois, ousou exigir a queda deste
                                mesmo presidente. Também conseguiu. O país quis mudar a sua história... e mudou Hoje, temos
                                muitos outros exemplos:
                            </p>
                            <ul class="panel-list">
                                <li><i class="fas fa-home me-2"></i>Fazer um mutirão para construir casas populares;</li>
                                <li><i class="fas fa-laptop-code me-2"></i>Criar um programa de computador;</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Objetivos -->
                <div class="accordion-panel" data-panel="objetivos">
                    <div class="panel-header" onclick="togglePanel('objetivos')">
                        <div class="panel-icon bg-success">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3 class="panel-title">Objetivos</h3>
                    </div>
                    <div class="panel-content">
                        <div class="panel-image">
                            <img src="https://images.unsplash.com/photo-1484480974693-6ca0a78fb36b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                 alt="Objetivos">
                        </div>
                        <div class="panel-body">
                            <span class="panel-badge bg-success">
                                <i class="fas fa-bullseye me-2"></i>Objetivos
                            </span>
                            <h4 class="panel-heading">Nossos Propósitos</h4>
                            <div class="panel-text panel-verse">
                                <p>Nossa visão é limitada<br>
                                mas, podemos ver lá longe...</p>

                                <p>Nossas pernas não lentas<br>
                                Mas, podemos chegar mais rápido<br>
                                Nossos corpos também não têm asas</p>

                                <p>Mas, voaremos bem mais alto<br>
                                Nossos músculos são frágeis<br>
                                Mas, suportaremos as cargas mais pesadas<br>
                                Não é o que somos<br>
                                Mas, o que podemos fazer.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Futuro -->
                <div class="accordion-panel" data-panel="futuro">
                    <div class="panel-header" onclick="togglePanel('futuro')">
                        <div class="panel-icon bg-info">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h3 class="panel-title">Futuro</h3>
                    </div>
                    <div class="panel-content">
                        <div class="panel-image">
                            <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                 alt="Futuro">
                        </div>
                        <div class="panel-body">
                            <span class="panel-badge bg-info">
                                <i class="fas fa-rocket me-2"></i>Futuro
                            </span>
                            <h4 class="panel-heading">Rumo ao Amanhã</h4>
                            <p class="panel-text">
                                Vou continuar me esforçando, para fazer algo especial em todos os dias da minha vida. Não tenho
                                limites. Prestarei os melhores serviços aos meus clientes, funcionários e fornecedores da melhor
                                maneira possível...
                            </p>
                            <p class="panel-text">
                                Ainda me sinto muito motivado e determinado...<br>
                                Para que isso tudo continue acontecendo...<br>
                                <strong>Darci Rodrigues</strong> Sempre serei fiel aos meus princípios E aos valores que nortearam a minha vida
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        function togglePanel(panelName) {
            const panels = document.querySelectorAll('.accordion-panel');
            const clickedPanel = document.querySelector(`[data-panel="${panelName}"]`);

            panels.forEach(panel => {
                if (panel.dataset.panel === panelName) {
                    panel.classList.add('active');
                } else {
                    panel.classList.remove('active');
                }
            });
        }
        </script>
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
                <?php if (!empty($testimonials) && count($testimonials) > 0): ?>
                <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($testimonials as $index => $testimonial): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="testimonial-card text-center">
                                        <div class="mb-3">
                                            <?php
                                            $rating = $testimonial['rating'] ?? 5;
                                            for ($i = 1; $i <= 5; $i++):
                                            ?>
                                                <i class="fas fa-star text-warning<?= $i > $rating ? ' opacity-25' : ''; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <p class="lead mb-3 testimonial-message">
                                            "<?= htmlspecialchars($testimonial['message']); ?>"
                                        </p>
                                        <h6 class="fw-bold"><?= htmlspecialchars($testimonial['name']); ?></h6>
                                        <?php if (!empty($testimonial['company_role'])): ?>
                                        <small class="text-muted"><?= htmlspecialchars($testimonial['company_role']); ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($testimonials) > 1): ?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <div class="text-center py-5">
                    <p class="lead text-muted">Seja o primeiro a deixar seu depoimento!</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Botão para adicionar depoimento -->
        <div class="row mt-4">
            <div class="col-lg-12 text-center">
                <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#testimonialModal">
                    <i class="fas fa-comment-dots me-2"></i>Deixe seu depoimento
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Modal Centralizado para Depoimento -->
<div class="modal fade" id="testimonialModal" tabindex="-1" aria-labelledby="testimonialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="testimonialModalLabel">
                    <i class="fas fa-comment-dots me-2"></i>Deixe seu Depoimento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body position-relative">
        <p class="text-muted mb-4">Sua opinião é muito importante para nós! Compartilhe sua experiência.</p>

        <!-- Feedback centralizado -->
        <div id="testimonialFeedback" class="testimonial-feedback-overlay"></div>

        <form id="testimonialForm">
            <div class="mb-3">
                <label for="testimonialName" class="form-label">Nome *</label>
                <input type="text" class="form-control" id="testimonialName" name="name" required minlength="3">
            </div>

            <div class="mb-3">
                <label for="testimonialEmail" class="form-label">Email *</label>
                <input type="email" class="form-control" id="testimonialEmail" name="email" required>
            </div>

            <div class="mb-3">
                <label for="testimonialCompanyRole" class="form-label">Cargo/Empresa</label>
                <input type="text" class="form-control" id="testimonialCompanyRole" name="company_role"
                       placeholder="Ex: Síndico - Edifício Central">
                <small class="form-text text-muted">Opcional</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Avaliação *</label>
                <div class="rating-input" id="ratingInput">
                    <i class="far fa-star" data-rating="1"></i>
                    <i class="far fa-star" data-rating="2"></i>
                    <i class="far fa-star" data-rating="3"></i>
                    <i class="far fa-star" data-rating="4"></i>
                    <i class="far fa-star" data-rating="5"></i>
                </div>
                <input type="hidden" id="testimonialRating" name="rating" value="0">
                <small class="form-text text-muted">Clique nas estrelas para avaliar</small>
            </div>

            <div class="mb-3">
                <label for="testimonialMessage" class="form-label">Seu depoimento *</label>
                <textarea class="form-control" id="testimonialMessage" name="message" rows="5" required minlength="10"
                          placeholder="Conte-nos sobre sua experiência..."></textarea>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="testimonialConsent" name="consent" required>
                <label class="form-check-label small" for="testimonialConsent">
                    Li e aceito a <a href="<?=urlBase('politica-privacidade');?>" target="_blank">Política de Privacidade</a>
                    e os <a href="<?=urlBase('termos-uso');?>" target="_blank">Termos de Uso</a>,
                    e autorizo o uso dos meus dados conforme descrito. *
                </label>
            </div>
        </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <button type="submit" form="testimonialForm" class="btn btn-primary">
                    <i class="fas fa-paper-plane me-2"></i>Enviar Depoimento
                </button>
            </div>
        </div>
    </div>
</div>

<style>

/* Limita depoimento a 2 linhas */
.testimonial-message {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.6;
    max-height: 3.2em; /* 2 linhas * 1.6 line-height */
}

/* Modal de depoimentos */
#testimonialModal .modal-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}

#testimonialModal .modal-header {
    background: linear-gradient(135deg, var(--primary-color, #007bff) 0%, var(--secondary-color, #0056b3) 100%);
    color: white;
    border-radius: 15px 15px 0 0;
    border-bottom: none;
    padding: 1.5rem 2rem;
}

#testimonialModal .modal-title {
    font-weight: 600;
}

#testimonialModal .btn-close {
    filter: brightness(0) invert(1);
}

#testimonialModal .modal-body {
    padding: 2rem;
}

#testimonialModal .modal-footer {
    border-top: 1px solid #e9ecef;
    padding: 1.25rem 2rem;
}

/* Feedback centralizado no modal */
.testimonial-feedback-overlay {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
    min-width: 320px;
    max-width: 90%;
    animation: fadeInScale 0.3s ease-out;
}

.testimonial-feedback-overlay.show {
    display: block;
}

.testimonial-feedback-overlay .alert {
    box-shadow: 0 15px 50px rgba(0,0,0,0.4);
    border: none;
    font-size: 1.1rem;
    padding: 1.5rem 2rem;
    border-radius: 12px;
    margin: 0;
}

@keyframes fadeInScale {
    from {
        opacity: 0;
        transform: translate(-50%, -50%) scale(0.8);
    }
    to {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
    }
}

/* Sistema de rating com estrelas */
.rating-input {
    font-size: 2rem;
    cursor: pointer;
    user-select: none;
    display: flex;
    gap: 8px;
}

.rating-input i {
    cursor: pointer;
    transition: all 0.2s ease;
    color: #ffc107;
}

.rating-input i:hover {
    transform: scale(1.2);
}

.rating-input i.fas {
    color: #ffc107;
}

.rating-input i.far {
    color: #ddd;
}

/* Melhorias no formulário */
#testimonialModal .form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
}

#testimonialModal .form-control {
    border-radius: 8px;
    border: 1px solid #ddd;
    padding: 0.75rem;
    transition: all 0.3s ease;
}

#testimonialModal .form-control:focus {
    border-color: var(--primary-color, #007bff);
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.1);
}

#testimonialModal textarea.form-control {
    resize: vertical;
    min-height: 120px;
}

/* Responsivo */
@media (max-width: 768px) {
    #testimonialModal .modal-dialog {
        margin: 0.5rem;
    }

    #testimonialModal .modal-body {
        padding: 1.5rem;
    }

    .testimonial-feedback-overlay {
        min-width: 280px;
        max-width: 95%;
    }

    .testimonial-feedback-overlay .alert {
        font-size: 1rem;
        padding: 1.2rem 1.5rem;
    }
}
</style>

<?php $this->end("container"); ?>

<?php $this->start("js"); ?>
    <!-- Home -->
    <script src="<?=urlBase(THEME_SITE ."/assets/js/home.js");?>"></script>
    <!-- Testimonials -->
    <script src="<?=urlBase(THEME_SITE ."/assets/js/testimonials.js");?>"></script>
<?php $this->end("js"); ?>