<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:header container class="border-b dark:bg-zinc-900 bg-zinc-50 dark:border-zinc-700">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:brand href="{{ route('home') }}" logo="/images/logos/android-chrome-512x512.png" name="{{ config('app.name') }}" class="max-sm:hidden dark:hidden" />
            <flux:brand href="{{ route('home') }}" logo="/images/logos/android-chrome-512x512.png" name="{{ config('app.name') }}" class="hidden max-sm:!hidden dark:max-sm:!flex" />

            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item icon="home" href="{{ route('home') }}" wire:navigate>Home</flux:navbar.item>
            </flux:navbar>

            <flux:spacer />

            <flux:dropdown position="top" align="start">
                <flux:profile avatar="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}" />

                <flux:menu>
                    <flux:menu.item icon="arrow-right-start-on-rectangle" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </flux:menu.item>
                </flux:menu>
            </flux:dropdown>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </flux:header>

        <flux:main container>
            {{ $slot }}
        </flux:main>
    </body>
</html>
