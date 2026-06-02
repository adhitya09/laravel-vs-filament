<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use App\Models\TransactionItem;
use App\Livewire\Pos;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PosCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_creates_transaction()
    {
        $category = Category::factory()->create();

        $paymentMethod = PaymentMethod::factory()->create([
            'is_cash' => true,
        ]);

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 10000,
            'cost_price' => 5000,
            'stock' => 10,
            'is_active' => true,
        ]);

        Livewire::test(Pos::class)
            ->call('addToOrder', $product->id)
            ->set('payment_method_id', $paymentMethod->id)
            ->set('cash_received', '20000')
            ->call('checkout');

        $this->assertDatabaseCount('transactions', 1);
    }

    public function test_checkout_creates_transaction_items()
    {
        $category = Category::factory()->create();

        $paymentMethod = PaymentMethod::factory()->create([
            'is_cash' => true,
        ]);

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 10000,
            'cost_price' => 5000,
            'stock' => 10,
            'is_active' => true,
        ]);

        Livewire::test(Pos::class)
            ->call('addToOrder', $product->id)
            ->set('payment_method_id', $paymentMethod->id)
            ->set('cash_received', '20000')
            ->call('checkout');

        $this->assertDatabaseCount('transaction_items', 1);
    }

    public function test_checkout_reduces_product_stock()
    {
        $category = Category::factory()->create();

        $paymentMethod = PaymentMethod::factory()->create([
            'is_cash' => true,
        ]);

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 10000,
            'cost_price' => 5000,
            'stock' => 10,
            'is_active' => true,
        ]);

        Livewire::test(Pos::class)
            ->call('addToOrder', $product->id)
            ->set('payment_method_id', $paymentMethod->id)
            ->set('cash_received', '20000')
            ->call('checkout');

        $product->refresh();

        $this->assertEquals(9, $product->stock);
    }

    public function test_checkout_fails_if_cart_empty()
    {
        $paymentMethod = PaymentMethod::factory()->create([
            'is_cash' => true,
        ]);

        Livewire::test(Pos::class)
            ->set('payment_method_id', $paymentMethod->id)
            ->set('cash_received', '20000')
            ->call('checkout');

        $this->assertDatabaseCount('transactions', 0);
    }

    public function test_checkout_fails_if_cash_less_than_total()
    {
        $category = Category::factory()->create();

        $paymentMethod = PaymentMethod::factory()->create([
            'is_cash' => true,
        ]);

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 10000,
            'cost_price' => 5000,
            'stock' => 10,
            'is_active' => true,
        ]);

        Livewire::test(Pos::class)
            ->call('addToOrder', $product->id)
            ->set('payment_method_id', $paymentMethod->id)
            ->set('cash_received', '1000')
            ->call('checkout');

        $this->assertDatabaseCount('transactions', 0);
    }

    public function test_checkout_resets_order_after_success()
    {
        $category = Category::factory()->create();

        $paymentMethod = PaymentMethod::factory()->create([
            'is_cash' => true,
        ]);

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 10000,
            'cost_price' => 5000,
            'stock' => 10,
            'is_active' => true,
        ]);

        Livewire::test(Pos::class)
            ->call('addToOrder', $product->id)
            ->set('payment_method_id', $paymentMethod->id)
            ->set('cash_received', '20000')
            ->call('checkout')
            ->assertSet('order_items', [])
            ->assertSet('total_price', 0);
    }

    public function test_checkout_saves_payment_method_and_amounts()
    {
        $category = Category::factory()->create();

        $paymentMethod = PaymentMethod::factory()->create([
            'is_cash' => true,
        ]);

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 15000,
            'cost_price' => 5000,
            'stock' => 10,
            'is_active' => true,
        ]);

        Livewire::test(Pos::class)
            ->call('addToOrder', $product->id)
            ->set('payment_method_id', $paymentMethod->id)
            ->set('cash_received', '20000')
            ->call('checkout');

        $this->assertDatabaseHas('transactions', [
            'payment_method_id' => $paymentMethod->id,
            'total' => 15000,
            'cash_received' => 20000,
            'change' => 5000,
        ]);
    }
}
