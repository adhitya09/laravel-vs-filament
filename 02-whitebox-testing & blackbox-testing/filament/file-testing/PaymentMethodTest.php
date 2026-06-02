<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_method_can_be_created()
    {
        $payment = PaymentMethod::factory()->create([
            'name' => 'Cash',
            'is_cash' => true
        ]);

        $this->assertDatabaseHas('payment_methods', [
            'name' => 'Cash'
        ]);
    }

    public function test_payment_method_can_be_updated()
    {
        $payment = PaymentMethod::factory()->create([
            'name' => 'Cash',
            'is_cash' => true
        ]);

        $payment->update([
            'name' => 'QRIS'
        ]);

        $this->assertDatabaseHas('payment_methods', [
            'name' => 'QRIS'
        ]);
    }

    public function test_payment_method_can_be_deleted()
    {
        $payment = PaymentMethod::factory()->create();

        $payment->delete();

        $this->assertSoftDeleted($payment);
    }

    public function test_payment_method_is_cash_field_can_be_saved()
    {
        $payment = PaymentMethod::factory()->create([
            'name' => 'Cash',
            'is_cash' => true,
        ]);

        $this->assertTrue($payment->is_cash);
        $this->assertDatabaseHas('payment_methods', [
            'name' => 'Cash',
            'is_cash' => 1,
        ]);
    }
}
