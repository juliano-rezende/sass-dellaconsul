<?php $this->layout("_theme"); ?>

<?php $this->start("css"); ?>
<style>
    /* Page Header */
    .dashboard-content h4 {
        font-weight: 600;
        color: #1e293b;
    }
    
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
        font-size: 0.875rem;
    }
    
    .breadcrumb-item a {
        color: #64748b;
        text-decoration: none;
    }
    
    .breadcrumb-item a:hover {
        color: #2563eb;
    }
    
    .breadcrumb-item.active {
        color: #94a3b8;
    }
    
    /* Padding para modals */
    #sliderModal .modal-body {
        padding: 2rem !important;
    }
    
    #sliderModal .modal-header {
        padding: 1.5rem 2rem;
    }
    
    #sliderModal .modal-footer {
        padding: 1rem 2rem 1.5rem;
    }
    
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

    .slider-card {
        border: 1px solid #dee2e6;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .slider-card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .slider-image {
        position: relative;
        overflow: hidden;
    }

    .slider-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .slider-card:hover .slider-overlay {
        opacity: 1;
    }

    .slider-status {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .slider-status.active {
        background: rgba(16, 185, 129, 0.9);
        color: white;
    }

    .slider-status.inactive {
        background: rgba(239, 68, 68, 0.9);
        color: white;
    }

    .slider-info {
        padding: 1rem;
    }

    .slider-info h6 {
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .slider-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.5rem;
    }

    .image-preview {
        text-align: center;
    }
</style>
<?php $this->end("css"); ?>

<?php $this->start("container"); ?>

<!-- Page Content -->
<div class="dashboard-content">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Gerenciamento de Sliders</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= urlBase('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Sliders</li>
                </ol>
            </nav>
        </div>
        <div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sliderModal" onclick="openSliderModal()">
                <i class="fas fa-plus me-2"></i>
                Adicionar Novo Slide
            </button>
        </div>
    </div>

    <!-- Sliders List Section -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>
                Slides Cadastrados
            </h5>
            <div class="d-flex gap-2">
                <div class="input-group" style="width: 300px;">
                    <input type="text" class="form-control" placeholder="Buscar slides..." id="searchInput">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <select class="form-select" style="width: 150px;" id="filterStatus">
                    <option value="">Todos</option>
                    <option value="active">Ativos</option>
                    <option value="inactive">Inativos</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="row" id="slidersGrid">
                <?php if (empty($sliders)): ?>
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle me-2"></i>
                            Nenhum slide cadastrado ainda. Adicione o primeiro slide usando o formulário acima.
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($sliders as $slider): ?>
                        <div class="col-lg-4 col-md-6 mb-4" data-slider-id="<?= $slider['id'] ?>">
                            <div class="slider-card">
                                <div class="slider-image">
                                    <img src="<?= !empty($slider['image']) ? urlBase($slider['image']) : '' ?>" 
                                         alt="<?= htmlspecialchars($slider['title'] ?? 'Slide') ?>"
                                         class="img-fluid"
                                         style="width: 100%; height: 200px; object-fit: cover;">
                                    <div class="slider-overlay">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-light me-2" 
                                                    title="Editar"
                                                    onclick="editSlider(<?= $slider['id'] ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" 
                                                    title="Remover"
                                                    onclick="deleteSlider(<?= $slider['id'] ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="slider-status <?= ($slider['status'] ?? 'inactive') === 'active' ? 'active' : 'inactive' ?>" 
                                         onclick="toggleSliderStatus(<?= $slider['id'] ?>)"
                                         title="Clique para <?= ($slider['status'] ?? 'inactive') === 'active' ? 'desativar' : 'ativar' ?>">
                                        <i class="fas fa-<?= ($slider['status'] ?? 'inactive') === 'active' ? 'check' : 'times' ?>-circle"></i>
                                    </div>
                                </div>
                                <div class="slider-info">
                                    <h6><?= htmlspecialchars($slider['title'] ?? 'Sem título') ?></h6>
                                    <p class="text-muted"><?= htmlspecialchars($slider['subtitle'] ?? '') ?></p>
                                    <?php if (!empty($slider['description'])): ?>
                                        <p class="text-muted small"><?= htmlspecialchars($slider['description']) ?></p>
                                    <?php endif; ?>
                                    <div class="slider-meta">
                                        <span class="badge bg-<?= ($slider['status'] ?? 'inactive') === 'active' ? 'primary' : 'secondary' ?>">
                                            Ordem: <?= $slider['order_position'] ?? 0 ?>
                                        </span>
                                        <small class="text-muted">
                                            <?php if (!empty($slider['created_at'])): ?>
                                                <?= date('d/m/Y', strtotime($slider['created_at'])) ?>
                                            <?php endif; ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Adicionar/Editar Slider -->
<div class="modal fade" id="sliderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sliderModalTitle">
                    <i class="fas fa-plus me-2"></i>
                    Adicionar Nova Imagem ao Slider
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="sliderForm" class="slider-form">
                    <input type="hidden" id="sliderId" name="id" value="">
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="sliderTitle" class="form-label">Título do Slide</label>
                            <input type="text" class="form-control" id="sliderTitle" placeholder="Digite o título" maxlength="20" required>
                            <small class="text-muted">Máximo 20 caracteres</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sliderSubtitle" class="form-label">Subtítulo</label>
                            <input type="text" class="form-control" id="sliderSubtitle" placeholder="Digite o subtítulo" maxlength="50">
                            <small class="text-muted">Máximo 50 caracteres</small>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="sliderOrder" class="form-label">Ordem</label>
                            <input type="number" class="form-control" id="sliderOrder" min="1" value="1">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="sliderDescription" class="form-label">Descrição</label>
                            <textarea class="form-control" id="sliderDescription" rows="3"
                                      placeholder="Descrição interna para identificação"></textarea>
                            <small class="text-muted">Uso interno para identificação</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sliderButtonText" class="form-label">Texto do Botão</label>
                            <input type="text" class="form-control" id="sliderButtonText" placeholder="Ex: Saiba Mais">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sliderButtonLink" class="form-label">Link do Botão</label>
                            <input type="url" class="form-control" id="sliderButtonLink" placeholder="https://...">
                        </div>
                    </div>

                    <div class="upload-area mb-3">
                        <label class="form-label">Imagem do Slide <span id="imageRequired">(obrigatório)</span></label>
                        <div class="upload-zone" id="imageUploadZone">
                            <i class="fas fa-image fa-3x text-muted mb-3"></i>
                            <h5>Arraste e solte uma imagem aqui</h5>
                            <p class="text-muted">ou clique para selecionar</p>
                            <p class="text-muted small">Formatos aceitos: JPG, PNG, WebP (Recomendado: 1920x800px)</p>
                            <input type="file" id="imageInput" accept="image/*" style="display: none;">
                            <button type="button" class="btn btn-outline-primary"
                                    onclick="document.getElementById('imageInput').click()">
                                <i class="fas fa-folder-open me-2"></i>
                                Selecionar Imagem
                            </button>
                        </div>
                        <div id="imagePreview" class="image-preview mt-3" style="display: none;">
                            <img id="previewImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                            <button type="button" class="btn btn-sm btn-danger mt-2" onclick="clearImage()">
                                <i class="fas fa-times me-1"></i>
                                Remover Imagem
                            </button>
                        </div>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="sliderActive" checked>
                        <label class="form-check-label" for="sliderActive">
                            Slide ativo (visível no site)
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="sliderForm" class="btn btn-primary" id="btnSaveSlider">
                    <i class="fas fa-save me-2"></i>
                    Salvar Slide
                </button>
            </div>
        </div>
    </div>
</div>

<?php $this->end("container"); ?>

<?php $this->start("js"); ?>
<script>
    // Sliders specific JavaScript
    $(document).ready(function () {
        // Desabilita autosave para este formulário específico
        const sliderForm = $('#sliderForm');
        sliderForm.find('input, textarea, select').off('input change');
        sliderForm.on('input change', 'input, textarea, select', function(e) {
            e.stopImmediatePropagation();
            e.stopPropagation();
        });
        
        // Image upload handling
        const imageUploadZone = document.getElementById('imageUploadZone');
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');

        // Drag and drop functionality
        imageUploadZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            imageUploadZone.classList.add('dragover');
        });

        imageUploadZone.addEventListener('dragleave', () => {
            imageUploadZone.classList.remove('dragover');
        });

        imageUploadZone.addEventListener('drop', (e) => {
            e.preventDefault();
            imageUploadZone.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0 && files[0].type.startsWith('image/')) {
                handleImage(files[0]);
            }
        });

        imageInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleImage(e.target.files[0]);
            }
        });

        function handleImage(file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
                imageUploadZone.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }

        // Form submission
        $('#sliderForm').on('submit', function (e) {
            e.preventDefault();
            
            // Validação básica
            const title = $('#sliderTitle').val().trim();
            if (!title) {
                showToast('Por favor, preencha o título do slide', 'error');
                $('#sliderTitle').focus();
                return;
            }
            
            const sliderId = $('#sliderId').val();
            const isEdit = sliderId && sliderId !== '';
            const imageFile = imageInput.files[0];
            
            // Valida imagem apenas na criação
            if (!isEdit && !imageFile) {
                showToast('Por favor, selecione uma imagem', 'error');
                return;
            }
            
            // Mostra loading
            const submitBtn = $('#btnSaveSlider');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Salvando...');
            
            const formData = new FormData();
            if (isEdit) {
                formData.append('id', sliderId);
            }
            formData.append('title', title);
            formData.append('subtitle', $('#sliderSubtitle').val().trim());
            formData.append('description', $('#sliderDescription').val().trim());
            formData.append('button_text', $('#sliderButtonText').val().trim());
            formData.append('button_link', $('#sliderButtonLink').val().trim());
            formData.append('order_position', $('#sliderOrder').val() || 0);
            formData.append('status', $('#sliderActive').is(':checked') ? 'active' : 'inactive');
            
            // Adiciona imagem apenas se foi selecionada
            if (imageFile) {
                formData.append('image', imageFile);
            }
            
            const url = isEdit ? '<?= urlBase("dashboard/sliders/update") ?>' : '<?= urlBase("dashboard/sliders/create") ?>';
            
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    submitBtn.prop('disabled', false).html(originalText);
                    
                    let result = response;
                    if (typeof response === 'string') {
                        try {
                            result = JSON.parse(response);
                        } catch(e) {
                            showToast('Erro ao processar resposta do servidor', 'error');
                            return;
                        }
                    }
                    
                    if (result.success) {
                        const message = result.message || (isEdit ? 'Slide atualizado com sucesso!' : 'Slide criado com sucesso!');
                        showToast(message, 'success');
                        $('#sliderModal').modal('hide');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showToast(result.message || 'Erro ao salvar slide', 'error');
                    }
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).html(originalText);
                    
                    let message = 'Erro ao salvar slide';
                    if (xhr.responseText) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            message = response.message || message;
                        } catch(e) {
                            if (xhr.status === 403) {
                                message = 'Sem permissão para realizar esta ação';
                            } else if (xhr.status === 500) {
                                message = 'Erro interno do servidor';
                            }
                        }
                    }
                    showToast(message, 'error');
                }
            });
        });

        // Search functionality
        $('#searchInput').on('keyup', function () {
            const query = $(this).val().toLowerCase();
            $('.slider-card').filter(function () {
                $(this).closest('.col-lg-4').toggle($(this).text().toLowerCase().indexOf(query) > -1);
            });
        });

        // Filter functionality
        $('#filterStatus').on('change', function () {
            const filter = $(this).val();
            if (filter) {
                $('.slider-card').closest('.col-lg-4').hide();
                $('.slider-card').each(function () {
                    const status = $(this).find('.slider-status').hasClass('active') ? 'active' : 'inactive';
                    if (status === filter) {
                        $(this).closest('.col-lg-4').show();
                    }
                });
            } else {
                $('.slider-card').closest('.col-lg-4').show();
            }
        });

    });

    // Função para abrir modal vazio (criar)
    window.openSliderModal = function() {
        $('#sliderId').val('');
        $('#sliderForm')[0].reset();
        $('#sliderModalTitle').html('<i class="fas fa-plus me-2"></i>Adicionar Nova Imagem ao Slider');
        $('#imageRequired').text('(obrigatório)');
        
        const imagePreview = document.getElementById('imagePreview');
        const imageUploadZone = document.getElementById('imageUploadZone');
        const imageInput = document.getElementById('imageInput');
        
        imagePreview.style.display = 'none';
        imageUploadZone.style.display = 'block';
        imageInput.value = '';
    };

    // Função para limpar imagem
    window.clearImage = function() {
        const imagePreview = document.getElementById('imagePreview');
        const imageUploadZone = document.getElementById('imageUploadZone');
        const previewImg = document.getElementById('previewImg');
        const imageInput = document.getElementById('imageInput');
        
        imagePreview.style.display = 'none';
        imageUploadZone.style.display = 'block';
        previewImg.src = '';
        imageInput.value = '';
    };

    // Função para deletar slider
    window.deleteSlider = function(id) {
        showConfirm('Tem certeza que deseja remover este slide?', function() {
            const formData = new FormData();
            formData.append('id', id);
            
            $.ajax({
                url: '<?= urlBase("dashboard/sliders/delete") ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    let result = response;
                    if (typeof response === 'string') {
                        try {
                            result = JSON.parse(response);
                        } catch(e) {
                            showToast('Erro ao processar resposta do servidor', 'error');
                            return;
                        }
                    }
                    
                    if (result.success) {
                        showToast(result.message || 'Slide removido com sucesso!', 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showToast(result.message || 'Erro ao remover slide', 'error');
                    }
                },
                error: function(xhr) {
                    let message = 'Erro ao remover slide';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        message = response.message || message;
                    } catch(e) {}
                    showToast(message, 'error');
                }
            });
        });
    };
        
    // Função para alternar status do slider
    window.toggleSliderStatus = function(id) {
        const formData = new FormData();
        formData.append('id', id);
        
        $.ajax({
            url: '<?= urlBase("dashboard/sliders/toggle-status") ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                const result = typeof response === 'string' ? JSON.parse(response) : response;
                if (result.success) {
                    showToast(result.message || 'Status atualizado!', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast(result.message || 'Erro ao alterar status', 'error');
                }
            },
            error: function(xhr) {
                let message = 'Erro ao alterar status';
                try {
                    const response = JSON.parse(xhr.responseText);
                    message = response.message || message;
                } catch(e) {}
                showToast(message, 'error');
            }
        });
    };
    
    // Função para editar slider
    window.editSlider = function(id) {
        // Busca dados completos via AJAX
        const formData = new FormData();
        formData.append('id', id);
        
        $.ajax({
            url: '<?= urlBase("dashboard/sliders/get") ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                let result = typeof response === 'string' ? JSON.parse(response) : response;
                
                if (result.success && result.slider) {
                    const slider = result.slider;
                    const imagePreview = document.getElementById('imagePreview');
                    const imageUploadZone = document.getElementById('imageUploadZone');
                    const previewImg = document.getElementById('previewImg');
                    
                    // Preenche formulário
                    $('#sliderId').val(slider.id);
                    $('#sliderTitle').val(slider.title || '');
                    $('#sliderSubtitle').val(slider.subtitle || '');
                    $('#sliderDescription').val(slider.description || '');
                    $('#sliderButtonText').val(slider.button_text || '');
                    $('#sliderButtonLink').val(slider.button_link || '');
                    $('#sliderOrder').val(slider.order_position || 1);
                    $('#sliderActive').prop('checked', slider.status === 'active');
                    
                    // Mostra imagem atual se existir
                    if (slider.image) {
                        const imageUrl = slider.image.startsWith('http') ? slider.image : '<?= urlBase("") ?>/' + slider.image;
                        previewImg.src = imageUrl;
                        imagePreview.style.display = 'block';
                        imageUploadZone.style.display = 'none';
                    } else {
                        imagePreview.style.display = 'none';
                        imageUploadZone.style.display = 'block';
                    }
                    
                    // Atualiza UI do modal
                    $('#sliderModalTitle').html('<i class="fas fa-edit me-2"></i>Editar Slide');
                    $('#imageRequired').text('(opcional - manter atual se não selecionar)');
                    
                    // Abre modal
                    $('#sliderModal').modal('show');
                } else {
                    showToast(result.message || 'Erro ao buscar slider', 'error');
                }
            },
            error: function() {
                showToast('Erro ao buscar dados do slider', 'error');
            }
        });
    };
</script>
<?php $this->end("js"); ?>
