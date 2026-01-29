<?php

use App\Models\MapPoint;
use function Livewire\Volt\{state};

state('mapPoints', fn() => MapPoint::all());

$confirmDelete = function ($id) {
    MapPoint::find($id)->delete();
    session()->flash('success', 'Map point deleted successfully.');
    return redirect()->route('admin.map-points.index');
};

?>

<x-layouts.admin-layout>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Map Points</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Manage interactive map landmarks</p>
        </div>
        <a href="{{ route('admin.map-points.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Add New Map Point
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-900">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Center (X, Y)</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($mapPoints as $point)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $point->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 truncate max-w-md">{{ $point->description }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                            {{ $point->center_x }}, {{ $point->center_y }}
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <a href="{{ route('admin.map-points.edit', $point->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                            <button type="button" wire:click="confirmDelete({{ $point->id }})" class="text-red-600 hover:text-red-900 cursor-pointer">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            No map points found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin-layout>
