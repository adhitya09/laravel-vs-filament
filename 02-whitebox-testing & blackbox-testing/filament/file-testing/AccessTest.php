<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;

class AccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_dashboard()
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_dashboard()
    {
        // ambil permission dashboard asli
        $permission = Permission::firstOrCreate([
            'name' => '_Dashboard',
            'guard_name' => 'web',
        ]);

        // buat role admin
        $role = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        // assign permission
        $role->givePermissionTo($permission);

        // buat user
        $user = User::factory()->create();

        // assign role
        $user->assignRole($role);

        // login
        $this->actingAs($user);

        // akses dashboard
        $response = $this->get('/');

        $response->assertSuccessful();
    }

    public function test_guest_cannot_access_products_page()
    {
        $response = $this->get('/products');

        $response->assertRedirect('/login');
    }

        public function test_user_without_permission_cannot_access_dashboard()
    {
        // buat role tanpa permission
        $role = Role::create([
            'name' => 'cashier',
            'guard_name' => 'web',
        ]);

        // buat user
        $user = User::factory()->create();

        // assign role cashier
        $user->assignRole($role);

        // login
        $this->actingAs($user);

        // akses dashboard
        $response = $this->get('/');

        // harus forbidden
        $response->assertForbidden();
    }

    public function test_user_without_role_cannot_access_panel()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertForbidden();
    }

    public function test_admin_without_dashboard_permission_cannot_access_dashboard()
    {
        $role = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $user = User::factory()->create();
        $user->assignRole($role);
        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertForbidden();
    }

    public function test_user_with_dashboard_permission_can_access_dashboard()
    {
        $permission = Permission::firstOrCreate([
            'name' => '_Dashboard',
            'guard_name' => 'web',
        ]);

        $role = Role::firstOrCreate([
            'name' => 'cashier',
            'guard_name' => 'web',
        ]);
        $role->givePermissionTo($permission);

        $user = User::factory()->create();
        $user->assignRole($role);

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertSuccessful();
    }

    public function test_dashboard_route_and_permission_are_valid()
    {
        Permission::firstOrCreate([
            'name' => '_Dashboard',
            'guard_name' => 'web',
        ]);

        $this->assertTrue(Route::has('filament.admin.pages.dashboard'));
    }
}
