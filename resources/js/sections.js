import { gsap } from 'gsap';
import { ScrollToPlugin } from 'gsap/ScrollToPlugin';
import { initCardStack } from './card-stack';

gsap.registerPlugin(ScrollToPlugin);

const TWEEN_SECONDS = 1.6;
const WHEEL_THRESHOLD = 24;
const GESTURE_GAP_MS = 260;
const COOLDOWN_MS = 420;

/**
 * Full-screen sections: native scrolling does the movement; this module adds keyboard /
 * button jumping, header theming and the card-stack transition. Each section sits in a slot
 * that keeps its place in the document while the card-stack pins the section itself to the
 * viewport, so the browser's own scrolling only ever moves the empty slots.
 */
export function initSections() {
    const root = document.documentElement;
    const sections = Array.from(document.querySelectorAll('[data-fp-section]'));
    if (sections.length < 2) return;

    const slots = sections.map((section) => {
        const slot = document.createElement('div');
        slot.className = 'fp-slot';
        if (section.classList.contains('fp-screen--end')) slot.classList.add('fp-slot--end');
        section.replaceWith(slot);
        slot.appendChild(section);
        return slot;
    });

    const header = document.getElementById('main-header');
    const navLinks = Array.from(document.querySelectorAll('a[href^="#"]'));
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)');

    let active = 0;
    let initialised = false;
    let locked = false;
    let scrollEndTimer = 0;
    let lastHash = '';
    let wheelAccumulated = 0;
    let lastWheelAt = 0;

    const stack = reduceMotion.matches ? null : initCardStack(sections, slots);

    function indexOfHash(hash) {
        if (!hash || hash === '#') return -1;
        return sections.findIndex((section) => `#${section.id}` === hash);
    }

    function setActive(index) {
        if (initialised && index === active) return;
        initialised = true;
        active = index;
        const section = sections[index];
        if (header) header.dataset.theme = section.dataset.headerTheme || 'dark';
        navLinks.forEach((link) => {
            const isCurrent = link.getAttribute('href') === `#${section.id}`;
            if (isCurrent) link.setAttribute('aria-current', 'location');
            else link.removeAttribute('aria-current');
        });
        const hash = index === 0 ? ' ' : `#${section.id}`;
        if (hash !== lastHash) {
            lastHash = hash;
            try { history.replaceState(null, '', index === 0 ? window.location.pathname : hash); } catch (e) { /* ignore */ }
        }
        document.dispatchEvent(new CustomEvent('fp:change', { detail: { index, id: section.id } }));
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) setActive(slots.indexOf(entry.target));
        });
    }, { rootMargin: '-45% 0px -45% 0px', threshold: 0 });
    slots.forEach((slot) => observer.observe(slot));

    function goTo(index) {
        index = Math.max(0, Math.min(sections.length - 1, index));
        const target = sections[index];
        if (reduceMotion.matches) {
            slots[index].scrollIntoView({ behavior: 'auto', block: 'start' });
            target.focus({ preventScroll: true });
            return;
        }
        locked = true;
        root.classList.add('fp-tweening');
        gsap.to(window, {
            scrollTo: { y: slots[index].offsetTop, autoKill: false },
            duration: TWEEN_SECONDS,
            ease: 'power3.inOut',
            overwrite: true,
            onComplete() {
                root.classList.remove('fp-tweening');
                target.focus({ preventScroll: true });
                window.setTimeout(() => { locked = false; }, COOLDOWN_MS);
            },
        });
    }

    document.addEventListener('click', (event) => {
        const link = event.target.closest('a[href^="#"]');
        if (!link) return;
        const index = indexOfHash(link.getAttribute('href'));
        if (index < 0) return;
        event.preventDefault();
        goTo(index);
    });

    function insideInnerScroller(target, deltaY) {
        const scroller = target.closest?.('[data-fp-inner-scroll]');
        if (!scroller) return false;
        const canScroll = scroller.scrollHeight > scroller.clientHeight;
        if (!canScroll) return false;
        if (deltaY > 0) return scroller.scrollTop + scroller.clientHeight < scroller.scrollHeight - 1;
        return scroller.scrollTop > 0;
    }

    window.addEventListener('keydown', (event) => {
        if (event.defaultPrevented || event.altKey || event.ctrlKey || event.metaKey) return;
        const target = event.target;
        if (target.isContentEditable || ['INPUT', 'TEXTAREA', 'SELECT', 'BUTTON'].includes(target.tagName)) return;
        let next = null;
        switch (event.key) {
            case 'ArrowDown':
            case 'PageDown':
            case ' ':
                if (event.shiftKey && event.key === ' ') next = active - 1;
                else next = active + 1;
                break;
            case 'ArrowUp':
            case 'PageUp':
                next = active - 1;
                break;
            case 'Home':
                next = 0;
                break;
            case 'End':
                next = sections.length - 1;
                break;
            default:
                return;
        }
        if (insideInnerScroller(target, next > active ? 1 : -1)) return;
        event.preventDefault();
        if (!locked) goTo(next);
    });

    function onWheel(event) {
        if (event.ctrlKey || Math.abs(event.deltaX) > Math.abs(event.deltaY)) return;
        if (insideInnerScroller(event.target, event.deltaY)) return;
        event.preventDefault();
        const now = performance.now();
        if (locked) {
            lastWheelAt = now;
            return;
        }
        // Inertia tails arrive as a stream of small deltas; a pause marks a new gesture.
        if (now - lastWheelAt > GESTURE_GAP_MS) wheelAccumulated = 0;
        lastWheelAt = now;
        wheelAccumulated += event.deltaY;
        if (Math.abs(wheelAccumulated) < WHEEL_THRESHOLD) return;
        const step = Math.sign(wheelAccumulated);
        wheelAccumulated = 0;
        goTo(active + step);
    }

    function bindWheel() {
        window.removeEventListener('wheel', onWheel);
        return; // TEMP: wheel jumping disabled for inspection; remove this line to restore
        if (finePointer.matches && !reduceMotion.matches) {
            window.addEventListener('wheel', onWheel, { passive: false });
        }
    }
    bindWheel();
    finePointer.addEventListener?.('change', bindWheel);
    reduceMotion.addEventListener?.('change', bindWheel);

    window.addEventListener('scroll', () => {
        window.clearTimeout(scrollEndTimer);
        scrollEndTimer = window.setTimeout(() => {
            if (locked && !root.classList.contains('fp-tweening')) locked = false;
        }, 150);
    }, { passive: true });

    let lastWidth = window.innerWidth;
    let resizeTimer = 0;
    window.addEventListener('resize', () => {
        window.clearTimeout(resizeTimer);
        resizeTimer = window.setTimeout(() => {
            if (window.innerWidth !== lastWidth && !locked) {
                lastWidth = window.innerWidth;
                slots[active].scrollIntoView({ behavior: 'auto', block: 'start' });
            }
            stack?.measure();
        }, 150);
    });

    const initial = indexOfHash(window.location.hash);
    if (initial > 0) {
        window.requestAnimationFrame(() => slots[initial].scrollIntoView({ behavior: 'auto', block: 'start' }));
    }
}
