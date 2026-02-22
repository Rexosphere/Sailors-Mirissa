<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
</head>

<body class="bg-orange-50">
    <!-- Header -->
    <header id="main-header"
        class="fixed top-0 left-0 w-full h-20 bg-white border-0 flex justify-between items-center shadow-md z-50 transition-all duration-300">

        <nav class="flex justify-between items-center w-full pl-8 pr-0">
            <!-- Left Side: Sailors Mirissa -->
            <div id="header-logo"
                class="text-2xl font-black font-['Merienda'] text-gray-800 leading-10 transition-colors duration-300">
                Sailors Mirissa
            </div>

            <!-- Center: Navigation Menu Items -->
            <div class="menu menu-horizontal hidden md:flex justify-center items-center gap-10 mx-auto">
                <x-mary-menu-item title="HOME" link="#featured_header"
                    class="header-nav-item text-gray-700 text-lg font-extrabold hover:text-gray-900 transition-colors" />
                <x-mary-menu-item title="EXPLORE" link="#interactive-map"
                    class="header-nav-item text-gray-700 text-lg font-extrabold hover:text-gray-900 transition-colors" />
                <x-mary-menu-item title="ROOMS" link="#floor-booking"
                    class="header-nav-item text-gray-700 text-lg font-extrabold hover:text-gray-900 transition-colors" />
                <x-mary-menu-item title="ATTRACTIONS" link="#attractions"
                    class="header-nav-item text-gray-700 text-lg font-extrabold hover:text-gray-900 transition-colors" />

            </div>

            <!-- Right Side: Check Availability Button -->
            <div class="flex-shrink-0">
                <a href="#availability"
                    class="bg-[#72B6B9] hover:bg-[#5A8E91] text-white px-8 h-20 flex items-center  font-bold font-['Merienda'] transition-colors text-center">
                    Check Availability
                </a>
            </div>

        </nav>
    </header>



    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-footer />

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const header = document.getElementById('main-header');
            const logo = document.getElementById('header-logo');
            const navItems = document.querySelectorAll('.header-nav-item');
            const featuredSection = document.getElementById('featured_header');

            function updateHeaderStyle() {
                if (!featuredSection) return;

                const headerRect = header.getBoundingClientRect();
                const sectionRect = featuredSection.getBoundingClientRect();

                // Check if header is overlapping with the featured section
                const isOverlapping = headerRect.bottom > sectionRect.top && headerRect.top < sectionRect.bottom;

                //if (isOverlapping) {
                // Make header translucent and blurred when over featured section
                header.className = 'fixed top-0 left-0 w-full h-20 bg-black/10 flex justify-between items-center z-50 transition-all duration-300';
                logo.className = 'text-2xl font-normal font-[\'Merienda\'] text-white leading-10 drop-shadow-sm transition-colors duration-300';

                navItems.forEach(item => {
                    item.className = item.className.replace('text-gray-700', 'text-stone-100').replace('hover:text-gray-900', 'hover:text-stone-300');
                });
                // } else {
                //     // Make header white and solid when not over featured section
                //     header.className = 'fixed top-0 left-0 w-full h-20 bg-white border-b border-gray-200 flex justify-between items-center shadow-md z-50 transition-all duration-300';
                //     logo.className = 'text-2xl font-normal font-[\'Merienda\'] text-gray-800 leading-10 transition-colors duration-300';

                //     navItems.forEach(item => {
                //         item.className = item.className.replace('text-stone-100', 'text-gray-700').replace('hover:text-stone-300', 'hover:text-gray-900');
                //     });
                // }
            }

            // Update on scroll
            window.addEventListener('scroll', updateHeaderStyle);
            // Update on page load
            updateHeaderStyle();
        });

        // ── Scroll-snap: hero ↔ interactive-map ────────────────────────────
        (function () {
            let isSnapping    = false;
            let heroVisible   = false; // hero is ≥85% on screen
            let mapVisible    = false; // map  is ≥85% on screen
            let touchStartY   = 0;
            let cooldown      = false; // short debounce after snap fires

            // Watch each section with IntersectionObserver
            const io = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (e.target.id === 'featured_header') heroVisible = e.isIntersecting;
                    if (e.target.id === 'interactive-map') mapVisible  = e.isIntersecting;
                });
            }, { threshold: 0.85 });

            document.addEventListener('DOMContentLoaded', () => {
                const hero = document.getElementById('featured_header');
                const map  = document.getElementById('interactive-map');
                if (hero) io.observe(hero);
                if (map)  io.observe(map);
            });

            function snapTo(y) {
                if (cooldown || isSnapping) return;
                cooldown   = true;
                isSnapping = true;
                window.scrollTo({ top: y, behavior: 'smooth' });
                // Release flags once scroll settles
                const poll = setInterval(() => {
                    if (Math.abs(window.scrollY - y) < 5) {
                        clearInterval(poll);
                        isSnapping = false;
                        setTimeout(() => { cooldown = false; }, 300);
                    }
                }, 50);
                setTimeout(() => { clearInterval(poll); isSnapping = false; cooldown = false; }, 1200);
            }

            function trySnap(deltaY) {
                const hero = document.getElementById('featured_header');
                const map  = document.getElementById('interactive-map');
                if (!hero || !map) return false;

                if (deltaY > 0 && heroVisible && !mapVisible) {
                    snapTo(Math.round(map.getBoundingClientRect().top + window.scrollY));
                    return true;
                }
                if (deltaY < 0 && mapVisible && !heroVisible) {
                    snapTo(Math.round(hero.getBoundingClientRect().top + window.scrollY));
                    return true;
                }
                return false;
            }

            // Wheel — passive:false so preventDefault actually works
            window.addEventListener('wheel', (e) => {
                if (isSnapping) { e.preventDefault(); return; }
                if (!heroVisible && !mapVisible) return; // outside zone — free scroll
                if (trySnap(e.deltaY)) e.preventDefault();
            }, { passive: false });

            // Touch
            window.addEventListener('touchstart', (e) => {
                touchStartY = e.touches[0].clientY;
            }, { passive: true });
            window.addEventListener('touchend', (e) => {
                if (isSnapping || cooldown) return;
                const delta = touchStartY - e.changedTouches[0].clientY;
                if (Math.abs(delta) < 30) return;
                trySnap(delta);
            }, { passive: true });
        })();
    </script>
</body>

</html>