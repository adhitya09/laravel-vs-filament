<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Livewire\Pos;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PosAdvancedTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_add_product_to_order()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 10000,
            'stock' => 10,
            'is_active' => true,
        ]);

        Livewire::test(Pos::class)
            ->call('addToOrder', $product->id)
            ->assertCount('order_items', 1);
    }

    public function test_duplicate_product_increases_quantity()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 10000,
            'stock' => 10,
            'is_active' => true,
        ]);

        Livewire::test(Pos::class)
            ->call('addToOrder', $product->id)
            ->call('addToOrder', $product->id)
            ->assertSet('order_items.0.quantity', 2);
    }

    public function test_can_increase_quantity()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 10000,
            'stock' => 10,
            'is_active' => true,
        ]);

        Livewire::test(Pos::class)
            ->call('addToOrder', $product->id)
            ->call('increaseQuantity', $product->id)
            ->assertSet('order_items.0.quantity', 2);
    }

    public function test_can_decrease_quantity()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 10000,
            'stock' => 10,
            'is_active' => true,
        ]);

        Livewire::test(Pos::class)
            ->call('addToOrder', $product->id)
            ->call('increaseQuantity', $product->id)
            ->call('decreaseQuantity', $product->id)
            ->assertSet('order_items.0.quantity', 1);
    }

    public function test_decrease_quantity_removes_item_if_quantity_one()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 10000,
            'stock' => 10,
            'is_active' => true,
        ]);

        Livewire::test(Pos::class)
            ->call('addToOrder', $product->id)
            ->call('decreaseQuantity', $product->id)
            ->assertSet('order_items', []);
    }

    public function test_can_calculate_total()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 10000,
            'stock' => 10,
            'is_active' => true,
        ]);

        Livewire::test(Pos::class)
            ->call('addToOrder', $product->id)
            ->call('increaseQuantity', $product->id)
            ->call('calculateTotal')
            ->assertSet('total_price', 20000);
    }

    public function test_invalid_cash_results_zero_change()
    {
        Livewire::test(Pos::class)
            ->set('total_price', 50000)
            ->set('cash_received', '10000')
            ->call('calculateChange')
            ->assertSet('change', 0);
    }

    public function test_can_reset_order()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 10000,
            'stock' => 10,
            'is_active' => true,
        ]);

        Livewire::test(Pos::class)
            ->call('addToOrder', $product->id)
            ->call('resetOrder')
            ->assertSet('order_items', [])
            ->assertSet('total_price', 0);
    }

    public function test_quantity_does_not_exceed_stock()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 10000,
            'stock' => 1,
            'is_active' => true,
        ]);

        Livewire::test(Pos::class)
            ->call('addToOrder', $product->id)
            ->call('increaseQuantity', $product->id)
            ->assertSet('order_items.0.quantity', 1);
    }
}
