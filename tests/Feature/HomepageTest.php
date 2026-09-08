<?php

use App\Models\Floor;
use App\Models\Room;
use Database\Seeders\FloorSeeder;
use Database\Seeders\RoomSeeder;

test('the homepage renders every floor even when a new room sorts first', function () {
    $this->seed([FloorSeeder::class, RoomSeeder::class]);
    $ground = Floor::where('slug', 'ground')->first();
    Room::create(['floor_id' => $ground->id, 'room_number' => 105, 'room_name' => 'Room 105', 'price' => '$130', 'description' => 'New', 'image_url' => '/images/rooms/x.png', 'sort_order' => 0]);

    $response = $this->get('/')->assertOk();

    $floors = collect(json_decode(str($response->getContent())->after('const floors = ')->before(';')->toString(), true));
    expect($floors)->toHaveCount(4)
        ->and($floors->firstWhere('id', 'ground')['band'])->toEqual(['x' => 9, 'y' => 76.4, 'w' => 84, 'h' => 12])
        ->and($floors->firstWhere('id', 'ground')['rooms'][0]['name'])->toBe('Room 105');
});

test('the homepage is a full-screen snap page with every section in order', function () {
    $this->seed([FloorSeeder::class, RoomSeeder::class]);

    $response = $this->get('/')->assertOk();
    $html = $response->getContent();

    $response->assertSeeInOrder([
        'id="featured_header"',
        'id="interactive-map"',
        'id="floor-booking"',
        'id="attractions"',
        'id="journey"',
        'id="site-footer"',
    ], false);

    expect(substr_count($html, 'data-fp-section'))->toBe(6)
        ->and(substr_count($html, 'data-fp-next'))->toBe(6)
        ->and($html)->toContain('<html lang="en" class="fp-snap">')
        ->and($html)->toContain('id="main-header" data-theme="dark"')
        ->and(preg_match('/(?<![\\w-])w-screen(?![\\w-])/', $html))->toBe(0);
});

test('other pages do not snap', function () {
    $this->get('/experiences')->assertOk()->assertDontSee('fp-snap');
});

test('booking buttons fall back to an email enquiry until BOOKING_URL is set', function () {
    config(['site.booking_url' => null]);
    $this->get('/')->assertSee('href="mailto:sailors.mirissa@gmail.com"', false);

    config(['site.booking_url' => 'https://example.com/book']);
    $this->get('/')
        ->assertSee('href="https://example.com/book"', false)
        ->assertSee('target="_blank" rel="noopener"', false);
});
