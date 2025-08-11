<?php $this->layout("_theme"); ?>

<?php $this->start("css"); ?>
<?php $this->end("css"); ?>

<?php $this->start("container"); ?>
<!-- Separador Escuro -->
<div class="client-separator-dark"></div>

<!-- Serviços Disponíveis -->
<section class="client-services">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2>Serviços Disponíveis</h2>
            <p>Descubra tudo que você pode fazer através do portal do cliente</p>
        </div>

        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <h4>Extratos e Boletos</h4>
                <p>Visualize e baixe seus extratos mensais, boletos de condomínio e histórico de pagamentos.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <h4>Solicitações de Manutenção</h4>
                <p>Abra chamados para manutenção, acompanhe o status e receba atualizações em tempo real.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h4>Agenda de Eventos</h4>
                <p>Consulte eventos do condomínio, reservas de áreas comuns e participe de atividades.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <h4>Comunicados</h4>
                <p>Receba notificações importantes, comunicados da administração e avisos de emergência.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h4>Diretoria e Síndico</h4>
                <p>Entre em contato com a diretoria, participe de assembleias e acompanhe decisões.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h4>App Móvel</h4>
                <p>Acesse todas as funcionalidades através do aplicativo móvel disponível para iOS e Android.</p>
            </div>
        </div>
    </div>
</section>

<!-- Benefícios -->
<section class="benefits-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2>Por que usar o Portal do Cliente?</h2>
                <div class="benefits-list">
                    <div class="benefit-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h5>Acesso 24/7</h5>
                            <p>Consulte informações a qualquer momento, de qualquer lugar</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <i class="fas fa-shield-alt"></i>
                        <div>
                            <h5>Segurança Total</h5>
                            <p>Dados protegidos com criptografia e autenticação segura</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <i class="fas fa-paper-plane"></i>
                        <div>
                            <h5>Comunicação Direta</h5>
                            <p>Comunicação rápida e eficiente com a administração</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <i class="fas fa-chart-line"></i>
                        <div>
                            <h5>Transparência</h5>
                            <p>Acompanhe todas as movimentações financeiras do condomínio</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="app-preview">
                    <img src="https://images.unsplash.com/photo-1551650975-87deedd944c3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                         alt="App Preview" class="img-fluid rounded-3 shadow">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Suporte -->
<section class="support-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2>Precisa de Ajuda?</h2>
                <p class="lead mb-4">
                    Nossa equipe de suporte está disponível para ajudar você com qualquer dúvida sobre o portal
                </p>

                <div class="support-options">
                    <div class="support-card">
                        <i class="fas fa-headset"></i>
                        <h5>Suporte por Telefone</h5>
                        <p>(11) 9999-9999</p>
                        <small>Segunda a Sexta, 8h às 18h</small>
                    </div>

                    <div class="support-card">
                        <i class="fas fa-envelope"></i>
                        <h5>E-mail de Suporte</h5>
                        <p>suporte@condominio.com</p>
                        <small>Resposta em até 2 horas</small>
                    </div>

                    <div class="support-card">
                        <i class="fas fa-comments"></i>
                        <h5>Chat Online</h5>
                        <p>Disponível 24/7</p>
                        <small>Atendimento instantâneo</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->end("container"); ?>

<?php $this->start("js"); ?>
<?php $this->end("js"); ?>