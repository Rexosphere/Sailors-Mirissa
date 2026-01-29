<?php

use App\Models\Experience;
use function Livewire\Volt\{state, mount};

state(['experience' => null]);
state(['id' => null]);

mount(function ($id = null) {
    $this->id = $id;
    if ($id) {
        $this->experience = Experience::findOrFail($id);
    }
});

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
        <form action="{{ $experience ? route('admin.experiences.update', $experience->id) : route('admin.experiences.store') }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Title *
                    </label>
                    <input type="text" id="title" name="title" 
                        value="{{ old('title', $experience?->title) }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" 
                        required>
                </div>

                <!-- Alt Text -->
                <div>
                    <label for="alt_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Alt Text *
                    </label>
                    <input type="text" id="alt_text" name="alt_text" 
                        value="{{ old('alt_text', $experience?->alt_text) }}"
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
                        required>{{ old('description', $experience?->description) }}</textarea>
                </div>

                <!-- Image Upload with Preview -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Image {{ $experience ? '(Leave empty to keep current)' : '*' }}
                    </label>
                    
                    <!-- Drag and Drop Upload Area -->
                    <div 
                        id="upload-area"
                        class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8 text-center hover:border-blue-400 dark:hover:border-blue-500 transition-colors cursor-pointer"
                        onclick="document.getElementById('image').click()"
                    >
                        <input type="file" id="image" name="image" accept="image/*"
                            class="hidden"
                            onchange="previewImage(this)">
                        
                        <!-- Default upload prompt (hidden when image is selected) -->
                        <div id="upload-prompt" class="space-y-2">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="text-gray-600 dark:text-gray-400">
                                <span class="font-medium text-blue-600 dark:text-blue-400">Click to upload</span> or drag and drop
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, AVIF, WEBP up to 5MB</p>
                        </div>
                        
                        <!-- Image preview (hidden by default) -->
                        <div id="image-preview" class="hidden">
                            <img id="preview-img" src="" alt="Preview" class="mx-auto h-40 rounded-lg object-cover">
                            <p id="file-name" class="mt-2 text-sm text-green-600 dark:text-green-400"></p>
                        </div>
                    </div>
                    
                    @if($experience && $experience->image_url)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Current image:</p>
                            <img src="{{ $experience->image_url }}" alt="Current" class="h-32 rounded border object-cover">
                        </div>
                    @endif
                </div>

                <!-- Badge -->
                <div>
                    <label for="badge" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Badge (Optional)
                    </label>
                    <input type="text" id="badge" name="badge" 
                        value="{{ old('badge', $experience?->badge) }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" 
                        placeholder="e.g., Top Spot, Hidden Gem">
                </div>

                <!-- Order -->
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Order *
                    </label>
                    <input type="number" id="order" name="order" min="0"
                        value="{{ old('order', $experience?->order ?? 0) }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" 
                        required>
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

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('upload-prompt').classList.add('hidden');
                    document.getElementById('image-preview').classList.remove('hidden');
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('file-name').textContent = input.files[0].name;
                };
                reader.readAsDataURL(input.files[0]);
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
            const input = document.getElementById('image');
            input.files = files;
            previewImage(input);
        }, false);
    </script>
</x-layouts.admin-layout>
