<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
});

test('non-admin users are sent back to the homepage', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('admin.dashboard'))->assertRedirect(route('home'));
});

test('admins can visit the dashboard', function () {
    $this->actingAs(User::factory()->admin()->create());

    $this->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Dashboard')
        ->assertSee(route('admin.rooms.index'));
});
