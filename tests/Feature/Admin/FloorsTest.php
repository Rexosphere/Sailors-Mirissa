<?php

use App\Models\Floor;
use App\Models\User;
use Database\Seeders\FloorSeeder;
use Livewire\Volt\Volt;

test('floors are seeded with polygon coordinates', function () {
    $this->seed(FloorSeeder::class);

    expect(Floor::count())->toBe(4)
        ->and(Floor::where('slug', 'ground')->first()->coordinates())->toHaveCount(8);
});

test('an admin can rename a floor and change its view', function () {
    $this->seed(FloorSeeder::class);
    $floor = Floor::where('slug', 'third')->first();

    Volt::actingAs(User::factory()->admin()->create())
        ->test('admin.floors.index')
        ->call('edit', $floor->id)
        ->assertSet('editing', true)
        ->assertSet('name', 'Third Floor')
        ->set('name', 'Top Floor')
        ->set('view', 'Sunset View')
        ->call('save')
        ->assertHasNoErrors()
        ->assertSet('editing', false);

    expect($floor->fresh())->name->toBe('Top Floor')->view->toBe('Sunset View')
        ->and($floor->fresh()->coords)->toBe('9,32.7,93,32.7,93,47.6,9,47.6');
});
