<?php

use App\Models\MapPoint;
use App\Support\PublicImages;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Layout('components.layouts.admin')] #[Title('Map points')] class extends Component {
    use Toast;

    public bool $confirmingDelete = false;

    public ?int $deletingId = null;

    public function with(): array
    {
        return [
            'points' => MapPoint::orderBy('name')->get(),
            'deleting' => $this->deletingId ? MapPoint::find($this->deletingId) : null,
            'headers' => [
                ['key' => 'image_url', 'label' => '', 'class' => 'w-28'],
                ['key' => 'name', 'label' => 'Landmark'],
                ['key' => 'icon', 'label' => 'Marker', 'class' => 'w-24'],
                ['key' => 'center_x', 'label' => 'Position', 'class' => 'w-36'],
            ],
        ];
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
        $this->confirmingDelete = true;
    }

    public function delete(): void
    {
        $point = MapPoint::findOrFail($this->deletingId);
        $iconSrc = PublicImages::srcFromHtml($point->icon);

        $point->delete();
        PublicImages::delete($point->image_url, MapPoint::where('image_url', $point->image_url)->count());
        PublicImages::delete($iconSrc, $iconSrc ? MapPoint::where('icon', 'like', '%'.$iconSrc.'%')->count() : 0);

        $this->confirmingDelete = false;
        $this->deletingId = null;
        $this->success("{$point->name} deleted.");
    }
}; ?>

<div>
    <x-mary-header title="Map points" subtitle="Landmarks on the interactive map. Click a marker on the homepage to see its card." separator>
        <x-slot:actions>
            <x-mary-button label="Add map point" icon="o-plus" link="{{ route('admin.map-points.create') }}" class="btn-primary btn-sm" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-card class="border border-base-content/10" body-class="p-0 sm:p-2">
        <x-mary-table :headers="$headers" :rows="$points" show-empty-text empty-text="No map points yet.">
            @scope('cell_image_url', $point)
                <img src="{{ $point->image_url }}" alt="" width="96" height="64" loading="lazy" class="h-16 w-24 rounded-md object-cover bg-base-200">
            @endscope
            @scope('cell_name', $point)
                <span class="font-medium">{{ $point->name }}</span>
                <span class="block max-w-md truncate text-xs text-base-content/60">{{ $point->description }}</span>
            @endscope
            @scope('cell_icon', $point)
                @if ($point->icon)
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-700 p-1.5">{!! $point->icon !!}</span>
                @else
                    <span class="text-base-content/40">&mdash;</span>
                @endif
            @endscope
            @scope('cell_center_x', $point)
                <span class="tabular-nums text-xs text-base-content/60">{{ $point->center_x }}, {{ $point->center_y }}</span>
            @endscope
            @scope('actions', $point)
                <div class="flex justify-end gap-1">
                    <x-mary-button icon="o-pencil-square" link="{{ route('admin.map-points.edit', $point->id) }}" class="btn-ghost btn-sm" tooltip-left="Edit" aria-label="Edit {{ $point->name }}" />
                    <x-mary-button icon="o-trash" wire:click="confirmDelete({{ $point->id }})" class="btn-ghost btn-sm text-error" tooltip-left="Delete" aria-label="Delete {{ $point->name }}" />
                </div>
            @endscope
        </x-mary-table>
    </x-mary-card>

    <x-mary-modal wire:model="confirmingDelete" title="Delete map point?" separator>
        <p class="text-sm text-base-content/70">
            {{ $deleting?->name ?? 'This landmark' }} will be removed from the interactive map. This cannot be undone.
        </p>
        <x-slot:actions>
            <x-mary-button label="Cancel" @click="$wire.confirmingDelete = false" class="btn-ghost" />
            <x-mary-button label="Delete" icon="o-trash" wire:click="delete" spinner="delete" class="btn-error" />
        </x-slot:actions>
    </x-mary-modal>
</div>
