// Intranet JavaScript
$(document).ready(function() {
    // Sidebar Toggle
    $('#sidebarToggle, #sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('collapsed');
        $('#content').toggleClass('expanded');
    });

    // Mobile sidebar toggle
    $('#sidebarToggle').on('click', function() {
        if ($(window).width() <= 768) {
            $('#sidebar').toggleClass('show');
        }
    });

    // Close sidebar on mobile when clicking outside
    $(document).on('click', function(e) {
        if ($(window).width() <= 768) {
            if (!$(e.target).closest('#sidebar, #sidebarToggle').length) {
                $('#sidebar').removeClass('show');
            }
        }
    });

    // Active menu item
    $('.menu-link').on('click', function() {
        $('.menu-link').removeClass('active');
        $(this).addClass('active');
    });

    // Logout functionality
    $('#logoutBtn').on('click', function(e) {
        e.preventDefault();
        showConfirm('Tem certeza que deseja sair?', function() {
            // Simulate logout
            showToast('Logout realizado com sucesso!', 'success');
            setTimeout(function() {
                window.location.href = '../intranet.html';
            }, 1500);
        });
    });

    // Initialize Charts
    initializeCharts();

    // Initialize quick actions
    initializeQuickActions();

    // Auto-refresh dashboard data - DESABILITADO: dados agora vêm do banco de dados
    // setInterval(refreshDashboardData, 30000); // Refresh every 30 seconds
});

// Chart Initialization
function initializeCharts() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                datasets: [{
                    label: 'Receita (R$)',
                    data: [1800000, 2100000, 1950000, 2400000, 2200000, 2400000],
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'R$ ' + (value / 1000000).toFixed(1) + 'M';
                            }
                        }
                    }
                }
            }
        });
    }

    // Services Chart
    const servicesCtx = document.getElementById('servicesChart');
    if (servicesCtx) {
        new Chart(servicesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Gestão Financeira', 'Manutenção', 'Segurança', 'Jurídico'],
                datasets: [{
                    data: [45, 25, 20, 10],
                    backgroundColor: [
                        '#2563eb',
                        '#10b981',
                        '#f59e0b',
                        '#ef4444'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    }
}

// Notifications - Desabilitadas
// function initializeNotifications() {
//     // Simulate real-time notifications
//     setInterval(function() {
//         const notifications = [
//             'Nova manutenção agendada para amanhã',
//             'Relatório financeiro disponível',
//             'Atualização do sistema concluída',
//             'Novo morador cadastrado'
//         ];
//         
//         const randomNotification = notifications[Math.floor(Math.random() * notifications.length)];
//         showToast(randomNotification, 'info');
//     }, 60000); // Every minute
// }

// Quick Actions
function initializeQuickActions() {
    $('.quick-action-btn').on('click', function(e) {
        e.preventDefault();
        const action = $(this).find('span').text();
        showToast(`Ação "${action}" iniciada!`, 'success');
        
        // Simulate loading
        $(this).addClass('loading');
        setTimeout(function() {
            $('.quick-action-btn').removeClass('loading');
        }, 2000);
    });
}

// Dashboard Data Refresh - REMOVIDO: dados agora vêm do banco de dados
// A função abaixo foi desabilitada pois os dados agora são dinâmicos e vêm do backend
/*
function refreshDashboardData() {
    // Simulate data refresh
    const stats = [
        { selector: '.stat-card:nth-child(1) h3', value: Math.floor(Math.random() * 5) + 22 },
        { selector: '.stat-card:nth-child(2) h3', value: Math.floor(Math.random() * 100) + 1200 },
        { selector: '.stat-card:nth-child(3) h3', value: Math.floor(Math.random() * 10) + 5 },
        { selector: '.stat-card:nth-child(4) h3', value: 'R$ ' + (Math.random() * 0.5 + 2.2).toFixed(1) + 'M' }
    ];
    
    stats.forEach(stat => {
        $(stat.selector).fadeOut(200, function() {
            $(this).text(stat.value).fadeIn(200);
        });
    });
}
*/

// Toast Notifications
function showToast(message, type = 'info') {
    const toast = $(`
        <div class="toast-notification toast-${type}">
            <div class="toast-content">
                <i class="fas fa-${getToastIcon(type)}"></i>
                <span>${message}</span>
            </div>
            <button class="toast-close">&times;</button>
        </div>
    `);
    
    $('body').append(toast);
    
    // Show toast
    setTimeout(() => {
        toast.addClass('show');
    }, 100);
    
    // Auto hide
    setTimeout(() => {
        hideToast(toast);
    }, 5000);
    
    // Manual close
    toast.find('.toast-close').on('click', function() {
        hideToast(toast);
    });
}

function hideToast(toast) {
    toast.removeClass('show');
    setTimeout(() => {
        toast.remove();
    }, 300);
}

function getToastIcon(type) {
    const icons = {
        success: 'check-circle',
        error: 'exclamation-circle',
        warning: 'exclamation-triangle',
        info: 'info-circle'
    };
    return icons[type] || 'info-circle';
}

// Add toast styles dynamically
const toastStyles = `
    <style>
        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            z-index: 9999;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            max-width: 350px;
        }
        
        .toast-notification.show {
            transform: translateX(0);
        }
        
        .toast-content {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex: 1;
        }
        
        .toast-close {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: #64748b;
            cursor: pointer;
            padding: 0;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .toast-success {
            border-left: 4px solid #10b981;
        }
        
        .toast-error {
            border-left: 4px solid #ef4444;
        }
        
        .toast-warning {
            border-left: 4px solid #f59e0b;
        }
        
        .toast-info {
            border-left: 4px solid #2563eb;
        }
        
        .toast-success i {
            color: #10b981;
        }
        
        .toast-error i {
            color: #ef4444;
        }
        
        .toast-warning i {
            color: #f59e0b;
        }
        
        .toast-info i {
            color: #2563eb;
        }
    </style>
`;

$('head').append(toastStyles);

// Confirm Modal
function showConfirm(message, onConfirm, onCancel) {
    // Remove modal existente se houver
    $('#confirmModal').remove();
    
    const modal = $(`
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="confirmModalLabel">
                            <i class="fas fa-question-circle text-warning me-2"></i>
                            Confirmação
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ${message}
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="confirmCancelBtn">
                            <i class="fas fa-times me-2"></i>
                            Cancelar
                        </button>
                        <button type="button" class="btn btn-primary" id="confirmOkBtn">
                            <i class="fas fa-check me-2"></i>
                            Confirmar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `);
    
    $('body').append(modal);
    
    const bsModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    bsModal.show();
    
    // Handler para confirmação
    $('#confirmOkBtn').on('click', function() {
        bsModal.hide();
        if (typeof onConfirm === 'function') {
            onConfirm();
        }
    });
    
    // Handler para cancelamento
    $('#confirmCancelBtn').on('click', function() {
        if (typeof onCancel === 'function') {
            onCancel();
        }
    });
    
    // Remove modal do DOM após fechar
    $('#confirmModal').on('hidden.bs.modal', function() {
        $(this).remove();
    });
}

// Exporta showConfirm e showToast globalmente
window.showConfirm = showConfirm;
window.showToast = showToast;

// Search functionality
$('.search-input').on('keyup', function() {
    const query = $(this).val().toLowerCase();
    
    if (query.length > 2) {
        // Simulate search
        showToast(`Buscando por: "${query}"`, 'info');
    }
});

// Export functionality
$('.export-btn').on('click', function() {
    const format = $(this).data('format');
    showToast(`Exportando dados em ${format.toUpperCase()}...`, 'info');
    
    // Simulate export
    setTimeout(() => {
        showToast(`Arquivo exportado com sucesso!`, 'success');
    }, 2000);
});

// Print functionality
$('.print-btn').on('click', function() {
    showToast('Preparando para impressão...', 'info');
    setTimeout(() => {
        window.print();
    }, 1000);
});

// Keyboard shortcuts
$(document).on('keydown', function(e) {
    // Ctrl/Cmd + K for search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        $('.search-input').focus();
    }
    
    // Ctrl/Cmd + B for sidebar toggle
    if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
        e.preventDefault();
        $('#sidebarToggle').click();
    }
    
    // Escape to close sidebar on mobile
    if (e.key === 'Escape' && $(window).width() <= 768) {
        $('#sidebar').removeClass('show');
    }
});


// Responsive adjustments
$(window).on('resize', function() {
    if ($(window).width() > 768) {
        $('#sidebar').removeClass('show');
    }
});

// Loading states
function showLoading(element) {
    $(element).addClass('loading');
}

function hideLoading(element) {
    $(element).removeClass('loading');
}

// Data table functionality
$('.data-table').on('click', '.sortable', function() {
    const column = $(this).data('column');
    const direction = $(this).hasClass('asc') ? 'desc' : 'asc';
    
    $('.sortable').removeClass('asc desc');
    $(this).addClass(direction);
    
    showToast(`Ordenando por ${column} (${direction})`, 'info');
});

// Pagination
$('.pagination .page-link').on('click', function(e) {
    e.preventDefault();
    const page = $(this).data('page');
    showToast(`Carregando página ${page}...`, 'info');
});

// Filter functionality
$('.filter-select').on('change', function() {
    const filter = $(this).val();
    showToast(`Filtrando por: ${filter}`, 'info');
});

// Date picker functionality
$('.date-picker').on('change', function() {
    const date = $(this).val();
    showToast(`Data selecionada: ${date}`, 'info');
});

// File upload
$('.file-upload').on('change', function() {
    const fileName = $(this).val().split('\\').pop();
    showToast(`Arquivo selecionado: ${fileName}`, 'success');
});

// Form validation
$('form').on('submit', function(e) {
    const requiredFields = $(this).find('[required]');
    let isValid = true;
    
    requiredFields.each(function() {
        if (!$(this).val()) {
            $(this).addClass('is-invalid');
            isValid = false;
        } else {
            $(this).removeClass('is-invalid');
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        showToast('Por favor, preencha todos os campos obrigatórios', 'error');
    }
});

// Remove validation classes on input
$('input, textarea, select').on('input', function() {
    $(this).removeClass('is-invalid');
});

// Initialize tooltips (Bootstrap 5)
const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});

// Initialize popovers (Bootstrap 5)
const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl);
});

// Dark mode toggle (if implemented)
$('.dark-mode-toggle').on('click', function() {
    $('body').toggleClass('dark-mode');
    const isDark = $('body').hasClass('dark-mode');
    showToast(`Modo ${isDark ? 'escuro' : 'claro'} ativado`, 'info');
});

// Language switcher
$('.language-select').on('change', function() {
    const language = $(this).val();
    showToast(`Idioma alterado para: ${language}`, 'info');
});

// Theme switcher
$('.theme-select').on('change', function() {
    const theme = $(this).val();
    showToast(`Tema alterado para: ${theme}`, 'info');
});

// Help system
$('.help-btn').on('click', function() {
    showToast('Abrindo sistema de ajuda...', 'info');
});

// Feedback system
$('.feedback-btn').on('click', function() {
    showToast('Abrindo formulário de feedback...', 'info');
});

// Settings
$('.settings-btn').on('click', function() {
    showToast('Abrindo configurações...', 'info');
});

// Profile
$('.profile-btn').on('click', function() {
    showToast('Abrindo perfil...', 'info');
});

// Logout confirmation
$('.logout-btn').on('click', function(e) {
    e.preventDefault();
    
    const confirmDialog = $(`
        <div class="modal fade" id="logoutModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar Logout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que deseja sair do sistema?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="confirmLogout">Sair</button>
                    </div>
                </div>
            </div>
        </div>
    `);
    
    $('body').append(confirmDialog);
    const modal = new bootstrap.Modal(confirmDialog);
    modal.show();
    
    $('#confirmLogout').on('click', function() {
        showToast('Logout realizado com sucesso!', 'success');
        setTimeout(() => {
            window.location.href = '../intranet.html';
        }, 1500);
    });
    
    confirmDialog.on('hidden.bs.modal', function() {
        confirmDialog.remove();
    });
}); 