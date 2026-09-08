<?php

use App\Models\Floor;
use App\Models\Room;
use App\Support\PublicImages;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

new #[Layout('components.layouts.admin')] #[Title('Room')] class extends Component {
    use Toast, WithFileUploads;

    public ?Room $room = null;

    public ?int $floor_id = null;

    public ?int $room_number = null;

    public string $room_name = '';

    public string $price = '';

    public string $description = '';

    public int $sort_order = 0;

    public $image = null;

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->room = Room::findOrFail($id);
            $this->floor_id = $this->room->floor_id;
            $this->room_number = $this->room->room_number;
            $this->room_name = $this->room->room_name;
            $this->price = $this->room->price;
            $this->description = $this->room->description;
            $this->sort_order = $this->room->sort_order;
        } else {
            $this->floor_id = Floor::ordered()->value('id');
            $this->sort_order = (int) Room::max('sort_order') + 1;
        }
    }

    public function rules(): array
    {
        return [
            'floor_id' => ['required', Rule::exists('floors', 'id')],
            'room_number' => ['required', 'integer', 'min:1', 'max:9999'],
            'room_name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:65535'],
            'image' => [$this->room ? 'nullable' : 'required', 'file', 'mimes:jpg,jpeg,png,webp,avif', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'Add a photo of the room.',
            'image.mimes' => 'Use a JPG, PNG, WEBP or AVIF photo. iPhone HEIC photos must be converted first.',
            'image.max' => 'The photo must be 10 MB or smaller.',
        ];
    }

    public function updatedImage(): void
    {
        $this->validateOnly('image');
    }

    public function save(): void
    {
        $data = $this->validate();
        unset($data['image']);

        if ($this->image) {
            $data['image_url'] = PublicImages::store($this->image, 'rooms', $data['room_name']);
        }

        if ($this->room) {
            $previous = $this->room->image_url;
            $this->room->update($data);

            if ($this->image) {
                PublicImages::delete($previous, Room::where('image_url', $previous)->count());
            }

            $this->success('Room updated.', redirectTo: route('admin.rooms.index'));

            return;
        }

        Room::create($data);

        $this->success('Room created.', 'It is now visible in the homepage floor picker.', redirectTo: route('admin.rooms.index'));
    }

    public function with(): array
    {
        return [
            'floors' => Floor::ordered()->get(),
            'placeholder' => 'data:image/svg+xml;utf8,'.rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="320" height="200" viewBox="0 0 320 200"><rect width="320" height="200" fill="#eef2f3"/><g fill="none" stroke="#9aa5ab" stroke-width="3"><rect x="96" y="60" width="128" height="80" rx="8"/><circle cx="130" cy="88" r="10"/><path d="M110 132l34-34 30 30 18-18 22 22"/></g></svg>'),
        ];
    }
}; ?>

<div>
    <x-mary-header :title="$room ? 'Edit room' : 'New room'" :subtitle="$room ? $room->room_name : 'Add a room to a floor of the building.'" separator>
        <x-slot:actions>
            <x-mary-button label="Back to rooms" icon="o-arrow-uturn-left" link="{{ route('admin.rooms.index') }}" class="btn-ghost btn-sm" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-form wire:submit="save">
        <div class="grid gap-6 lg:grid-cols-5">
            <x-mary-card class="border border-base-content/10 lg:col-span-3" title="Details">
                <div class="grid gap-4 sm:grid-cols-2">
                    <x-mary-select label="Floor" wire:model="floor_id" :options="$floors" option-value="id" option-label="name" required />
                    <x-mary-input label="Room number" wire:model="room_number" type="number" inputmode="numeric" min="1" max="9999" placeholder="101" required />
                    <x-mary-input label="Room name" wire:model="room_name" placeholder="Room 101" required />
                    <x-mary-input label="Price" wire:model="price" placeholder="$120" hint="Shown as typed, e.g. $120 or From $120" required />
                    <div class="sm:col-span-2">
                        <x-mary-textarea label="Description" wire:model="description" rows="4" placeholder="What makes this room special?" hint="One or two sentences. Shown in the room card." required />
                    </div>
                    <x-mary-input label="Order" wire:model="sort_order" type="number" inputmode="numeric" min="0" hint="Lower numbers appear first on the floor" required />
                </div>
            </x-mary-card>

            <x-mary-card class="border border-base-content/10 lg:col-span-2" title="Photo">
                <x-mary-file wire:model="image" accept="image/png,image/jpeg,image/webp,image/avif" :label="$room ? 'Replace photo' : 'Photo'" hint="JPG, PNG, WEBP or AVIF, landscape, up to 10 MB." change-text="Choose a photo" :required="! $room">
                    <img src="{{ $room?->image_url ?? $placeholder }}" alt="" class="aspect-[4/3] w-full rounded-lg border border-dashed border-base-content/20 object-cover bg-base-200">
                </x-mary-file>
            </x-mary-card>
        </div>

        <x-slot:actions>
            <x-mary-button label="Cancel" link="{{ route('admin.rooms.index') }}" class="btn-ghost" />
            <x-mary-button :label="$room ? 'Save changes' : 'Create room'" icon="o-check" type="submit" spinner="save" class="btn-primary" />
        </x-slot:actions>
    </x-mary-form>
</div>
