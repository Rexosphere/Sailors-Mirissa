<!-- Hero Section -->
<section id="featured_header" class="relative min-h-dvh overflow-hidden">
    <!-- Hero Image -->
    <div class="absolute inset-0">
        <picture>
            <source srcset="/images/photos/hero-background-mobile.avif" media="(max-width: 767px)">
            <img src="/images/photos/hero-background.avif"
                alt="Sailor's Mirissa beachfront hotel with ocean view in Mirissa, Sri Lanka"
                class="w-full h-full object-cover object-center md:object-center" fetchpriority="high" decoding="async">
        </picture>
    </div>

    <!-- Dark overlay -->
    <div
        class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent pointer-events-none z-10">
    </div>

    <!-- Content wrapper -->
    <div class="relative z-20 flex flex-col min-h-dvh pointer-events-none">
        <div class="flex-1"></div>

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
                    <svg class="h-12 w-12 md:h-16 md:w-16 flex-shrink-0 text-white" fill="none"
                        stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 19h12M4.5 12.5l15-4.5m0 0-3.5 6m3.5-6-4.5-3M4.5 12.5 8 15l2.5-.75" />
                    </svg>
                    <div class="flex flex-col justify-center">
                        <div class="w-8 h-0.5 bg-white mb-2"></div>
                        <p class="text-base md:text-lg text-white font-medium leading-snug">2.5 hours from<br>the
                            airport</p>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="flex items-start lg:items-center gap-4">
                    <svg class="h-12 w-12 md:h-16 md:w-16 flex-shrink-0 text-white" fill="none"
                        stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v3m0 4.5v3m0 4.5v3M4 20 8 4m12 16L16 4" />
                    </svg>
                    <div class="flex flex-col justify-center">
                        <div class="w-8 h-0.5 bg-white mb-2"></div>
                        <p class="text-base md:text-lg text-white font-medium leading-snug">Minutes away from
                            the<br>Southern Expressway</p>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="flex items-start lg:items-center gap-4">
                    <svg class="h-12 w-12 md:h-16 md:w-16 flex-shrink-0 text-white" fill="none"
                        stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 17h14M5 17a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm14 0a2 2 0 1 0 4 0 2 2 0 0 0-4 0Zm-14 0v-4l2-5h10l2 5v4M9 8v4m6-4v4" />
                    </svg>
                    <div class="flex flex-col justify-center">
                        <div class="w-8 h-0.5 bg-white mb-2"></div>
                        <p class="text-base md:text-lg text-white font-medium leading-snug">24/7 available<br>Tuk-tuks
                            and taxis</p>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="flex items-start lg:items-center gap-4">
                    <svg class="h-12 w-12 md:h-16 md:w-16 flex-shrink-0 text-white" fill="none"
                        stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM11 9l-2.5 4L7 21m4-12 3 2 1.5 4M11 9l-3 1m6 4-1 7" />
                    </svg>
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
