<?php

use App\Models\Room;
use function Livewire\Volt\{state, mount};

state(['room' => null]);
state(['id' => null]);

mount(function ($id = null) {
    $this->id = $id;
    if ($id) {
        $this->room = Room::findOrFail($id);
    }
});

?>

<x-layouts.admin-layout>
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            {{ $room ? 'Edit' : 'Create' }} Room Category
        </h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            {{ $room ? 'Update the room category details below' : 'Add a new room category (Floor + Room Type combination)' }}
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
        <form action="{{ $room ? route('admin.rooms.update', $room->id) : route('admin.rooms.store') }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-6">
                <!-- Floor Information -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Floor Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Floor ID -->
                        <div>
                            <label for="floor_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Floor *
                            </label>
                            <select id="floor_id" name="floor_id"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="ground" {{ ($room?->floor_id ?? '') == 'ground' ? 'selected' : '' }}>Ground Floor</option>
                                <option value="first" {{ ($room?->floor_id ?? '') == 'first' ? 'selected' : '' }}>First Floor</option>
                                <option value="second" {{ ($room?->floor_id ?? '') == 'second' ? 'selected' : '' }}>Second Floor</option>
                                <option value="third" {{ ($room?->floor_id ?? '') == 'third' ? 'selected' : '' }}>Third Floor</option>
                            </select>
                        </div>



                        <!-- Floor View -->
                        <div>
                            <label for="floor_view" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Floor View *
                            </label>
                            <input type="text" id="floor_view" name="floor_view" 
                                value="{{ old('floor_view', $room?->floor_view) }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="e.g., Garden View, Ocean View"
                                required>
                        </div>
                    </div>
                </div>

                <!-- Room Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Room Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Room Type -->
                        <div>
                            <label for="room_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Room Type *
                            </label>
                            <select id="room_type" name="room_type"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="double" {{ ($room?->room_type ?? 'double') == 'double' ? 'selected' : '' }}>Double Room</option>
                                <option value="twin" {{ ($room?->room_type ?? '') == 'twin' ? 'selected' : '' }}>Twin Room</option>
                            </select>
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Price per Night *
                            </label>
                            <input type="text" id="price" name="price" 
                                value="{{ old('price', $room?->price) }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="$120"
                                required>
                        </div>

                        <!-- Order -->
                        <div>
                            <label for="order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Display Order *
                            </label>
                            <input type="number" id="order" name="order" min="0"
                                value="{{ old('order', $room?->order ?? 0) }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                required>
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Description *
                            </label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                required>{{ old('description', $room?->description) }}</textarea>
                        </div>

                        <!-- Facilities/Amenities -->\n                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Facilities & Amenities
                            </label>
                            <div id="facilities-container" class="space-y-2">
                                @if($room && $room->facilities)
                                    @foreach($room->facilities as $index => $facility)
                                        <div class="flex gap-2 facility-item">
                                            <input type="text" name="facilities[]" value="{{ $facility }}"
                                                class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                                placeholder="e.g., Free Wi-Fi">
                                            <button type="button" onclick="removeFacility(this)" 
                                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                                Remove
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="flex gap-2 facility-item">
                                        <input type="text" name="facilities[]" value="Free Wi-Fi"
                                            class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                            placeholder="e.g., Free Wi-Fi">
                                        <button type="button" onclick="removeFacility(this)" 
                                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                            Remove
                                        </button>
                                    </div>
                                    <div class="flex gap-2 facility-item">
                                        <input type="text" name="facilities[]" value="Air Conditioning"
                                            class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                            placeholder="e.g., Air Conditioning">
                                        <button type="button" onclick="removeFacility(this)" 
                                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                            Remove
                                        </button>
                                    </div>
                                    <div class="flex gap-2 facility-item">
                                        <input type="text" name="facilities[]" value="24/7 Room Service"
                                            class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                            placeholder="e.g., 24/7 Room Service">
                                        <button type="button" onclick="removeFacility(this)" 
                                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                            Remove
                                        </button>
                                    </div>
                                    <div class="flex gap-2 facility-item">
                                        <input type="text" name="facilities[]" value="Premium Amenities"
                                            class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                            placeholder="e.g., Premium Amenities">
                                        <button type="button" onclick="removeFacility(this)" 
                                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                            Remove
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" onclick="addFacility()" 
                                class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                + Add Facility
                            </button>
                        </div>

                        <!-- Multiple Image Upload -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Room Images (Multiple) {{ $room ? '(Upload new to add more)' : '*' }}
                            </label>
                            
                            <!-- Drag and Drop Upload Area -->
                            <div 
                                id="upload-area"
                                class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8 text-center hover:border-blue-400 dark:hover:border-blue-500 transition-colors cursor-pointer"
                                onclick="document.getElementById('images').click()"
                            >
                                <input type="file" id="images" name="images[]" accept="image/*" multiple
                                    class="hidden"
                                    onchange="previewMultipleImages(this)">
                                
                                <!-- Default upload prompt -->
                                <div id="upload-prompt" class="space-y-2">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="text-gray-600 dark:text-gray-400">
                                        <span class="font-medium text-blue-600 dark:text-blue-400">Click to upload</span> or drag and drop
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, AVIF, WEBP up to 5MB (Multiple files allowed)</p>
                                </div>
                                
                                <!-- Multiple Images preview grid -->
                                <div id="images-preview-grid" class="hidden grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                            </div>
                            
                            @if($room && $room->images)
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Current images:</p>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="current-images-grid">
                                        @foreach($room->images as $index => $image)
                                            <div class="relative group" data-image="{{ $image }}">
                                                <img src="{{ asset($image) }}" alt="Room image" class="h-32 w-full rounded border object-cover">
                                                <button type="button" onclick="removeExistingImage(this, '{{ $image }}')" 
                                                    class="absolute top-1 right-1 bg-red-600 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" id="removed-images" name="removed_images" value="">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-4">
                <a href="{{ route('admin.rooms.index') }}" 
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    Cancel
                </a>
                <button type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    {{ $room ? 'Update' : 'Create' }} Room
                </button>
            </div>
        </form>
    </div>

    <script>
        let removedImages = [];

        function previewMultipleImages(input) {
            if (input.files && input.files.length > 0) {
                const grid = document.getElementById('images-preview-grid');
                grid.innerHTML = '';
                
                Array.from(input.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative';
                        div.innerHTML = `
                            <img src="${e.target.result}" alt="Preview ${index + 1}" class="h-32 w-full rounded-lg object-cover">
                            <div class="absolute bottom-1 right-1 bg-black/60 text-white text-xs px-2 py-1 rounded">
                                ${index + 1}
                            </div>
                        `;
                        grid.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });
                
                document.getElementById('upload-prompt').classList.add('hidden');
                grid.classList.remove('hidden');
            }
        }

        function removeExistingImage(button, imagePath) {
            if (confirm('Remove this image?')) {
                removedImages.push(imagePath);
                document.getElementById('removed-images').value = JSON.stringify(removedImages);
                button.closest('[data-image]').remove();
            }
        }

        // Drag and drop handling
        const uploadArea = document.getElementById('upload-area');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, () => {
                uploadArea.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, () => {
                uploadArea.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
            }, false);
        });

        uploadArea.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            const input = document.getElementById('images');
            input.files = files;
            previewMultipleImages(input);
        }, false);

        // Facilities management
        function addFacility() {
            const container = document.getElementById('facilities-container');
            const div = document.createElement('div');
            div.className = 'flex gap-2 facility-item';
            div.innerHTML = `
                <input type="text" name="facilities[]" value=""
                    class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                    placeholder="e.g., Swimming Pool">
                <button type="button" onclick="removeFacility(this)" 
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Remove
                </button>
            `;
            container.appendChild(div);
        }

        function removeFacility(button) {
            const container = document.getElementById('facilities-container');
            if (container.children.length > 1) {
                button.closest('.facility-item').remove();
            } else {
                alert('At least one facility must remain');
            }
        }
    </script>
</x-layouts.admin-layout>
