// Animação dos contadores
$(document).ready(function () {
    'use strict';

    function animateCounters() {
        $('.counter').each(function () {
            const $this = $(this);
            const countTo = $this.attr('data-target');

            $({countNum: $this.text()}).animate({
                countNum: countTo
            }, {
                duration: 2000,
                easing: 'swing',
                step: function () {
                    $this.text(Math.floor(this.countNum));
                },
                complete: function () {
                    $this.text(this.countNum);
                }
            });
        });
    }

// Trigger counter animation when in viewport
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

// Observe statistics section
    const statsSection = document.querySelector('.statistics-section');
    if (statsSection) {
        observer.observe(statsSection);
    }
});