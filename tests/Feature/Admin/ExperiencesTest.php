<?php

use App\Models\Experience;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Volt;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
    Storage::fake('public_uploads');
});

test('an admin can create and delete an experience', function () {
    Volt::actingAs($this->admin)
        ->test('admin.experiences.form')
        ->set('title', 'Secret Beach')
        ->set('alt_text', 'A hidden cove')
        ->set('description', 'Quiet sand and clear water.')
        ->set('badge', 'Hidden Gem')
        ->set('sort_order', 2)
        ->set('image', UploadedFile::fake()->createWithContent('beach.webp', file_get_contents(base_path('tests/Fixtures/tiny.webp'))))
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.experiences.index'));

    $experience = Experience::where('title', 'Secret Beach')->firstOrFail();
    expect($experience->image_url)->toStartWith('/images/experiences/secret-beach-')
        ->and($experience->badge)->toBe('Hidden Gem')
        ->and($experience->icon)->toBeNull();
    Storage::disk('public_uploads')->assertExists(ltrim($experience->image_url, '/'));

    Volt::actingAs($this->admin)
        ->test('admin.experiences.index')
        ->call('confirmDelete', $experience->id)
        ->call('delete');

    expect(Experience::count())->toBe(0);
    Storage::disk('public_uploads')->assertMissing(ltrim($experience->image_url, '/'));
});

test('experiences are rendered on the homepage in order', function () {
    Experience::create(['title' => 'Second', 'description' => 'b', 'image_url' => '/images/b.png', 'alt_text' => 'b', 'sort_order' => 2]);
    Experience::create(['title' => 'First', 'description' => 'a', 'image_url' => '/images/a.png', 'alt_text' => 'a', 'sort_order' => 1]);

    $this->get('/')->assertOk()->assertSeeInOrder(['First', 'Second']);
});
