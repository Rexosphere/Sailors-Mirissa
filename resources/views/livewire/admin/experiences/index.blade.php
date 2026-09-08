<?php

use App\Models\Experience;
use App\Support\PublicImages;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Layout('components.layouts.admin')] #[Title('Experiences')] class extends Component {
    use Toast;

    public bool $confirmingDelete = false;

    public ?int $deletingId = null;

    public function with(): array
    {
        return [
            'experiences' => Experience::ordered()->get(),
            'deleting' => $this->deletingId ? Experience::find($this->deletingId) : null,
            'headers' => [
                ['key' => 'image_url', 'label' => '', 'class' => 'w-28'],
                ['key' => 'title', 'label' => 'Title'],
                ['key' => 'badge', 'label' => 'Badge', 'class' => 'w-36'],
                ['key' => 'sort_order', 'label' => 'Order', 'class' => 'w-20'],
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
        $experience = Experience::findOrFail($this->deletingId);
        $otherReferences = Experience::where('image_url', $experience->image_url)->whereKeyNot($experience->id)->count();

        $experience->delete();
        PublicImages::delete($experience->image_url, $otherReferences);

        $this->confirmingDelete = false;
        $this->deletingId = null;
        $this->success("{$experience->title} deleted.");
    }
}; ?>

<div>
    <x-mary-header title="Experiences" subtitle="Attraction cards in the homepage Must-Visit carousel." separator>
        <x-slot:actions>
            <x-mary-button label="Add experience" icon="o-plus" link="{{ route('admin.experiences.create') }}" class="btn-primary btn-sm" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-card class="border border-base-content/10" body-class="p-0 sm:p-2">
        <x-mary-table :headers="$headers" :rows="$experiences" show-empty-text empty-text="No experiences yet. Add the first attraction card.">
            @scope('cell_image_url', $experience)
                <img src="{{ $experience->image_url }}" alt="{{ $experience->alt_text }}" width="96" height="64" loading="lazy" class="h-16 w-24 rounded-md object-cover bg-base-200">
            @endscope
            @scope('cell_title', $experience)
                <span class="font-medium">{{ $experience->title }}</span>
                <span class="block max-w-md truncate text-xs text-base-content/60">{{ $experience->description }}</span>
            @endscope
            @scope('cell_badge', $experience)
                @if ($experience->badge)
                    <x-mary-badge :value="$experience->badge" class="badge-primary badge-soft" />
                @else
                    <span class="text-base-content/40">&mdash;</span>
                @endif
            @endscope
            @scope('actions', $experience)
                <div class="flex justify-end gap-1">
                    <x-mary-button icon="o-pencil-square" link="{{ route('admin.experiences.edit', $experience->id) }}" class="btn-ghost btn-sm" tooltip-left="Edit" aria-label="Edit {{ $experience->title }}" />
                    <x-mary-button icon="o-trash" wire:click="confirmDelete({{ $experience->id }})" class="btn-ghost btn-sm text-error" tooltip-left="Delete" aria-label="Delete {{ $experience->title }}" />
                </div>
            @endscope
        </x-mary-table>
    </x-mary-card>

    <x-mary-modal wire:model="confirmingDelete" title="Delete experience?" separator>
        <p class="text-sm text-base-content/70">
            {{ $deleting?->title ?? 'This card' }} will disappear from the homepage carousel. This cannot be undone.
        </p>
        <x-slot:actions>
            <x-mary-button label="Cancel" @click="$wire.confirmingDelete = false" class="btn-ghost" />
            <x-mary-button label="Delete" icon="o-trash" wire:click="delete" spinner="delete" class="btn-error" />
        </x-slot:actions>
    </x-mary-modal>
</div>
