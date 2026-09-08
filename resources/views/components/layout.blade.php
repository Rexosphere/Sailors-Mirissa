@php
    $isHome = isset($pageKey) && trim((string) $pageKey) === 'home';
    $homeBase = $isHome ? '' : route('home');
    $bookingUrl = config('site.booking_url') ?: 'mailto:'.config('seo.business.contact.email');
    $bookingExternal = (bool) config('site.booking_url');
    $navItems = [
        ['label' => 'HOME', 'hash' => 'featured_header'],
        ['label' => 'EXPLORE', 'hash' => 'interactive-map'],
        ['label' => 'ROOMS', 'hash' => 'floor-booking'],
        ['label' => 'ATTRACTIONS', 'hash' => 'attractions'],
    ];
@endphp
<!DOCTYPE html>
<html lang="en" @class(['fp-snap' => $isHome])>

<head>
    @include('partials.head')
</head>

<body class="bg-orange-50">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 focus:z-[60] focus:rounded-md focus:bg-white focus:px-4 focus:py-2 focus:text-gray-900 focus:shadow-lg">Skip to content</a>

    <!-- Header -->
    <header id="main-header" data-theme="dark"
        class="fixed top-0 left-0 z-50 flex h-20 w-full items-center justify-between">

        <nav class="flex w-full items-center justify-between pl-4 pr-0 md:pl-8" aria-label="Main">
            <a href="{{ $homeBase }}#featured_header" id="header-logo"
                class="font-display text-xl font-black leading-10 md:text-2xl">
                Sailors Mirissa
            </a>

            <button id="mobile-menu-toggle" type="button" aria-controls="mobile-menu" aria-expanded="false" aria-label="Open menu"
                class="z-50 mr-3 flex h-11 w-11 flex-col items-center justify-center space-y-1.5 md:hidden">
                <span class="hamburger-line block h-0.5 w-6 transition-all duration-300"></span>
                <span class="hamburger-line block h-0.5 w-6 transition-all duration-300"></span>
                <span class="hamburger-line block h-0.5 w-6 transition-all duration-300"></span>
            </button>

            <ul class="mx-auto hidden items-center justify-center gap-10 md:flex">
                @foreach ($navItems as $item)
                    <li>
                        <a href="{{ $homeBase }}#{{ $item['hash'] }}"
                            class="header-nav-item text-lg font-extrabold transition-colors">{{ $item['label'] }}</a>
                    </li>
                @endforeach
            </ul>

            <div class="hidden flex-shrink-0 md:flex">
                <a href="{{ $bookingUrl }}" @if ($bookingExternal) target="_blank" rel="noopener" @endif
                    class="flex h-20 items-center bg-[#72B6B9] px-8 text-center font-display font-bold text-white transition-colors hover:bg-[#5A8E91] active:bg-[#4F7F82]">
                    Check Availability
                </a>
            </div>
        </nav>

        <!-- Mobile Dropdown Menu -->
        <div id="mobile-menu"
            class="fixed top-20 left-0 w-full -translate-y-full transform overflow-hidden bg-white opacity-0 shadow-lg transition-all duration-300 ease-in-out md:hidden"
            aria-hidden="true">
            <div class="flex flex-col py-4">
                @foreach ($navItems as $item)
                    <a href="{{ $homeBase }}#{{ $item['hash'] }}"
                        class="mobile-nav-item px-6 py-4 text-lg font-extrabold text-gray-700 transition-colors hover:bg-gray-100 active:bg-gray-100">{{ $item['label'] }}</a>
                @endforeach
                <a href="{{ $bookingUrl }}" @if ($bookingExternal) target="_blank" rel="noopener" @endif
                    class="mobile-nav-item mx-6 mt-2 rounded-lg bg-[#72B6B9] px-6 py-4 text-center font-display font-bold text-white transition-colors hover:bg-[#5A8E91] active:bg-[#4F7F82]">Check
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
            const toggle = document.getElementById('mobile-menu-toggle');
            const menu = document.getElementById('mobile-menu');
            const lines = document.querySelectorAll('.hamburger-line');
            if (!toggle || !menu) return;

            let open = false;

            function setOpen(next) {
                open = next;
                menu.classList.toggle('-translate-y-full', !open);
                menu.classList.toggle('opacity-0', !open);
                menu.classList.toggle('translate-y-0', open);
                menu.classList.toggle('opacity-100', open);
                menu.setAttribute('aria-hidden', String(!open));
                toggle.setAttribute('aria-expanded', String(open));
                toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
                lines[0].style.transform = open ? 'rotate(45deg) translateY(8px)' : 'none';
                lines[1].style.opacity = open ? '0' : '1';
                lines[2].style.transform = open ? 'rotate(-45deg) translateY(-8px)' : 'none';
            }

            toggle.addEventListener('click', () => setOpen(!open));
            menu.querySelectorAll('.mobile-nav-item').forEach((item) => item.addEventListener('click', () => setOpen(false)));
            document.addEventListener('keydown', (event) => { if (event.key === 'Escape' && open) setOpen(false); });
        });
    </script>
    @livewireScriptConfig
</body>

</html>
