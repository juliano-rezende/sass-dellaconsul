<?php $this->layout("_theme"); ?>

<?php $this->start("css"); ?>
<style>
    .legal-page {
        padding: 100px 0 60px;
        background: #f8f9fa;
        min-height: 100vh;
    }

    .legal-content {
        background: white;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .legal-toc {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 30px;
        position: sticky;
        top: 100px;
    }

    .legal-toc ul {
        list-style: none;
        padding-left: 0;
    }

    .legal-toc li {
        margin-bottom: 8px;
    }

    .legal-toc a {
        color: #2563eb;
        text-decoration: none;
    }

    .legal-toc a:hover {
        text-decoration: underline;
    }

    .legal-section {
        margin-bottom: 40px;
        scroll-margin-top: 100px;
    }

    .legal-section h3 {
        color: #2563eb;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e5e7eb;
    }

    .last-updated {
        color: #6c757d;
        font-size: 0.9rem;
        font-style: italic;
        margin-bottom: 30px;
    }

    .highlight-box {
        background: #eff6ff;
        border-left: 4px solid #2563eb;
        padding: 15px;
        margin: 20px 0;
    }
</style>
<?php $this->end("css"); ?>

<?php $this->start("container"); ?>

<div class="legal-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 d-none d-lg-block">
                <div class="legal-toc">
                    <h5 class="mb-3">Índice</h5>
                    <ul>
                        <li><a href="#aceitacao">1. Aceitação dos Termos</a></li>
                        <li><a href="#servicos">2. Serviços Oferecidos</a></li>
                        <li><a href="#cadastro">3. Cadastro e Conta</a></li>
                        <li><a href="#propriedade">4. Propriedade Intelectual</a></li>
                        <li><a href="#uso-adequado">5. Uso Adequado</a></li>
                        <li><a href="#envio-conteudo">6. Envio de Conteúdo</a></li>
                        <li><a href="#limitacao">7. Limitação de Responsabilidade</a></li>
                        <li><a href="#disponibilidade">8. Disponibilidade</a></li>
                        <li><a href="#links-externos">9. Links Externos</a></li>
                        <li><a href="#alteracoes">10. Alterações</a></li>
                        <li><a href="#lei-aplicavel">11. Lei Aplicável</a></li>
                        <li><a href="#foro">12. Foro</a></li>
                        <li><a href="#contato">13. Contato</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="legal-content">
                    <h1 class="mb-4">Termos de Uso</h1>
                    <p class="last-updated">Última atualização: <?= date('d/m/Y'); ?></p>

                    <p class="lead">
                        Bem-vindo ao website da Della Consul. Ao acessar e usar este site, você concorda com os seguintes 
                        Termos de Uso. Por favor, leia-os atentamente.
                    </p>

                    <!-- 1. Aceitação -->
                    <section class="legal-section" id="aceitacao">
                        <h3>1. Aceitação dos Termos</h3>
                        <p>Ao acessar, navegar e/ou utilizar os serviços disponíveis neste website, você declara ter lido, compreendido e concordado com estes Termos de Uso, bem como com nossa <a href="<?=urlBase('politica-privacidade');?>">Política de Privacidade</a>.</p>
                        <p>Se você não concorda com qualquer parte destes termos, não deverá utilizar este site.</p>
                    </section>

                    <!-- 2. Serviços -->
                    <section class="legal-section" id="servicos">
                        <h3>2. Serviços Oferecidos</h3>
                        <p>A Della Consul é especialista em gestão condominial, oferecendo:</p>
                        <ul>
                            <li>Gestão financeira e administrativa de condomínios</li>
                            <li>Manutenção preventiva e corretiva</li>
                            <li>Gestão de segurança patrimonial</li>
                            <li>Assessoria jurídica condominial</li>
                            <li>Gestão de pessoas e recursos humanos</li>
                            <li>Soluções tecnológicas para condomínios</li>
                        </ul>
                        <p>Este website serve como canal de informação sobre nossos serviços e meio de contato com nossos clientes e potenciais clientes.</p>
                    </section>

                    <!-- 3. Cadastro -->
                    <section class="legal-section" id="cadastro">
                        <h3>3. Cadastro e Área do Cliente</h3>
                        <p>Algumas funcionalidades do site podem requerer cadastro e criação de conta:</p>
                        <ul>
                            <li>Você deve fornecer informações verdadeiras, precisas e atualizadas</li>
                            <li>É sua responsabilidade manter a confidencialidade de suas credenciais de acesso</li>
                            <li>Você é responsável por todas as atividades realizadas através de sua conta</li>
                            <li>Notifique-nos imediatamente sobre qualquer uso não autorizado de sua conta</li>
                        </ul>
                    </section>

                    <!-- 4. Propriedade Intelectual -->
                    <section class="legal-section" id="propriedade">
                        <h3>4. Propriedade Intelectual</h3>
                        <p>Todo o conteúdo deste website, incluindo mas não limitado a:</p>
                        <ul>
                            <li>Textos, imagens, gráficos, logos e ícones</li>
                            <li>Vídeos, áudios e elementos multimídia</li>
                            <li>Código-fonte, scripts e funcionalidades</li>
                            <li>Design, layout e identidade visual</li>
                        </ul>
                        <p>São de propriedade exclusiva da Della Consul ou de seus licenciadores, protegidos pelas leis de direitos autorais e propriedade intelectual brasileiras e internacionais.</p>
                        <div class="highlight-box">
                            <p><strong>É expressamente proibido:</strong> copiar, reproduzir, distribuir, transmitir, exibir, executar, modificar ou criar trabalhos derivados sem autorização prévia e por escrito.</p>
                        </div>
                    </section>

                    <!-- 5. Uso Adequado -->
                    <section class="legal-section" id="uso-adequado">
                        <h3>5. Uso Adequado do Website</h3>
                        <p><strong>Você concorda em NÃO:</strong></p>
                        <ul>
                            <li>Usar o site para fins ilegais ou não autorizados</li>
                            <li>Tentar obter acesso não autorizado a sistemas ou redes</li>
                            <li>Interferir no funcionamento adequado do site</li>
                            <li>Transmitir vírus, malware ou códigos maliciosos</li>
                            <li>Coletar dados de outros usuários sem consentimento</li>
                            <li>Fazer engenharia reversa ou descompilar qualquer parte do site</li>
                            <li>Usar bots, scrapers ou ferramentas automatizadas sem autorização</li>
                            <li>Publicar conteúdo ofensivo, difamatório ou ilegal</li>
                            <li>Violar direitos de privacidade ou propriedade intelectual de terceiros</li>
                        </ul>
                    </section>

                    <!-- 6. Envio de Conteúdo -->
                    <section class="legal-section" id="envio-conteudo">
                        <h3>6. Envio de Conteúdo e Depoimentos</h3>
                        <p>Ao enviar currículos, depoimentos, mensagens ou qualquer outro conteúdo através do site:</p>
                        
                        <h5>6.1 Veracidade das Informações</h5>
                        <ul>
                            <li>Você declara que as informações fornecidas são verdadeiras e precisas</li>
                            <li>É responsável pela autenticidade e legalidade do conteúdo enviado</li>
                        </ul>

                        <h5>6.2 Direitos de Publicação</h5>
                        <ul>
                            <li>Para depoimentos: você concede à Della Consul o direito não-exclusivo de publicar, reproduzir e exibir seu depoimento no website e materiais de marketing</li>
                            <li>Podemos editar depoimentos para adequação de formato, sem alterar o sentido</li>
                            <li>Você pode solicitar a remoção de seu depoimento a qualquer momento</li>
                        </ul>

                        <h5>6.3 Moderação de Conteúdo</h5>
                        <ul>
                            <li>Reservamo-nos o direito de revisar, aprovar, rejeitar ou remover qualquer conteúdo enviado</li>
                            <li>Conteúdos que violem estes termos, sejam ofensivos, difamatórios ou ilegais serão removidos</li>
                            <li>Não nos responsabilizamos por conteúdos enviados por usuários</li>
                        </ul>
                    </section>

                    <!-- 7. Limitação de Responsabilidade -->
                    <section class="legal-section" id="limitacao">
                        <h3>7. Limitação de Responsabilidade</h3>
                        <p>A Della Consul não se responsabiliza por:</p>
                        <ul>
                            <li>Danos diretos, indiretos, incidentais ou consequenciais decorrentes do uso ou impossibilidade de uso do site</li>
                            <li>Erros, omissões ou imprecisões no conteúdo disponibilizado</li>
                            <li>Perda de dados ou informações</li>
                            <li>Vírus ou outros componentes nocivos que possam afetar seu equipamento</li>
                            <li>Ações de terceiros ou conteúdos de sites externos</li>
                        </ul>
                        <p><strong>O site é fornecido "como está" e "conforme disponível"</strong>, sem garantias de qualquer tipo, expressas ou implícitas.</p>
                    </section>

                    <!-- 8. Disponibilidade -->
                    <section class="legal-section" id="disponibilidade">
                        <h3>8. Disponibilidade do Serviço</h3>
                        <p>Nos esforçamos para manter o site disponível, porém:</p>
                        <ul>
                            <li>Não garantimos disponibilidade ininterrupta ou livre de erros</li>
                            <li>Podemos suspender o acesso para manutenção, atualizações ou correções</li>
                            <li>Não nos responsabilizamos por indisponibilidades causadas por fatores externos</li>
                            <li>Podemos descontinuar funcionalidades ou o site inteiro sem aviso prévio</li>
                        </ul>
                    </section>

                    <!-- 9. Links Externos -->
                    <section class="legal-section" id="links-externos">
                        <h3>9. Links para Sites Externos</h3>
                        <p>Este site pode conter links para websites de terceiros. Esses links são fornecidos apenas para conveniência:</p>
                        <ul>
                            <li>Não temos controle sobre o conteúdo de sites externos</li>
                            <li>Não endossamos ou nos responsabilizamos por sites de terceiros</li>
                            <li>O acesso a sites externos é por sua conta e risco</li>
                            <li>Recomendamos ler os termos e políticas dos sites que você visita</li>
                        </ul>
                    </section>

                    <!-- 10. Alterações -->
                    <section class="legal-section" id="alteracoes">
                        <h3>10. Alterações nos Termos</h3>
                        <p>Reservamo-nos o direito de modificar estes Termos de Uso a qualquer momento:</p>
                        <ul>
                            <li>Alterações entram em vigor imediatamente após publicação no site</li>
                            <li>Alterações significativas serão destacadas no topo da página</li>
                            <li>O uso continuado do site após alterações constitui aceitação dos novos termos</li>
                            <li>Recomendamos revisar estes termos periodicamente</li>
                        </ul>
                    </section>

                    <!-- 11. Lei Aplicável -->
                    <section class="legal-section" id="lei-aplicavel">
                        <h3>11. Lei Aplicável</h3>
                        <p>Estes Termos de Uso são regidos pelas leis da República Federativa do Brasil, incluindo:</p>
                        <ul>
                            <li>Código Civil Brasileiro (Lei nº 10.406/2002)</li>
                            <li>Código de Defesa do Consumidor (Lei nº 8.078/1990)</li>
                            <li>Marco Civil da Internet (Lei nº 12.965/2014)</li>
                            <li>Lei Geral de Proteção de Dados (Lei nº 13.709/2018)</li>
                        </ul>
                    </section>

                    <!-- 12. Foro -->
                    <section class="legal-section" id="foro">
                        <h3>12. Foro de Eleição</h3>
                        <p>Fica eleito o foro da comarca de <strong>Ipatinga, Estado de Minas Gerais</strong>, para dirimir quaisquer controvérsias decorrentes destes Termos de Uso, com renúncia expressa a qualquer outro, por mais privilegiado que seja.</p>
                    </section>

                    <!-- 13. Contato -->
                    <section class="legal-section" id="contato">
                        <h3>13. Contato</h3>
                        <p>Para dúvidas, esclarecimentos ou solicitações relacionadas a estes Termos de Uso, entre em contato:</p>
                        <p><strong>E-mail:</strong> contato@dellaconsul.com<br>
                        <strong>Telefones:</strong> (31) 3826-3154 | (31) 3827-7590<br>
                        <strong>Endereço:</strong> Av. Carlos Chagas nº 516 - Cidade Nobre, Ipatinga/MG, 3º Andar - Recepção 302</p>
                    </section>

                    <hr class="my-5">

                    <div class="text-center">
                        <p class="text-muted mb-3">Tem dúvidas sobre estes termos?</p>
                        <a href="<?=urlBase('contatos');?>" class="btn btn-primary">Entre em Contato</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->end("container"); ?>
