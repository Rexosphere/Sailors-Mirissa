<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
</head>

<body class="bg-orange-50">
    @php
        // Anchors live on the homepage, so prefix them with the home route to keep
        // the shared header/footer nav working from /accommodation, /location, etc.
        $onHome = request()->routeIs('home');
        $anchor = fn (string $id) => ($onHome ? '' : route('home')) . '#' . $id;
    @endphp

    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 focus:z-[100] focus:bg-white focus:text-brand-strong focus:px-4 focus:py-3 focus:rounded-lg focus:shadow-lg focus:ring-2 focus:ring-brand-strong">
        Skip to main content
    </a>

    <!-- Header -->
    <header id="main-header"
        class="fixed top-0 left-0 w-full h-20 border-0 flex justify-between items-center z-50 transition-all duration-300">

        <nav class="flex justify-between items-center w-full pl-4 md:pl-8 pr-0" aria-label="Primary">
            <!-- Left Side: Sailors Mirissa -->
            <a href="{{ route('home') }}"
                class="header-logo text-xl md:text-2xl font-black font-display leading-10 transition-colors duration-300">
                Sailors Mirissa
            </a>

            <!-- Hamburger Menu Button (Mobile Only) -->
            <button id="mobile-menu-toggle" type="button" aria-label="Open menu" aria-expanded="false"
                aria-controls="mobile-menu"
                class="md:hidden flex flex-col justify-center items-center w-11 h-11 mr-3 space-y-1.5 z-50 rounded-md focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-current cursor-pointer">
                <span class="hamburger-line block w-6 h-0.5 transition-all duration-300"></span>
                <span class="hamburger-line block w-6 h-0.5 transition-all duration-300"></span>
                <span class="hamburger-line block w-6 h-0.5 transition-all duration-300"></span>
            </button>

            <!-- Center: Navigation Menu Items (Desktop) -->
            <div class="menu menu-horizontal hidden md:flex justify-center items-center gap-10 mx-auto">
                <x-mary-menu-item title="HOME" link="{{ $anchor('featured_header') }}"
                    class="header-nav-item text-lg font-extrabold transition-colors" />
                <x-mary-menu-item title="EXPLORE" link="{{ $anchor('interactive-map') }}"
                    class="header-nav-item text-lg font-extrabold transition-colors" />
                <x-mary-menu-item title="ROOMS" link="{{ $anchor('floor-booking') }}"
                    class="header-nav-item text-lg font-extrabold transition-colors" />
                <x-mary-menu-item title="ATTRACTIONS" link="{{ $anchor('attractions') }}"
                    class="header-nav-item text-lg font-extrabold transition-colors" />

            </div>

            <!-- Right Side: Check Availability Button (Desktop) -->
            <div class="hidden md:flex flex-shrink-0">
                <a href="{{ $anchor('floor-booking') }}"
                    class="bg-brand-strong hover:bg-brand-hover text-white px-8 h-20 flex items-center font-bold font-display transition-colors text-center focus-visible:outline-2 focus-visible:outline-offset-[-4px] focus-visible:outline-white">
                    Check Availability
                </a>
            </div>

        </nav>

        <!-- Mobile Dropdown Menu -->
        <div id="mobile-menu" inert
            class="fixed top-20 left-0 w-full bg-white shadow-lg transform -translate-y-full opacity-0 transition-all duration-300 ease-in-out md:hidden overflow-hidden">
            <div class="flex flex-col py-4">
                <a href="{{ $anchor('featured_header') }}"
                    class="mobile-nav-item px-6 py-4 text-gray-700 text-lg font-extrabold hover:bg-gray-100 transition-colors">HOME</a>
                <a href="{{ $anchor('interactive-map') }}"
                    class="mobile-nav-item px-6 py-4 text-gray-700 text-lg font-extrabold hover:bg-gray-100 transition-colors">EXPLORE</a>
                <a href="{{ $anchor('floor-booking') }}"
                    class="mobile-nav-item px-6 py-4 text-gray-700 text-lg font-extrabold hover:bg-gray-100 transition-colors">ROOMS</a>
                <a href="{{ $anchor('attractions') }}"
                    class="mobile-nav-item px-6 py-4 text-gray-700 text-lg font-extrabold hover:bg-gray-100 transition-colors">ATTRACTIONS</a>
                <a href="{{ $anchor('floor-booking') }}"
                    class="mobile-nav-item px-6 py-4 mx-6 mt-2 bg-brand-strong hover:bg-brand-hover text-white text-center font-bold font-display rounded-lg transition-colors">Check
                    Availability</a>
            </div>
        </div>
    </header>



    <!-- Main Content -->
    <main id="main-content">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-footer />

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const header = document.getElementById('main-header');
            const hero = document.getElementById('featured_header');

            // Header switches to its translucent state only while the hero is
            // behind it. Driven by IntersectionObserver rather than a scroll
            // handler so it costs nothing per frame.
            if (header && hero) {
                const io = new IntersectionObserver(
                    ([entry]) => header.classList.toggle('is-over-hero', entry.isIntersecting),
                    { rootMargin: '-80px 0px 0px 0px', threshold: 0 }
                );
                io.observe(hero);
            }

            // Mobile menu
            const toggle = document.getElementById('mobile-menu-toggle');
            const menu = document.getElementById('mobile-menu');

            if (toggle && menu) {
                const setMenu = (open) => {
                    menu.classList.toggle('-translate-y-full', !open);
                    menu.classList.toggle('opacity-0', !open);
                    menu.classList.toggle('translate-y-0', open);
                    menu.classList.toggle('opacity-100', open);
                    menu.toggleAttribute('inert', !open);
                    toggle.setAttribute('aria-expanded', String(open));
                    toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
                    toggle.classList.toggle('is-open', open);
                };

                toggle.addEventListener('click', () => {
                    setMenu(toggle.getAttribute('aria-expanded') !== 'true');
                });

                menu.querySelectorAll('.mobile-nav-item').forEach((item) => {
                    item.addEventListener('click', () => setMenu(false));
                });

                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
                        setMenu(false);
                        toggle.focus();
                    }
                });
            }
        });
    </script>
</body>

</html>