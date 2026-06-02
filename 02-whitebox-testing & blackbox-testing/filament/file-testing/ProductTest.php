<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_has_default_stock_zero()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'stock' => 0
        ]);

        $this->assertEquals(
            0,
            $product->stock
        );
    }

    public function test_product_price_must_be_numeric()
    {
        $this->assertFalse(
            is_numeric('abc')
        );

        $this->assertTrue(
            is_numeric(10000)
        );
    }

    public function test_product_can_be_soft_deleted()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id
        ]);

        $product->delete();

        $this->assertSoftDeleted($product);
    }

    public function test_product_active_status_can_be_true()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'is_active' => true
        ]);

        $this->assertTrue(
            $product->is_active
        );
    }
}
