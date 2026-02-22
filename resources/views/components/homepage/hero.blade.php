<!-- Hero Section -->
<section id="featured_header" class="relative min-h-screen overflow-hidden">
    <!-- Hero Image -->
    <div class="absolute inset-0">
        <img src="/images/photos/hero-background.avif"
            alt="Sailor's Mirissa beachfront hotel with ocean view in Mirissa, Sri Lanka"
            class="w-full h-full object-cover object-center md:object-center animate-ken-burns">
    </div>

    <!-- Dark overlay -->
    <div
        class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent pointer-events-none z-10">
    </div>

    <!-- Content wrapper -->
    <div class="relative z-20 flex flex-col min-h-screen pointer-events-none">
        <!-- Hero text (vertically centered) -->
        <div class="text-white px-8 py-8 w-full flex flex-col justify-center flex-1" style="margin-top: 10vh;">
            <h1 class="sr-only text-4xl md:text-7xl font-bold font-display leading-tight w-full">
                Your Chill Spot in Paradise
            </h1>

            <p class="sr-only text-xl md:text-2xl font-light mb-8 mt-6 leading-relaxed">
                Wake up in the heart of Mirissa, roll out of bed,<br>
                and you're already living your best life.<br>
                Everything you want is within a wave's reach.
            </p>

            <div class="sr-only flex flex-col items-start gap-4 pointer-events-auto">
                <a href="#availability"
                    class="text-2xl font-bold tracking-widest hover:text-gray-200 transition-colors">CHECK
                    AVAILABILITY</a>
                <div class="w-48 h-0.5 bg-white"></div>
            </div>
        </div>

        <!-- Location Features -->
        <div class="px-8 pb-12 pointer-events-auto">
            <!-- Scroll Down Button -->
            <div class="flex justify-center pb-4 pt-16 pointer-events-auto">
                <a href="#interactive-map"
                    class="flex flex-col items-center gap-2 text-white hover:text-gray-200 transition-colors">
                    <span class="text-sm uppercase tracking-wider">Scroll Down</span>
                    <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 lg:justify-items-center">

                <!-- Item 1 -->
                <div class="flex items-start lg:items-center gap-4">
                    <img src="images/icons/departures.avif" alt="Airport Icon"
                        class="h-12 w-12 md:h-16 md:w-16 flex-shrink-0 object-contain invert">
                    <div class="flex flex-col justify-center">
                        <div class="w-8 h-0.5 bg-white mb-2"></div>
                        <p class="text-base md:text-lg text-white font-medium leading-snug">2.5 hours from<br>the
                            airport</p>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="flex items-start lg:items-center gap-4">
                    <img src="images/icons/motorway.avif" alt="Highway Icon"
                        class="h-12 w-12 md:h-16 md:w-16 flex-shrink-0 object-contain invert">
                    <div class="flex flex-col justify-center">
                        <div class="w-8 h-0.5 bg-white mb-2"></div>
                        <p class="text-base md:text-lg text-white font-medium leading-snug">Minutes away from
                            the<br>Southern Expressway</p>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="flex items-start lg:items-center gap-4">
                    <img src="images/icons/taxi.avif" alt="Taxi Icon"
                        class="h-12 w-12 md:h-16 md:w-16 flex-shrink-0 object-contain invert">
                    <div class="flex flex-col justify-center">
                        <div class="w-8 h-0.5 bg-white mb-2"></div>
                        <p class="text-base md:text-lg text-white font-medium leading-snug">24/7 available<br>Tuk-tuks
                            and taxis</p>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="flex items-start lg:items-center gap-4">
                    <img src="images/icons/walking.avif" alt="Walking Icon"
                        class="h-12 w-12 md:h-16 md:w-16 flex-shrink-0 object-contain invert">
                    <div class="flex flex-col justify-center">
                        <div class="w-8 h-0.5 bg-white mb-2"></div>
                        <p class="text-base md:text-lg text-white font-medium leading-snug">Walk to most<br>Mirissa
                            highlights</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>