<?php

use App\Models\Room;
use function Livewire\Volt\{state};

state('rooms', fn() => Room::all()->groupBy('floor_id')->toArray());

$confirmDelete = function ($id) {
    Room::find($id)->delete();
    session()->flash('success', 'Room deleted successfully.');
    return redirect()->route('admin.rooms.index');
};

?>

<x-layouts.admin-layout>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Rooms</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Manage hotel rooms by floor</p>
        </div>
        <a href="{{ route('admin.rooms.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Add New Room
        </a>
    </div>

    @forelse($rooms as $floorId => $floorRooms)
        @php
            $firstRoom = is_array($floorRooms) ? collect($floorRooms)->first() : $floorRooms->first();
        @endphp
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="bg-gray-50 dark:bg-gray-900 px-6 py-3 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $firstRoom['floor_name'] ?? $firstRoom->floor_name }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $firstRoom['floor_view'] ?? $firstRoom->floor_view }}</p>
            </div>
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Room</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Order</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($floorRooms as $room)
                        @php
                            $roomData = is_array($room) ? $room : $room;
                        @endphp
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ is_array($roomData) ? $roomData['room_name'] : $roomData->room_name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 truncate max-w-md">{{ is_array($roomData) ? $roomData['description'] : $roomData->description }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ is_array($roomData) ? $roomData['price'] : $roomData->price }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ is_array($roomData) ? $roomData['order'] : $roomData->order }}</td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <a href="{{ route('admin.rooms.edit', is_array($roomData) ? $roomData['id'] : $roomData->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                <button type="button" wire:click="confirmDelete({{ is_array($roomData) ? $roomData['id'] : $roomData->id }})" class="text-red-600 hover:text-red-900 cursor-pointer">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @empty
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center text-gray-500 dark:text-gray-400">
            No rooms found.
        </div>
    @endforelse
</x-layouts.admin-layout>
