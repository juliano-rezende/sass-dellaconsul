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
                        <li><a href="#informacoes-gerais">1. Informações Gerais</a></li>
                        <li><a href="#dados-coletados">2. Dados Coletados</a></li>
                        <li><a href="#finalidade">3. Finalidade do Tratamento</a></li>
                        <li><a href="#base-legal">4. Base Legal</a></li>
                        <li><a href="#compartilhamento">5. Compartilhamento de Dados</a></li>
                        <li><a href="#armazenamento">6. Armazenamento e Retenção</a></li>
                        <li><a href="#direitos-titular">7. Direitos do Titular</a></li>
                        <li><a href="#seguranca">8. Segurança</a></li>
                        <li><a href="#cookies">9. Cookies</a></li>
                        <li><a href="#dpo">10. Encarregado de Dados</a></li>
                        <li><a href="#alteracoes">11. Alterações</a></li>
                        <li><a href="#legislacao">12. Legislação Aplicável</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="legal-content">
                    <h1 class="mb-4">Política de Privacidade</h1>
                    <p class="last-updated">Última atualização: <?= date('d/m/Y'); ?></p>

                    <p class="lead">
                        A Della Consul está comprometida com a proteção da privacidade e dos dados pessoais de seus 
                        clientes, parceiros e visitantes, em conformidade com a Lei Geral de Proteção de Dados (LGPD - Lei nº 13.709/2018).
                    </p>

                    <!-- 1. Informações Gerais -->
                    <section class="legal-section" id="informacoes-gerais">
                        <h3>1. Informações Gerais</h3>
                        <p><strong>Controlador de Dados:</strong> Della Consul Serviços Sincronizados</p>
                        <p><strong>Endereço:</strong> Av. Carlos Chagas nº 516 - Cidade Nobre, Ipatinga/MG, 3º Andar - Recepção 302</p>
                        <p><strong>Telefones:</strong> (31) 3826-3154 | (31) 3827-7590</p>
                        <p><strong>E-mail:</strong> contato@dellaconsul.com</p>
                        <p><strong>Website:</strong> <?= $_SERVER['HTTP_HOST']; ?></p>
                    </section>

                    <!-- 2. Dados Coletados -->
                    <section class="legal-section" id="dados-coletados">
                        <h3>2. Dados Pessoais Coletados</h3>
                        <p>Coletamos os seguintes tipos de dados pessoais:</p>
                        <ul>
                            <li><strong>Dados de Identificação:</strong> nome completo, e-mail, telefone</li>
                            <li><strong>Dados Profissionais:</strong> cargo, empresa, informações do currículo</li>
                            <li><strong>Dados de Navegação:</strong> endereço IP, tipo de navegador, páginas acessadas</li>
                            <li><strong>Dados de Interação:</strong> depoimentos, avaliações, mensagens de contato</li>
                            <li><strong>Documentos:</strong> currículos enviados através do formulário "Trabalhe Conosco"</li>
                        </ul>
                    </section>

                    <!-- 3. Finalidade -->
                    <section class="legal-section" id="finalidade">
                        <h3>3. Finalidade do Tratamento de Dados</h3>
                        <p>Utilizamos seus dados pessoais para as seguintes finalidades:</p>
                        <ul>
                            <li>Processar e responder solicitações de contato</li>
                            <li>Gerenciar processos seletivos e recrutamento</li>
                            <li>Publicar depoimentos e avaliações (mediante consentimento)</li>
                            <li>Melhorar nossos serviços e experiência do usuário</li>
                            <li>Enviar informações sobre nossos serviços (quando autorizado)</li>
                            <li>Cumprir obrigações legais e regulatórias</li>
                            <li>Garantir a segurança do nosso website</li>
                        </ul>
                    </section>

                    <!-- 4. Base Legal -->
                    <section class="legal-section" id="base-legal">
                        <h3>4. Base Legal para o Tratamento</h3>
                        <p>O tratamento de seus dados pessoais está fundamentado nas seguintes bases legais da LGPD:</p>
                        <ul>
                            <li><strong>Consentimento:</strong> para envio de depoimentos, recebimento de comunicações e uso de cookies não essenciais</li>
                            <li><strong>Execução de Contrato:</strong> para prestação de serviços contratados</li>
                            <li><strong>Legítimo Interesse:</strong> para melhorias do website e segurança</li>
                            <li><strong>Cumprimento de Obrigação Legal:</strong> quando exigido por lei</li>
                        </ul>
                    </section>

                    <!-- 5. Compartilhamento -->
                    <section class="legal-section" id="compartilhamento">
                        <h3>5. Compartilhamento de Dados</h3>
                        <p>Seus dados pessoais não serão vendidos, alugados ou compartilhados com terceiros, exceto:</p>
                        <ul>
                            <li>Com prestadores de serviços essenciais (hospedagem, análise de dados), sob rigorosos termos de confidencialidade</li>
                            <li>Quando exigido por lei ou ordem judicial</li>
                            <li>Para proteção dos direitos e segurança da Della Consul</li>
                            <li>Em caso de fusão, aquisição ou venda de ativos (com notificação prévia)</li>
                        </ul>
                    </section>

                    <!-- 6. Armazenamento -->
                    <section class="legal-section" id="armazenamento">
                        <h3>6. Armazenamento e Período de Retenção</h3>
                        <p>Seus dados pessoais são armazenados em servidores seguros e mantidos apenas pelo tempo necessário para cumprir as finalidades descritas:</p>
                        <ul>
                            <li><strong>Currículos:</strong> até 2 anos após o envio ou até solicitação de exclusão</li>
                            <li><strong>Depoimentos aprovados:</strong> enquanto houver consentimento ou até solicitação de exclusão</li>
                            <li><strong>Dados de contato:</strong> conforme necessário para atendimento da solicitação</li>
                            <li><strong>Dados de navegação:</strong> até 6 meses</li>
                        </ul>
                        <p>Dados necessários para cumprimento de obrigações legais serão mantidos conforme exigido por lei.</p>
                    </section>

                    <!-- 7. Direitos do Titular -->
                    <section class="legal-section" id="direitos-titular">
                        <h3>7. Direitos do Titular dos Dados</h3>
                        <div class="highlight-box">
                            <p><strong>De acordo com a LGPD, você tem os seguintes direitos:</strong></p>
                        </div>
                        <ul>
                            <li><strong>Confirmação e Acesso:</strong> saber se tratamos seus dados e acessá-los</li>
                            <li><strong>Correção:</strong> solicitar correção de dados incompletos, inexatos ou desatualizados</li>
                            <li><strong>Anonimização, Bloqueio ou Eliminação:</strong> de dados desnecessários ou excessivos</li>
                            <li><strong>Portabilidade:</strong> receber seus dados em formato estruturado</li>
                            <li><strong>Eliminação:</strong> dos dados tratados com seu consentimento</li>
                            <li><strong>Informação:</strong> sobre compartilhamento de dados com terceiros</li>
                            <li><strong>Revogação do Consentimento:</strong> retirar seu consentimento a qualquer momento</li>
                            <li><strong>Oposição:</strong> opor-se ao tratamento quando não for necessário consentimento</li>
                        </ul>
                        <p>Para exercer seus direitos, entre em contato através do e-mail: <strong>privacidade@dellaconsul.com</strong></p>
                    </section>

                    <!-- 8. Segurança -->
                    <section class="legal-section" id="seguranca">
                        <h3>8. Medidas de Segurança</h3>
                        <p>Implementamos medidas técnicas e organizacionais para proteger seus dados pessoais:</p>
                        <ul>
                            <li>Criptografia de dados em trânsito (HTTPS/SSL)</li>
                            <li>Controle de acesso restrito aos dados</li>
                            <li>Monitoramento de segurança e logs de acesso</li>
                            <li>Backups regulares e seguros</li>
                            <li>Treinamento da equipe sobre proteção de dados</li>
                            <li>Procedimentos para resposta a incidentes de segurança</li>
                        </ul>
                    </section>

                    <!-- 9. Cookies -->
                    <section class="legal-section" id="cookies">
                        <h3>9. Política de Cookies</h3>
                        <p>Utilizamos cookies e tecnologias semelhantes para:</p>
                        <ul>
                            <li><strong>Cookies Essenciais:</strong> necessários para funcionamento do site (sessão, autenticação)</li>
                            <li><strong>Cookies de Desempenho:</strong> análise de uso e melhorias do site</li>
                            <li><strong>Cookies de Funcionalidade:</strong> lembrar suas preferências</li>
                        </ul>
                        <p>Você pode controlar e desabilitar cookies através das configurações do seu navegador. Note que isso pode afetar a funcionalidade do site.</p>
                    </section>

                    <!-- 10. DPO -->
                    <section class="legal-section" id="dpo">
                        <h3>10. Encarregado de Proteção de Dados (DPO)</h3>
                        <p>Nomeamos um Encarregado de Proteção de Dados para atuar como canal de comunicação entre você, a Della Consul e a Autoridade Nacional de Proteção de Dados (ANPD).</p>
                        <p><strong>Contato DPO:</strong> privacidade@dellaconsul.com</p>
                        <p><strong>Telefone:</strong> (31) 3826-3154</p>
                    </section>

                    <!-- 11. Alterações -->
                    <section class="legal-section" id="alteracoes">
                        <h3>11. Alterações nesta Política</h3>
                        <p>Podemos atualizar esta Política de Privacidade periodicamente. Alterações significativas serão comunicadas através:</p>
                        <ul>
                            <li>Aviso destacado em nosso website</li>
                            <li>E-mail para usuários cadastrados</li>
                            <li>Atualização da data no topo desta página</li>
                        </ul>
                        <p>Recomendamos revisar esta política regularmente.</p>
                    </section>

                    <!-- 12. Legislação -->
                    <section class="legal-section" id="legislacao">
                        <h3>12. Legislação e Foro</h3>
                        <p>Esta Política de Privacidade é regida pela legislação brasileira, especialmente:</p>
                        <ul>
                            <li>Lei Geral de Proteção de Dados (Lei nº 13.709/2018)</li>
                            <li>Marco Civil da Internet (Lei nº 12.965/2014)</li>
                            <li>Código de Defesa do Consumidor (Lei nº 8.078/1990)</li>
                        </ul>
                        <p>Fica eleito o foro da comarca de Ipatinga/MG para dirimir quaisquer controvérsias decorrentes desta política.</p>
                    </section>

                    <hr class="my-5">

                    <div class="text-center">
                        <p class="text-muted mb-3">Tem dúvidas sobre esta política?</p>
                        <a href="<?=urlBase('contatos');?>" class="btn btn-primary">Entre em Contato</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->end("container"); ?>
