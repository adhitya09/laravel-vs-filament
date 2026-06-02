<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Setting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(): User
    {
        $role = Role::create([
            'name' => 'Admin',
            'permissions' => [
                'setting.viewAny',
                'setting.update',
            ],
        ]);

        return User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
            'role_id' => $role->id,
        ]);
    }

    public function test_user_can_view_setting_page()
    {
        $user = $this->createUser();

        Setting::create([
            'store_name' => 'Toko Kami',
            'store_address' => 'Jl. Merdeka 123',
            'store_phone' => '081234567890',
            'print_type' => 'kabel',
        ]);

        $this->actingAs($user);

        $response = $this->get('/setting');

        $response->assertStatus(200);
        $response->assertViewIs('pages.setting.index');
        $response->assertViewHas('setting');
    }

    public function test_user_can_update_setting()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $response = $this->put('/setting', [
            'store_name' => 'Toko Baru',
            'store_address' => 'Jl. Sudirman 456',
            'store_phone' => '082345678901',
            'print_type' => 'bluetooth',
            'printer_name' => 'Printer1',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Setting berhasil disimpan');

        $this->assertDatabaseHas('settings', [
            'id' => 1,
            'store_name' => 'Toko Baru',
            'store_address' => 'Jl. Sudirman 456',
            'store_phone' => '082345678901',
            'print_type' => 'bluetooth',
        ]);
    }

    public function test_user_can_upload_store_logo()
    {
        Storage::fake('public');

        $user = $this->createUser();

        $this->actingAs($user);

        $response = $this->put('/setting', [
            'store_name' => 'Toko Baru',
            'store_address' => 'Jl. Sudirman 456',
            'store_phone' => '082345678901',
            'print_type' => 'kabel',
            'store_logo' => UploadedFile::fake()->image('logo.png'),
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $setting = Setting::first();

        $this->assertNotNull($setting->store_logo);

        Storage::disk('public')->assertExists($setting->store_logo);
    }

    public function test_setting_validation_fails_with_missing_required_fields()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $response = $this->put('/setting', []);

        $response->assertSessionHasErrors([
            'store_name',
            'store_address',
            'store_phone',
            'print_type',
        ]);
    }

    public function test_setting_validation_fails_with_invalid_print_type()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $response = $this->put('/setting', [
            'store_name' => 'Toko',
            'store_address' => 'Alamat',
            'store_phone' => '081234567890',
            'print_type' => 'invalid_type',
        ]);

        $response->assertSessionHasErrors('print_type');
    }

    public function test_setting_validation_fails_with_invalid_image()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $response = $this->put('/setting', [
            'store_name' => 'Toko',
            'store_address' => 'Alamat',
            'store_phone' => '081234567890',
            'print_type' => 'kabel',
            'store_logo' => UploadedFile::fake()->create('logo.txt', 3000),
        ]);

        $response->assertSessionHasErrors('store_logo');
    }

    public function test_old_logo_is_deleted_when_new_logo_uploaded()
    {
        Storage::fake('public');

        $user = $this->createUser();

        // Create initial setting with logo
        $oldLogo = UploadedFile::fake()->image('old_logo.png');
        $this->actingAs($user);
        $this->put('/setting', [
            'store_name' => 'Toko',
            'store_address' => 'Alamat',
            'store_phone' => '081234567890',
            'print_type' => 'kabel',
            'store_logo' => $oldLogo,
        ]);

        $oldSetting = Setting::first();
        $oldLogoPath = $oldSetting->store_logo;

        // Upload new logo
        $newLogo = UploadedFile::fake()->image('new_logo.png');
        $response = $this->put('/setting', [
            'store_name' => 'Toko Baru',
            'store_address' => 'Alamat Baru',
            'store_phone' => '082345678901',
            'print_type' => 'bluetooth',
            'store_logo' => $newLogo,
        ]);

        $response->assertRedirect();

        // Old logo should not exist
        Storage::disk('public')->assertMissing($oldLogoPath);

        // New logo should exist
        $newSetting = Setting::first();
        $this->assertNotEquals($oldLogoPath, $newSetting->store_logo);
        Storage::disk('public')->assertExists($newSetting->store_logo);
    }
}
