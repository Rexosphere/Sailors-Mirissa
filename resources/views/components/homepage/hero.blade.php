<!-- Hero Section -->
<section id="featured_header" class="fp-screen" data-fp-section data-header-theme="dark" tabindex="-1" aria-label="Welcome to Sailors Mirissa">
    <!-- Hero Image -->
    <div class="absolute inset-0">
        <img src="/images/photos/hero-background.avif"
            alt="Sailor's Mirissa beachfront hotel with ocean view in Mirissa, Sri Lanka"
            fetchpriority="high" decoding="async"
            class="h-full w-full object-cover animate-ken-burns">
    </div>

    <!-- Dark overlay -->
    <div class="pointer-events-none absolute inset-0 z-10 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>

    <!-- Content wrapper -->
    <div class="pointer-events-none relative z-20 flex h-full flex-col">
        <!-- Hero text (vertically centered) -->
        <div class="flex w-full flex-1 flex-col justify-center px-8 py-8 text-white" style="margin-top: 10vh;">
            <h1 class="sr-only w-full font-display text-4xl font-bold leading-tight md:text-7xl">
                Your Chill Spot in Paradise
            </h1>

            <p class="sr-only mb-8 mt-6 text-xl font-light leading-relaxed md:text-2xl">
                Wake up in the heart of Mirissa, roll out of bed,<br>
                and you're already living your best life.<br>
                Everything you want is within a wave's reach.
            </p>
        </div>

        <!-- Location Features -->
        <div class="pointer-events-auto px-5 pb-20 sm:px-8 sm:pb-24">
            <div class="grid grid-cols-2 gap-4 md:gap-6 lg:grid-cols-4 lg:justify-items-center">
                @foreach ([
                    ['icon' => 'departures', 'alt' => 'Airport', 'text' => '2.5 hours from<br>the airport'],
                    ['icon' => 'motorway', 'alt' => 'Highway', 'text' => 'Minutes away from the<br>Southern Expressway'],
                    ['icon' => 'taxi', 'alt' => 'Taxi', 'text' => '24/7 available<br>Tuk-tuks and taxis'],
                    ['icon' => 'walking', 'alt' => 'Walking', 'text' => 'Walk to most<br>Mirissa highlights'],
                ] as $feature)
                    <div class="flex items-start gap-3 sm:gap-4 lg:items-center">
                        <img src="/images/icons/{{ $feature['icon'] }}.avif" alt="" width="64" height="64" decoding="async"
                            class="h-9 w-9 flex-shrink-0 object-contain invert sm:h-12 sm:w-12 md:h-16 md:w-16">
                        <div class="flex flex-col justify-center">
                            <div class="mb-2 h-0.5 w-8 bg-white"></div>
                            <p class="text-sm font-medium leading-snug text-white sm:text-base md:text-lg">{!! $feature['text'] !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <x-scroll-next target="interactive-map" label="Explore Mirissa" theme="dark" />
</section>
