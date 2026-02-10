<div>
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
                    <x-mary-input 
                        label="Title *" 
                        wire:model="title" 
                        placeholder="Experience title"
                        required 
                    />
                </div>

                <!-- Alt Text -->
                <div>
                    <x-mary-input 
                        label="Alt Text *" 
                        wire:model="alt_text" 
                        placeholder="Image alt text for accessibility"
                        required 
                    />
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <x-mary-textarea 
                        label="Description *" 
                        wire:model="description" 
                        placeholder="Describe this experience..."
                        rows="4"
                        required 
                    />
                </div>

                <!-- Image Upload with Mary UI -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Image {{ $experience ? '(Click to change)' : '*' }}
                    </label>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">PNG, JPG, AVIF, WEBP up to 5MB - Click on image to upload</p>
                    
                    <x-mary-file wire:model="image" accept="image/png, image/jpeg, image/webp, image/avif">
                        @if($image)
                            <img src="{{ $image->temporaryUrl() }}" class="h-40 rounded-lg object-cover border-2 border-dashed border-green-400" />
                        @elseif($experience?->image_url)
                            <img src="{{ $experience->image_url }}" class="h-40 rounded-lg object-cover border-2 border-dashed border-gray-300" />
                        @else
                            <div class="h-40 w-64 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-700 cursor-pointer hover:border-blue-500 transition-colors">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="mt-2 text-sm text-gray-500 dark:text-gray-400">Click to upload</span>
                            </div>
                        @endif
                    </x-mary-file>
                    
                    @error('image') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    
                    @if($image)
                        <div class="mt-2 flex items-center text-green-600 dark:text-green-400">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm">{{ $image->getClientOriginalName() }}</span>
                            <button type="button" wire:click="removeImage" class="ml-4 text-sm text-red-600 hover:text-red-800 dark:text-red-400">
                                Remove
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Badge -->
                <div>
                    <x-mary-input 
                        label="Badge (Optional)" 
                        wire:model="badge" 
                        placeholder="e.g., Top Spot, Hidden Gem"
                    />
                </div>

                <!-- Order -->
                <div>
                    <x-mary-input 
                        label="Order *" 
                        wire:model="order" 
                        type="number"
                        min="0"
                        required 
                    />
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-4">
                <x-mary-button 
                    label="Cancel" 
                    link="{{ route('admin.experiences.index') }}"
                    class="btn-ghost"
                />
                <x-mary-button 
                    label="{{ $experience ? 'Update' : 'Create' }} Experience" 
                    type="submit"
                    class="btn-primary"
                    spinner="save"
                />
            </div>
        </form>
    </div>
</div>
