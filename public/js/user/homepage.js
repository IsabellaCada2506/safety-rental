/*
 * Author: Isabella Cadavid Posada
 * Date: 2026-11-04
 * Description: Automatic user banner with pause controls, keyboard-friendly buttons and reduced-motion support.
 */

(() => {
    document.querySelectorAll('[data-user-carousel]').forEach((carousel) => {
        const slides = Array.from(carousel.querySelectorAll('[data-user-slide]'));
        const dots = Array.from(carousel.querySelectorAll('[data-user-dot]'));
        const previous = carousel.querySelector('[data-user-previous]');
        const next = carousel.querySelector('[data-user-next]');
        const toggle = carousel.querySelector('[data-user-toggle]');
        const status = carousel.querySelector('[data-user-status]');
        const motionPreference = window.matchMedia('(prefers-reduced-motion: reduce)');
        const interval = Math.max(3000, Number(carousel.dataset.interval) || 5000);
        let currentIndex = 0;
        let timer = null;
        let paused = motionPreference.matches;
        let hovered = false;
        let focused = false;

        const stop = () => {
            window.clearInterval(timer);
            timer = null;
        };

        const show = (index) => {
            currentIndex = (index + slides.length) % slides.length;
            slides.forEach((slide, slideIndex) => {
                slide.hidden = slideIndex !== currentIndex;
            });
            dots.forEach((dot, dotIndex) => {
                dot.setAttribute('aria-pressed', String(dotIndex === currentIndex));
            });
            status.textContent = carousel.dataset.statusTemplate
                .replace(':current', String(currentIndex + 1))
                .replace(':total', String(slides.length));
        };

        const sync = () => {
            stop();
            toggle.textContent = paused ? carousel.dataset.playLabel : carousel.dataset.pauseLabel;
            const running = !paused && !hovered && !focused && !document.hidden;
            status.setAttribute('aria-live', running ? 'off' : 'polite');
            if (running && slides.length > 1) {
                timer = window.setInterval(() => show(currentIndex + 1), interval);
            }
        };

        slides.forEach((image) => {
            const useFallback = () => {
                if (image.dataset.fallbackApplied === 'true') {
                    return;
                }
                image.dataset.fallbackApplied = 'true';
                image.src = carousel.dataset.fallback;
            };
            image.addEventListener('error', useFallback);
            if (image.complete && image.naturalWidth === 0) {
                useFallback();
            }
        });

        previous.addEventListener('click', () => {
            show(currentIndex - 1);
            sync();
        });
        next.addEventListener('click', () => {
            show(currentIndex + 1);
            sync();
        });
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                show(index);
                sync();
            });
        });
        toggle.addEventListener('click', () => {
            paused = !paused;
            sync();
        });
        carousel.addEventListener('mouseenter', () => {
            hovered = true;
            sync();
        });
        carousel.addEventListener('mouseleave', () => {
            hovered = false;
            sync();
        });
        carousel.addEventListener('focusin', () => {
            focused = true;
            sync();
        });
        carousel.addEventListener('focusout', (event) => {
            focused = carousel.contains(event.relatedTarget);
            sync();
        });
        document.addEventListener('visibilitychange', sync);
        motionPreference.addEventListener('change', (event) => {
            if (event.matches) {
                paused = true;
            }
            sync();
        });

        show(0);
        sync();
    });
})();
