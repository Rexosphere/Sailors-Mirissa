<?php

use App\Models\Floor;
use App\Models\Room;
use App\Support\PublicImages;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Layout('components.layouts.admin')] #[Title('Rooms')] class extends Component {
    use Toast;

    public string $floor = '';

    public bool $confirmingDelete = false;

    public ?int $deletingId = null;

    public function mount(): void
    {
        $this->floor = Floor::ordered()->value('slug') ?? '';
    }

    public function with(): array
    {
        $floors = Floor::ordered()->with('rooms')->get();

        return [
            'floors' => $floors,
            'deleting' => $this->deletingId ? Room::find($this->deletingId) : null,
            'headers' => [
                ['key' => 'image_url', 'label' => '', 'class' => 'w-28', 'sortable' => false],
                ['key' => 'room_number', 'label' => 'No.', 'class' => 'w-20'],
                ['key' => 'room_name', 'label' => 'Room'],
                ['key' => 'price', 'label' => 'Price', 'class' => 'w-40'],
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
        $room = Room::findOrFail($this->deletingId);
        $otherReferences = Room::where('image_url', $room->image_url)->whereKeyNot($room->id)->count();

        $room->delete();
        PublicImages::delete($room->image_url, $otherReferences);

        $this->confirmingDelete = false;
        $this->deletingId = null;
        $this->success("Room {$room->room_name} deleted.");
    }
}; ?>

<div>
    <x-mary-header title="Rooms" subtitle="Rooms are grouped by floor and shown in the homepage floor picker." separator>
        <x-slot:actions>
            <x-mary-button label="Add room" icon="o-plus" link="{{ route('admin.rooms.create') }}" class="btn-primary btn-sm" />
        </x-slot:actions>
    </x-mary-header>

    @if ($floors->isEmpty())
        <x-mary-alert title="No floors yet" description="Run the database seeder or add floors before creating rooms." icon="o-exclamation-triangle" class="alert-warning" />
    @else
        <x-mary-card class="border border-base-content/10" body-class="p-0 sm:p-2">
            <x-mary-tabs wire:model="floor" label-class="font-medium" active-class="text-primary" content-class="px-0 py-2">
                @foreach ($floors as $floorItem)
                    <x-mary-tab name="{{ $floorItem->slug }}" label="{{ $floorItem->name }}" badge="{{ $floorItem->rooms->count() }}" badge-class="badge-ghost">
                        <x-mary-table :headers="$headers" :rows="$floorItem->rooms" show-empty-text empty-text="No rooms on this floor yet.">
                            @scope('cell_image_url', $room)
                                <img src="{{ $room->image_url }}" alt="" width="96" height="64" loading="lazy" class="h-16 w-24 rounded-md object-cover bg-base-200">
                            @endscope
                            @scope('cell_room_name', $room)
                                <span class="font-medium">{{ $room->room_name }}</span>
                                <span class="block max-w-md truncate text-xs text-base-content/60">{{ $room->description }}</span>
                            @endscope
                            @scope('cell_price', $room)
                                <span class="tabular-nums">{{ $room->price }}</span>
                            @endscope
                            @scope('actions', $room)
                                <div class="flex justify-end gap-1">
                                    <x-mary-button icon="o-pencil-square" link="{{ route('admin.rooms.edit', $room->id) }}" class="btn-ghost btn-sm" tooltip-left="Edit" aria-label="Edit {{ $room->room_name }}" />
                                    <x-mary-button icon="o-trash" wire:click="confirmDelete({{ $room->id }})" class="btn-ghost btn-sm text-error" tooltip-left="Delete" aria-label="Delete {{ $room->room_name }}" />
                                </div>
                            @endscope
                        </x-mary-table>
                    </x-mary-tab>
                @endforeach
            </x-mary-tabs>
        </x-mary-card>
    @endif

    <x-mary-modal wire:model="confirmingDelete" title="Delete room?" separator>
        <p class="text-sm text-base-content/70">
            {{ $deleting?->room_name ?? 'This room' }} will be removed from the homepage immediately. This cannot be undone.
        </p>
        <x-slot:actions>
            <x-mary-button label="Cancel" @click="$wire.confirmingDelete = false" class="btn-ghost" />
            <x-mary-button label="Delete room" icon="o-trash" wire:click="delete" spinner="delete" class="btn-error" />
        </x-slot:actions>
    </x-mary-modal>
</div>
