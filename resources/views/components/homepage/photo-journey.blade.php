<section id="journey" class="fp-screen bg-black" data-fp-section data-header-theme="dark" tabindex="-1" aria-label="Around the south coast" data-carousel-group>
    <div data-carousel class="fp-carousel flex h-full snap-x snap-mandatory overflow-x-auto">
        @foreach ([['matara', 'Matara', 'Colonial harbour town, 30 minutes east'], ['road', 'The coastal road', 'Palm-lined drives along the southern shore'], ['galle', 'Galle Fort', 'UNESCO ramparts, an hour up the coast']] as [$file, $alt, $caption])
            <div class="relative h-full w-full shrink-0 snap-center">
                <img src="/images/{{ $file }}.avif" alt="{{ $alt }}" loading="lazy" decoding="async"
                    class="h-full w-full object-cover object-center">
                <div class="pointer-events-none absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-28 left-6 md:bottom-32 md:left-12">
                    <p class="fp-eyebrow !text-[#8fd0d3]">Day trips</p>
                    <h3 class="mt-1 font-serif text-3xl font-bold text-white md:text-5xl">{{ $alt }}</h3>
                    <p class="mt-1 text-sm text-white/80 md:text-base">{{ $caption }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <button type="button" data-carousel-prev aria-label="Previous photo"
        class="absolute left-4 top-1/2 z-20 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full border-2 border-white/70 bg-black/50 text-white transition-all duration-300 hover:bg-white hover:text-black active:scale-95 disabled:opacity-30 disabled:hover:bg-black/50 disabled:hover:text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
    </button>
    <button type="button" data-carousel-next aria-label="Next photo"
        class="absolute right-4 top-1/2 z-20 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full border-2 border-white/70 bg-black/50 text-white transition-all duration-300 hover:bg-white hover:text-black active:scale-95 disabled:opacity-30 disabled:hover:bg-black/50 disabled:hover:text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <div data-carousel-dots class="absolute bottom-20 left-1/2 z-20 flex -translate-x-1/2 text-white"></div>

    <x-scroll-next target="site-footer" label="contact details" theme="dark" />
</section>
