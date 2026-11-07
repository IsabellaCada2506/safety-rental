/*
 * Author: Isabella Cadavid Posada
 * Author: Wendy Atehortua
 * Date: 2026-11-06
 * Description: Fully automatic user banner carousel without manual pause buttons, transitioning automatically.
 */

(() => {
    document.querySelectorAll('[data-user-carousel]').forEach((carousel) => {
        const slides = Array.from(carousel.querySelectorAll('[data-user-slide]'));
        const dots = Array.from(carousel.querySelectorAll('[data-user-dot]'));
        const previous = carousel.querySelector('[data-user-previous]');
        const next = carousel.querySelector('[data-user-next]');
        const status = carousel.querySelector('[data-user-status]');
        const interval = Math.max(3000, Number(carousel.dataset.interval) || 4000);
        let currentIndex = 0;
        let timer = null;

        const stop = () => {
            if (timer !== null) {
                window.clearInterval(timer);
                timer = null;
            }
        };

        const show = (index) => {
            currentIndex = (index + slides.length) % slides.length;
            slides.forEach((slide, slideIndex) => {
                slide.hidden = slideIndex !== currentIndex;
            });
            dots.forEach((dot, dotIndex) => {
                dot.setAttribute('aria-pressed', String(dotIndex === currentIndex));
            });
            if (status && carousel.dataset.statusTemplate) {
                status.textContent = carousel.dataset.statusTemplate
                    .replace(':current', String(currentIndex + 1))
                    .replace(':total', String(slides.length));
            }
        };

        const start = () => {
            stop();
            if (slides.length > 1 && !document.hidden) {
                timer = window.setInterval(() => {
                    show(currentIndex + 1);
                }, interval);
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

        if (previous) {
            previous.addEventListener('click', () => {
                show(currentIndex - 1);
                start();
            });
        }

        if (next) {
            next.addEventListener('click', () => {
                show(currentIndex + 1);
                start();
            });
        }

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                show(index);
                start();
            });
        });

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                stop();
            } else {
                start();
            }
        });

        show(0);
        start();
    });
})();
