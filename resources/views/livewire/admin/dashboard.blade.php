<?php

use App\Models\Experience;
use App\Models\Floor;
use App\Models\MapPoint;
use App\Models\Room;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin')] #[Title('Dashboard')] class extends Component {
    public function with(): array
    {
        return [
            'cards' => [
                ['label' => 'Floors', 'count' => Floor::count(), 'icon' => 'o-building-office', 'route' => route('admin.floors.index'), 'hint' => 'Names, views and order of the building floors'],
                ['label' => 'Rooms', 'count' => Room::count(), 'icon' => 'o-key', 'route' => route('admin.rooms.index'), 'hint' => 'Rooms shown in the floor picker on the homepage'],
                ['label' => 'Experiences', 'count' => Experience::count(), 'icon' => 'o-photo', 'route' => route('admin.experiences.index'), 'hint' => 'Attraction cards in the Must-Visit carousel'],
                ['label' => 'Map points', 'count' => MapPoint::count(), 'icon' => 'o-map-pin', 'route' => route('admin.map-points.index'), 'hint' => 'Landmarks on the interactive map'],
            ],
        ];
    }
}; ?>

<div>
    <x-mary-header title="Dashboard" subtitle="Welcome back, {{ auth()->user()->name }}." separator>
        <x-slot:actions>
            <x-mary-button label="Open homepage" icon="o-arrow-top-right-on-square" link="{{ route('home') }}" external class="btn-outline btn-sm" />
        </x-slot:actions>
    </x-mary-header>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        @foreach ($cards as $card)
            <a href="{{ $card['route'] }}" wire:navigate class="card bg-base-100 border border-base-content/10 hover:border-primary/40 hover:shadow-md transition-all duration-200 active:scale-[0.99]">
                <div class="card-body p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm text-base-content/60">{{ $card['label'] }}</p>
                            <p class="text-3xl font-bold tabular-nums mt-1">{{ $card['count'] }}</p>
                        </div>
                        <span class="rounded-full bg-primary/10 text-primary p-3">
                            <x-mary-icon :name="$card['icon']" class="w-6 h-6" />
                        </span>
                    </div>
                    <p class="text-xs text-base-content/60 mt-3 leading-relaxed">{{ $card['hint'] }}</p>
                </div>
            </a>
        @endforeach
    </div>

    <div class="mt-8 grid gap-4 md:grid-cols-2">
        <x-mary-card title="Quick actions" class="border border-base-content/10">
            <div class="flex flex-wrap gap-2">
                <x-mary-button label="Add room" icon="o-plus" link="{{ route('admin.rooms.create') }}" class="btn-primary btn-sm" />
                <x-mary-button label="Add experience" icon="o-plus" link="{{ route('admin.experiences.create') }}" class="btn-outline btn-sm" />
                <x-mary-button label="Add map point" icon="o-plus" link="{{ route('admin.map-points.create') }}" class="btn-outline btn-sm" />
            </div>
        </x-mary-card>
        <x-mary-card title="Photo guidelines" class="border border-base-content/10">
            <ul class="text-sm space-y-2 text-base-content/70 list-disc ps-5">
                <li>JPG, PNG, WEBP or AVIF, up to 10 MB. Convert iPhone HEIC photos before uploading.</li>
                <li>Room photos look best in landscape (about 4:3). Attraction cards are portrait (about 3:4).</li>
                <li>Lower "order" numbers appear first.</li>
            </ul>
        </x-mary-card>
    </div>
</div>
