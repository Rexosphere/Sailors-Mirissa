<?php

use App\Models\MapPoint;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Volt;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
    Storage::fake('public_uploads');
});

test('a map point needs a position on the map', function () {
    Volt::actingAs($this->admin)
        ->test('admin.map-points.form')
        ->set('name', 'Harbour')
        ->set('description', 'Boats')
        ->set('image', UploadedFile::fake()->createWithContent('harbour.png', file_get_contents(base_path('tests/Fixtures/tiny.png'))))
        ->call('save')
        ->assertHasErrors(['center_x' => 'required', 'center_y' => 'required']);
});

test('an admin can place a map point with an icon', function () {
    Volt::actingAs($this->admin)
        ->test('admin.map-points.form')
        ->set('name', 'Harbour')
        ->set('description', 'Whale watching boats leave from here.')
        ->set('center_x', 4000)
        ->set('center_y', 3000)
        ->set('image', UploadedFile::fake()->createWithContent('harbour.jpg', file_get_contents(base_path('tests/Fixtures/tiny.jpg'))))
        ->set('icon_file', UploadedFile::fake()->createWithContent('icon.png', file_get_contents(base_path('tests/Fixtures/tiny.png'))))
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.map-points.index'));

    $point = MapPoint::where('name', 'Harbour')->firstOrFail();
    expect($point->coords)->toBe('4000,2850,4150,3000,4000,3150,3850,3000')
        ->and($point->icon)->toContain('<img src="/images/icons/harbour-icon-')
        ->and($point->image_url)->toStartWith('/images/map-points/harbour-');
});

test('editing without moving keeps the drawn polygon', function () {
    $point = MapPoint::create(['name' => 'Beach', 'coords' => '1,2,3,4,5,6', 'center_x' => 100, 'center_y' => 200, 'image_url' => '/images/b.png', 'description' => 'Sand']);

    Volt::actingAs($this->admin)
        ->test('admin.map-points.form', ['id' => $point->id])
        ->set('description', 'Golden sand')
        ->call('save')
        ->assertHasNoErrors();

    expect($point->fresh()->coords)->toBe('1,2,3,4,5,6')
        ->and($point->fresh()->description)->toBe('Golden sand');
});
