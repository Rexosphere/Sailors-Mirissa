<?php

use App\Models\Experience;
use App\Models\MapPoint;
use App\Models\Room;
use App\Models\User;
use Database\Seeders\ExperienceSeeder;
use Database\Seeders\FloorSeeder;
use Database\Seeders\MapPointSeeder;
use Database\Seeders\RoomSeeder;

beforeEach(function () {
    $this->seed([FloorSeeder::class, RoomSeeder::class, ExperienceSeeder::class, MapPointSeeder::class]);
    $this->actingAs(User::factory()->admin()->create());
});

test('every admin page renders through the admin layout', function (string $route, array $params, string $expected) {
    $params = array_map(fn ($param) => $param instanceof Closure ? $param() : $param, $params);

    $this->get(route($route, $params))
        ->assertOk()
        ->assertSee('data-theme="sailors"', false)
        ->assertSee($expected);
})->with([
    'dashboard' => ['admin.dashboard', [], 'Quick actions'],
    'floors' => ['admin.floors.index', [], 'Panoramic Ocean View'],
    'rooms' => ['admin.rooms.index', [], 'Room 404'],
    'room create' => ['admin.rooms.create', [], 'New room'],
    'room edit' => ['admin.rooms.edit', ['id' => fn () => Room::first()->id], 'Edit room'],
    'experiences' => ['admin.experiences.index', [], 'Coconut Tree Hill'],
    'experience create' => ['admin.experiences.create', [], 'New experience'],
    'experience edit' => ['admin.experiences.edit', ['id' => fn () => Experience::first()->id], 'Edit experience'],
    'map points' => ['admin.map-points.index', [], 'Turtle Beach'],
    'map point create' => ['admin.map-points.create', [], 'New map point'],
    'map point edit' => ['admin.map-points.edit', ['id' => fn () => MapPoint::first()->id], 'Edit map point'],
]);
