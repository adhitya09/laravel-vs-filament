<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\InventoryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InventoryObserverTest extends TestCase
{
    use RefreshDatabase;

    public function test_inventory_item_increases_product_stock()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'stock' => 10,
        ]);

        $inventory = Inventory::create([
            'type' => 'in',
            'source' => 'manual',
            'total' => 5,
            'notes' => 'Tambah stok',
        ]);

        InventoryItem::create([
            'inventory_id' => $inventory->id,
            'product_id' => $product->id,
            'quantity' => 5,
            'cost_price' => 10000,
        ]);

        $product->refresh();

        $this->assertEquals(15, $product->stock);
    }

    public function test_inventory_item_reduces_product_stock()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'stock' => 20,
        ]);

        $inventory = Inventory::create([
            'type' => 'out',
            'source' => 'manual',
            'total' => 5,
            'notes' => 'Barang keluar',
        ]);

        InventoryItem::create([
            'inventory_id' => $inventory->id,
            'product_id' => $product->id,
            'quantity' => 5,
            'cost_price' => 10000,
        ]);

        $product->refresh();

        $this->assertEquals(15, $product->stock);
    }

    public function test_inventory_item_adjustment_updates_stock()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'stock' => 50,
        ]);

        $inventory = Inventory::create([
            'type' => 'adjustment',
            'source' => 'manual',
            'total' => 30,
            'notes' => 'Stock opname',
        ]);

        InventoryItem::create([
            'inventory_id' => $inventory->id,
            'product_id' => $product->id,
            'quantity' => 30,
            'cost_price' => 10000,
        ]);

        $product->refresh();

        $this->assertEquals(30, $product->stock);
    }

    public function test_inventory_item_delete_restores_stock_for_in_type()
    {
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'stock' => 10,
        ]);

        $inventory = Inventory::create([
            'type' => 'in',
            'source' => 'manual',
            'total' => 5,
            'notes' => 'Tambah stok',
        ]);

        $inventoryItem = InventoryItem::create([
            'inventory_id' => $inventory->id,
            'product_id' => $product->id,
            'quantity' => 5,
            'cost_price' => 10000,
        ]);

        $inventoryItem->delete();

        $this->assertEquals(10, $product->fresh()->stock);
    }

    public function test_inventory_reference_number_is_generated()
    {
        $inventory = Inventory::create([
            'type' => 'in',
            'source' => 'manual',
            'total' => 5,
            'notes' => 'Tambah stok',
        ]);

        $this->assertStringStartsWith('INV-', $inventory->reference_number);
        $this->assertMatchesRegularExpression('/INV-\d{8}-\d{2}/', $inventory->reference_number);
    }
}
