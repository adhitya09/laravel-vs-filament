<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ProductAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_products_page()
    {
        $response = $this->get('/products');

        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_products_page()
    {
        // permission product
        $permission = Permission::firstOrCreate([
            'name' => 'view_any_product',
            'guard_name' => 'web',
        ]);

        // role admin
        $role = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        // assign permission
        $role->givePermissionTo($permission);

        // create user
        $user = User::factory()->create();

        $user->assignRole($role);

        // login
        $this->actingAs($user);

        // akses products
        $response = $this->get('/products');

        $response->assertSuccessful();
    }

    public function test_cashier_cannot_access_products_page()
    {
        // role cashier tanpa permission
        $role = Role::firstOrCreate([
            'name' => 'cashier',
            'guard_name' => 'web',
        ]);

        // create user
        $user = User::factory()->create();

        $user->assignRole($role);

        // login
        $this->actingAs($user);

        // akses products
        $response = $this->get('/products');

        // forbidden
        $response->assertForbidden();
    }

    public function test_user_with_product_permission_can_access_products_page()
    {
        $permission = Permission::firstOrCreate([
            'name' => 'view_any_product',
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

        $response = $this->get('/products');

        $response->assertSuccessful();
    }
}
