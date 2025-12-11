<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Saylor\'s Mirissa - Where Ocean Meets Elegance' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-orange-50">
    <!-- Header -->
<header id="main-header" class="fixed top-0 left-0 w-full h-20 bg-white border-0 flex justify-between items-center shadow-md z-50 transition-all duration-300">

    <nav class="flex justify-between items-center w-full pl-8 pr-0">
        <!-- Left Side: Saylor's Mirissa -->
        <div id="header-logo" class="text-2xl font-normal font-['Belleza'] text-gray-800 leading-10 transition-colors duration-300">
            Sailor's Mirissa
        </div>

        <!-- Center: Navigation Menu Items -->
        <div class="menu menu-horizontal hidden md:flex justify-center items-center gap-10 mx-auto">
            <x-mary-menu-item title="HOME" link="{{ route('home') }}" class="header-nav-item text-gray-700 text-lg font-extrabold hover:text-gray-900 transition-colors" />
            <x-mary-menu-item title="LOCATION" link="#location" class="header-nav-item text-gray-700 text-lg font-extrabold hover:text-gray-900 transition-colors" />
            <x-mary-menu-item title="ACCOMMODATION" link="#Accomodation" class="header-nav-item text-gray-700 text-lg font-extrabold hover:text-gray-900 transition-colors" />
            <x-mary-menu-item title="EXPERIENCES" link="#Experiences" class="header-nav-item text-gray-700 text-lg font-extrabold hover:text-gray-900 transition-colors" />
            
        </div>

        <!-- Right Side: Check Availability Button -->
        <div class="flex-shrink-0">
            <a href="#availability" class="bg-[#72B6B9] hover:bg-[#5A8E91] text-white px-8 h-20 flex items-center  font-bold font-['NATS'] transition-colors text-center">
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
        document.addEventListener('DOMContentLoaded', function() {
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

                if (isOverlapping) {
                    // Make header translucent and blurred when over featured section
                    header.className = 'fixed top-0 left-0 w-full h-20 bg-black/10 flex justify-between items-center z-50 transition-all duration-300';
                    logo.className = 'text-2xl font-normal font-[\'Belleza\'] text-white leading-10 drop-shadow-sm transition-colors duration-300';
                    
                    navItems.forEach(item => {
                        item.className = item.className.replace('text-gray-700', 'text-stone-100').replace('hover:text-gray-900', 'hover:text-stone-300');
                    });
                } else {
                    // Make header white and solid when not over featured section
                    header.className = 'fixed top-0 left-0 w-full h-20 bg-white border-b border-gray-200 flex justify-between items-center shadow-md z-50 transition-all duration-300';
                    logo.className = 'text-2xl font-normal font-[\'Belleza\'] text-gray-800 leading-10 transition-colors duration-300';
                    
                    navItems.forEach(item => {
                        item.className = item.className.replace('text-stone-100', 'text-gray-700').replace('hover:text-stone-300', 'hover:text-gray-900');
                    });
                }
            }

            // Update on scroll
            window.addEventListener('scroll', updateHeaderStyle);
            // Update on page load
            updateHeaderStyle();
        });
    </script>
</body>
</html>