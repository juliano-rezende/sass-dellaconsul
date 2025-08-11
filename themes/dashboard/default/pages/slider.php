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
                <i class="fas fa-plus me-2"></i>
                Adicionar Nova Imagem ao Slider
            </h5>
        </div>
        <div class="card-body">
            <form id="sliderForm" class="slider-form">
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

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Salvar Slide
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
                <!-- Slider Card 1 -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="slider-card">
                        <div class="slider-image">
                            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Slide 1"
                                 class="img-fluid">
                            <div class="slider-overlay">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-danger" title="Remover">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="slider-status active">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="slider-info">
                            <h6>Gestão Condominial Profissional</h6>
                            <p class="text-muted">Especialistas em administração de condomínios</p>
                            <div class="slider-meta">
                                <span class="badge bg-primary">Ordem: 1</span>
                                <small class="text-muted">Adicionado em 15/01/2024</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slider Card 2 -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="slider-card">
                        <div class="slider-image">
                            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Slide 2"
                                 class="img-fluid">
                            <div class="slider-overlay">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-danger" title="Remover">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="slider-status active">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="slider-info">
                            <h6>Segurança e Manutenção</h6>
                            <p class="text-muted">Cuidamos de tudo para você</p>
                            <div class="slider-meta">
                                <span class="badge bg-primary">Ordem: 2</span>
                                <small class="text-muted">Adicionado em 14/01/2024</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slider Card 3 -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="slider-card">
                        <div class="slider-image">
                            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Slide 3"
                                 class="img-fluid">
                            <div class="slider-overlay">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-danger" title="Remover">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="slider-status inactive">
                                <i class="fas fa-times-circle"></i>
                            </div>
                        </div>
                        <div class="slider-info">
                            <h6>Portal do Cliente</h6>
                            <p class="text-muted">Acesso fácil e rápido aos serviços</p>
                            <div class="slider-meta">
                                <span class="badge bg-secondary">Ordem: 3</span>
                                <small class="text-muted">Adicionado em 13/01/2024</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->end("container"); ?>

<?php $this->start("js"); ?>
<script>
    // Sliders specific JavaScript
    $(document).ready(function () {
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
            showToast('Slide salvo com sucesso!', 'success');
            this.reset();
            imagePreview.style.display = 'none';
            imageUploadZone.style.display = 'block';
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

        // Slider card actions
        $(document).on('click', '.slider-card .btn-light', function () {
            const action = $(this).find('i').hasClass('fa-edit') ? 'editar' : 'visualizar';
            showToast(`Ação ${action} iniciada...`, 'info');
        });

        $(document).on('click', '.slider-card .btn-danger', function () {
            if (confirm('Tem certeza que deseja remover este slide?')) {
                $(this).closest('.col-lg-4').fadeOut();
                showToast('Slide removido com sucesso!', 'success');
            }
        });

        // Toggle slider status
        $(document).on('click', '.slider-status', function () {
            $(this).toggleClass('active inactive');
            const isActive = $(this).hasClass('active');
            $(this).find('i').toggleClass('fa-check-circle fa-times-circle');
            showToast(`Slide ${isActive ? 'ativado' : 'desativado'}!`, 'success');
        });
    });
</script>
<?php $this->end("js"); ?>
