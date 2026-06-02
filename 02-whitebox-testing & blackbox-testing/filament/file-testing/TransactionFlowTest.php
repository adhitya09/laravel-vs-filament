<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_transaction_has_transaction_items()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id
        ]);

        $paymentMethod = PaymentMethod::factory()->create();

        $transaction = Transaction::factory()->create([
            'payment_method_id' => $paymentMethod->id
        ]);

        TransactionItem::factory()->create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id
        ]);

        $this->assertCount(
            1,
            $transaction->transactionItems
        );
    }

    public function test_transaction_belongs_to_payment_method()
    {
        $paymentMethod = PaymentMethod::factory()->create([
            'name' => 'Cash'
        ]);

        $transaction = Transaction::factory()->create([
            'payment_method_id' => $paymentMethod->id
        ]);

        $this->assertEquals(
            'Cash',
            $transaction->paymentMethod->name
        );
    }

    public function test_transaction_item_belongs_to_product()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'name' => 'Laptop'
        ]);

        $transactionItem = TransactionItem::factory()->create([
            'product_id' => $product->id
        ]);

        $this->assertEquals(
            'Laptop',
            $transactionItem->product->name
        );
    }

    public function test_transaction_item_can_access_deleted_product()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'name' => 'Mouse'
        ]);

        $transactionItem = TransactionItem::factory()->create([
            'product_id' => $product->id
        ]);

        // soft delete product
        $product->delete();

        $this->assertEquals(
            'Mouse',
            $transactionItem->productWithTrashed->name
        );
    }
}
