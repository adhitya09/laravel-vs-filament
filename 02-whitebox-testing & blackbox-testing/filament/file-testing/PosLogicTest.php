<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Livewire\Pos;
use Livewire\Livewire;
use App\Models\Product;
use App\Models\Category;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PosLogicTest extends TestCase
{
    use RefreshDatabase;

    public function test_calculate_total_price_correctly()
    {
        Livewire::test(Pos::class)
            ->set('order_items', [
                [
                    'product_id' => 1,
                    'name' => 'Produk A',
                    'price' => 10000,
                    'cost_price' => 5000,
                    'total_profit' => 5000,
                    'quantity' => 2,
                    'image_url' => null
                ],
                [
                    'product_id' => 2,
                    'name' => 'Produk B',
                    'price' => 5000,
                    'cost_price' => 2000,
                    'total_profit' => 3000,
                    'quantity' => 1,
                    'image_url' => null
                ]
            ])
            ->call('calculateTotal')
            ->assertSet('total_price', 25000);
    }

    public function test_change_calculation_correct()
    {
        Livewire::test(Pos::class)
            ->set('total_price', 20000)
            ->set('cash_received', '50000')
            ->call('calculateChange')
            ->assertSet('change', 30000);
    }

    public function test_change_becomes_zero_if_cash_less_than_total()
    {
        Livewire::test(Pos::class)
            ->set('total_price', 50000)
            ->set('cash_received', '10000')
            ->call('calculateChange')
            ->assertSet('change', 0);
    }

    public function test_cannot_add_quantity_more_than_stock()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'stock' => 1,
            'name' => 'Produk Test',
            'price' => 10000,
            'cost_price' => 5000,
        ]);

        Livewire::test(Pos::class)
            ->set('order_items', [
                [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'cost_price' => $product->cost_price,
                    'total_profit' => $product->price - $product->cost_price,
                    'quantity' => 1,
                    'image_url' => null
                ]
            ])
            ->call('increaseQuantity', $product->id)
            ->assertSet('order_items.0.quantity', 1);
    }

    public function test_checkout_fails_if_cart_empty()
    {
        $paymentMethod = PaymentMethod::factory()->create();

        Livewire::test(Pos::class)
            ->set('payment_method_id', $paymentMethod->id)
            ->call('checkout')
            ->assertSet('showCheckoutModal', false);
    }
}
