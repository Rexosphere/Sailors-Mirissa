<?php

use App\Models\Experience;
use App\Support\PublicImages;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

new #[Layout('components.layouts.admin')] #[Title('Experience')] class extends Component {
    use Toast, WithFileUploads;

    public ?Experience $experience = null;

    public string $title = '';

    public string $alt_text = '';

    public string $description = '';

    public string $badge = '';

    public string $icon = '';

    public int $sort_order = 0;

    public $image = null;

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->experience = Experience::findOrFail($id);
            $this->title = $this->experience->title;
            $this->alt_text = $this->experience->alt_text;
            $this->description = $this->experience->description;
            $this->badge = (string) $this->experience->badge;
            $this->icon = (string) $this->experience->icon;
            $this->sort_order = $this->experience->sort_order;
        } else {
            $this->sort_order = (int) Experience::max('sort_order') + 1;
        }
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'alt_text' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'badge' => ['nullable', 'string', 'max:40'],
            'icon' => ['nullable', 'string', 'max:5000'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:65535'],
            'image' => [$this->experience ? 'nullable' : 'required', 'file', 'mimes:jpg,jpeg,png,webp,avif', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'Add a photo for the card.',
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
        $data['badge'] = $data['badge'] ?: null;
        $data['icon'] = $data['icon'] ?: null;

        if ($this->image) {
            $data['image_url'] = PublicImages::store($this->image, 'experiences', $data['title']);
        }

        if ($this->experience) {
            $previous = $this->experience->image_url;
            $this->experience->update($data);

            if ($this->image) {
                PublicImages::delete($previous, Experience::where('image_url', $previous)->count());
            }

            $this->success('Experience updated.', redirectTo: route('admin.experiences.index'));

            return;
        }

        Experience::create($data);

        $this->success('Experience created.', redirectTo: route('admin.experiences.index'));
    }

    public function with(): array
    {
        return [
            'placeholder' => 'data:image/svg+xml;utf8,'.rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="240" height="320" viewBox="0 0 240 320"><rect width="240" height="320" fill="#eef2f3"/><g fill="none" stroke="#9aa5ab" stroke-width="3"><rect x="56" y="120" width="128" height="80" rx="8"/><circle cx="90" cy="148" r="10"/><path d="M70 192l34-34 30 30 18-18 22 22"/></g></svg>'),
        ];
    }
}; ?>

<div>
    <x-mary-header :title="$experience ? 'Edit experience' : 'New experience'" :subtitle="$experience ? $experience->title : 'Add an attraction card to the homepage carousel.'" separator>
        <x-slot:actions>
            <x-mary-button label="Back to experiences" icon="o-arrow-uturn-left" link="{{ route('admin.experiences.index') }}" class="btn-ghost btn-sm" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-form wire:submit="save">
        <div class="grid gap-6 lg:grid-cols-5">
            <x-mary-card class="border border-base-content/10 lg:col-span-3" title="Details">
                <div class="grid gap-4 sm:grid-cols-2">
                    <x-mary-input label="Title" wire:model="title" placeholder="Coconut Tree Hill" required />
                    <x-mary-input label="Badge" wire:model="badge" placeholder="Top Spot" hint="Optional short label over the photo" />
                    <div class="sm:col-span-2">
                        <x-mary-textarea label="Description" wire:model="description" rows="3" placeholder="One line that sells the place." required />
                    </div>
                    <div class="sm:col-span-2">
                        <x-mary-input label="Image description (alt text)" wire:model="alt_text" placeholder="Coconut palms on a hill above the ocean" hint="Read by screen readers and search engines" required />
                    </div>
                    <x-mary-input label="Order" wire:model="sort_order" type="number" inputmode="numeric" min="0" hint="Lower numbers appear first" required />
                    <div class="sm:col-span-2">
                        <x-mary-textarea label="Badge icon (optional inline SVG)" wire:model="icon" rows="2" placeholder="<svg ...></svg>" hint="Advanced: a small SVG shown next to the badge text" />
                    </div>
                </div>
            </x-mary-card>

            <x-mary-card class="border border-base-content/10 lg:col-span-2" title="Photo">
                <x-mary-file wire:model="image" accept="image/png,image/jpeg,image/webp,image/avif" :label="$experience ? 'Replace photo' : 'Photo'" hint="JPG, PNG, WEBP or AVIF, portrait works best, up to 10 MB." change-text="Choose a photo" :required="! $experience">
                    <img src="{{ $experience?->image_url ?? $placeholder }}" alt="" class="aspect-[3/4] w-full max-w-xs rounded-lg border border-dashed border-base-content/20 object-cover bg-base-200">
                </x-mary-file>
            </x-mary-card>
        </div>

        <x-slot:actions>
            <x-mary-button label="Cancel" link="{{ route('admin.experiences.index') }}" class="btn-ghost" />
            <x-mary-button :label="$experience ? 'Save changes' : 'Create experience'" icon="o-check" type="submit" spinner="save" class="btn-primary" />
        </x-slot:actions>
    </x-mary-form>
</div>
