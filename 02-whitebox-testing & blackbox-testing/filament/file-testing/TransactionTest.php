<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\TransactionItem;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_stock_decreases_when_transaction_item_created()
    {
        $product = Product::factory()->create([
            'stock' => 10
        ]);

        TransactionItem::factory()->create([
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        // 10 - 2 = 8

        $this->assertEquals(
            8,
            $product->fresh()->stock
        );
    }

    public function test_stock_updates_when_transaction_item_updated()
    {
        $product = Product::factory()->create([
            'stock' => 10
        ]);

        $transactionItem =
            TransactionItem::factory()->create([
                'product_id' => $product->id,
                'quantity' => 2
            ]);

        // stock sekarang 8

        $transactionItem->update([
            'quantity' => 4
        ]);

        // observer:
        // +2 lalu -4
        // hasil akhir = 6

        $this->assertEquals(
            6,
            $product->fresh()->stock
        );
    }

    public function test_stock_returns_when_transaction_item_deleted()
    {
        $product = Product::factory()->create([
            'stock' => 10
        ]);

        $transactionItem =
            TransactionItem::factory()->create([
                'product_id' => $product->id,
                'quantity' => 2
            ]);

        // stock sekarang 8

        $transactionItem->delete();

        // stock kembali jadi 10

        $this->assertEquals(
            10,
            $product->fresh()->stock
        );
    }

    public function test_product_with_trashed_relationship_returns_deleted_product()
    {
        $product = Product::factory()->create([
            'stock' => 10,
        ]);

        $transactionItem = TransactionItem::factory()->create([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $product->delete();

        $this->assertNotNull($transactionItem->productWithTrashed);
        $this->assertEquals($product->id, $transactionItem->productWithTrashed->id);
    }

    public function test_transaction_number_is_generated_when_transaction_created()
    {
        $paymentMethod = \App\Models\PaymentMethod::factory()->create();

        $transaction = \App\Models\Transaction::create([
            'payment_method_id' => $paymentMethod->id,
            'name' => 'Test Customer',
            'total' => 10000,
            'cash_received' => 10000,
            'change' => 0,
        ]);

        $this->assertStringStartsWith('TRX', $transaction->transaction_number);
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'transaction_number' => $transaction->transaction_number,
        ]);
    }

    //     public function test_stock_can_become_negative()
    // {
    //     $product = Product::factory()->create([
    //         'stock' => 1
    //     ]);

    //     TransactionItem::factory()->create([
    //         'product_id' => $product->id,
    //         'quantity' => 5
    //     ]);

    //     $this->assertEquals(
    //         -4,
    //         $product->fresh()->stock
    //     );
    // }

        public function test_transaction_fails_if_stock_not_enough()
    {
        $this->expectException(\Exception::class);

        $product = Product::factory()->create([
            'stock' => 1
        ]);

        TransactionItem::factory()->create([
            'product_id' => $product->id,
            'quantity' => 5
        ]);
    }
}
