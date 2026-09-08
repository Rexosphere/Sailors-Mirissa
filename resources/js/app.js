import './bootstrap';

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import { initCarousel, initCarousels } from './carousel';
import { initSections } from './sections';

window.Alpine = Alpine;
window.fpCarousel = { init: initCarousel };

Livewire.start();

initCarousels();

if (document.documentElement.classList.contains('fp-snap')) {
    initSections();
}
