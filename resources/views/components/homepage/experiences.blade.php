@php
    $attractions = \App\Models\Experience::ordered()->get();
@endphp

<section class="fp-screen flex flex-col justify-center bg-stone-50" id="attractions" data-fp-section data-header-theme="light" tabindex="-1">
    <div class="container mx-auto flex min-h-0 flex-col px-4 pb-16 pt-24 md:px-10 md:pb-20 md:pt-28" data-carousel-group>
        <div class="mb-5 flex items-end justify-between gap-4 md:mb-8">
            <div>
                <h2 class="font-serif text-2xl font-bold text-slate-800 sm:text-3xl md:text-5xl">Must-Visit Attractions</h2>
                <p class="mt-2 text-base font-light tracking-wide text-slate-500 md:mt-3 md:text-lg">Swipe to explore the coast</p>
            </div>
            <div class="hidden gap-3 sm:flex">
                <button type="button" data-carousel-prev aria-label="Previous attraction"
                    class="flex size-12 items-center justify-center rounded-full border border-slate-200 text-slate-600 transition-all hover:bg-white hover:shadow-md active:scale-95 disabled:cursor-default disabled:opacity-40 disabled:hover:bg-transparent disabled:hover:shadow-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </button>
                <button type="button" data-carousel-next aria-label="Next attraction"
                    class="flex size-12 items-center justify-center rounded-full border border-slate-200 text-slate-600 transition-all hover:bg-white hover:shadow-md active:scale-95 disabled:cursor-default disabled:opacity-40 disabled:hover:bg-transparent disabled:hover:shadow-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </button>
            </div>
        </div>

        <div data-carousel class="fp-carousel -mx-4 flex snap-x snap-mandatory gap-5 overflow-x-auto px-4 pb-2 md:mx-0 md:gap-8 md:px-0">
            @forelse ($attractions as $attraction)
                <article class="group relative w-[72vw] shrink-0 snap-center sm:w-[320px] md:w-[400px]">
                    <div class="relative mb-4 h-[38dvh] max-h-[520px] overflow-hidden rounded-2xl shadow-lg transition-shadow duration-500 group-hover:shadow-2xl md:mb-6 md:h-[46dvh]">
                        <img src="{{ $attraction->image_url }}" alt="{{ $attraction->alt_text }}" loading="lazy" decoding="async"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 z-10 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-60 transition-opacity group-hover:opacity-80"></div>
                        @if ($attraction->badge)
                            <div class="absolute left-4 top-4 z-20 flex items-center gap-1.5 rounded-full bg-white/95 px-4 py-1.5 text-xs font-bold uppercase tracking-wider shadow-sm backdrop-blur-md">
                                @if ($attraction->icon)
                                    {!! $attraction->icon !!}
                                @endif
                                {{ $attraction->badge }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-serif text-xl font-bold text-slate-800 transition-colors group-hover:text-amber-500 md:text-2xl">{{ $attraction->title }}</h3>
                        <p class="mt-1 line-clamp-2 text-sm leading-relaxed text-slate-500 md:text-base">{{ $attraction->description }}</p>
                    </div>
                </article>
            @empty
                <p class="text-slate-500">Attractions are being updated. Check back soon.</p>
            @endforelse
        </div>

        <div data-carousel-dots class="mt-3 flex justify-center text-slate-700 sm:hidden"></div>
    </div>

    <x-scroll-next target="journey" label="the south coast" theme="light" />
</section>
