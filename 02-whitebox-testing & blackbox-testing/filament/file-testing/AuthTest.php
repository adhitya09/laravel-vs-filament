<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_panel()
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_user_without_role_cannot_access_panel()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertForbidden();
    }

    public function test_admin_role_still_cannot_access_without_permissions()
    {
        Role::create(['name' => 'admin']);

        $user = User::factory()->create();

        $user->assignRole('admin');

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertForbidden();
    }
}
