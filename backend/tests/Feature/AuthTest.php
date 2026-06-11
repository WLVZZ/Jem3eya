<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('issues access and refresh tokens for valid credentials', function (): void {
    $role = Role::create(['slug' => 'super-admin', 'name' => 'Super Admin']);
    $user = User::create([
        'name_ar' => 'مدير',
        'username' => 'admin',
        'email' => 'admin@example.com',
        'password' => Hash::make('secret123'),
        'status' => 'active',
    ]);
    $user->roles()->attach($role);

    $this->postJson('/api/v1/auth/login', [
        'username' => 'admin',
        'password' => 'secret123',
    ])
        ->assertOk()
        ->assertJsonPath('tokens.token_type', 'Bearer')
        ->assertJsonStructure(['tokens' => ['access_token', 'refresh_token']]);
});
