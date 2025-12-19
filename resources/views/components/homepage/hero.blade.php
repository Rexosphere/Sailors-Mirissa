<!-- Hero Section -->
<section id="featured_header" class="relative min-h-screen overflow-hidden">
    <!-- Hero Image -->
    <div class="absolute inset-0">
        <img src="/images/photos/hero-background.avif"
             alt="Saylors Mirissa"
             class="w-full h-full object-cover animate-ken-burns">
    </div>

    <!-- Dark overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent pointer-events-none z-10"></div>

    <!-- Content wrapper -->
    <div class="relative z-20 flex flex-col min-h-screen pointer-events-none">
        <!-- Hero text (vertically centered) -->
        <div class="text-white px-8 py-8 w-full flex flex-col justify-center flex-1" style="margin-top: 10vh;">
            {{-- <h1 class="text-4xl md:text-7xl font-bold font-display leading-tight w-full whitespace-nowrap">
                Your Chill Spot in Paradise
            </h1>

            <p class="text-xl md:text-2xl font-light mb-8 leading-relaxed whitespace-pre-line">
                Wake up in the heart of Mirissa, roll out of bed.
                and you're already living your best life.
                Everything you want is within a wave's reach.
            </p>

            <div class="flex flex-col items-start gap-4">
                <div class="text-2xl font-bold tracking-widest">CHECK AVAILABILITY</div>
                <div class="w-48 h-0.5 bg-white"></div>
            </div> --}}
        </div>

        <!-- Location Features -->
        <div class="max-w-screen-2xl mx-auto px-8 pb-12 pointer-events-auto">
            <!-- Scroll Down Button -->
            <div class="flex justify-center pb-4 pt-16 pointer-events-auto">
                <a href="#interactive-map" class="flex flex-col items-center gap-2 text-white hover:text-gray-200 transition-colors">
                    <span class="text-sm uppercase tracking-wider">Scroll Down</span>
                    <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </a>
            </div>

            <div class="flex flex-col md:flex-row text-center items-center justify-between gap-8 md:gap-12">

                <!-- Item 1 -->
                <div class="flex flex-col items-center w-fit">
                    <img src="images/icons/departures.avif" alt="Airport Icon" class="h-16 w-16 mb-2 object-contain invert">
                    <div class="w-8 h-0.5 bg-gray-50 mb-2"></div>
                    <p class="text-sm text-gray-100">2.5 hours from <br> the airport</p>
                </div>

                <!-- Item 2 -->
                <div class="flex flex-col items-center w-fit">
                    <img src="images/icons/motorway.avif" alt="highwayIcon" class="h-16 w-16 mb-2 object-contain invert">
                    <div class="w-8 h-0.5 bg-gray-50 mb-2"></div>
                    <p class="text-sm text-gray-100">Minutes away from the <br> Southern Expressway</p>
                </div>

                <!-- Item 3 -->
                <div class="flex flex-col items-center w-fit">
                    <img src="images/icons/taxi.avif" alt="mobile Icon" class="h-16 w-16 mb-2 object-contain invert">
                    <div class="w-8 h-0.5 bg-gray-50 mb-2"></div>
                    <p class="text-sm text-gray-100">24/7 available <br> Tuk-tuks and taxis</p>
                </div>

                <!-- Item 4 -->
                <div class="flex flex-col items-center w-fit">
                    <img src="images/icons/walking.avif" alt="walk Icon" class="h-16 w-16 mb-2 object-contain invert">
                    <div class="w-8 h-0.5 bg-gray-50 mb-2"></div>
                    <p class="text-sm text-gray-100 text-center">
                        Walk to most <br> Mirissa highlights
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

