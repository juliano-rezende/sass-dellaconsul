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
    <!-- Add New Slider Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-plus me-2" id="formIcon"></i>
                <span id="formTitle">Adicionar Nova Imagem ao Slider</span>
            </h5>
        </div>
        <div class="card-body">
            <form id="sliderForm" class="slider-form">
                <input type="hidden" id="sliderId" name="id" value="">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="sliderTitle" class="form-label">Título do Slide (20 Caracteres)</label>
                        <input type="text" class="form-control" id="sliderTitle" placeholder="Digite o título" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="sliderSubtitle" class="form-label">Subtítulo (50 Caracteres)</label>
                        <input type="text" class="form-control" id="sliderSubtitle" placeholder="Digite o subtítulo">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="sliderOrder" class="form-label">Ordem de Exibição</label>
                        <input type="number" class="form-control" id="sliderOrder" min="1" value="1">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="sliderDescription" class="form-label">Descrição (uso interno para ideintificacao)</label>
                        <textarea class="form-control" id="sliderDescription" rows="3"
                                  placeholder="Descreva o conteúdo do slide"></textarea>
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
                    <label class="form-label">Imagem do Slide</label>
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
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="sliderActive" checked>
                    <label class="form-check-label" for="sliderActive">
                        Slide ativo (visível no site)
                    </label>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" id="btnCancel" style="display: none;" onclick="cancelEdit()">
                        <i class="fas fa-times me-2"></i>
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                        <i class="fas fa-save me-2"></i>
                        <span id="btnSubmitText">Salvar Slide</span>
                    </button>
                </div>
            </form>
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

<?php $this->end("container"); ?>

<?php $this->start("js"); ?>
<script>
    // Sliders specific JavaScript
    $(document).ready(function () {
        // Desabilita autosave para este formulário específico
        // O script.js global tem um autosave que escuta todos os inputs
        // Vamos desabilitar especificamente para o formulário de sliders
        const sliderForm = $('#sliderForm');
        
        // Remove event listeners do autosave global
        sliderForm.find('input, textarea, select').off('input change');
        
        // Adiciona um handler que previne a propagação para o autosave global
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

        // Desabilita autosave para este formulário
        $('#sliderForm input, #sliderForm textarea, #sliderForm select').off('input change');
        
        // Form submission
        $('#sliderForm').on('submit', function (e) {
            e.preventDefault();
            
            // Validação básica
            const title = $('#sliderTitle').val().trim();
            if (!title) {
                if (typeof showToast !== 'undefined') {
                    showToast('Por favor, preencha o título do slide', 'error');
                } else {
                    alert('Por favor, preencha o título do slide');
                }
                $('#sliderTitle').focus();
                return;
            }
            
            const sliderId = $('#sliderId').val();
            const isEdit = sliderId && sliderId !== '';
            const imageFile = imageInput.files[0];
            
            // Valida imagem apenas na criação
            if (!isEdit && !imageFile) {
                if (typeof showToast !== 'undefined') {
                    showToast('Por favor, selecione uma imagem', 'error');
                } else {
                    alert('Por favor, selecione uma imagem');
                }
                return;
            }
            
            // Mostra loading
            const submitBtn = $('#btnSubmit');
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
                    
                    // Tenta parsear se for string
                    let result = response;
                    if (typeof response === 'string') {
                        try {
                            result = JSON.parse(response);
                        } catch(e) {
                            console.error('Erro ao parsear resposta:', e, response);
                            if (typeof showToast !== 'undefined') {
                                showToast('Erro ao processar resposta do servidor', 'error');
                            } else {
                                alert('Erro ao processar resposta do servidor');
                            }
                            return;
                        }
                    }
                    
                    if (result.success) {
                        const message = result.message || (isEdit ? 'Slide atualizado com sucesso!' : 'Slide criado com sucesso!');
                        if (typeof showToast !== 'undefined') {
                            showToast(message, 'success');
                        } else {
                            alert(message);
                        }
                        
                        // Limpa formulário
                        resetForm();
                        
                        // Recarrega a página para mostrar as mudanças
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        if (typeof showToast !== 'undefined') {
                            showToast(result.message || 'Erro ao salvar slide', 'error');
                        } else {
                            alert(result.message || 'Erro ao salvar slide');
                        }
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
                    
                    let message = 'Erro ao salvar slide';
                    
                    // Tenta extrair mensagem de erro da resposta
                    if (xhr.responseText) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.message) {
                                message = response.message;
                            }
                        } catch(e) {
                            // Se não for JSON, tenta extrair mensagem de erro HTML
                            if (xhr.status === 0) {
                                message = 'Erro de conexão. Verifique sua internet.';
                            } else if (xhr.status === 500) {
                                message = 'Erro interno do servidor. Verifique os logs.';
                            } else if (xhr.status === 403) {
                                message = 'Sem permissão para realizar esta ação';
                            } else {
                                message = `Erro ${xhr.status}: ${xhr.statusText}`;
                            }
                        }
                    } else {
                        if (xhr.status === 0) {
                            message = 'Erro de conexão. Verifique sua internet.';
                        } else {
                            message = `Erro ${xhr.status}: ${error || xhr.statusText}`;
                        }
                    }
                    
                    if (typeof showToast !== 'undefined') {
                        showToast(message, 'error');
                    } else {
                        alert(message);
                    }
                }
            });
        });
        
        // Função para resetar formulário
        function resetForm() {
            $('#sliderForm')[0].reset();
            $('#sliderId').val('');
            imagePreview.style.display = 'none';
            imageUploadZone.style.display = 'block';
            previewImg.src = '';
            imageInput.value = '';
            $('#formIcon').removeClass('fa-edit').addClass('fa-plus');
            $('#formTitle').text('Adicionar Nova Imagem ao Slider');
            $('#btnSubmitText').text('Salvar Slide');
            $('#btnCancel').hide();
        }

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

        // Função para deletar slider
        window.deleteSlider = function(id) {
            if (!confirm('Tem certeza que deseja remover este slide?')) {
                return;
            }
            
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
                    // Tenta parsear se for string
                    let result = response;
                    if (typeof response === 'string') {
                        try {
                            result = JSON.parse(response);
                        } catch(e) {
                            console.error('Erro ao parsear resposta:', e, response);
                            if (typeof showToast !== 'undefined') {
                                showToast('Erro ao processar resposta do servidor', 'error');
                            } else {
                                alert('Erro ao processar resposta do servidor');
                            }
                            return;
                        }
                    }
                    
                    if (result.success) {
                        const message = result.message || 'Slide removido com sucesso!';
                        if (typeof showToast !== 'undefined') {
                            showToast(message, 'success');
                        } else {
                            alert(message);
                        }
                        
                        $(`[data-slider-id="${id}"]`).fadeOut(300, function() {
                            $(this).remove();
                            // Verifica se não há mais sliders
                            if ($('#slidersGrid .col-lg-4').length === 0) {
                                $('#slidersGrid').html(`
                                    <div class="col-12">
                                        <div class="alert alert-info text-center">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Nenhum slide cadastrado ainda. Adicione o primeiro slide usando o formulário acima.
                                        </div>
                                    </div>
                                `);
                            }
                        });
                    } else {
                        const message = result.message || 'Erro ao remover slide';
                        if (typeof showToast !== 'undefined') {
                            showToast(message, 'error');
                        } else {
                            alert(message);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro AJAX ao deletar:', {
                        status: xhr.status,
                        statusText: xhr.statusText,
                        responseText: xhr.responseText,
                        error: error
                    });
                    
                    let message = 'Erro ao remover slide';
                    
                    // Tenta extrair mensagem de erro da resposta
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
                                message = 'Erro interno do servidor. Verifique os logs.';
                            } else if (xhr.status === 403) {
                                message = 'Sem permissão para realizar esta ação';
                            } else {
                                message = `Erro ${xhr.status}: ${xhr.statusText}`;
                            }
                        }
                    } else {
                        if (xhr.status === 0) {
                            message = 'Erro de conexão. Verifique sua internet.';
                        } else {
                            message = `Erro ${xhr.status}: ${error || xhr.statusText}`;
                        }
                    }
                    
                    if (typeof showToast !== 'undefined') {
                        showToast(message, 'error');
                    } else {
                        alert(message);
                    }
                }
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
                        const statusElement = $(`[data-slider-id="${id}"] .slider-status`);
                        const isActive = result.status === 'active';
                        
                        statusElement.toggleClass('active inactive', isActive);
                        statusElement.find('i')
                            .removeClass('fa-check-circle fa-times-circle')
                            .addClass(isActive ? 'fa-check-circle' : 'fa-times-circle');
                        
                        // Atualiza badge
                        const badge = $(`[data-slider-id="${id}"] .badge`);
                        badge.removeClass('bg-primary bg-secondary')
                             .addClass(isActive ? 'bg-primary' : 'bg-secondary');
                        
                        showToast(result.message || `Slide ${isActive ? 'ativado' : 'desativado'}!`, 'success');
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
            // Busca dados do slider na página
            const sliderCard = $(`[data-slider-id="${id}"]`);
            if (!sliderCard.length) {
                if (typeof showToast !== 'undefined') {
                    showToast('Slider não encontrado', 'error');
                } else {
                    alert('Slider não encontrado');
                }
                return;
            }
            
            // Preenche formulário com dados do slider
            const title = sliderCard.find('.slider-info h6').text().trim();
            const subtitle = sliderCard.find('.slider-info p.text-muted').first().text().trim();
            const description = sliderCard.find('.slider-info p.text-muted.small').text().trim();
            const orderPosition = sliderCard.find('.badge').text().replace('Ordem: ', '').trim();
            const isActive = sliderCard.find('.slider-status').hasClass('active');
            const imageUrl = sliderCard.find('.slider-image img').attr('src');
            
            // Busca dados completos via AJAX para pegar button_text e button_link
            const formData = new FormData();
            formData.append('id', id);
            
            $.ajax({
                url: '<?= urlBase("dashboard/sliders/get") ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    let result = typeof response === 'string' ? JSON.parse(response) : response;
                    
                    if (result.success && result.slider) {
                        const slider = result.slider;
                        
                        // Preenche formulário
                        $('#sliderId').val(slider.id);
                        $('#sliderTitle').val(slider.title || title);
                        $('#sliderSubtitle').val(slider.subtitle || subtitle);
                        $('#sliderDescription').val(slider.description || description);
                        $('#sliderButtonText').val(slider.button_text || '');
                        $('#sliderButtonLink').val(slider.button_link || '');
                        $('#sliderOrder').val(slider.order_position || orderPosition);
                        $('#sliderActive').prop('checked', (slider.status || (isActive ? 'active' : 'inactive')) === 'active');
                        
                        // Mostra imagem atual
                        if (imageUrl) {
                            previewImg.src = imageUrl;
                            imagePreview.style.display = 'block';
                            imageUploadZone.style.display = 'none';
                        }
                        
                        // Atualiza UI do formulário
                        $('#formIcon').removeClass('fa-plus').addClass('fa-edit');
                        $('#formTitle').text('Editar Slide');
                        $('#btnSubmitText').text('Atualizar Slide');
                        $('#btnCancel').show();
                        
                        // Scroll para o formulário
                        $('html, body').animate({
                            scrollTop: $('#sliderForm').offset().top - 100
                        }, 500);
                    } else {
                        // Se não conseguir buscar via AJAX, usa dados da página
                        $('#sliderId').val(id);
                        $('#sliderTitle').val(title);
                        $('#sliderSubtitle').val(subtitle);
                        $('#sliderDescription').val(description);
                        $('#sliderOrder').val(orderPosition);
                        $('#sliderActive').prop('checked', isActive);
                        
                        if (imageUrl) {
                            previewImg.src = imageUrl;
                            imagePreview.style.display = 'block';
                            imageUploadZone.style.display = 'none';
                        }
                        
                        $('#formIcon').removeClass('fa-plus').addClass('fa-edit');
                        $('#formTitle').text('Editar Slide');
                        $('#btnSubmitText').text('Atualizar Slide');
                        $('#btnCancel').show();
                        
                        $('html, body').animate({
                            scrollTop: $('#sliderForm').offset().top - 100
                        }, 500);
                    }
                },
                error: function() {
                    // Em caso de erro, usa dados da página mesmo
                    $('#sliderId').val(id);
                    $('#sliderTitle').val(title);
                    $('#sliderSubtitle').val(subtitle);
                    $('#sliderDescription').val(description);
                    $('#sliderOrder').val(orderPosition);
                    $('#sliderActive').prop('checked', isActive);
                    
                    if (imageUrl) {
                        previewImg.src = imageUrl;
                        imagePreview.style.display = 'block';
                        imageUploadZone.style.display = 'none';
                    }
                    
                    $('#formIcon').removeClass('fa-plus').addClass('fa-edit');
                    $('#formTitle').text('Editar Slide');
                    $('#btnSubmitText').text('Atualizar Slide');
                    $('#btnCancel').show();
                    
                    $('html, body').animate({
                        scrollTop: $('#sliderForm').offset().top - 100
                    }, 500);
                }
            });
        };
        
        // Função para cancelar edição
        window.cancelEdit = function() {
            resetForm();
        };
    });
</script>
<?php $this->end("js"); ?>
