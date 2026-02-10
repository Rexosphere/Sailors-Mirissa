<?php

use App\Models\MapPoint;
use function Livewire\Volt\{state, mount};

state(['mapPoint' => null]);
state(['id' => null]);

mount(function ($id = null) {
    $this->id = $id;
    if ($id) {
        $this->mapPoint = MapPoint::findOrFail($id);
    }
});

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

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-100 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form action="{{ $mapPoint ? route('admin.map-points.update', $mapPoint->id) : route('admin.map-points.store') }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Name *
                    </label>
                    <input type="text" id="name" name="name" 
                        value="{{ old('name', $mapPoint?->name) }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" 
                        required>
                </div>

                <!-- Image Upload (Main Photo) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Main Photo {{ $mapPoint ? '(Leave empty to keep current)' : '*' }}
                    </label>
                    <input type="file" name="image" accept="image/*"
                        class="block w-full text-sm text-gray-500 dark:text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100
                            dark:file:bg-blue-900 dark:file:text-blue-300"
                        {{ $mapPoint ? '' : 'required' }}>
                    
                    @if($mapPoint && $mapPoint->image_url)
                        <div class="mt-2 text-xs text-gray-500">
                            Current: <a href="{{ $mapPoint->image_url }}" target="_blank" class="text-blue-600 hover:underline">View Image</a>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Description *
                    </label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" 
                        required>{{ old('description', $mapPoint?->description) }}</textarea>
                </div>

                <!-- Icon Upload -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Map Marker Icon (Optional)
                    </label>
                    <div class="flex items-center space-x-4">
                        <input type="file" name="icon_file" accept="image/*"
                            class="block w-full text-sm text-gray-500 dark:text-gray-400
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-lg file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100
                                dark:file:bg-blue-900 dark:file:text-blue-300">
                        
                        @if($mapPoint && $mapPoint->icon)
                            <div class="h-10 w-10 flex-shrink-0 bg-gray-100 rounded-full flex items-center justify-center overflow-hidden border">
                                {!! $mapPoint->icon !!}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Map Location Picker -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Location on Map (Click to select) *
                    </label>
                    <div class="relative w-full aspect-[4/3] bg-gray-200 rounded-lg overflow-hidden cursor-crosshair border-2 border-gray-300 dark:border-gray-600 group"
                         onclick="selectMapLocation(event)">
                        <img src="/images/photos/interactive-map.avif" alt="Map" class="w-full h-full object-cover pointer-events-none">
                        
                        <!-- Marker element -->
                        <div id="map-marker" class="absolute w-4 h-4 bg-red-600 border-2 border-white rounded-full shadow-md transform -translate-x-1/2 -translate-y-1/2 pointer-events-none transition-all duration-200 {{ $mapPoint ? '' : 'hidden' }}"
                             style="{{ $mapPoint ? 'left: ' . ($mapPoint->center_x / 8000 * 100) . '%; top: ' . ($mapPoint->center_y / 6000 * 100) . '%;' : '' }}">
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Click on the map to set the center point.</p>
                </div>

                <!-- Hidden Coordinates -->
                <input type="hidden" id="center_x" name="center_x" value="{{ old('center_x', $mapPoint?->center_x) }}">
                <input type="hidden" id="center_y" name="center_y" value="{{ old('center_y', $mapPoint?->center_y) }}">
                <input type="hidden" id="coords" name="coords" value="{{ old('coords', $mapPoint?->coords) }}">
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

    <script>
        const ORIGINAL_WIDTH = 8000;
        const ORIGINAL_HEIGHT = 6000;

        function selectMapLocation(event) {
            const rect = event.currentTarget.getBoundingClientRect();
            
            // Calculate percentage position
            const xPercent = (event.clientX - rect.left) / rect.width;
            const yPercent = (event.clientY - rect.top) / rect.height;

            // Calculate original coordinates
            const centerX = Math.round(xPercent * ORIGINAL_WIDTH);
            const centerY = Math.round(yPercent * ORIGINAL_HEIGHT);

            // Update hidden inputs
            document.getElementById('center_x').value = centerX;
            document.getElementById('center_y').value = centerY;
            
            // Auto-generate coords (diamond shape around center, radius ~150px)
            const radius = 150;
            const coords = [
                centerX, centerY - radius, // Top
                centerX + radius, centerY, // Right
                centerX, centerY + radius, // Bottom
                centerX - radius, centerY  // Left
            ].join(',');
            
            document.getElementById('coords').value = coords;

            // Move marker visual
            const marker = document.getElementById('map-marker');
            marker.style.left = (xPercent * 100) + '%';
            marker.style.top = (yPercent * 100) + '%';
            marker.classList.remove('hidden');
        }
    </script>
</x-layouts.admin-layout>
