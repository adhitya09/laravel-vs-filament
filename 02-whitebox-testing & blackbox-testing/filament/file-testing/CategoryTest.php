<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_can_be_created()
    {
        $category = Category::factory()->create([
            'name' => 'Makanan'
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'Makanan'
        ]);
    }

    public function test_category_can_be_updated()
    {
        $category = Category::factory()->create([
            'name' => 'Minuman'
        ]);

        $category->update([
            'name' => 'Snack'
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'Snack'
        ]);
    }

    public function test_category_can_be_deleted()
    {
        $category = Category::factory()->create();

        $category->delete();

        $this->assertSoftDeleted($category);
    }

    public function test_category_has_products_relation()
    {
        $category = Category::factory()->create();

        Product::factory()->count(3)->create([
            'category_id' => $category->id
        ]);

        $this->assertCount(
            3,
            $category->products
        );
    }
}
