$(document).ready(function() {
    'use strict';

    // Navegação suave
    $(document).on('click', 'a[href^="#"]', function(e) {
        e.preventDefault();
        
        const href = $(this).attr('href');
        
        // Ignorar links vazios ou apenas #
        if (href === '#' || href === '') {
            return;
        }
        
        const target = $(href);
        
        if (target.length) {
            const offsetTop = target.offset().top - 80;
            
            $('html, body').animate({
                scrollTop: offsetTop
            }, 400);
            
            // Fechar menu mobile se estiver aberto
            $('.navbar-collapse').collapse('hide');
        }
    });

    // Gerenciar links ativos na página index
    if (window.location.pathname.endsWith('home.html') || window.location.pathname.endsWith('/')) {
        // Remover todas as classes active dos links de navegação
        $('.navbar-nav .nav-link').removeClass('active');
        
        // Adicionar classe active temporariamente quando clicar em links de âncora
        $(document).on('click', '.navbar-nav .nav-link[href^="#"]', function() {
            $('.navbar-nav .nav-link').removeClass('active');
            $(this).addClass('active');
        });
    }

    // Navbar scroll effect
    $(window).scroll(function() {
        if ($(window).scrollTop() > 100) {
            $('.navbar').addClass('scrolled');
        } else {
            $('.navbar').removeClass('scrolled');
        }
    });
    

    // Formulário de contato
    $('#contactForm').on('submit', function(e) {
        e.preventDefault();
        
        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');
        const originalText = $submitBtn.text();
        
        // Simular envio
        $submitBtn.prop('disabled', true);
        $submitBtn.html('<span class="spinner-border spinner-border-sm me-2"></span>Enviando...');
        
        // Simular delay de envio
        setTimeout(function() {
            showToast('Mensagem enviada com sucesso! Entraremos em contato em breve.', 'success');
            $form[0].reset();
            $submitBtn.prop('disabled', false);
            $submitBtn.text(originalText);
        }, 2000);
    });

    // Função para mostrar toast notifications (padrão lateral) - Exposta globalmente
    window.showToast = function(message, type = 'info') {
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

    // Animação de entrada dos elementos
    function animateOnScroll() {
        $('.service-item, .about-content, .testimonial-card').each(function() {
            const elementTop = $(this).offset().top;
            const elementBottom = elementTop + $(this).outerHeight();
            const viewportTop = $(window).scrollTop();
            const viewportBottom = viewportTop + $(window).height();
            
            if (elementBottom > viewportTop && elementTop < viewportBottom) {
                $(this).addClass('animate-fade-in-up');
            }
        });
    }

    // Trigger animation on scroll
    $(window).scroll(animateOnScroll);
    animateOnScroll(); // Initial check

    // Parallax effect para o hero
    $(window).scroll(function() {
        const scrolled = $(window).scrollTop();
        const parallax = $('.hero-slide');
        const speed = 0.5;
        
        parallax.css('transform', 'translateY(' + (scrolled * speed) + 'px)');
    });

    // Smooth reveal para seções
    function revealSections() {
        const sections = document.querySelectorAll('section');
        
        const sectionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        sections.forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(30px)';
            section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            sectionObserver.observe(section);
        });
    }

    // Initialize section reveals
    revealSections();

    // Hover effects para cards de serviços
    $('.service-item').hover(
        function() {
            $(this).find('.service-icon').addClass('pulse');
        },
        function() {
            $(this).find('.service-icon').removeClass('pulse');
        }
    );

    // Adicionar classe CSS para animação pulse
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            .pulse {
                animation: pulse 0.6s ease-in-out;
            }
            
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.1); }
                100% { transform: scale(1); }
            }
            
            .easeInOutQuart {
                transition-timing-function: cubic-bezier(0.77, 0, 0.175, 1);
            }
        `)
        .appendTo('head');

    // Validação de formulário em tempo real
    $('.form-control').on('blur', function() {
        const $field = $(this);
        const value = $field.val().trim();
        
        if ($field.attr('required') && !value) {
            $field.addClass('is-invalid');
            showFieldError($field, 'Este campo é obrigatório');
        } else if ($field.attr('type') === 'email' && value && !isValidEmail(value)) {
            $field.addClass('is-invalid');
            showFieldError($field, 'Digite um e-mail válido');
        } else if ($field.attr('type') === 'tel' && value && !isValidPhone(value)) {
            $field.addClass('is-invalid');
            showFieldError($field, 'Digite um telefone válido');
        } else {
            $field.removeClass('is-invalid');
            hideFieldError($field);
        }
    });

    function showFieldError($field, message) {
        let $error = $field.siblings('.invalid-feedback');
        if (!$error.length) {
            $error = $('<div class="invalid-feedback"></div>');
            $field.after($error);
        }
        $error.text(message);
    }

    function hideFieldError($field) {
        $field.siblings('.invalid-feedback').remove();
    }

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function isValidPhone(phone) {
        const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
        return phoneRegex.test(phone.replace(/\D/g, ''));
    }

    // Máscara para telefone
    $('#telefone').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 11) value = value.slice(0, 11);
        
        if (value.length > 0) {
            if (value.length <= 2) {
                value = `(${value}`;
            } else if (value.length <= 6) {
                value = `(${value.slice(0, 2)}) ${value.slice(2)}`;
            } else if (value.length <= 10) {
                value = `(${value.slice(0, 2)}) ${value.slice(2, 6)}-${value.slice(6)}`;
            } else {
                value = `(${value.slice(0, 2)}) ${value.slice(2, 7)}-${value.slice(7)}`;
            }
        }
        
        $(this).val(value);
    });

    // Lazy loading para imagens
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Preloader
    $(window).on('load', function() {
        $('.preloader').fadeOut('slow');
    });

    // Back to top button
    const $backToTop = $('<button class="back-to-top" title="Voltar ao topo"><i class="fas fa-chevron-up"></i></button>');
    $('body').append($backToTop);

    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
            $backToTop.fadeIn();
        } else {
            $backToTop.fadeOut();
        }
    });

    $backToTop.on('click', function() {
        $('html, body').animate({ scrollTop: 0 }, 800);
    });

    // Adicionar estilos para back to top
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            .back-to-top {
                position: fixed;
                bottom: 30px;
                right: 30px;
                width: 50px;
                height: 50px;
                background: var(--primary-color);
                color: white;
                border: none;
                border-radius: 50%;
                cursor: pointer;
                display: none;
                z-index: 1000;
                transition: var(--transition);
                box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
            }
            
            .back-to-top:hover {
                background: #1d4ed8;
                transform: translateY(-3px);
                box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
            }
            
            .back-to-top i {
                font-size: 1.2rem;
            }
            
            .is-invalid {
                border-color: var(--danger-color) !important;
            }
            
            .invalid-feedback {
                display: block;
                color: var(--danger-color);
                font-size: 0.875rem;
                margin-top: 0.25rem;
            }
        `)
        .appendTo('head');

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Funcionalidades específicas da Área do Cliente
    if (window.location.pathname.includes('area-cliente.html')) {
        // Toggle de senha
        $('.password-toggle').on('click', function() {
            const input = $(this).siblings('input');
            const icon = $(this).find('i');
            
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        // Formulário de login do cliente
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');
            const originalText = $submitBtn.html();
            
            $submitBtn.prop('disabled', true);
            $submitBtn.html('<span class="spinner-border spinner-border-sm me-2"></span>Entrando...');
            
            // Simular login
            setTimeout(function() {
                showToast('Dashboard realizado com sucesso! Redirecionando...', 'success');
                // Aqui você redirecionaria para o dashboard do cliente
                setTimeout(function() {
                    window.location.href = '#dashboard';
                }, 2000);
            }, 2000);
        });
    }

    // Funcionalidades específicas da Intranet
    if (window.location.pathname.includes('intranet.html')) {
        // Toggle de senha para intranet
        $('.password-toggle').on('click', function() {
            const input = $(this).siblings('input');
            const icon = $(this).find('i');
            
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        // Formulário de login da intranet
        $('#intranetLoginForm').on('submit', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');
            const originalText = $submitBtn.html();
            
            $submitBtn.prop('disabled', true);
            $submitBtn.html('<span class="spinner-border spinner-border-sm me-2"></span>Acessando...');
            
            // Simular login
            setTimeout(function() {
                showToast('Acesso autorizado! Redirecionando para o sistema...', 'success');
                // Aqui você redirecionaria para o dashboard da intranet
                setTimeout(function() {
                    window.location.href = '#intranet-dashboard';
                }, 2000);
            }, 2000);
        });

        // Simular status dos sistemas
        function updateSystemStatus() {
            $('.status-badge').each(function() {
                const $badge = $(this);
                const isOnline = Math.random() > 0.1; // 90% chance de estar online
                
                if (isOnline) {
                    $badge.removeClass('offline').addClass('online').text('Online');
                } else {
                    $badge.removeClass('online').addClass('offline').text('Offline');
                }
            });
        }

        // Atualizar status a cada 30 segundos
        setInterval(updateSystemStatus, 30000);
    }

    console.log('CondomínioPro - Site carregado com sucesso!');
}); 