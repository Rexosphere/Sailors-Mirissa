import './bootstrap';

import Alpine from 'alpinejs'

window.Alpine = Alpine

Alpine.start()

// Horizontal card carousels: scroll by one card per press.
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('experiences-scroll-container');
    const prev = document.getElementById('experiences-prev');
    const next = document.getElementById('experiences-next');

    if (!container || !prev || !next) return;

    const step = (direction) => {
        const card = container.firstElementChild;
        const gap = 32; // gap-8
        const width = card ? card.offsetWidth : 400;
        container.scrollBy({ left: direction * (width + gap), behavior: 'smooth' });
    };

    prev.addEventListener('click', () => step(-1));
    next.addEventListener('click', () => step(1));
})

// Admin forms: move focus to the first invalid field after a failed submit, and
// disable the submit button while the request is in flight.
document.addEventListener('DOMContentLoaded', () => {
    const summary = document.querySelector('[data-error-summary]');
    if (summary) {
        const firstInvalid = document.querySelector('[aria-invalid="true"]');
        (firstInvalid || summary).focus({ preventScroll: false });
    }

    document.querySelectorAll('form[method="POST"]').forEach((form) => {
        form.addEventListener('submit', () => {
            const button = form.querySelector('button[type="submit"]');
            if (!button || button.disabled) return;
            button.disabled = true;
            button.dataset.originalText = button.textContent.trim();
            button.textContent = 'Saving…';
            button.classList.add('opacity-60', 'cursor-not-allowed');
        });
    });
})
