<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('authenticated user can update profile', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $payload = [
        'name' => 'Updated Name',
        'email' => $user->email,
    ];

    $response = $this->patch(route('settings.profile.update'), $payload);

    $response->assertRedirect();
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Updated Name',
    ]);
}); 