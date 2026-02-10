@php
    $attractions = \App\Models\Experience::all()->toArray();
@endphp

<section class="py-16 pb-24 overflow-hidden bg-stone-50 dark:bg-[#162028]" id="attractions">
    <div class="container mx-auto px-4 md:px-10">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl md:text-5xl font-bold font-serif text-slate-800 dark:text-white">Must-Visit Attractions</h2>
                <p class="text-slate-500 dark:text-slate-400 mt-3 text-lg font-light tracking-wide">Swipe to explore the coast</p>
            </div>
            <div class="flex gap-3">
                <button id="experiences-prev" class="size-12 rounded-full border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-800 hover:shadow-md transition-all" aria-label="Previous">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </button>
                <button id="experiences-next" class="size-12 rounded-full border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-800 hover:shadow-md transition-all" aria-label="Next">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </button>
            </div>
        </div>

        <div id="experiences-scroll-container" class="flex overflow-x-auto hide-scrollbar snap-x snap-mandatory pb-12 gap-8 -mx-4 px-4 md:mx-0 md:px-0 scroll-smooth">
            @foreach($attractions as $attraction)
                <!-- Card -->
                <div class="snap-center shrink-0 w-[85vw] md:w-[400px] group cursor-pointer relative">
                    <div class="relative overflow-hidden rounded-2xl aspect-[4/5] md:aspect-[3/4] mb-6 shadow-lg group-hover:shadow-2xl transition-all duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent z-10 opacity-60 group-hover:opacity-80 transition-opacity"></div>
                        <div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-110" 
                             data-alt="{{ $attraction['alt_text'] }}" 
                             style='background-image: url("{{ $attraction['image_url'] }}");'>
                        </div>
                        @if($attraction['badge'])
                            <div class="absolute top-4 left-4 bg-white/95 dark:bg-black/80 backdrop-blur-md px-4 py-1.5 rounded-full text-xs font-bold shadow-sm z-20 flex items-center gap-1.5 uppercase tracking-wider">
                                @if($attraction['icon'])
                                    {!! $attraction['icon'] !!}
                                @endif
                                {{ $attraction['badge'] }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold font-serif text-slate-800 dark:text-white group-hover:text-amber-500 dark:group-hover:text-blue-400 transition-colors">{{ $attraction['title'] }}</h3>
                        <p class="text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">{{ $attraction['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <style>
            .hide-scrollbar::-webkit-scrollbar {
                display: none;
            }
            .hide-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const container = document.getElementById('experiences-scroll-container');
                const prevBtn = document.getElementById('experiences-prev');
                const nextBtn = document.getElementById('experiences-next');

                if (!container || !prevBtn || !nextBtn) return;

                prevBtn.addEventListener('click', () => {
                     const firstCard = container.querySelector('div.snap-center');
                     const cardWidth = firstCard ? firstCard.offsetWidth : 400;
                     const gap = 32; // gap-8 is 2rem = 32px
                     container.scrollBy({ left: -(cardWidth + gap), behavior: 'smooth' });
                });

                nextBtn.addEventListener('click', () => {
                     const firstCard = container.querySelector('div.snap-center');
                     const cardWidth = firstCard ? firstCard.offsetWidth : 400;
                     const gap = 32; 
                     container.scrollBy({ left: (cardWidth + gap), behavior: 'smooth' });
                });
            });
        </script>
    </div>
</section>
