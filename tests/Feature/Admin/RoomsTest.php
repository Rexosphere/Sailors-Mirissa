<?php

use App\Models\Floor;
use App\Models\Room;
use App\Models\User;
use Database\Seeders\FloorSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Volt;

beforeEach(function () {
    $this->seed(FloorSeeder::class);
    $this->admin = User::factory()->admin()->create();
    Storage::fake('public_uploads');
});

function fixtureUpload(string $name): UploadedFile
{
    return UploadedFile::fake()->createWithContent($name, file_get_contents(base_path('tests/Fixtures/'.$name)));
}

test('rooms index lists rooms grouped by floor', function () {
    $floor = Floor::where('slug', 'first')->first();
    Room::create(['floor_id' => $floor->id, 'room_number' => 201, 'room_name' => 'Room 201', 'price' => '$150', 'description' => 'Sea breeze', 'image_url' => '/images/rooms/first_floor_1.png', 'sort_order' => 1]);

    $this->actingAs($this->admin)
        ->get(route('admin.rooms.index'))
        ->assertOk()
        ->assertSee('First Floor')
        ->assertSee('Room 201');
});

test('an admin can create a room with an avif photo', function () {
    $floor = Floor::where('slug', 'ground')->first();

    Volt::actingAs($this->admin)
        ->test('admin.rooms.form')
        ->set('floor_id', $floor->id)
        ->set('room_number', 105)
        ->set('room_name', 'Room 105')
        ->set('price', '$130')
        ->set('description', 'Quiet garden corner.')
        ->set('sort_order', 0)
        ->set('image', fixtureUpload('tiny.avif'))
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.rooms.index'));

    $room = Room::where('room_number', 105)->firstOrFail();
    expect($room->floor_id)->toBe($floor->id)
        ->and($room->image_url)->toStartWith('/images/rooms/room-105-')
        ->and($room->image_url)->toEndWith('.avif');
    Storage::disk('public_uploads')->assertExists(ltrim($room->image_url, '/'));
});

test('a room photo must be an image format browsers can show', function () {
    $floor = Floor::where('slug', 'ground')->first();

    Volt::actingAs($this->admin)
        ->test('admin.rooms.form')
        ->set('floor_id', $floor->id)
        ->set('room_number', 106)
        ->set('room_name', 'Room 106')
        ->set('price', '$130')
        ->set('description', 'Test')
        ->set('image', UploadedFile::fake()->createWithContent('photo.heic', random_bytes(512)))
        ->call('save')
        ->assertHasErrors(['image' => 'mimes']);

    expect(Room::count())->toBe(0);
});

test('a new room needs a photo', function () {
    Volt::actingAs($this->admin)
        ->test('admin.rooms.form')
        ->set('room_number', 107)
        ->set('room_name', 'Room 107')
        ->set('price', '$130')
        ->set('description', 'Test')
        ->call('save')
        ->assertHasErrors(['image' => 'required']);
});

test('editing a room keeps the photo unless a new one is uploaded', function () {
    $floor = Floor::where('slug', 'second')->first();
    $room = Room::create(['floor_id' => $floor->id, 'room_number' => 301, 'room_name' => 'Room 301', 'price' => '$180', 'description' => 'Ocean', 'image_url' => '/images/rooms/first_floor_1.png', 'sort_order' => 3]);

    Volt::actingAs($this->admin)
        ->test('admin.rooms.form', ['id' => $room->id])
        ->assertSet('room_name', 'Room 301')
        ->set('price', '$190')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.rooms.index'));

    expect($room->fresh()->price)->toBe('$190')
        ->and($room->fresh()->image_url)->toBe('/images/rooms/first_floor_1.png');
});

test('deleting a room removes its uploaded photo', function () {
    $floor = Floor::where('slug', 'ground')->first();
    Storage::disk('public_uploads')->put('images/rooms/room-108.png', 'png');
    $room = Room::create(['floor_id' => $floor->id, 'room_number' => 108, 'room_name' => 'Room 108', 'price' => '$100', 'description' => 'Test', 'image_url' => '/images/rooms/room-108.png', 'sort_order' => 1]);

    Volt::actingAs($this->admin)
        ->test('admin.rooms.index')
        ->call('confirmDelete', $room->id)
        ->assertSet('confirmingDelete', true)
        ->call('delete')
        ->assertSet('confirmingDelete', false);

    expect(Room::find($room->id))->toBeNull();
    Storage::disk('public_uploads')->assertMissing('images/rooms/room-108.png');
});

test('deleting a room keeps a photo shared with another room', function () {
    $floor = Floor::where('slug', 'ground')->first();
    Storage::disk('public_uploads')->put('images/rooms/shared.png', 'png');
    $a = Room::create(['floor_id' => $floor->id, 'room_number' => 109, 'room_name' => 'A', 'price' => '$1', 'description' => 'x', 'image_url' => '/images/rooms/shared.png', 'sort_order' => 1]);
    Room::create(['floor_id' => $floor->id, 'room_number' => 110, 'room_name' => 'B', 'price' => '$1', 'description' => 'x', 'image_url' => '/images/rooms/shared.png', 'sort_order' => 2]);

    Volt::actingAs($this->admin)->test('admin.rooms.index')->call('confirmDelete', $a->id)->call('delete');

    Storage::disk('public_uploads')->assertExists('images/rooms/shared.png');
});

test('non-admins cannot open the rooms admin', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('admin.rooms.create'))
        ->assertRedirect(route('home'));
});
