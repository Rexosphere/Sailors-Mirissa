<?php

use App\Models\Experience;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use function Livewire\Volt\{state, uses, mount};

uses([WithFileUploads::class]);

state(['experience' => null]);
state(['title' => '']);
state(['description' => '']);
state(['image_url' => '']);
state(['alt_text' => '']);
state(['badge' => '']);
state(['icon' => '']);
state(['order' => 0]);
state(['image' => null]);

mount(function ($id = null) {
    if ($id) {
        $this->experience = Experience::findOrFail($id);
        $this->title = $this->experience->title;
        $this->description = $this->experience->description;
        $this->image_url = $this->experience->image_url;
        $this->alt_text = $this->experience->alt_text;
        $this->badge = $this->experience->badge ?? '';
        $this->icon = $this->experience->icon ?? '';
        $this->order = $this->experience->order;
    }
});

$save = function () {
    $this->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'image_url' => 'required|string',
        'alt_text' => 'required|string|max:255',
        'order' => 'required|integer|min:0',
    ]);

    $data = [
        'title' => $this->title,
        'description' => $this->description,
        'image_url' => $this->image_url,
        'alt_text' => $this->alt_text,
        'badge' => $this->badge,
        'icon' => $this->icon,
        'order' => $this->order,
    ];

    if ($this->experience) {
        $this->experience->update($data);
        session()->flash('success', 'Experience updated successfully.');
    } else {
        Experience::create($data);
        session()->flash('success', 'Experience created successfully.');
    }

    return redirect()->route('admin.experiences.index');
};

?>

<x-layouts.admin-layout>
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            {{ $experience ? 'Edit' : 'Create' }} Experience
        </h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            {{ $experience ? 'Update the experience details below' : 'Add a new attraction to the homepage' }}
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Title *
                    </label>
                    <input type="text" id="title" wire:model="title" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" 
                        required>
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Alt Text -->
                <div>
                    <label for="alt_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Alt Text *
                    </label>
                    <input type="text" id="alt_text" wire:model="alt_text" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" 
                        required>
                    @error('alt_text') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Description *
                    </label>
                    <textarea id="description" wire:model="description" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" 
                        required></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Image URL -->
                <div class="md:col-span-2">
                    <label for="image_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Image URL *
                    </label>
                    <input type="text" id="image_url" wire:model="image_url" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" 
                        placeholder="https://example.com/image.jpg"
                        required>
                    @error('image_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    @if($image_url)
                        <img src="{{ $image_url }}" alt="Preview" class="mt-2 h-32 rounded border">
                    @endif
                </div>

                <!-- Badge -->
                <div>
                    <label for="badge" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Badge (Optional)
                    </label>
                    <input type="text" id="badge" wire:model="badge" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" 
                        placeholder="e.g., Top Spot, Hidden Gem">
                    @error('badge') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Order -->
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Order *
                    </label>
                    <input type="number" id="order" wire:model="order" min="0"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" 
                        required>
                    @error('order') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Icon SVG -->
                <div class="md:col-span-2">
                    <label for="icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Icon SVG (Optional)
                    </label>
                    <textarea id="icon" wire:model="icon" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white font-mono text-sm"
                        placeholder="<svg>...</svg>"></textarea>
                    <p class="mt-1 text-sm text-gray-500">Paste the complete SVG code for the badge icon</p>
                    @error('icon') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-4">
                <a href="{{ route('admin.experiences.index') }}" 
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    Cancel
                </a>
                <button type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    {{ $experience ? 'Update' : 'Create' }} Experience
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin-layout>
