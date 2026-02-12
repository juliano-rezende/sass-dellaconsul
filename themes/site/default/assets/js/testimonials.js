/**
 * Sistema de Depoimentos - Frontend
 * Gerencia o formulário de envio de depoimentos
 */

(function() {
    'use strict';

    // Variáveis globais
    let selectedRating = 0;
    const form = document.getElementById('testimonialForm');
    const ratingInput = document.getElementById('ratingInput');
    const ratingHiddenInput = document.getElementById('testimonialRating');
    const feedbackDiv = document.getElementById('testimonialFeedback');

    // Inicialização
    document.addEventListener('DOMContentLoaded', function() {
        initRatingSystem();
        initFormSubmit();
        initModalEvents();
    });

    /**
     * Inicializa eventos do modal
     */
    function initModalEvents() {
        const modalElement = document.getElementById('testimonialModal');
        if (!modalElement) return;

        // Limpa o formulário quando o modal é fechado
        modalElement.addEventListener('hidden.bs.modal', function() {
            if (form) {
                form.reset();
                selectedRating = 0;
                highlightStars(0);
            }
            if (feedbackDiv) {
                feedbackDiv.classList.remove('show');
                feedbackDiv.innerHTML = '';
            }
        });
    }

    /**
     * Inicializa sistema de rating com estrelas
     */
    function initRatingSystem() {
        if (!ratingInput) return;

        const stars = ratingInput.querySelectorAll('i');
        
        stars.forEach(star => {
            // Hover effect
            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                highlightStars(rating);
            });

            // Click effect
            star.addEventListener('click', function() {
                selectedRating = parseInt(this.getAttribute('data-rating'));
                if (ratingHiddenInput) {
                    ratingHiddenInput.value = selectedRating;
                }
                highlightStars(selectedRating);
            });
        });

        // Reset on mouse leave
        ratingInput.addEventListener('mouseleave', function() {
            highlightStars(selectedRating);
        });
    }

    /**
     * Destaca estrelas até o rating especificado
     */
    function highlightStars(rating) {
        if (!ratingInput) return;
        
        const stars = ratingInput.querySelectorAll('i');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('far');
                star.classList.add('fas');
                star.classList.add('text-warning');
            } else {
                star.classList.remove('fas');
                star.classList.add('far');
                star.classList.remove('text-warning');
            }
        });
    }

    /**
     * Inicializa submit do formulário via AJAX
     */
    function initFormSubmit() {
        if (!form) return;

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Valida rating
            if (selectedRating === 0) {
                showFeedback('Por favor, selecione uma avaliação (estrelas).', 'danger');
                return;
            }

            // Valida consentimento
            const consent = document.getElementById('testimonialConsent');
            if (!consent || !consent.checked) {
                showFeedback('Você precisa aceitar a Política de Privacidade e os Termos de Uso.', 'danger');
                return;
            }

            // Desabilita botão de submit (procura dentro do form ou por atributo form)
            let submitBtn = form.querySelector('button[type="submit"]');
            if (!submitBtn) {
                // Procura botão com atributo form
                submitBtn = document.querySelector(`button[type="submit"][form="${form.id}"]`);
            }
            if (!submitBtn) {
                console.error('Botão de submit não encontrado no formulário');
                return;
            }
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando...';

            // Prepara dados do formulário
            const formData = new FormData(form);

            // Envia via AJAX
            fetch(getBaseUrl() + '/depoimentos/enviar', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showFeedback(data.message, 'success');
                    form.reset();
                    selectedRating = 0;
                    highlightStars(0);
                    
                    // Fecha o modal após 3 segundos (dá tempo de ler a mensagem)
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('testimonialModal'));
                        if (modal) {
                            modal.hide();
                        }
                        // Limpa o feedback ao fechar
                        if (feedbackDiv) {
                            feedbackDiv.classList.remove('show');
                            feedbackDiv.innerHTML = '';
                        }
                    }, 3000);
                } else {
                    showFeedback(data.message || 'Erro ao enviar depoimento. Tente novamente.', 'danger');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                showFeedback('Erro ao enviar depoimento. Por favor, tente novamente.', 'danger');
            })
            .finally(() => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            });
        });
    }

    /**
     * Exibe feedback visual para o usuário - Centralizado
     */
    function showFeedback(message, type) {
        if (!feedbackDiv) return;

        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

        feedbackDiv.innerHTML = `
            <div class="alert ${alertClass} d-flex align-items-center" role="alert">
                <i class="fas ${iconClass} me-3" style="font-size: 1.5rem;"></i>
                <div>${message}</div>
            </div>
        `;

        // Mostra o feedback centralizado
        feedbackDiv.classList.add('show');

        // Remove automaticamente após 5 segundos
        setTimeout(() => {
            feedbackDiv.classList.remove('show');
            setTimeout(() => {
                feedbackDiv.innerHTML = '';
            }, 300); // Aguarda animação terminar
        }, 5000);
    }

    /**
     * Retorna a URL base do site
     */
    function getBaseUrl() {
        // Pega a URL base do atributo data-url-base se existir, senão usa a origem
        const baseUrlElement = document.querySelector('[data-url-base]');
        if (baseUrlElement) {
            return baseUrlElement.getAttribute('data-url-base');
        }
        
        // Fallback: tenta detectar baseado na estrutura do site
        const currentPath = window.location.pathname;
        const pathParts = currentPath.split('/').filter(part => part);
        
        // Se estiver em subpasta, ajusta
        if (pathParts.length > 0 && !pathParts[0].includes('.')) {
            return window.location.origin + '/' + pathParts[0];
        }
        
        return window.location.origin;
    }

})();
