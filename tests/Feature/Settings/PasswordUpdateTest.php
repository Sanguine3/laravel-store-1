<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('authenticated user can update password', function () {
    $user = User::factory()->create([
        'password' => Hash::make('old-password'),
    ]);

    $this->actingAs($user);

    $response = $this->put(route('settings.password.update'), [
        'current_password' => 'old-password',
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertRedirect(route('settings.password'));
    expect(Hash::check('new-password', $user->refresh()->password))->toBeTrue();
});

test('invalid current password fails to update password', function () {
    $user = User::factory()->create([
        'password' => Hash::make('old-password'),
    ]);

    $this->actingAs($user);

    $response = $this->from(route('settings.password'))
        ->put(route('settings.password.update'), [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response->assertRedirect(route('settings.password'));
    $response->assertSessionHasErrors('current_password');
    expect(Hash::check('old-password', $user->refresh()->password))->toBeTrue();
});
