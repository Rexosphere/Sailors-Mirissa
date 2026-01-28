<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('homepage');
})->name('home');

Route::get('/location', function () {
    return view('location');
})->name('location');

Route::get('/accommodation', function () {
    return view('accommodation');
})->name('accommodation');

Route::get('/experiences', function () {
    return view('experiences');
})->name('experiences');

Route::get('/experience/{slug}', function (string $slug) {
    $experiences = config('experiences');
    
    if (!isset($experiences[$slug])) {
        abort(404);
    }
    
    return view('experience', ['item' => $experiences[$slug]]);
})->name('experience');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Volt::route('/', 'admin.dashboard')->name('dashboard');
    
    // Experiences
    Volt::route('/experiences', 'admin.experiences.index')->name('experiences.index');
    Volt::route('/experiences/create', 'admin.experiences.form')->name('experiences.create');
    Volt::route('/experiences/{id}/edit', 'admin.experiences.form')->name('experiences.edit');
    
    // Map Points
    Volt::route('/map-points', 'admin.map-points.index')->name('map-points.index');
    Volt::route('/map-points/create', 'admin.map-points.form')->name('map-points.create');
    Volt::route('/map-points/{id}/edit', 'admin.map-points.form')->name('map-points.edit');
    
    // Rooms
    Volt::route('/rooms', 'admin.rooms.index')->name('rooms.index');
    Volt::route('/rooms/create', 'admin.rooms.form')->name('rooms.create');
    Volt::route('/rooms/{id}/edit', 'admin.rooms.form')->name('rooms.edit');
});

require __DIR__.'/auth.php';
