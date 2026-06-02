<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_setting_can_be_created()
    {
        $setting = Setting::factory()->create([
            'name' => 'POS Filament',
            'phone' => '08123456789',
            'address' => 'Balikpapan'
        ]);

        $this->assertDatabaseHas('settings', [
            'name' => 'POS Filament'
        ]);
    }

    public function test_setting_can_be_updated()
    {
        $setting = Setting::factory()->create([
            'name' => 'Old Store'
        ]);

        $setting->update([
            'name' => 'New Store'
        ]);

        $this->assertDatabaseHas('settings', [
            'name' => 'New Store'
        ]);
    }

    public function test_setting_can_be_deleted()
    {
        $setting = Setting::factory()->create();

        $setting->delete();

        $this->assertDatabaseMissing('settings', [
            'id' => $setting->id
        ]);
    }

    public function test_setting_phone_can_be_saved()
    {
        $setting = Setting::factory()->create([
            'phone' => '08123456789'
        ]);

        $this->assertEquals(
            '08123456789',
            $setting->phone
        );
    }
}
