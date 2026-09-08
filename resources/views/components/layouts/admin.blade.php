<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="sailors">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ isset($title) ? $title.' · ' : '' }}Admin · Sailors Mirissa</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nata+Sans:wght@400;500;600;700&family=Merienda:wght@600;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-base-200 text-base-content">
    <x-mary-nav sticky full-width class="bg-base-100">
        <x-slot:brand>
            <label for="admin-drawer" class="btn btn-ghost btn-square btn-sm me-2 lg:hidden" aria-label="Open menu">
                <x-mary-icon name="o-bars-3" class="w-5 h-5" />
            </label>
            <a href="{{ route('admin.dashboard') }}" wire:navigate class="font-display text-xl font-bold text-primary">Sailors Mirissa</a>
            <span class="badge badge-ghost badge-sm ms-3 hidden sm:inline-flex">Admin</span>
        </x-slot:brand>
        <x-slot:actions>
            <x-mary-button label="View site" icon="o-arrow-top-right-on-square" link="{{ route('home') }}" external class="btn-ghost btn-sm" responsive />
            <x-mary-dropdown right>
                <x-slot:trigger>
                    <x-mary-button icon="o-user" class="btn-ghost btn-sm btn-circle" aria-label="Account menu" />
                </x-slot:trigger>
                <x-mary-menu-item title="{{ auth()->user()->name }}" disabled />
                <x-mary-menu-item title="Profile settings" icon="o-cog-6-tooth" link="{{ route('profile.edit') }}" />
                <x-mary-menu-separator />
                <x-mary-menu-item title="Log out" icon="o-arrow-right-start-on-rectangle" onclick="document.getElementById('admin-logout').submit()" />
            </x-mary-dropdown>
        </x-slot:actions>
    </x-mary-nav>

    <x-mary-main full-width with-nav>
        <x-slot:sidebar drawer="admin-drawer" collapsible class="bg-base-100 lg:border-r border-base-content/10">
            <x-mary-menu activate-by-route active-bg-color="bg-primary/10 text-primary font-semibold" class="mt-2">
                <x-mary-menu-item title="Dashboard" icon="o-squares-2x2" link="{{ route('admin.dashboard') }}" exact />
                <x-mary-menu-item title="Floors" icon="o-building-office" link="{{ route('admin.floors.index') }}" />
                <x-mary-menu-item title="Rooms" icon="o-key" link="{{ route('admin.rooms.index') }}" />
                <x-mary-menu-item title="Experiences" icon="o-photo" link="{{ route('admin.experiences.index') }}" />
                <x-mary-menu-item title="Map points" icon="o-map-pin" link="{{ route('admin.map-points.index') }}" />
            </x-mary-menu>
        </x-slot:sidebar>
        <x-slot:content class="max-w-6xl">
            {{ $slot }}
        </x-slot:content>
    </x-mary-main>

    <form id="admin-logout" method="POST" action="{{ route('logout') }}" class="hidden">@csrf</form>
    <x-mary-toast />
    @livewireScriptConfig
</body>
</html>
