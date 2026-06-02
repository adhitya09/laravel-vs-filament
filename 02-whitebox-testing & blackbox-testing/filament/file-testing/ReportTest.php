<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_transaction_total_can_be_calculated()
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

        $total = Transaction::sum('total');

        $this->assertEquals(
            150000,
            $total
        );
    }

    public function test_report_can_filter_transactions()
    {
        $payment = PaymentMethod::factory()->create();

        Transaction::factory()->count(3)->create([
            'payment_method_id' => $payment->id
        ]);

        $transactions = Transaction::latest()->get();

        $this->assertCount(
            3,
            $transactions
        );
    }

        public function test_report_can_get_latest_transaction()
    {
        $payment = PaymentMethod::factory()->create();

        Transaction::factory()->count(2)->create([
            'payment_method_id' => $payment->id
        ]);

        $latest = Transaction::latest()->first();

        $this->assertNotNull($latest);
    }

    public function test_report_can_calculate_average_transaction_total()
    {
        $payment = PaymentMethod::factory()->create();

        Transaction::factory()->create([
            'payment_method_id' => $payment->id,
            'total' => 80000,
        ]);

        Transaction::factory()->create([
            'payment_method_id' => $payment->id,
            'total' => 120000,
        ]);

        $this->assertEquals(
            100000,
            Transaction::average('total')
        );
    }
}
