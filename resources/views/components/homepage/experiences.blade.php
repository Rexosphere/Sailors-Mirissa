@php
    // The carousel is DB-backed but the detail pages come from config('experiences'),
    // keyed by slug. Only some titles have a matching page, so link conditionally
    // rather than generating 404s.
    $pages = config('experiences');
    $attractions = \App\Models\Experience::all()->map(function ($item) use ($pages) {
        $slug = \Illuminate\Support\Str::slug($item->title);
        $item->page_slug = isset($pages[$slug]) ? $slug : null;
        return $item;
    });
@endphp

<section class="py-16 pb-24 overflow-hidden bg-stone-50" id="attractions">
    <div class="container mx-auto px-4 md:px-10">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl md:text-5xl font-bold font-display text-slate-800">Must-Visit Experiences</h2>
                <p class="text-slate-600 mt-3 text-lg font-light tracking-wide">Swipe to explore the coast</p>
            </div>
            <div class="flex gap-3">
                <button id="experiences-prev" type="button" class="size-12 rounded-full border border-slate-300 flex items-center justify-center text-slate-700 hover:bg-white hover:shadow-md transition-all cursor-pointer focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-strong" aria-label="Previous experiences" aria-controls="experiences-scroll-container">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </button>
                <button id="experiences-next" type="button" class="size-12 rounded-full border border-slate-300 flex items-center justify-center text-slate-700 hover:bg-white hover:shadow-md transition-all cursor-pointer focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-strong" aria-label="Next experiences" aria-controls="experiences-scroll-container">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </button>
            </div>
        </div>

        <div id="experiences-scroll-container" tabindex="0" role="group" aria-label="Experiences"
            class="flex overflow-x-auto hide-scrollbar snap-x snap-mandatory pb-12 gap-8 -mx-4 px-4 md:mx-0 md:px-0 scroll-smooth focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-strong">
            @foreach($attractions as $attraction)
                @php
                    $tag = $attraction->page_slug ? 'a' : 'div';
                @endphp
                <!-- Card -->
                <{{ $tag }} @if($attraction->page_slug) href="{{ route('experience', $attraction->page_slug) }}" @endif
                    class="snap-center shrink-0 w-[85vw] md:w-[400px] group relative block rounded-2xl @if($attraction->page_slug) cursor-pointer focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-brand-strong @endif">
                    <div class="relative overflow-hidden rounded-2xl aspect-[4/5] md:aspect-[3/4] mb-6 shadow-lg group-hover:shadow-2xl transition-all duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent z-10 opacity-60 group-hover:opacity-80 transition-opacity"></div>
                        <img src="{{ $attraction->image_url }}" alt="{{ $attraction->alt_text }}" loading="lazy"
                             decoding="async"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @if($attraction->badge)
                            <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-md px-4 py-1.5 rounded-full text-xs font-bold shadow-sm z-20 flex items-center gap-1.5 uppercase tracking-wider text-slate-900">
                                @if($attraction->icon)
                                    {!! strip_tags($attraction->icon, '<svg><path><circle><g><rect><line><polyline><polygon>') !!}
                                @endif
                                {{ $attraction->badge }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold font-display text-slate-800 group-hover:text-brand-strong transition-colors">{{ $attraction->title }}</h3>
                        <p class="text-slate-600 mt-1 leading-relaxed">{{ $attraction->description }}</p>
                    </div>
                </{{ $tag }}>
            @endforeach
        </div>

    </div>
</section>
