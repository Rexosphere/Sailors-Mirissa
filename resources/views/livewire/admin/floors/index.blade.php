<?php

use App\Models\Floor;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Layout('components.layouts.admin')] #[Title('Floors')] class extends Component {
    use Toast;

    public bool $editing = false;

    public ?int $editingId = null;

    public string $name = '';

    public string $view = '';

    public int $sort_order = 0;

    public function with(): array
    {
        return [
            'floors' => Floor::ordered()->withCount('rooms')->get(),
            'headers' => [
                ['key' => 'name', 'label' => 'Floor'],
                ['key' => 'view', 'label' => 'View'],
                ['key' => 'rooms_count', 'label' => 'Rooms', 'class' => 'w-24'],
                ['key' => 'sort_order', 'label' => 'Order', 'class' => 'w-24'],
            ],
        ];
    }

    public function edit(int $id): void
    {
        $floor = Floor::findOrFail($id);

        $this->editingId = $floor->id;
        $this->name = $floor->name;
        $this->view = $floor->view;
        $this->sort_order = $floor->sort_order;
        $this->resetValidation();
        $this->editing = true;
    }

    public function save(): void
    {
        $data = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'view' => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:65535'],
        ]);

        Floor::findOrFail($this->editingId)->update($data);

        $this->editing = false;
        $this->success('Floor updated.');
    }
}; ?>

<div>
    <x-mary-header title="Floors" subtitle="The four floors of the building. Names and views appear in the room picker; the outline on the building image is fixed." separator />

    <x-mary-card class="border border-base-content/10" body-class="p-0 sm:p-2">
        <x-mary-table :headers="$headers" :rows="$floors">
            @scope('cell_name', $floor)
                <span class="font-medium">{{ $floor->name }}</span>
                <span class="block text-xs text-base-content/50">{{ $floor->slug }}</span>
            @endscope
            @scope('cell_rooms_count', $floor)
                <x-mary-badge :value="$floor->rooms_count" class="badge-ghost" />
            @endscope
            @scope('actions', $floor)
                <x-mary-button icon="o-pencil-square" wire:click="edit({{ $floor->id }})" spinner="edit({{ $floor->id }})" class="btn-ghost btn-sm" tooltip-left="Edit" aria-label="Edit {{ $floor->name }}" />
            @endscope
        </x-mary-table>
    </x-mary-card>

    <x-mary-modal wire:model="editing" title="Edit floor" separator>
        <x-mary-form wire:submit="save" no-separator>
            <x-mary-input label="Name" wire:model="name" required />
            <x-mary-input label="View" wire:model="view" hint="Shown under the floor name, e.g. Ocean View" required />
            <x-mary-input label="Order" wire:model="sort_order" type="number" min="0" hint="Lower numbers come first" required />
            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.editing = false" class="btn-ghost" />
                <x-mary-button label="Save" type="submit" spinner="save" class="btn-primary" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>
</div>
