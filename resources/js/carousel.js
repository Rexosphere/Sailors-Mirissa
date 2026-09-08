const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

/**
 * Horizontal scroll-snap carousel with optional dots and prev/next buttons.
 * Controls live inside the closest [data-carousel-group] (or the parent element).
 */
export function initCarousel(root) {
    if (root.__carousel) {
        root.__carousel.refresh();
        return root.__carousel;
    }

    const group = root.closest('[data-carousel-group]') ?? root.parentElement;
    const dots = group?.querySelector('[data-carousel-dots]');
    const prev = group?.querySelector('[data-carousel-prev]');
    const next = group?.querySelector('[data-carousel-next]');
    let active = 0;
    let raf = 0;

    const items = () => Array.from(root.children);

    function itemLeft(el) {
        return el.getBoundingClientRect().left - root.getBoundingClientRect().left + root.scrollLeft;
    }

    function current() {
        const center = root.scrollLeft + root.clientWidth / 2;
        let best = 0;
        let distance = Infinity;
        items().forEach((el, i) => {
            const d = Math.abs(itemLeft(el) + el.offsetWidth / 2 - center);
            if (d < distance) {
                distance = d;
                best = i;
            }
        });
        return best;
    }

    function update() {
        const list = items();
        active = current();
        dots?.querySelectorAll('.fp-dot').forEach((dot, i) => dot.setAttribute('aria-current', i === active ? 'true' : 'false'));
        if (prev) prev.disabled = active === 0;
        if (next) next.disabled = active >= list.length - 1;
    }

    function scrollToIndex(index) {
        const list = items();
        index = Math.max(0, Math.min(list.length - 1, index));
        const el = list[index];
        if (!el) return;
        root.scrollTo({
            left: itemLeft(el) - (root.clientWidth - el.offsetWidth) / 2,
            behavior: reduceMotion.matches ? 'auto' : 'smooth',
        });
    }

    function refresh() {
        if (dots) {
            dots.innerHTML = items()
                .map((_, i) => `<button type="button" class="fp-dot" aria-label="Go to slide ${i + 1}" data-index="${i}"></button>`)
                .join('');
        }
        update();
    }

    dots?.addEventListener('click', (event) => {
        const dot = event.target.closest('.fp-dot');
        if (dot) scrollToIndex(Number(dot.dataset.index));
    });
    prev?.addEventListener('click', () => scrollToIndex(active - 1));
    next?.addEventListener('click', () => scrollToIndex(active + 1));
    root.addEventListener('scroll', () => {
        if (!raf) raf = requestAnimationFrame(() => { raf = 0; update(); });
    }, { passive: true });
    window.addEventListener('resize', update);

    root.__carousel = { refresh, scrollToIndex };
    refresh();

    return root.__carousel;
}

export function initCarousels() {
    document.querySelectorAll('[data-carousel]').forEach((el) => initCarousel(el));
}
