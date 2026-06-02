<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_can_count_transactions()
    {
        $payment = PaymentMethod::factory()->create();

        Transaction::factory()->count(5)->create([
            'payment_method_id' => $payment->id
        ]);

        $this->assertEquals(
            5,
            Transaction::count()
        );
    }

    public function test_dashboard_can_calculate_total_income()
    {
        $payment = PaymentMethod::factory()->create();

        Transaction::factory()->create([
            'payment_method_id' => $payment->id,
            'total' => 100000
        ]);

        Transaction::factory()->create([
            'payment_method_id' => $payment->id,
            'total' => 50000
        ]);

        $income = Transaction::sum('total');

        $this->assertEquals(
            150000,
            $income
        );
    }

    public function test_dashboard_can_get_latest_transaction()
    {
        $payment = PaymentMethod::factory()->create();

        Transaction::factory()->count(3)->create([
            'payment_method_id' => $payment->id
        ]);

        $latest = Transaction::latest()->first();

        $this->assertNotNull($latest);
    }
}
