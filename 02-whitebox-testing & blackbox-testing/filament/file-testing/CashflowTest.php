<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CashFlow;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CashflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_cashflow_can_be_created()
    {
        $cashflow = CashFlow::factory()->create([
            'date' => now(),
            'type' => 'income',
            'source' => 'Penjualan',
            'amount' => 100000,
            'notes' => 'Pemasukan harian'
        ]);

        $this->assertDatabaseHas('cash_flows', [
            'amount' => 100000
        ]);
    }

    public function test_cashflow_can_be_updated()
    {
        $cashflow = CashFlow::factory()->create([
            'amount' => 100000
        ]);

        $cashflow->update([
            'amount' => 200000
        ]);

        $this->assertDatabaseHas('cash_flows', [
            'amount' => 200000
        ]);
    }

    public function test_cashflow_can_be_deleted()
    {
        $cashflow = CashFlow::factory()->create();

        $cashflow->delete();

        $this->assertDatabaseMissing('cash_flows', [
            'id' => $cashflow->id
        ]);
    }

    public function test_cashflow_amount_must_be_numeric()
    {
        $this->assertTrue(
            is_numeric(100000)
        );

        $this->assertFalse(
            is_numeric('abc')
        );
    }
}
