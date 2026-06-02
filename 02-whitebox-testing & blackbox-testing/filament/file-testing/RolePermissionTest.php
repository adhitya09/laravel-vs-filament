<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

it('creates a role', function () {
    $role = Role::create([
        'name' => 'manager',
        'guard_name' => 'web',
    ]);

    $this->assertDatabaseHas('roles', [
        'id' => $role->id,
        'name' => 'manager',
    ]);
});

it('creates a permission', function () {
    $permission = Permission::create([
        'name' => 'view_any_role',
        'guard_name' => 'web',
    ]);

    $this->assertDatabaseHas('permissions', [
        'id' => $permission->id,
        'name' => 'view_any_role',
    ]);
});

it('assigns a permission to a role', function () {
    $permission = Permission::create([
        'name' => 'view_any_role',
        'guard_name' => 'web',
    ]);

    $role = Role::create([
        'name' => 'manager',
        'guard_name' => 'web',
    ]);

    $role->givePermissionTo($permission);

    $this->assertTrue($role->hasPermissionTo('view_any_role'));
});

it('assigns a role to a user', function () {
    $role = Role::create([
        'name' => 'manager',
        'guard_name' => 'web',
    ]);

    $user = User::factory()->create();
    $user->assignRole($role);

    $this->assertTrue($user->hasRole('manager'));
});

it('allows a user with role permissions to access the role page', function () {
    $permission = Permission::create([
        'name' => 'view_any_role',
        'guard_name' => 'web',
    ]);

    $role = Role::create([
        'name' => 'manager',
        'guard_name' => 'web',
    ]);
    $role->givePermissionTo($permission);

    $user = User::factory()->create();
    $user->assignRole($role);

    $this->actingAs($user);

    $this->get('/shield/roles')->assertSuccessful();
});

it('denies access to role page for users without permission', function () {
    $role = Role::create([
        'name' => 'karyawan',
        'guard_name' => 'web',
    ]);

    $user = User::factory()->create();
    $user->assignRole($role);

    $this->actingAs($user);

    $this->get('/shield/roles')->assertForbidden();
});

it('updates a role', function () {
    $role = Role::create([
        'name' => 'staff',
        'guard_name' => 'web',
    ]);

    $role->update(['name' => 'supervisor']);

    $this->assertDatabaseHas('roles', [
        'id' => $role->id,
        'name' => 'supervisor',
    ]);
});

it('deletes an unused role', function () {
    $role = Role::create([
        'name' => 'temporary-role',
        'guard_name' => 'web',
    ]);

    $role->delete();

    $this->assertDatabaseMissing('roles', [
        'name' => 'temporary-role',
    ]);
});

it('has a valid dashboard permission', function () {
    $permission = Permission::firstOrCreate([
        'name' => '_Dashboard',
        'guard_name' => 'web',
    ]);

    $this->assertDatabaseHas('permissions', [
        'name' => '_Dashboard',
    ]);
});

it('has a valid product permission', function () {
    $permission = Permission::firstOrCreate([
        'name' => 'view_any_product',
        'guard_name' => 'web',
    ]);

    $this->assertDatabaseHas('permissions', [
        'name' => 'view_any_product',
    ]);
});

it('has a valid user permission', function () {
    $permission = Permission::firstOrCreate([
        'name' => 'view_any_user',
        'guard_name' => 'web',
    ]);

    $this->assertDatabaseHas('permissions', [
        'name' => 'view_any_user',
    ]);
});

it('has a valid role permission', function () {
    $permission = Permission::firstOrCreate([
        'name' => 'view_any_role',
        'guard_name' => 'web',
    ]);

    $this->assertDatabaseHas('permissions', [
        'name' => 'view_any_role',
    ]);
});
