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

    .file-item {
        background-color: #f8f9fa;
    }

    .file-item:hover {
        background-color: #e9ecef;
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
                Upload de Formulários
            </h5>
        </div>
        <div class="card-body">
            <form id="uploadForm" class="upload-form">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="formType" class="form-label">Tipo de Formulário</label>
                        <select class="form-select" id="group" required>
                            <option value="">Selecione o tipo</option>
                            <option value="1">Direito Condominial e gestao de condominio</option>
                            <option value="2">Praticas de servicos e logisticas</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="formDescription" class="form-label">Descrição</label>
                        <textarea class="form-control" id="formDescription" rows="3"
                                  placeholder="Descreva o formulário"></textarea>
                    </div>
                </div>

                <div class="upload-area mb-3">
                    <div class="upload-zone" id="uploadZone">
                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                        <h5>Arraste e solte arquivos aqui</h5>
                        <p class="text-muted">ou clique para selecionar</p>
                        <input type="file" id="fileInput" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.txt"
                               style="display: none;">
                        <button type="button" class="btn btn-outline-primary"
                                onclick="document.getElementById('fileInput').click()">
                            <i class="fas fa-folder-open me-2"></i>
                            Selecionar Arquivos
                        </button>
                    </div>
                    <div id="fileList" class="file-list mt-3" style="display: none;">
                        <h6>Arquivos selecionados:</h6>
                        <div id="selectedFiles"></div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-2"></i>
                        Enviar Formulários
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
                Formulários Enviados
            </h5>
            <div class="d-flex gap-2">
                <div class="input-group" style="width: 300px;">
                    <input type="text" class="form-control" placeholder="Buscar formulários..." id="searchInput">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <select class="form-select" style="width: 150px;" id="filterType">
                    <option value="">Todos os tipos</option>
                    <option value="contrato">Contrato</option>
                    <option value="relatorio">Relatório</option>
                    <option value="planilha">Planilha</option>
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
                        <th>Nome do Arquivo</th>
                        <th>Tipo</th>
                        <th>Título</th>
                        <th>Versão</th>
                        <th>Data de Upload</th>
                        <th>Tamanho</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody id="filesTableBody">
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-pdf text-danger me-2"></i>
                                <span>contrato_condominio_2024.pdf</span>
                            </div>
                        </td>
                        <td><span class="badge bg-primary">Contrato</span></td>
                        <td>Contrato de Gestão Condominial</td>
                        <td>v2.1</td>
                        <td>15/01/2024</td>
                        <td>2.5 MB</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary" title="Download">
                                    <i class="fas fa-download"></i>
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
                                <span>relatorio_financeiro.xlsx</span>
                            </div>
                        </td>
                        <td><span class="badge bg-info">Relatório</span></td>
                        <td>Relatório Financeiro Mensal</td>
                        <td>v1.0</td>
                        <td>14/01/2024</td>
                        <td>1.8 MB</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary" title="Download">
                                    <i class="fas fa-download"></i>
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
                                <span>manual_procedimentos.docx</span>
                            </div>
                        </td>
                        <td><span class="badge bg-secondary">Documento</span></td>
                        <td>Manual de Procedimentos</td>
                        <td>v3.0</td>
                        <td>13/01/2024</td>
                        <td>3.2 MB</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary" title="Download">
                                    <i class="fas fa-download"></i>
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
    // Formulários specific JavaScript
    $(document).ready(function () {
        // File upload handling
        const uploadZone = document.getElementById('uploadZone');
        const fileInput = document.getElementById('fileInput');
        const fileList = document.getElementById('fileList');
        const selectedFiles = document.getElementById('selectedFiles');

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
            handleFiles(files);
        });

        fileInput.addEventListener('change', (e) => {
            handleFiles(e.target.files);
        });

        function handleFiles(files) {
            if (files.length > 0) {
                fileList.style.display = 'block';
                selectedFiles.innerHTML = '';

                Array.from(files).forEach(file => {
                    const fileItem = document.createElement('div');
                    fileItem.className = 'file-item d-flex justify-content-between align-items-center p-2 border rounded mb-2';
                    fileItem.innerHTML = `
                            <div>
                                <i class="fas fa-file me-2"></i>
                                <span>${file.name}</span>
                                <small class="text-muted">(${formatFileSize(file.size)})</small>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        `;
                    selectedFiles.appendChild(fileItem);
                });
            }
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Form submission
        $('#uploadForm').on('submit', function (e) {
            e.preventDefault();
            showToast('Formulários enviados com sucesso!', 'success');
            this.reset();
            fileList.style.display = 'none';
            selectedFiles.innerHTML = '';
        });

        // Search functionality
        $('#searchInput').on('keyup', function () {
            const query = $(this).val().toLowerCase();
            $('#filesTableBody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(query) > -1);
            });
        });

        // Filter functionality
        $('#filterType').on('change', function () {
            const filter = $(this).val();
            if (filter) {
                $('#filesTableBody tr').hide();
                $('#filesTableBody tr').each(function () {
                    const type = $(this).find('.badge').text().toLowerCase();
                    if (type === filter.toLowerCase()) {
                        $(this).show();
                    }
                });
            } else {
                $('#filesTableBody tr').show();
            }
        });

        // Download and delete buttons
        $(document).on('click', '.btn-outline-primary', function () {
            showToast('Download iniciado...', 'info');
        });

        $(document).on('click', '.btn-outline-danger', function () {
            if (confirm('Tem certeza que deseja remover este arquivo?')) {
                $(this).closest('tr').fadeOut();
                showToast('Arquivo removido com sucesso!', 'success');
            }
        });
    });
</script>
<?php $this->end("js"); ?>
