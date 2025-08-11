<?php $this->layout("_theme"); ?>

<?php $this->start("css"); ?>
<style>
    .upload-zone {
        border: 2px dashed #dee2e6;
        border-radius: 10px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .upload-zone:hover,
    .upload-zone.dragover {
        border-color: #2563eb;
        background-color: rgba(37, 99, 235, 0.05);
    }

    .file-preview {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 1rem;
        background-color: #f8f9fa;
    }

    .selected-file {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .selected-file i {
        color: #6c757d;
    }
</style>
<?php $this->end("css"); ?>

<?php $this->start("container"); ?>

<!-- Page Content -->
<div class="dashboard-content">
    <!-- Upload Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-upload me-2"></i>
                Upload de Arquivos de Condomínio
            </h5>
        </div>
        <div class="card-body">
            <form id="arquivoForm" class="arquivo-form">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="condominio" class="form-label">Condomínio</label>
                        <select class="form-select" id="condominio" required>
                            <option value="">Selecione o condomínio</option>
                            <option value="001">Residencial Solar (ID: 001)</option>
                            <option value="002">Edifício Vista (ID: 002)</option>
                            <option value="003">Condomínio Jardim (ID: 003)</option>
                            <option value="004">Complexo Central (ID: 004)</option>
                            <option value="005">Residencial Horizonte (ID: 005)</option>
                            <option value="006">Tower Business (ID: 006)</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tipoArquivo" class="form-label">Tipo de Arquivo</label>
                        <select class="form-select" id="tipoArquivo" required>
                            <option value="">Selecione o tipo</option>
                            <option value="contrato">Contrato</option>
                            <option value="relatorio">Relatório</option>
                            <option value="manutencao">Manutenção</option>
                            <option value="financeiro">Financeiro</option>
                            <option value="seguranca">Segurança</option>
                            <option value="documento">Documento</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="referencia" class="form-label">Referência</label>
                        <input type="text" class="form-control" id="referencia" placeholder="Ex: CONTR-2024-001" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="dataArquivo" class="form-label">Data do Arquivo</label>
                        <input type="date" class="form-control" id="dataArquivo" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" rows="3" placeholder="Descreva o conteúdo do arquivo" required></textarea>
                </div>

                <div class="upload-area mb-3">
                    <label class="form-label">Arquivo</label>
                    <div class="upload-zone" id="uploadZone">
                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                        <h5>Arraste e solte o arquivo aqui</h5>
                        <p class="text-muted">ou clique para selecionar</p>
                        <p class="text-muted small">Formatos aceitos: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG (Máx: 10MB)</p>
                        <input type="file" id="fileInput" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" style="display: none;">
                        <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('fileInput').click()">
                            <i class="fas fa-folder-open me-2"></i>
                            Selecionar Arquivo
                        </button>
                    </div>
                    <div id="filePreview" class="file-preview mt-3" style="display: none;">
                        <div class="selected-file">
                            <i class="fas fa-file me-2"></i>
                            <span id="fileName"></span>
                            <small id="fileSize" class="text-muted"></small>
                            <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="removeFile()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-2"></i>
                        Enviar Arquivo
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Files List Section -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>
                Arquivos Registrados
            </h5>
            <div class="d-flex gap-2">
                <div class="input-group" style="width: 300px;">
                    <input type="text" class="form-control" placeholder="Buscar arquivos..." id="searchInput">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <select class="form-select" style="width: 150px;" id="filterCondominio">
                    <option value="">Todos os condomínios</option>
                    <option value="001">Residencial Solar</option>
                    <option value="002">Edifício Vista</option>
                    <option value="003">Condomínio Jardim</option>
                    <option value="004">Complexo Central</option>
                    <option value="005">Residencial Horizonte</option>
                    <option value="006">Tower Business</option>
                </select>
                <select class="form-select" style="width: 150px;" id="filterTipo">
                    <option value="">Todos os tipos</option>
                    <option value="contrato">Contrato</option>
                    <option value="relatorio">Relatório</option>
                    <option value="manutencao">Manutenção</option>
                    <option value="financeiro">Financeiro</option>
                    <option value="seguranca">Segurança</option>
                    <option value="documento">Documento</option>
                    <option value="outro">Outro</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Arquivo</th>
                        <th>Condomínio</th>
                        <th>Tipo</th>
                        <th>Referência</th>
                        <th>Data</th>
                        <th>Tamanho</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody id="arquivosTableBody">
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-pdf text-danger me-2"></i>
                                <div>
                                    <div>contrato_residencial_solar.pdf</div>
                                    <small class="text-muted">Contrato de gestão condominial</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-primary">Residencial Solar</span>
                        </td>
                        <td><span class="badge bg-info">Contrato</span></td>
                        <td>CONTR-2024-001</td>
                        <td>15/01/2024</td>
                        <td>2.5 MB</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary" title="Download">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" title="Remover">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-excel text-success me-2"></i>
                                <div>
                                    <div>relatorio_financeiro_vista.xlsx</div>
                                    <small class="text-muted">Relatório financeiro mensal</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-warning">Edifício Vista</span>
                        </td>
                        <td><span class="badge bg-success">Relatório</span></td>
                        <td>REL-2024-002</td>
                        <td>14/01/2024</td>
                        <td>1.8 MB</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary" title="Download">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" title="Remover">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-word text-primary me-2"></i>
                                <div>
                                    <div>manutencao_elevador_jardim.docx</div>
                                    <small class="text-muted">Relatório de manutenção do elevador</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-primary">Condomínio Jardim</span>
                        </td>
                        <td><span class="badge bg-warning">Manutenção</span></td>
                        <td>MANUT-2024-003</td>
                        <td>13/01/2024</td>
                        <td>3.2 MB</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary" title="Download">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" title="Remover">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Navegação de páginas">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Anterior</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Próximo</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php $this->end("container"); ?>

<?php $this->start("js"); ?>
<script>
    // Arquivos de Condomínio specific JavaScript
    $(document).ready(function() {
        // Set current date
        $('#dataArquivo').val(new Date().toISOString().split('T')[0]);

        // File upload handling
        const uploadZone = document.getElementById('uploadZone');
        const fileInput = document.getElementById('fileInput');
        const filePreview = document.getElementById('filePreview');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');

        // Drag and drop functionality
        uploadZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadZone.classList.add('dragover');
        });

        uploadZone.addEventListener('dragleave', () => {
            uploadZone.classList.remove('dragover');
        });

        uploadZone.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadZone.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFile(files[0]);
            }
        });

        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleFile(e.target.files[0]);
            }
        });

        function handleFile(file) {
            fileName.textContent = file.name;
            fileSize.textContent = `(${formatFileSize(file.size)})`;
            filePreview.style.display = 'block';
            uploadZone.style.display = 'none';
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        window.removeFile = function() {
            filePreview.style.display = 'none';
            uploadZone.style.display = 'block';
            fileInput.value = '';
        };

        // Form submission
        $('#arquivoForm').on('submit', function(e) {
            e.preventDefault();
            showToast('Arquivo enviado com sucesso!', 'success');
            this.reset();
            removeFile();
        });

        // Search functionality
        $('#searchInput').on('keyup', function() {
            const query = $(this).val().toLowerCase();
            $('#arquivosTableBody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(query) > -1);
            });
        });

        // Filter functionality
        $('#filterCondominio, #filterTipo').on('change', function() {
            applyFilters();
        });

        function applyFilters() {
            const condominio = $('#filterCondominio').val();
            const tipo = $('#filterTipo').val();

            $('#arquivosTableBody tr').each(function() {
                let show = true;

                if (condominio) {
                    const cardCondominio = $(this).find('td:nth-child(2) .badge').text().toLowerCase();
                    if (!cardCondominio.includes(condominio.toLowerCase())) {
                        show = false;
                    }
                }

                if (tipo) {
                    const cardTipo = $(this).find('td:nth-child(3) .badge').text().toLowerCase();
                    if (cardTipo !== tipo.toLowerCase()) {
                        show = false;
                    }
                }

                $(this).toggle(show);
            });
        }

        // Action buttons
        $(document).on('click', '.btn-outline-primary', function() {
            showToast('Download iniciado...', 'info');
        });

        $(document).on('click', '.btn-outline-success', function() {
            showToast('Visualizando arquivo...', 'info');
        });

        $(document).on('click', '.btn-outline-warning', function() {
            showToast('Editando arquivo...', 'info');
        });

        $(document).on('click', '.btn-outline-danger', function() {
            if (confirm('Tem certeza que deseja remover este arquivo?')) {
                $(this).closest('tr').fadeOut();
                showToast('Arquivo removido com sucesso!', 'success');
            }
        });
    });
</script>
<?php $this->end("js"); ?>
