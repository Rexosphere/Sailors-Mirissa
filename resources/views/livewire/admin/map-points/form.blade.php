<?php

use App\Models\MapPoint;
use App\Support\PublicImages;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

new #[Layout('components.layouts.admin')] #[Title('Map point')] class extends Component {
    use Toast, WithFileUploads;

    /** Pixel size of /images/photos/interactive-map.avif, the coordinate space of map points. */
    public const MAP_WIDTH = 8000;

    public const MAP_HEIGHT = 6000;

    public ?MapPoint $point = null;

    public string $name = '';

    public string $description = '';

    public ?int $center_x = null;

    public ?int $center_y = null;

    public $image = null;

    public $icon_file = null;

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->point = MapPoint::findOrFail($id);
            $this->name = $this->point->name;
            $this->description = $this->point->description;
            $this->center_x = $this->point->center_x;
            $this->center_y = $this->point->center_y;
        }
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'center_x' => ['required', 'integer', 'min:0', 'max:'.self::MAP_WIDTH],
            'center_y' => ['required', 'integer', 'min:0', 'max:'.self::MAP_HEIGHT],
            'image' => [$this->point ? 'nullable' : 'required', 'file', 'mimes:jpg,jpeg,png,webp,avif', 'max:10240'],
            'icon_file' => ['nullable', 'file', 'mimes:png,webp,avif,svg', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'center_x.required' => 'Click the map to place the marker.',
            'center_y.required' => 'Click the map to place the marker.',
            'image.required' => 'Add a photo for the landmark card.',
            'image.mimes' => 'Use a JPG, PNG, WEBP or AVIF photo. iPhone HEIC photos must be converted first.',
            'icon_file.mimes' => 'Use a PNG, WEBP, AVIF or SVG with a transparent background.',
        ];
    }

    public function updatedImage(): void
    {
        $this->validateOnly('image');
    }

    public function updatedIconFile(): void
    {
        $this->validateOnly('icon_file');
    }

    public function save(): void
    {
        $data = $this->validate();
        unset($data['image'], $data['icon_file']);

        $moved = ! $this->point || $this->point->center_x !== $data['center_x'] || $this->point->center_y !== $data['center_y'];
        if ($moved) {
            $data['coords'] = $this->diamondAround($data['center_x'], $data['center_y']);
        }

        if ($this->image) {
            $data['image_url'] = PublicImages::store($this->image, 'map-points', $data['name']);
        }

        if ($this->icon_file) {
            $iconUrl = PublicImages::store($this->icon_file, 'icons', $data['name'].'-icon');
            $data['icon'] = '<img src="'.e($iconUrl).'" class="w-full h-full object-contain" alt="'.e($data['name']).' icon">';
        }

        if ($this->point) {
            $previousImage = $this->point->image_url;
            $previousIcon = PublicImages::srcFromHtml($this->point->icon);
            $this->point->update($data);

            if ($this->image) {
                PublicImages::delete($previousImage, MapPoint::where('image_url', $previousImage)->count());
            }
            if ($this->icon_file && $previousIcon) {
                PublicImages::delete($previousIcon, MapPoint::where('icon', 'like', '%'.$previousIcon.'%')->count());
            }

            $this->success('Map point updated.', redirectTo: route('admin.map-points.index'));

            return;
        }

        MapPoint::create($data);

        $this->success('Map point created.', redirectTo: route('admin.map-points.index'));
    }

    /**
     * Highlight polygon around the marker, in map pixels.
     */
    private function diamondAround(int $x, int $y, int $radius = 150): string
    {
        return implode(',', [$x, $y - $radius, $x + $radius, $y, $x, $y + $radius, $x - $radius, $y]);
    }

    public function with(): array
    {
        return [
            'placeholder' => 'data:image/svg+xml;utf8,'.rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="320" height="200" viewBox="0 0 320 200"><rect width="320" height="200" fill="#eef2f3"/><g fill="none" stroke="#9aa5ab" stroke-width="3"><rect x="96" y="60" width="128" height="80" rx="8"/><circle cx="130" cy="88" r="10"/><path d="M110 132l34-34 30 30 18-18 22 22"/></g></svg>'),
            'iconPlaceholder' => 'data:image/svg+xml;utf8,'.rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"><circle cx="40" cy="40" r="38" fill="#334155"/><path d="M40 22a12 12 0 0 1 12 12c0 9-12 22-12 22S28 43 28 34a12 12 0 0 1 12-12z" fill="none" stroke="#fff" stroke-width="3"/></svg>'),
        ];
    }
}; ?>

<div>
    <x-mary-header :title="$point ? 'Edit map point' : 'New map point'" :subtitle="$point ? $point->name : 'Add a landmark to the interactive map.'" separator>
        <x-slot:actions>
            <x-mary-button label="Back to map points" icon="o-arrow-uturn-left" link="{{ route('admin.map-points.index') }}" class="btn-ghost btn-sm" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-form wire:submit="save">
        <div class="grid gap-6 lg:grid-cols-5">
            <x-mary-card class="border border-base-content/10 lg:col-span-3" title="Details">
                <div class="grid gap-4">
                    <x-mary-input label="Name" wire:model="name" placeholder="Coconut Tree Hill" required />
                    <x-mary-textarea label="Description" wire:model="description" rows="3" placeholder="What is here and why visit." required />
                </div>

                <div class="mt-6">
                    <fieldset class="fieldset py-0">
                        <legend class="fieldset-legend mb-0.5">Position on the map <span class="text-error">*</span></legend>
                    </fieldset>
                    <div
                        x-data="{
                            x: $wire.entangle('center_x'),
                            y: $wire.entangle('center_y'),
                            place(event) {
                                const rect = event.currentTarget.getBoundingClientRect();
                                this.x = Math.round((event.clientX - rect.left) / rect.width * {{ self::MAP_WIDTH }});
                                this.y = Math.round((event.clientY - rect.top) / rect.height * {{ self::MAP_HEIGHT }});
                            },
                            get left() { return this.x === null ? 0 : this.x / {{ self::MAP_WIDTH }} * 100 },
                            get top() { return this.y === null ? 0 : this.y / {{ self::MAP_HEIGHT }} * 100 },
                        }"
                        class="relative aspect-[4/3] w-full cursor-crosshair overflow-hidden rounded-lg border border-base-content/20 bg-base-200"
                        role="button"
                        tabindex="0"
                        aria-label="Click to place the marker"
                        @click="place($event)"
                    >
                        <img src="/images/photos/interactive-map.avif" alt="" class="pointer-events-none h-full w-full object-cover" draggable="false">
                        <span
                            x-show="x !== null"
                            x-cloak
                            :style="`left:${left}%; top:${top}%`"
                            class="pointer-events-none absolute h-5 w-5 -translate-x-1/2 -translate-y-1/2 rounded-full border-2 border-white bg-error shadow-md transition-all duration-150"
                        ></span>
                    </div>
                    <p class="fieldset-label mt-1">Click where the marker should sit. Coordinates: <span class="tabular-nums" x-text="x === null ? 'not set' : `${x}, ${y}`"></span></p>
                    @error('center_x') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </x-mary-card>

            <div class="grid gap-6 lg:col-span-2 content-start">
                <x-mary-card class="border border-base-content/10" title="Photo">
                    <x-mary-file wire:model="image" accept="image/png,image/jpeg,image/webp,image/avif" :label="$point ? 'Replace photo' : 'Photo'" hint="Shown in the popup card. JPG, PNG, WEBP or AVIF, up to 10 MB." change-text="Choose a photo" :required="! $point">
                        <img src="{{ $point?->image_url ?? $placeholder }}" alt="" class="aspect-[4/3] w-full rounded-lg border border-dashed border-base-content/20 object-cover bg-base-200">
                    </x-mary-file>
                </x-mary-card>

                <x-mary-card class="border border-base-content/10" title="Marker icon">
                    <x-mary-file wire:model="icon_file" accept="image/png,image/webp,image/avif,image/svg+xml" label="Icon" hint="Optional. Square PNG/SVG with a transparent background, white works best." change-text="Choose an icon">
                        <img src="{{ PublicImages::srcFromHtml($point?->icon) ?? $iconPlaceholder }}" alt="" class="h-20 w-20 rounded-full border border-dashed border-base-content/20 bg-slate-700 object-contain p-2">
                    </x-mary-file>
                </x-mary-card>
            </div>
        </div>

        <x-slot:actions>
            <x-mary-button label="Cancel" link="{{ route('admin.map-points.index') }}" class="btn-ghost" />
            <x-mary-button :label="$point ? 'Save changes' : 'Create map point'" icon="o-check" type="submit" spinner="save" class="btn-primary" />
        </x-slot:actions>
    </x-mary-form>
</div>
