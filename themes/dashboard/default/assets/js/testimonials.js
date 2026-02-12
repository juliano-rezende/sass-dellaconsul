/**
 * Sistema de Depoimentos - Dashboard
 * Gerencia aprovação, rejeição e exclusão de depoimentos
 */

(function() {
    'use strict';

    // Inicialização
    document.addEventListener('DOMContentLoaded', function() {
        initFilters();
    });

    /**
     * Inicializa filtros da página
     */
    function initFilters() {
        const filterStatus = document.getElementById('filterStatus');
        const filterRating = document.getElementById('filterRating');
        const filterDate = document.getElementById('filterDate');
        const searchInput = document.getElementById('searchInput');
        const clearFiltersBtn = document.getElementById('clearFiltersBtn');

        if (filterStatus) {
            filterStatus.addEventListener('change', filterTestimonials);
        }

        if (filterRating) {
            filterRating.addEventListener('change', filterTestimonials);
        }

        if (filterDate) {
            filterDate.addEventListener('change', filterTestimonials);
        }

        if (searchInput) {
            searchInput.addEventListener('input', debounce(filterTestimonials, 300));
        }

        if (clearFiltersBtn) {
            clearFiltersBtn.addEventListener('click', clearFilters);
        }
    }

    /**
     * Limpa todos os filtros
     */
    function clearFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('filterStatus').value = '';
        document.getElementById('filterRating').value = '';
        document.getElementById('filterDate').value = '';
        filterTestimonials();
    }

    /**
     * Filtra depoimentos na tabela
     */
    function filterTestimonials() {
        const filterStatus = document.getElementById('filterStatus').value;
        const filterRating = document.getElementById('filterRating').value;
        const filterDate = document.getElementById('filterDate').value;
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const tbody = document.getElementById('testimonialsTableBody');
        const rows = tbody.querySelectorAll('tr[data-testimonial-id]');

        let visibleCount = 0;
        let totalRows = rows.length;

        // Remove mensagem inicial do PHP se houver
        const initialEmptyRow = tbody.querySelector('tr:not([data-testimonial-id]):not(.filter-empty-state)');
        if (initialEmptyRow && totalRows > 0) {
            initialEmptyRow.style.display = 'none';
        }

        rows.forEach(row => {
            const status = row.getAttribute('data-status');
            const rating = row.getAttribute('data-rating');
            const createdAt = row.getAttribute('data-created-at');
            const text = row.textContent.toLowerCase();
            
            const matchesStatus = !filterStatus || status === filterStatus;
            const matchesRating = !filterRating || rating === filterRating;
            const matchesDate = !filterDate || filterByDate(createdAt, filterDate);
            const matchesSearch = !searchTerm || text.includes(searchTerm);

            if (matchesStatus && matchesRating && matchesDate && matchesSearch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Atualiza mensagem de "nenhum resultado"
        updateEmptyState(visibleCount, totalRows);
    }

    /**
     * Filtra por período de data
     */
    function filterByDate(dateStr, period) {
        if (!dateStr || !period) return true;

        const itemDate = new Date(dateStr);
        const now = new Date();
        now.setHours(0, 0, 0, 0);

        switch (period) {
            case 'hoje':
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                const tomorrow = new Date(today);
                tomorrow.setDate(tomorrow.getDate() + 1);
                return itemDate >= today && itemDate < tomorrow;
                
            case 'semana':
                const weekAgo = new Date(now);
                weekAgo.setDate(weekAgo.getDate() - 7);
                return itemDate >= weekAgo;
                
            case 'mes':
                const monthAgo = new Date(now);
                monthAgo.setMonth(monthAgo.getMonth() - 1);
                return itemDate >= monthAgo;
                
            default:
                return true;
        }
    }

    /**
     * Atualiza estado vazio da tabela
     */
    function updateEmptyState(visibleCount, totalRows) {
        const tbody = document.getElementById('testimonialsTableBody');
        let filterEmptyRow = tbody.querySelector('.filter-empty-state');

        // Se não há registros visíveis após filtro
        if (visibleCount === 0 && totalRows > 0) {
            // Remove mensagem inicial se houver
            const initialEmptyRow = tbody.querySelector('tr:not([data-testimonial-id]):not(.filter-empty-state)');
            if (initialEmptyRow) {
                initialEmptyRow.style.display = 'none';
            }

            // Adiciona mensagem de filtro vazio
            if (!filterEmptyRow) {
                filterEmptyRow = document.createElement('tr');
                filterEmptyRow.className = 'filter-empty-state';
                filterEmptyRow.innerHTML = `
                    <td colspan="6" class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">Nenhum depoimento encontrado com os filtros aplicados</p>
                        <small class="text-muted">Tente ajustar os filtros ou limpar a busca</small>
                    </td>
                `;
                tbody.appendChild(filterEmptyRow);
            }
            filterEmptyRow.style.display = '';
        } else {
            // Remove mensagem de filtro se houver resultados
            if (filterEmptyRow) {
                filterEmptyRow.remove();
            }
            
            // Mostra mensagem inicial se não houver registros no total
            if (totalRows === 0) {
                const initialEmptyRow = tbody.querySelector('tr:not([data-testimonial-id])');
                if (initialEmptyRow) {
                    initialEmptyRow.style.display = '';
                }
            }
        }
    }

    /**
     * Visualiza depoimento completo
     */
    window.viewTestimonial = function(id) {
        const modalBody = document.getElementById('modalBody');
        modalBody.innerHTML = '<div class="text-center py-4"><div class="spinner-border" role="status"></div></div>';

        const modal = new bootstrap.Modal(document.getElementById('viewModal'));
        modal.show();

        fetch(getBaseUrl() + '/dashboard/depoimentos/get', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const testimonial = data.testimonial;
                const stars = generateStars(testimonial.rating);
                const statusBadge = generateStatusBadge(testimonial.status);

                modalBody.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nome:</strong> ${escapeHtml(testimonial.name)}</p>
                            <p><strong>Email:</strong> ${escapeHtml(testimonial.email)}</p>
                            ${testimonial.company_role ? `<p><strong>Cargo/Empresa:</strong> ${escapeHtml(testimonial.company_role)}</p>` : ''}
                        </div>
                        <div class="col-md-6 text-end">
                            <p><strong>Avaliação:</strong><br>${stars}</p>
                            <p><strong>Status:</strong><br>${statusBadge}</p>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <p><strong>Depoimento:</strong></p>
                        <div class="p-3 bg-light rounded" style="white-space: pre-wrap;">
                            "${nl2br(testimonial.message)}"
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="small text-muted mb-0">
                                <i class="far fa-calendar me-1"></i>
                                Enviado em: ${testimonial.created_at_formatted || '-'}
                            </p>
                        </div>
                        ${testimonial.approved_at ? `
                        <div class="col-md-6 text-end">
                            <p class="small text-muted mb-0">
                                <i class="far fa-check-circle me-1"></i>
                                Aprovado em: ${testimonial.approved_at_formatted || '-'}
                            </p>
                        </div>
                        ` : ''}
                    </div>
                    ${testimonial.consent_date_formatted ? `
                    <hr>
                    <div class="alert alert-info mb-0">
                        <h6 class="mb-2"><i class="fas fa-shield-alt me-1"></i> Registro de Consentimento LGPD</h6>
                        <div class="row small">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Data/Hora:</strong> ${testimonial.consent_date_formatted}</p>
                                <p class="mb-0"><strong>IP:</strong> ${escapeHtml(testimonial.consent_ip || 'N/A')}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Consentimento:</strong> <span class="badge bg-success">Sim</span></p>
                                <p class="mb-0"><strong>Versão da Política:</strong> ${escapeHtml(testimonial.privacy_policy_version || '1.0')}</p>
                            </div>
                        </div>
                    </div>
                    ` : ''}
                `;
            } else {
                modalBody.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            modalBody.innerHTML = '<div class="alert alert-danger">Erro ao carregar depoimento</div>';
        });
    };

    /**
     * Aprova depoimento
     */
    window.approveTestimonial = function(id) {
        showConfirm('Deseja realmente aprovar este depoimento?', function() {
            showLoading();

        fetch(getBaseUrl() + '/dashboard/depoimentos/approve', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                showToast('Depoimento aprovado com sucesso!', 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Erro:', error);
            showToast('Erro ao aprovar depoimento', 'error');
        });
        });
    };

    /**
     * Rejeita depoimento
     */
    window.rejectTestimonial = function(id) {
        showConfirm('Deseja realmente rejeitar este depoimento?', function() {
            showLoading();

        fetch(getBaseUrl() + '/dashboard/depoimentos/reject', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                showToast('Depoimento rejeitado', 'warning');
                setTimeout(() => location.reload(), 1500);
            } else {
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Erro:', error);
            showToast('Erro ao rejeitar depoimento', 'error');
        });
        });
    };

    /**
     * Exclui depoimento
     */
    window.deleteTestimonial = function(id) {
        showConfirm('Deseja realmente excluir este depoimento? Esta ação não pode ser desfeita.', function() {
            showLoading();

        fetch(getBaseUrl() + '/dashboard/depoimentos/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                showToast('Depoimento excluído com sucesso', 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Erro:', error);
            showToast('Erro ao excluir depoimento', 'error');
        });
        });
    };

    /**
     * Utilitários
     */
    function generateStars(rating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            stars += `<i class="fas fa-star ${i > rating ? 'text-muted' : 'text-warning'}"></i>`;
        }
        return stars;
    }

    function generateStatusBadge(status) {
        const statusConfig = {
            'pending': { label: 'Pendente', class: 'bg-warning' },
            'approved': { label: 'Aprovado', class: 'bg-success' },
            'rejected': { label: 'Rejeitado', class: 'bg-danger' }
        };
        const config = statusConfig[status] || { label: status, class: 'bg-secondary' };
        return `<span class="badge ${config.class}">${config.label}</span>`;
    }

    /**
     * Função mantida apenas como fallback
     * As datas já vêm formatadas do backend
     */
    function formatDate(dateString) {
        // Se já vier formatado do backend, retorna direto
        if (!dateString) return '-';
        
        // Se for string formatada (dd/mm/yyyy hh:mm), retorna direto
        if (typeof dateString === 'string' && /^\d{2}\/\d{2}\/\d{4}/.test(dateString)) {
            return dateString;
        }
        
        // Fallback: tenta formatar
        try {
            const date = new Date(dateString);
            if (isNaN(date.getTime())) {
                return '-';
            }
            return date.toLocaleDateString('pt-BR') + ' ' + date.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
        } catch (error) {
            return '-';
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    /**
     * Converte quebras de linha em <br> (após escapar HTML)
     */
    function nl2br(text) {
        if (!text) return '';
        const escaped = escapeHtml(text);
        return escaped.replace(/\r\n|\r|\n/g, '<br>');
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    function getBaseUrl() {
        return window.location.origin + window.location.pathname.split('/').slice(0, -1).join('/').replace('/dashboard', '');
    }

    function showLoading() {
        if (!document.getElementById('loadingOverlay')) {
            const overlay = document.createElement('div');
            overlay.id = 'loadingOverlay';
            overlay.innerHTML = '<div class="spinner-border text-primary" role="status"></div>';
            overlay.style.cssText = 'position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(255,255,255,0.8);display:flex;align-items:center;justify-content:center;z-index:9999;';
            document.body.appendChild(overlay);
        }
    }

    function hideLoading() {
        const overlay = document.getElementById('loadingOverlay');
        if (overlay) {
            overlay.remove();
        }
    }

})();
