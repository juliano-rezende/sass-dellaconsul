<?php $this->layout("_theme"); ?>

<?php $this->start("css"); ?>
<style>
    .careers-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 120px 0 80px;
        text-align: center;
    }

    .careers-title {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .careers-subtitle {
        font-size: 1.25rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto 2rem;
    }

    .careers-form-section {
        padding: 80px 0;
        background-color: #f8f9fa;
    }

    .careers-form-card {
        background: white;
        border-radius: 15px;
        padding: 3rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .section-header {
        margin-bottom: 3rem;
    }

    .section-header h2 {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .section-header p {
        color: #6c757d;
        font-size: 1.1rem;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        padding: 1rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }

    .careers-info {
        padding: 80px 0;
        background: white;
    }

    .careers-info-card {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 2rem;
        height: 100%;
        text-align: center;
        transition: all 0.3s ease;
    }

    .careers-info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .careers-info-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: white;
        font-size: 2rem;
    }

    .careers-info-card h4 {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .careers-info-card p {
        color: #6c757d;
        line-height: 1.6;
    }

    .vacancies-section {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .vacancy-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .vacancy-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .vacancy-title {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .vacancy-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .vacancy-description {
        color: #6c757d;
        line-height: 1.6;
        margin: 1rem 0;
    }

    .vacancy-requirements {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }

    .vacancy-requirements h6 {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .vacancy-requirements ul {
        color: #6c757d;
        padding-left: 1.5rem;
    }

    .vacancy-requirements li {
        margin-bottom: 0.5rem;
    }

    .file-upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 10px;
        padding: 2rem;
        text-align: center;
        background: #f8f9fa;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .file-upload-area:hover {
        border-color: #667eea;
        background: #f0f2ff;
    }

    .file-upload-area.dragover {
        border-color: #667eea;
        background: #e8ecff;
    }

    .file-upload-icon {
        font-size: 3rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }

    .file-upload-text {
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .file-upload-hint {
        color: #adb5bd;
        font-size: 0.875rem;
    }

    .client-separator-dark {
        height: 80px;
        background: #2c3e50;
    }
</style>
<?php $this->end("css"); ?>

<?php $this->start("container"); ?>

<!-- Hero Section -->
<section class="careers-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="careers-title">
                    Trabalhe Conosco
                </h1>
                <p class="careers-subtitle">
                    Junte-se à nossa equipe e faça parte de uma empresa que valoriza pessoas,
                    inovação e excelência na gestão condominial.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#vagas" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-briefcase me-2"></i>Ver Vagas
                    </a>
                    <a href="#formulario" class="btn btn-light btn-lg">
                        <i class="fas fa-paper-plane me-2"></i>Enviar Currículo
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Informações sobre a Empresa -->
<section class="careers-info">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="careers-info-card">
                    <div class="careers-info-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4>Equipe Colaborativa</h4>
                    <p>Trabalhamos em equipe, valorizando a diversidade e promovendo um ambiente
                        de respeito e crescimento mútuo.</p>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="careers-info-card">
                    <div class="careers-info-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h4>Desenvolvimento Profissional</h4>
                    <p>Investimos no crescimento dos nossos colaboradores através de treinamentos,
                        capacitações e oportunidades de carreira.</p>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="careers-info-card">
                    <div class="careers-info-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h4>Benefícios Atraentes</h4>
                    <p>Oferecemos benefícios competitivos, ambiente descontraído e horários flexíveis
                        para garantir sua qualidade de vida.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Formulário de Currículo -->
<section class="careers-form-section" id="formulario">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-header text-center">
                    <h2>Envie seu Currículo</h2>
                    <p>Preencha o formulário abaixo e anexe seu currículo. Nossa equipe entrará em contato em até 48
                        horas</p>
                </div>

                <div class="careers-form-card">
                    <form id="careersForm">
                        <div class="row g-4">
                            <!-- Informações Pessoais -->
                            <div class="col-12">
                                <h5 class="mb-3 text-primary">
                                    <i class="fas fa-user me-2"></i>Informações Pessoais
                                </h5>
                            </div>

                            <div class="col-md-6">
                                <label for="nome" class="form-label">Nome Completo *</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>

                            <div class="col-md-6">
                                <label for="cpf" class="form-label">CPF *</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" required>
                            </div>

                            <div class="col-md-6">
                                <label for="data_nascimento" class="form-label">Data de Nascimento *</label>
                                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento"
                                       required>
                            </div>

                            <div class="col-md-6">
                                <label for="estado_civil" class="form-label">Estado Civil</label>
                                <select class="form-control" id="estado_civil" name="estado_civil">
                                    <option value="">Selecione...</option>
                                    <option value="solteiro">Solteiro(a)</option>
                                    <option value="casado">Casado(a)</option>
                                    <option value="divorciado">Divorciado(a)</option>
                                    <option value="viuvo">Viúvo(a)</option>
                                </select>
                            </div>

                            <!-- Informações de Contato -->
                            <div class="col-12">
                                <h5 class="mb-3 text-primary mt-4">
                                    <i class="fas fa-phone me-2"></i>Informações de Contato
                                </h5>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">E-mail *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="col-md-6">
                                <label for="telefone" class="form-label">Telefone *</label>
                                <input type="tel" class="form-control" id="telefone" name="telefone" required>
                            </div>

                            <div class="col-md-6">
                                <label for="celular" class="form-label">Celular</label>
                                <input type="tel" class="form-control" id="celular" name="celular">
                            </div>

                            <div class="col-md-6">
                                <label for="whatsapp" class="form-label">WhatsApp</label>
                                <input type="tel" class="form-control" id="whatsapp" name="whatsapp">
                            </div>

                            <!-- Endereço -->
                            <div class="col-12">
                                <h5 class="mb-3 text-primary mt-4">
                                    <i class="fas fa-map-marker-alt me-2"></i>Endereço
                                </h5>
                            </div>

                            <div class="col-md-6">
                                <label for="cep" class="form-label">CEP *</label>
                                <input type="text" class="form-control" id="cep" name="cep" required>
                            </div>

                            <div class="col-md-6">
                                <label for="endereco" class="form-label">Endereço *</label>
                                <input type="text" class="form-control" id="endereco" name="endereco" required>
                            </div>

                            <div class="col-md-4">
                                <label for="numero" class="form-label">Número *</label>
                                <input type="text" class="form-control" id="numero" name="numero" required>
                            </div>

                            <div class="col-md-4">
                                <label for="complemento" class="form-label">Complemento</label>
                                <input type="text" class="form-control" id="complemento" name="complemento">
                            </div>

                            <div class="col-md-4">
                                <label for="bairro" class="form-label">Bairro *</label>
                                <input type="text" class="form-control" id="bairro" name="bairro" required>
                            </div>

                            <div class="col-md-6">
                                <label for="cidade" class="form-label">Cidade *</label>
                                <input type="text" class="form-control" id="cidade" name="cidade" required>
                            </div>

                            <div class="col-md-6">
                                <label for="estado" class="form-label">Estado *</label>
                                <select class="form-control" id="estado" name="estado" required>
                                    <option value="">Selecione...</option>
                                    <option value="AC">Acre</option>
                                    <option value="AL">Alagoas</option>
                                    <option value="AP">Amapá</option>
                                    <option value="AM">Amazonas</option>
                                    <option value="BA">Bahia</option>
                                    <option value="CE">Ceará</option>
                                    <option value="DF">Distrito Federal</option>
                                    <option value="ES">Espírito Santo</option>
                                    <option value="GO">Goiás</option>
                                    <option value="MA">Maranhão</option>
                                    <option value="MT">Mato Grosso</option>
                                    <option value="MS">Mato Grosso do Sul</option>
                                    <option value="MG">Minas Gerais</option>
                                    <option value="PA">Pará</option>
                                    <option value="PB">Paraíba</option>
                                    <option value="PR">Paraná</option>
                                    <option value="PE">Pernambuco</option>
                                    <option value="PI">Piauí</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="RN">Rio Grande do Norte</option>
                                    <option value="RS">Rio Grande do Sul</option>
                                    <option value="RO">Rondônia</option>
                                    <option value="RR">Roraima</option>
                                    <option value="SC">Santa Catarina</option>
                                    <option value="SP">São Paulo</option>
                                    <option value="SE">Sergipe</option>
                                    <option value="TO">Tocantins</option>
                                </select>
                            </div>

                            <!-- Informações Profissionais -->
                            <div class="col-12">
                                <h5 class="mb-3 text-primary mt-4">
                                    <i class="fas fa-briefcase me-2"></i>Informações Profissionais
                                </h5>
                            </div>

                            <div class="col-md-6">
                                <label for="career_area_id" class="form-label">Área de Interesse *</label>
                                <select class="form-control" id="career_area_id" name="career_area_id" required>
                                    <option value="">Selecione uma área...</option>
                                    <?php if (!empty($careerAreas)): ?>
                                        <?php foreach ($careerAreas as $area): ?>
                                            <option value="<?= $area['id'] ?>"><?= htmlspecialchars($area['name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="1">Administração</option>
                                        <option value="2">Manutenção</option>
                                        <option value="3">Segurança</option>
                                        <option value="4">Limpeza</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="cargo_interesse" class="form-label">Cargo Específico</label>
                                <input type="text" class="form-control" id="cargo_interesse" name="cargo_interesse" placeholder="Ex: Zelador, Porteiro, etc.">
                            </div>

                            <div class="col-md-6">
                                <label for="experiencia" class="form-label">Tempo de Experiência *</label>
                                <select class="form-control" id="experiencia" name="experiencia" required>
                                    <option value="">Selecione...</option>
                                    <option value="sem_experiencia">Sem experiência</option>
                                    <option value="ate_1_ano">Até 1 ano</option>
                                    <option value="1_a_3_anos">1 a 3 anos</option>
                                    <option value="3_a_5_anos">3 a 5 anos</option>
                                    <option value="5_a_10_anos">5 a 10 anos</option>
                                    <option value="mais_10_anos">Mais de 10 anos</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="escolaridade" class="form-label">Escolaridade *</label>
                                <select class="form-control" id="escolaridade" name="escolaridade" required>
                                    <option value="">Selecione...</option>
                                    <option value="fundamental_incompleto">Fundamental Incompleto</option>
                                    <option value="fundamental_completo">Fundamental Completo</option>
                                    <option value="medio_incompleto">Médio Incompleto</option>
                                    <option value="medio_completo">Médio Completo</option>
                                    <option value="superior_incompleto">Superior Incompleto</option>
                                    <option value="superior_completo">Superior Completo</option>
                                    <option value="pos_graduacao">Pós-graduação</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="pretensao_salarial" class="form-label">Pretensão Salarial</label>
                                <select class="form-control" id="pretensao_salarial" name="pretensao_salarial">
                                    <option value="">Selecione...</option>
                                    <option value="ate_sm">Até 1 salário mínimo</option>
                                    <option value="1_a_2_sm">1 a 2 salários mínimos</option>
                                    <option value="2_a_3_sm">2 a 3 salários mínimos</option>
                                    <option value="3_a_5_sm">3 a 5 salários mínimos</option>
                                    <option value="mais_5_sm">Mais de 5 salários mínimos</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="disponibilidade" class="form-label">Disponibilidade *</label>
                                <select class="form-control" id="disponibilidade" name="disponibilidade" required>
                                    <option value="">Selecione...</option>
                                    <option value="imediata">Imediata</option>
                                    <option value="15_dias">15 dias</option>
                                    <option value="30_dias">30 dias</option>
                                    <option value="60_dias">60 dias</option>
                                    <option value="90_dias">90 dias</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="disponibilidade_horarios" class="form-label">Disponibilidade de
                                    Horários</label>
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="manha"
                                                   name="disponibilidade_horarios[]" value="manha">
                                            <label class="form-check-label" for="manha">Manhã</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="tarde"
                                                   name="disponibilidade_horarios[]" value="tarde">
                                            <label class="form-check-label" for="tarde">Tarde</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="noite"
                                                   name="disponibilidade_horarios[]" value="noite">
                                            <label class="form-check-label" for="noite">Noite</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="plantao"
                                                   name="disponibilidade_horarios[]" value="plantao">
                                            <label class="form-check-label" for="plantao">Plantão</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Anexo de Currículo -->
                            <div class="col-12">
                                <h5 class="mb-3 text-primary mt-4">
                                    <i class="fas fa-file-upload me-2"></i>Anexo de Currículo
                                </h5>
                            </div>

                            <div class="col-12">
                                <div class="file-upload-area" id="fileUploadArea">
                                    <div class="file-upload-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <div class="file-upload-text">
                                        Clique aqui para anexar seu currículo ou arraste o arquivo
                                    </div>
                                    <div class="file-upload-hint">
                                        Formatos aceitos: PDF, DOC, DOCX (Máximo: 5MB)
                                    </div>
                                    <input type="file" id="curriculo" name="curriculo" accept=".pdf,.doc,.docx"
                                           style="position: absolute; opacity: 0; width: 0; height: 0; overflow: hidden;" required>
                                </div>
                                <div id="fileInfo" class="mt-3" style="display: none;">
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle me-2"></i>
                                        <span id="fileName"></span>
                                        <button type="button" class="btn btn-sm btn-outline-danger ms-2"
                                                id="removeFile">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Observações -->
                            <div class="col-12">
                                <label for="observacoes" class="form-label">Observações Adicionais</label>
                                <textarea class="form-control" id="observacoes" name="observacoes" rows="4"
                                          placeholder="Informações adicionais sobre sua experiência, habilidades especiais, disponibilidade ou qualquer outra informação relevante..."></textarea>
                            </div>

                            <!-- Termos -->
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="concordo_termos" required>
                                    <label class="form-check-label" for="concordo_termos">
                                        Concordo com a <a href="#" class="text-primary">Política de Privacidade</a>
                                        e autorizo o uso dos meus dados para fins de recrutamento e seleção
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>Enviar Currículo
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->end("container"); ?>

<?php $this->start("js"); ?>
<script>
    // Verifica se jQuery está carregado
    if (typeof jQuery === 'undefined') {
        console.error('jQuery não está carregado!');
    }
    
    $(document).ready(function () {
        console.log('Document ready - Careers page');
        
        // Verifica se os elementos existem
        if ($('#fileUploadArea').length === 0) {
            console.error('Elemento #fileUploadArea não encontrado!');
        }
        if ($('#curriculo').length === 0) {
            console.error('Elemento #curriculo não encontrado!');
        }
        
        // Máscara para CPF
        if ($('#cpf').length > 0 && typeof $.fn.mask !== 'undefined') {
            $('#cpf').mask('000.000.000-00');
        }

        // Máscara para telefone
        if (typeof $.fn.mask !== 'undefined') {
            $('#telefone').mask('(00) 0000-0000');
            $('#celular').mask('(00) 00000-0000');
            $('#whatsapp').mask('(00) 00000-0000');

            // Máscara para CEP
            $('#cep').mask('00000-000');
        }

        // Busca CEP
        $('#cep').on('blur', function () {
            const cep = $(this).val().replace(/\D/g, '');
            if (cep.length === 8) {
                $.get(`https://viacep.com.br/ws/${cep}/json/`, function (data) {
                    if (!data.erro) {
                        $('#endereco').val(data.logradouro);
                        $('#bairro').val(data.bairro);
                        $('#cidade').val(data.localidade);
                        $('#estado').val(data.uf);
                    }
                });
            }
        });

        // Upload de arquivo - múltiplas formas de garantir que funcione
        $('#fileUploadArea').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('File upload area clicked');
            
            // Tenta múltiplas formas de disparar o click
            const fileInput = document.getElementById('curriculo');
            if (fileInput) {
                fileInput.click();
            } else {
                $('#curriculo').click();
            }
        });

        // Também permite clicar diretamente no input (caso esteja visível)
        $('#curriculo').on('click', function (e) {
            e.stopPropagation();
            console.log('File input clicked directly');
        });
        
        // Fallback: adiciona listener também no elemento nativo
        const fileInputNative = document.getElementById('curriculo');
        if (fileInputNative) {
            fileInputNative.addEventListener('click', function(e) {
                console.log('Native file input clicked');
            });
        }

        $('#curriculo').on('change', function (e) {
            console.log('File input changed');
            const file = this.files[0];
            if (file) {
                console.log('File selected:', file.name, file.type, file.size);
                
                // Validar tamanho (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('O arquivo é muito grande. Tamanho máximo: 5MB');
                    this.value = '';
                    return;
                }

                // Validar tipo
                const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                const allowedExtensions = ['pdf', 'doc', 'docx'];
                const fileExtension = file.name.split('.').pop().toLowerCase();
                
                if (!allowedTypes.includes(file.type) && !allowedExtensions.includes(fileExtension)) {
                    alert('Tipo de arquivo não permitido. Use PDF, DOC ou DOCX');
                    this.value = '';
                    return;
                }

                $('#fileName').text(file.name);
                $('#fileInfo').show();
                $('#fileUploadArea').hide();
            } else {
                console.log('No file selected');
            }
        });

        // Remover arquivo
        $('#removeFile').on('click', function () {
            $('#curriculo').val('');
            $('#fileInfo').hide();
            $('#fileUploadArea').show();
        });

        // Drag and drop
        $('#fileUploadArea').on('dragover', function (e) {
            e.preventDefault();
            $(this).addClass('dragover');
        });

        $('#fileUploadArea').on('dragleave', function (e) {
            e.preventDefault();
            $(this).removeClass('dragover');
        });

        $('#fileUploadArea').on('drop', function (e) {
            e.preventDefault();
            $(this).removeClass('dragover');

            const files = e.originalEvent.dataTransfer.files;
            if (files.length > 0) {
                $('#curriculo')[0].files = files;
                $('#curriculo').trigger('change');
            }
        });

        // Envio do formulário
        $('#careersForm').on('submit', function (e) {
            e.preventDefault();

            // Validação básica
            if (!$('#concordo_termos').is(':checked')) {
                alert('Você deve concordar com os termos para continuar');
                return;
            }

            const curriculumFile = $('#curriculo')[0].files[0];
            if (!curriculumFile) {
                alert('Por favor, anexe seu currículo');
                return;
            }

            // Valida campos obrigatórios
            const nome = $('#nome').val().trim();
            const email = $('#email').val().trim();
            const telefone = $('#telefone').val().trim();
            const careerAreaId = $('#career_area_id').val();
            const cargoInteresse = $('#cargo_interesse').val().trim();

            if (!nome || !email || !telefone || !careerAreaId) {
                alert('Por favor, preencha todos os campos obrigatórios');
                return;
            }

            // Mostra loading
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Enviando...');

            // Prepara FormData
            const formData = new FormData();
            formData.append('name', nome);
            formData.append('email', email);
            formData.append('phone', telefone);
            formData.append('career_area_id', careerAreaId);
            formData.append('position', cargoInteresse || 'Não especificado');
            
            // Mapeia experiência
            const experiencia = $('#experiencia').val();
            const experienceMap = {
                'sem_experiencia': 0,
                'ate_1_ano': 1,
                '1_a_3_anos': 2,
                '3_a_5_anos': 4,
                '5_a_10_anos': 7,
                'mais_10_anos': 10
            };
            formData.append('experience_years', experienceMap[experiencia] || 0);
            
            // Mensagem com informações adicionais
            let message = '';
            if ($('#mensagem').val()) {
                message = $('#mensagem').val().trim();
            }
            formData.append('message', message);
            
            // Arquivo do currículo
            formData.append('curriculum_file', curriculumFile);

            // Envia via AJAX
            $.ajax({
                url: '<?= urlBase("trabalhe-conosco") ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    submitBtn.prop('disabled', false).html(originalText);
                    
                    // Tenta parsear se for string
                    let result = response;
                    if (typeof response === 'string') {
                        try {
                            result = JSON.parse(response);
                        } catch(e) {
                            console.error('Erro ao parsear resposta:', e, response);
                            alert('Erro ao processar resposta do servidor');
                            return;
                        }
                    }
                    
                    if (result.success) {
                        alert(result.message || 'Currículo enviado com sucesso! Nossa equipe entrará em contato em até 48 horas.');
                        // Reset do formulário
                        $('#careersForm')[0].reset();
                        $('#fileInfo').hide();
                        $('#fileUploadArea').show();
                    } else {
                        alert(result.message || 'Erro ao enviar currículo. Tente novamente.');
                    }
                },
                error: function(xhr, status, error) {
                    submitBtn.prop('disabled', false).html(originalText);
                    
                    console.error('Erro AJAX:', {
                        status: xhr.status,
                        statusText: xhr.statusText,
                        responseText: xhr.responseText,
                        error: error
                    });
                    
                    let message = 'Erro ao enviar currículo';
                    
                    if (xhr.responseText) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.message) {
                                message = response.message;
                            }
                        } catch(e) {
                            if (xhr.status === 0) {
                                message = 'Erro de conexão. Verifique sua internet.';
                            } else if (xhr.status === 500) {
                                message = 'Erro interno do servidor. Tente novamente mais tarde.';
                            } else {
                                message = `Erro ${xhr.status}: ${error || xhr.statusText}`;
                            }
                        }
                    }
                    
                    alert(message);
                }
            });
        });

        // Smooth scroll para links internos
        $('a[href^="#"]').on('click', function (e) {
            e.preventDefault();
            const target = $(this.getAttribute('href'));
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 800);
            }
        });
    });
</script>
<?php $this->end("js"); ?>
