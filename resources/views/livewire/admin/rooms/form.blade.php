<?php

use App\Models\Room;
use function Livewire\Volt\{state, mount};

state(['room' => null]);
state(['floor_id' => 'ground']);
state(['floor_name' => '']);
state(['floor_view' => '']);
state(['floor_coords' => '']);
state(['room_number' => 0]);
state(['room_name' => '']);
state(['price' => '']);
state(['description' => '']);
state(['image_url' => '']);
state(['order' => 0]);

mount(function ($id = null) {
    if ($id) {
        $this->room = Room::findOrFail($id);
        $this->floor_id = $this->room->floor_id;
        $this->floor_name = $this->room->floor_name;
        $this->floor_view = $this->room->floor_view;
        $this->floor_coords = $this->room->floor_coords;
        $this->room_number = $this->room->room_number;
        $this->room_name = $this->room->room_name;
        $this->price = $this->room->price;
        $this->description = $this->room->description;
        $this->image_url = $this->room->image_url;
        $this->order = $this->room->order;
    }
});

$save = function () {
    $this->validate([
        'floor_id' => 'required|string',
        'floor_name' => 'required|string|max:255',
        'floor_view' => 'required|string|max:255',
        'floor_coords' => 'required|string',
        'room_number' => 'required|integer',
        'room_name' => 'required|string|max:255',
        'price' => 'required|string|max:255',
        'description' => 'required|string',
        'image_url' => 'required|string',
        'order' => 'required|integer|min:0',
    ]);

    $data = [
        'floor_id' => $this->floor_id,
        'floor_name' => $this->floor_name,
        'floor_view' => $this->floor_view,
        'floor_coords' => $this->floor_coords,
        'room_number' => $this->room_number,
        'room_name' => $this->room_name,
        'price' => $this->price,
        'description' => $this->description,
        'image_url' => $this->image_url,
        'order' => $this->order,
    ];

    if ($this->room) {
        $this->room->update($data);
        session()->flash('success', 'Room updated successfully.');
    } else {
        Room::create($data);
        session()->flash('success', 'Room created successfully.');
    }

    return redirect()->route('admin.rooms.index');
};

?>

<x-layouts.admin-layout>
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            {{ $room ? 'Edit' : 'Create' }} Room
        </h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            {{ $room ? 'Update the room details below' : 'Add a new room to the hotel' }}
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form wire:submit="save">
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
                            <select id="floor_id" wire:model="floor_id"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="ground">Ground Floor</option>
                                <option value="first">First Floor</option>
                                <option value="second">Second Floor</option>
                                <option value="third">Third Floor</option>
                            </select>
                            @error('floor_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Floor Name -->
                        <div>
                            <label for="floor_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Floor Name *
                            </label>
                            <input type="text" id="floor_name" wire:model="floor_name" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="e.g., Ground Floor"
                                required>
                            @error('floor_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Floor View -->
                        <div>
                            <label for="floor_view" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Floor View *
                            </label>
                            <input type="text" id="floor_view" wire:model="floor_view" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="e.g., Garden View, Ocean View"
                                required>
                            @error('floor_view') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Floor Coordinates -->
                        <div>
                            <label for="floor_coords" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Floor Coordinates *
                            </label>
                            <input type="text" id="floor_coords" wire:model="floor_coords" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white font-mono text-sm"
                                placeholder="1282,913,1983,913,1983,1054,1282,1054"
                                required>
                            @error('floor_coords') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Room Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Room Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Room Number -->
                        <div>
                            <label for="room_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Room Number *
                            </label>
                            <input type="number" id="room_number" wire:model="room_number"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="101"
                                required>
                            @error('room_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Room Name -->
                        <div>
                            <label for="room_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Room Name *
                            </label>
                            <input type="text" id="room_name" wire:model="room_name" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Room 101"
                                required>
                            @error('room_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Price *
                            </label>
                            <input type="text" id="price" wire:model="price" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="$120"
                                required>
                            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
                                placeholder="/images/rooms/room.png"
                                required>
                            @error('image_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            @if($image_url)
                                <img src="{{ $image_url }}" alt="Preview" class="mt-2 h-32 rounded border">
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
</x-layouts.admin-layout>
