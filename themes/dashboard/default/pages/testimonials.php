<?php $this->layout("_theme"); ?>

<?php $this->start("css"); ?>
<style>
    /* Estilos específicos para depoimentos */
    .rating-stars {
        color: #fbbf24;
        font-size: 1rem;
    }
    
    .rating-stars .text-muted {
        color: #d1d5db !important;
    }
    
    .message-preview {
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: inline-block;
    }
    
    /* Badges de status customizados */
    .badge.bg-warning {
        background-color: #fbbf24 !important;
        color: #78350f !important;
    }
    
    .badge.bg-success {
        background-color: #10b981 !important;
    }
    
    .badge.bg-danger {
        background-color: #ef4444 !important;
    }
</style>
<?php $this->end("css"); ?>

<?php $this->start("container"); ?>

<!-- Page Content -->
<div class="dashboard-content">
    <!-- Stats Cards -->
    <div class="row mb-4 g-4">
        <?php
        $total = count($testimonials ?? []);
        $pendentes = count(array_filter($testimonials ?? [], fn($t) => ($t['status'] ?? '') === 'pending'));
        $aprovados = count(array_filter($testimonials ?? [], fn($t) => ($t['status'] ?? '') === 'approved'));
        $rejeitados = count(array_filter($testimonials ?? [], fn($t) => ($t['status'] ?? '') === 'rejected'));
        ?>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-color: #2563eb; --card-color-light: #60a5fa;">
                <div class="stat-icon bg-primary">
                    <i class="fas fa-comment-dots"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $total ?></h3>
                    <p>Total de Depoimentos</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-color: #f59e0b; --card-color-light: #fbbf24;">
                <div class="stat-icon bg-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $pendentes ?></h3>
                    <p>Pendentes</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-color: #10b981; --card-color-light: #34d399;">
                <div class="stat-icon bg-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $aprovados ?></h3>
                    <p>Aprovados</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-color: #ef4444; --card-color-light: #f87171;">
                <div class="stat-icon bg-danger">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $rejeitados ?></h3>
                    <p>Rejeitados</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-end">
                <div class="col-md-4 mb-3">
                    <label for="searchInput" class="form-label">Buscar</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput" placeholder="Nome, email...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="filterStatus" class="form-label">Status</label>
                    <select class="form-select" id="filterStatus">
                        <option value="">Todos</option>
                        <option value="pending">Pendentes</option>
                        <option value="approved">Aprovados</option>
                        <option value="rejected">Rejeitados</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="filterRating" class="form-label">Avaliação</label>
                    <select class="form-select" id="filterRating">
                        <option value="">Todas</option>
                        <option value="5">5 estrelas</option>
                        <option value="4">4 estrelas</option>
                        <option value="3">3 estrelas</option>
                        <option value="2">2 estrelas</option>
                        <option value="1">1 estrela</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="filterDate" class="form-label">Período</label>
                    <select class="form-select" id="filterDate">
                        <option value="">Todas</option>
                        <option value="hoje">Hoje</option>
                        <option value="semana">Esta semana</option>
                        <option value="mes">Este mês</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label d-block">&nbsp;</label>
                    <button type="button" class="btn btn-outline-secondary w-100" id="clearFiltersBtn">
                        <i class="fas fa-times me-1"></i>
                        Limpar Filtros
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>
                Lista de Depoimentos
            </h5>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th style="width: 200px;">Cliente</th>
                        <th class="text-center" style="width: 140px;">Avaliação</th>
                        <th style="width: 280px;">Mensagem</th>
                        <th class="text-center" style="width: 120px;">Status</th>
                        <th class="text-center" style="width: 140px;">Data</th>
                        <th class="text-center" style="width: 180px;">Ações</th>
                    </tr>
                    </thead>
                    <tbody id="testimonialsTableBody">
                        <?php if (empty($testimonials)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Nenhum depoimento encontrado.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($testimonials as $testimonial): ?>
                                <?php
                                $status = $testimonial['status'] ?? 'pending';
                                $statusLabels = [
                                    'pending' => ['label' => 'Pendente', 'class' => 'bg-warning'],
                                    'approved' => ['label' => 'Aprovado', 'class' => 'bg-success'],
                                    'rejected' => ['label' => 'Rejeitado', 'class' => 'bg-danger']
                                ];
                                $statusInfo = $statusLabels[$status] ?? ['label' => 'Desconhecido', 'class' => 'bg-secondary'];
                                
                                $createdAt = $testimonial['created_at'] ?? '';
                                $createdAtISO = '';
                                if ($createdAt instanceof \DateTime) {
                                    $createdAtISO = $createdAt->format('Y-m-d H:i:s');
                                    $createdAt = $createdAt->format('d/m/Y H:i');
                                } elseif (is_string($createdAt)) {
                                    $createdAtISO = $createdAt;
                                    $createdAt = date('d/m/Y H:i', strtotime($createdAt));
                                }
                                
                                $rating = $testimonial['rating'] ?? 5;
                                ?>
                                <tr data-testimonial-id="<?= $testimonial['id'] ?>" data-status="<?= $status ?>" data-rating="<?= $rating ?>" data-created-at="<?= htmlspecialchars($createdAtISO) ?>">
                                    <td>
                                        <div>
                                            <h6 class="mb-0 fw-semibold"><?= htmlspecialchars($testimonial['name'] ?? 'Sem nome') ?></h6>
                                            <small class="text-muted"><?= htmlspecialchars($testimonial['email'] ?? '') ?></small>
                                            <?php if (!empty($testimonial['company_role'])): ?>
                                                <br><small class="text-muted"><i class="fas fa-briefcase me-1"></i><?= htmlspecialchars($testimonial['company_role']) ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="rating-stars">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="fas fa-star<?= $i > $rating ? ' text-muted' : '' ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="message-preview" title="<?= htmlspecialchars($testimonial['message'] ?? '') ?>">
                                            <?= htmlspecialchars(mb_strimwidth($testimonial['message'] ?? '', 0, 60, "...")) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge <?= $statusInfo['class'] ?>"><?= $statusInfo['label'] ?></span>
                                    </td>
                                    <td class="text-center"><?= $createdAt ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary" 
                                                title="Visualizar"
                                                onclick="viewTestimonial(<?= $testimonial['id'] ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        
                                        <?php if ($status === 'pending' && \App\Helpers\ACL::can($_SESSION['user_role'], 'depoimentos', 'approve')): ?>
                                            <button class="btn btn-sm btn-success" 
                                                    title="Aprovar"
                                                    onclick="approveTestimonial(<?= $testimonial['id'] ?>)">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        <?php endif; ?>
                                        
                                        <?php if ($status === 'pending' && \App\Helpers\ACL::can($_SESSION['user_role'], 'depoimentos', 'reject')): ?>
                                            <button class="btn btn-sm btn-warning" 
                                                    title="Rejeitar"
                                                    onclick="rejectTestimonial(<?= $testimonial['id'] ?>)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        <?php endif; ?>
                                        
                                        <?php if (\App\Helpers\ACL::can($_SESSION['user_role'], 'depoimentos', 'delete')): ?>
                                            <button class="btn btn-sm btn-danger" 
                                                    title="Excluir"
                                                    onclick="deleteTestimonial(<?= $testimonial['id'] ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Visualização -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">
                    <i class="fas fa-comment-dots me-2"></i>Detalhes do Depoimento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Conteúdo carregado dinamicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<?php $this->end("container"); ?>

<?php $this->start("js"); ?>
<script src="<?= urlBase(THEME_DASHBOARD . "/assets/js/testimonials.js"); ?>"></script>
<?php $this->end("js"); ?>
