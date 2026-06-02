<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReceiptControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_receipt_page_can_be_accessed()
    {
        $paymentMethod = PaymentMethod::factory()->create();

        $transaction = Transaction::factory()->create([
            'payment_method_id' => $paymentMethod->id,
        ]);

        $response = $this->get('/receipt/' . $transaction->id);

        $response->assertSuccessful();
    }

    public function test_receipt_download_can_be_accessed()
    {
        $paymentMethod = PaymentMethod::factory()->create();

        $transaction = Transaction::factory()->create([
            'payment_method_id' => $paymentMethod->id,
        ]);

        $response = $this->get('/receipt/' . $transaction->id . '/download');

        $response->assertSuccessful();
    }

    public function test_receipt_has_transaction_items()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
        ]);

        $paymentMethod = PaymentMethod::factory()->create();

        $transaction = Transaction::factory()->create([
            'payment_method_id' => $paymentMethod->id,
        ]);

        TransactionItem::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 10000,
            'cost_price' => 5000,
            'total_profit' => 10000,
        ]);

        $this->assertCount(
            1,
            $transaction->transactionItems
        );
    }

    public function test_invalid_receipt_returns_404()
    {
        $response = $this->get('/receipt/99999');

        $response->assertNotFound();
    }

    public function test_invalid_receipt_download_returns_404()
    {
        $response = $this->get('/receipt/99999/download');

        $response->assertNotFound();
    }
    public function test_receipt_page_displays_transaction_item()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'name' => 'Produk Receipt',
        ]);

        $paymentMethod = PaymentMethod::factory()->create();

        $transaction = Transaction::factory()->create([
            'payment_method_id' => $paymentMethod->id,
        ]);

        TransactionItem::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 10000,
            'cost_price' => 5000,
            'total_profit' => 5000,
        ]);

        $response = $this->get('/receipt/' . $transaction->id);

        $response->assertSuccessful();
        $response->assertSee('Produk Receipt');
    }

    public function test_receipt_download_returns_pdf()
    {
        $paymentMethod = PaymentMethod::factory()->create();

        $transaction = Transaction::factory()->create([
            'payment_method_id' => $paymentMethod->id,
        ]);

        $response = $this->get('/receipt/' . $transaction->id . '/download');

        $response->assertSuccessful();
        $this->assertStringContainsString('application/pdf', $response->headers->get('content-type'));
    }}
