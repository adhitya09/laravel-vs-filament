<?php

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

it('allows admin with user permission to access users page', function () {
    $permission = Permission::firstOrCreate([
        'name' => 'view_any_user',
        'guard_name' => 'web',
    ]);

    $role = Role::firstOrCreate([
        'name' => 'admin',
        'guard_name' => 'web',
    ]);
    $role->givePermissionTo($permission);

    $user = User::factory()->create();
    $user->assignRole($role);

    $this->actingAs($user);

    $this->get('/users')->assertSuccessful();
});

it('denies access to users page for user without permission', function () {
    $role = Role::create([
        'name' => 'cashier',
        'guard_name' => 'web',
    ]);

    $user = User::factory()->create();
    $user->assignRole($role);

    $this->actingAs($user);

    $this->get('/users')->assertForbidden();
});

it('redirects guest to login when accessing users page', function () {
    $this->get('/users')->assertRedirect('/login');
});

it('creates a new user and hashes the password', function () {
    $user = User::create([
        'name' => 'Test User',
        'email' => 'test.user@example.com',
        'password' => 'plain-password',
    ]);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'email' => 'test.user@example.com',
    ]);

    expect(Hash::check('plain-password', $user->password))->toBeTrue();
});

it('updates user data', function () {
    $user = User::factory()->create([
        'name' => 'Original Name',
        'email' => 'original@example.com',
    ]);

    $user->update([
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ]);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ]);
});

it('deletes a user', function () {
    $user = User::factory()->create();

    $user->delete();

    $this->assertDatabaseMissing('users', [
        'id' => $user->id,
    ]);
});

it('requires unique email for users', function () {
    User::factory()->create([
        'email' => 'duplicate@example.com',
    ]);

    $this->expectException(QueryException::class);

    User::create([
        'name' => 'Duplicate Email',
        'email' => 'duplicate@example.com',
        'password' => 'other-password',
    ]);
});

it('hashes passwords when saving a user', function () {
    $user = User::create([
        'name' => 'Hash User',
        'email' => 'hash@example.com',
        'password' => 'secret-password',
    ]);

    expect(Hash::check('secret-password', $user->password))->toBeTrue();
});
