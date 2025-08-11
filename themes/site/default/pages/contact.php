<?php $this->layout("_theme"); ?>

<?php $this->start("css"); ?>
<?php $this->end("css"); ?>

<?php $this->start("container"); ?>

    <!-- Separador Escuro -->
    <div class="client-separator-dark"></div>

    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="contact-title">
                        Fale conosco
                    </h1>
                    <p class="contact-subtitle">
                        Estamos aqui para ajudar você a encontrar a melhor solução para o seu condomínio.
                        Solicite um orçamento personalizado e descubra como podemos transformar a gestão do seu
                        condomínio.
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="contact-info">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Endereço</h4>
                                <p>Av.Carlos Chagas nº 516 <br> Cidade Nobre, 3º Andar - Recepção 302<br> Ipatinga-MG -
                                    CEP: 39864-000</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Telefone</h4>
                                <p>(31) 3826-3154 <br> (31) 3827-7590</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <h4>E-mail</h4>
                                <p>contato@condominio.com<br>comercial@condominio.com</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Horário de Atendimento</h4>
                                <p>Segunda a Sexta: 8h às 18h<br>Sábado: 8h às 12h</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Formulário de Contato -->
    <section class="contact-form-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-header text-center mb-5">
                        <h2>Solicite um Orçamento</h2>
                        <p>Preencha o formulário abaixo e nossa equipe entrará em contato em até 24 horas</p>
                    </div>

                    <div class="contact-form-card">
                        <form id="contactForm">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="nome" class="form-label">Nome Completo *</label>
                                    <input type="text" class="form-control" id="nome" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">E-mail *</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="telefone" class="form-label">Telefone *</label>
                                    <input type="tel" class="form-control" id="telefone" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="empresa" class="form-label">Empresa</label>
                                    <input type="text" class="form-control" id="empresa">
                                </div>

                                <div class="col-12">
                                    <label for="condominio" class="form-label">Nome do Condomínio *</label>
                                    <input type="text" class="form-control" id="condominio" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="unidades" class="form-label">Número de Unidades</label>
                                    <select class="form-control" id="unidades">
                                        <option value="">Selecione...</option>
                                        <option value="1-50">1 a 50 unidades</option>
                                        <option value="51-100">51 a 100 unidades</option>
                                        <option value="101-200">101 a 200 unidades</option>
                                        <option value="201-500">201 a 500 unidades</option>
                                        <option value="500+">Mais de 500 unidades</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="servico" class="form-label">Serviço de Interesse</label>
                                    <select class="form-control" id="servico">
                                        <option value="">Selecione...</option>
                                        <option value="gestao-completa">Gestão Completa</option>
                                        <option value="gestao-financeira">Gestão Financeira</option>
                                        <option value="manutencao">Manutenção</option>
                                        <option value="seguranca">Segurança</option>
                                        <option value="gestao-legal">Gestão Legal</option>
                                        <option value="tecnologia">Tecnologia</option>
                                        <option value="outro">Outro</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="mensagem" class="form-label">Mensagem</label>
                                    <textarea class="form-control" id="mensagem" rows="5"
                                              placeholder="Descreva suas necessidades, dúvidas ou solicitações..."></textarea>
                                </div>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="concordo" required>
                                        <label class="form-check-label" for="concordo">
                                            Concordo com a <a href="#" class="text-primary">Política de Privacidade</a>
                                            e autorizo o contato
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-paper-plane me-2"></i>Enviar Mensagem
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mapa -->
    <section class="map-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-header text-center mb-5">
                        <h2>Nossa Localização</h2>
                        <p>Visite nossa sede e conheça nossa equipe</p>
                    </div>

                    <div class="map-container">
                        <iframe
                                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d235.11120656509613!2d-42.5587161!3d-19.4650798!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xafffdb7eaf7a49%3A0x78196f1af48cf3d1!2sAv.%20Carlos%20Chagas%2C%20516%20-%20Cidade%20Nobre%2C%20Ipatinga%20-%20MG%2C%2035162-359!5e0!3m2!1spt-BR!2sbr!4v1754757347326!5m2!1spt-BR!2sbr"
                                width="100%"
                                height="450"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="faq-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-header text-center mb-5">
                        <h2>Perguntas Frequentes</h2>
                        <p>Tire suas dúvidas sobre nossos serviços</p>
                    </div>

                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse1">
                                    Como funciona o processo de contratação?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    O processo é simples: após o primeiro contato, nossa equipe fará uma visita técnica
                                    ao condomínio,
                                    apresentará uma proposta personalizada e, após a aprovação, iniciaremos os serviços
                                    em até 30 dias.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse2">
                                    Quais são os custos dos serviços?
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Os custos variam de acordo com o tamanho do condomínio, número de unidades e
                                    serviços contratados.
                                    Oferecemos propostas personalizadas sem compromisso.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse3">
                                    Vocês atendem condomínios de qualquer tamanho?
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Sim! Atendemos desde pequenos condomínios com poucas unidades até grandes complexos
                                    residenciais
                                    com centenas de unidades.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse4">
                                    Como é feito o suporte aos condôminos?
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Oferecemos suporte 24/7 através de telefone, e-mail e aplicativo móvel.
                                    Nossa equipe está sempre disponível para atender emergências e solicitações.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php $this->end("container"); ?>

<?php $this->start("js"); ?>
<?php $this->end("js"); ?>