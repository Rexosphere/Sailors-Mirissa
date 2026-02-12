<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
</head>

<body class="bg-orange-50">
    <!-- Header -->
    <header id="main-header"
        class="fixed top-0 left-0 w-full h-20 bg-white border-0 flex justify-between items-center shadow-md z-50 transition-all duration-300">

        <nav class="flex justify-between items-center w-full pl-4 md:pl-8 pr-0">
            <!-- Left Side: Sailors Mirissa -->
            <div id="header-logo"
                class="text-xl md:text-2xl font-black font-['Merienda'] text-gray-800 leading-10 transition-colors duration-300">
                Sailors Mirissa
            </div>

            <!-- Hamburger Menu Button (Mobile Only) -->
            <button id="mobile-menu-toggle"
                class="md:hidden flex flex-col justify-center items-center w-10 h-10 mr-4 space-y-1.5 z-50">
                <span class="hamburger-line block w-6 h-0.5 bg-gray-800 transition-all duration-300"></span>
                <span class="hamburger-line block w-6 h-0.5 bg-gray-800 transition-all duration-300"></span>
                <span class="hamburger-line block w-6 h-0.5 bg-gray-800 transition-all duration-300"></span>
            </button>

            <!-- Center: Navigation Menu Items (Desktop) -->
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

            <!-- Right Side: Check Availability Button (Desktop) -->
            <div class="hidden md:flex flex-shrink-0">
                <a href="#availability"
                    class="bg-[#72B6B9] hover:bg-[#5A8E91] text-white px-8 h-20 flex items-center  font-bold font-['Merienda'] transition-colors text-center">
                    Check Availability
                </a>
            </div>

        </nav>

        <!-- Mobile Dropdown Menu -->
        <div id="mobile-menu"
            class="fixed top-20 left-0 w-full bg-white shadow-lg transform -translate-y-full opacity-0 transition-all duration-300 ease-in-out md:hidden overflow-hidden">
            <div class="flex flex-col py-4">
                <a href="#featured_header"
                    class="mobile-nav-item px-6 py-4 text-gray-700 text-lg font-extrabold hover:bg-gray-100 transition-colors">HOME</a>
                <a href="#interactive-map"
                    class="mobile-nav-item px-6 py-4 text-gray-700 text-lg font-extrabold hover:bg-gray-100 transition-colors">EXPLORE</a>
                <a href="#floor-booking"
                    class="mobile-nav-item px-6 py-4 text-gray-700 text-lg font-extrabold hover:bg-gray-100 transition-colors">ROOMS</a>
                <a href="#attractions"
                    class="mobile-nav-item px-6 py-4 text-gray-700 text-lg font-extrabold hover:bg-gray-100 transition-colors">ATTRACTIONS</a>
                <a href="#availability"
                    class="px-6 py-4 mx-6 mt-2 bg-[#72B6B9] hover:bg-[#5A8E91] text-white text-center font-bold font-['Merienda'] rounded-lg transition-colors">Check
                    Availability</a>
            </div>
        </div>
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
            
            // Mobile menu toggle functionality
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburgerLines = document.querySelectorAll('.hamburger-line');
            const mobileNavItems = document.querySelectorAll('.mobile-nav-item');
            let isMobileMenuOpen = false;

            // Toggle mobile menu
            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', function() {
                    isMobileMenuOpen = !isMobileMenuOpen;
                    
                    if (isMobileMenuOpen) {
                        // Open menu
                        mobileMenu.classList.remove('-translate-y-full', 'opacity-0');
                        mobileMenu.classList.add('translate-y-0', 'opacity-100');
                        
                        // Animate hamburger to X
                        hamburgerLines[0].style.transform = 'rotate(45deg) translateY(8px)';
                        hamburgerLines[1].style.opacity = '0';
                        hamburgerLines[2].style.transform = 'rotate(-45deg) translateY(-8px)';
                    } else {
                        // Close menu
                        mobileMenu.classList.remove('translate-y-0', 'opacity-100');
                        mobileMenu.classList.add('-translate-y-full', 'opacity-0');
                        
                        // Animate X back to hamburger
                        hamburgerLines[0].style.transform = 'none';
                        hamburgerLines[1].style.opacity = '1';
                        hamburgerLines[2].style.transform = 'none';
                    }
                });

                // Close mobile menu when clicking on a menu item
                mobileNavItems.forEach(item => {
                    item.addEventListener('click', function() {
                        isMobileMenuOpen = false;
                        mobileMenu.classList.remove('translate-y-0', 'opacity-100');
                        mobileMenu.classList.add('-translate-y-full', 'opacity-0');
                        
                        // Animate X back to hamburger
                        hamburgerLines[0].style.transform = 'none';
                        hamburgerLines[1].style.opacity = '1';
                        hamburgerLines[2].style.transform = 'none';
                    });
                });
            }

            function updateHeaderStyle() {
                if (!featuredSection) return;

                const headerRect = header.getBoundingClientRect();
                const sectionRect = featuredSection.getBoundingClientRect();

                // Check if header is overlapping with the featured section
                const isOverlapping = headerRect.bottom > sectionRect.top && headerRect.top < sectionRect.bottom;

                //if (isOverlapping) {
                // Make header translucent and blurred when over featured section
                header.className = 'fixed top-0 left-0 w-full h-20 bg-black/10 flex justify-between items-center z-50 transition-all duration-300';
                logo.className = 'text-xl md:text-2xl font-normal font-[\'Merienda\'] text-white leading-10 drop-shadow-sm transition-colors duration-300';

                navItems.forEach(item => {
                    item.className = item.className.replace('text-gray-700', 'text-stone-100').replace('hover:text-gray-900', 'hover:text-stone-300');
                });
                
                // Update hamburger lines color for mobile
                if (hamburgerLines.length > 0) {
                    hamburgerLines.forEach(line => {
                        line.classList.remove('bg-gray-800');
                        line.classList.add('bg-white');
                    });
                }
                // } else {
                //     // Make header white and solid when not over featured section
                //     header.className = 'fixed top-0 left-0 w-full h-20 bg-white border-b border-gray-200 flex justify-between items-center shadow-md z-50 transition-all duration-300';
                //     logo.className = 'text-xl md:text-2xl font-normal font-[\'Merienda\'] text-gray-800 leading-10 transition-colors duration-300';

                //     navItems.forEach(item => {
                //         item.className = item.className.replace('text-stone-100', 'text-gray-700').replace('hover:text-stone-300', 'hover:text-gray-900');
                //     });
                    
                //     // Update hamburger lines color for mobile
                //     if (hamburgerLines.length > 0) {
                //         hamburgerLines.forEach(line => {
                //             line.classList.remove('bg-white');
                //             line.classList.add('bg-gray-800');
                //         });
                //     }
                // }
            }

            // Update on scroll
            window.addEventListener('scroll', updateHeaderStyle);
            // Update on page load
            updateHeaderStyle();
        });
    </script>
</body>

</html>