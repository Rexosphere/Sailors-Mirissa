<?php

use App\Models\MapPoint;
use function Livewire\Volt\{state, mount};

state(['mapPoint' => null]);
state(['name' => '']);
state(['description' => '']);
state(['image_url' => '']);
state(['coords' => '']);
state(['center_x' => 0]);
state(['center_y' => 0]);
state(['icon' => '']);

mount(function ($id = null) {
    if ($id) {
        $this->mapPoint = MapPoint::findOrFail($id);
        $this->name = $this->mapPoint->name;
        $this->description = $this->mapPoint->description;
        $this->image_url = $this->mapPoint->image_url;
        $this->coords = $this->mapPoint->coords;
        $this->center_x = $this->mapPoint->center_x;
        $this->center_y = $this->mapPoint->center_y;
        $this->icon = $this->mapPoint->icon ?? '';
    }
});

$save = function () {
    $this->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'image_url' => 'required|string',
        'coords' => 'required|string',
        'center_x' => 'required|integer',
        'center_y' => 'required|integer',
    ]);

    $data = [
        'name' => $this->name,
        'description' => $this->description,
        'image_url' => $this->image_url,
        'coords' => $this->coords,
        'center_x' => $this->center_x,
        'center_y' => $this->center_y,
        'icon' => $this->icon,
    ];

    if ($this->mapPoint) {
        $this->mapPoint->update($data);
        session()->flash('success', 'Map point updated successfully.');
    } else {
        MapPoint::create($data);
        session()->flash('success', 'Map point created successfully.');
    }

    return redirect()->route('admin.map-points.index');
};

?>

<x-layouts.admin-layout>
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            {{ $mapPoint ? 'Edit' : 'Create' }} Map Point
        </h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            {{ $mapPoint ? 'Update the map point details below' : 'Add a new landmark to the interactive map' }}
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Name *
                    </label>
                    <input type="text" id="name" wire:model="name" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" 
                        required>
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Image URL -->
                <div>
                    <label for="image_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Image URL *
                    </label>
                    <input type="text" id="image_url" wire:model="image_url" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" 
                        placeholder="/images/photos/example.jpg"
                        required>
                    @error('image_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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

                <!-- Center X -->
                <div>
                    <label for="center_x" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Center X Coordinate *
                    </label>
                    <input type="number" id="center_x" wire:model="center_x"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" 
                        required>
                    @error('center_x') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Center Y -->
                <div>
                    <label for="center_y" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Center Y Coordinate *
                    </label>
                    <input type="number" id="center_y" wire:model="center_y"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" 
                        required>
                    @error('center_y') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Polygon Coordinates -->
                <div class="md:col-span-2">
                    <label for="coords" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Polygon Coordinates *
                    </label>
                    <input type="text" id="coords" wire:model="coords" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white font-mono text-sm" 
                        placeholder="834,2339,1470,2155,1803,2247..."
                        required>
                    <p class="mt-1 text-sm text-gray-500">Enter comma-separated coordinates (x1,y1,x2,y2,...)</p>
                    @error('coords') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Icon HTML -->
                <div class="md:col-span-2">
                    <label for="icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Icon HTML (Optional)
                    </label>
                    <textarea id="icon" wire:model="icon" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white font-mono text-sm"
                        placeholder='<img src="/images/icons/example.avif" class="w-full h-full object-contain" alt="Icon">'></textarea>
                    <p class="mt-1 text-sm text-gray-500">Paste the complete HTML/SVG code for the map icon</p>
                    @error('icon') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-4">
                <a href="{{ route('admin.map-points.index') }}" 
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    Cancel
                </a>
                <button type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    {{ $mapPoint ? 'Update' : 'Create' }} Map Point
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin-layout>
