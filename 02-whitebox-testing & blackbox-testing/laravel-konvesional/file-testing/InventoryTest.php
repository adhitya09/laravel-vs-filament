<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\InventoryItem;
use App\Models\CashFlow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(): User
    {
        $role = Role::create([
            'name' => 'Admin',
            'permissions' => [
                'inventory.viewAny',
                'inventory.create',
                'inventory.update',
                'inventory.delete',
            ],
        ]);

        return User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
            'role_id' => $role->id,
        ]);
    }

    private function createProduct($name = 'Produk', $stock = 100): Product
    {
        $category = Category::create([
            'name' => 'Kategori Test',
        ]);

        return Product::create([
            'name' => $name,
            'description' => 'Produk test',
            'sku' => 'SKU' . uniqid(),
            'barcode' => 'BARCODE' . uniqid(),
            'price' => 10000,
            'cost_price' => 6000,
            'stock' => $stock,
            'category_id' => $category->id,
        ]);
    }

    public function test_user_can_view_inventory_index()
    {
        $user = $this->createUser();

        $product = $this->createProduct();

        Inventory::create([
            'reference_no' => 'INV-20240101-ABC123',
            'type' => 'in',
            'source' => 'Supplier A',
            'notes' => 'Pembelian bulanan',
            'inventory_date' => now(),
            'total_modal' => 100000,
        ]);

        $this->actingAs($user);

        $response = $this->get('/inventory');

        $response->assertStatus(200);
        $response->assertViewIs('pages.inventory.index');
        $response->assertViewHas('inventories');
    }

    public function test_user_can_create_inventory_in_type()
    {
        $user = $this->createUser();
        $product = $this->createProduct('Roti', 0);

        $this->actingAs($user);

        $response = $this->post('/inventory', [
            'type' => 'in',
            'source' => 'Supplier ABC',
            'notes' => 'Pembelian barang',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 50,
                    'cost_price' => 5000,
                ]
            ],
        ]);

        $response->assertRedirect('/inventory');
        $response->assertSessionHas('success', 'Inventory berhasil disimpan');

        // Check inventory was created
        $this->assertDatabaseHas('inventories', [
            'type' => 'in',
            'source' => 'Supplier ABC',
        ]);

        // Check stock was increased
        $product->refresh();
        $this->assertEquals(50, $product->stock);

        // Check inventory item was created
        $inventory = Inventory::first();
        $this->assertDatabaseHas('inventory_items', [
            'inventory_id' => $inventory->id,
            'product_id' => $product->id,
            'quantity' => 50,
        ]);
    }

    public function test_user_can_create_inventory_out_type()
    {
        $user = $this->createUser();
        $product = $this->createProduct('Roti', 100);

        $this->actingAs($user);

        $response = $this->post('/inventory', [
            'type' => 'out',
            'source' => 'Pengeluaran',
            'notes' => 'Pengurangan stok',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 30,
                    'cost_price' => 5000,
                ]
            ],
        ]);

        $response->assertRedirect('/inventory');
        $response->assertSessionHas('success', 'Inventory berhasil disimpan');

        // Check stock was decreased
        $product->refresh();
        $this->assertEquals(70, $product->stock);

        // Check cash flow was created for OUT type
        $this->assertDatabaseHas('cash_flows', [
            'type' => 'OUT',
            'amount' => 150000, // 30 * 5000
            'source' => 'Pembelian Inventory',
        ]);
    }

    public function test_user_can_create_inventory_adjustment_type()
    {
        $user = $this->createUser();
        $product = $this->createProduct('Roti', 100);

        $this->actingAs($user);

        $response = $this->post('/inventory', [
            'type' => 'adjustment',
            'source' => 'Penyesuaian',
            'notes' => 'Stok opname',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 80,
                    'cost_price' => null,
                ]
            ],
        ]);

        $response->assertRedirect('/inventory');
        $response->assertSessionHas('success', 'Inventory berhasil disimpan');

        // Check stock was adjusted to exact amount
        $product->refresh();
        $this->assertEquals(80, $product->stock);
    }

    public function test_inventory_validation_fails_with_missing_required_fields()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $response = $this->post('/inventory', []);

        $response->assertSessionHasErrors([
            'type',
            'source',
            'items',
        ]);
    }

    public function test_inventory_validation_fails_with_empty_items()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $response = $this->post('/inventory', [
            'type' => 'in',
            'source' => 'Supplier',
            'items' => [],
        ]);

        $response->assertSessionHasErrors('items');
    }

    public function test_inventory_validation_fails_with_invalid_product()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $response = $this->post('/inventory', [
            'type' => 'in',
            'source' => 'Supplier',
            'items' => [
                [
                    'product_id' => 9999,
                    'quantity' => 10,
                ]
            ],
        ]);

        $response->assertSessionHasErrors();
    }

    public function test_inventory_fails_if_stock_insufficient_for_out_type()
    {
        $user = $this->createUser();
        $product = $this->createProduct('Roti', 10);

        $this->actingAs($user);

        $response = $this->post('/inventory', [
            'type' => 'out',
            'source' => 'Pengeluaran',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 50, // More than available stock
                ]
            ],
        ]);

        $response->assertSessionHasErrors('error');

        // Stock should remain unchanged
        $product->refresh();
        $this->assertEquals(10, $product->stock);
    }

    public function test_user_can_view_inventory_detail()
    {
        $user = $this->createUser();
        $product = $this->createProduct();

        $inventory = Inventory::create([
            'reference_no' => 'INV-20240101-ABC123',
            'type' => 'in',
            'source' => 'Supplier A',
            'notes' => 'Pembelian bulanan',
            'inventory_date' => now(),
            'total_modal' => 100000,
        ]);

        InventoryItem::create([
            'inventory_id' => $inventory->id,
            'product_id' => $product->id,
            'quantity' => 10,
            'cost_price' => 10000,
        ]);

        $this->actingAs($user);

        $response = $this->get('/inventory/' . $inventory->id);

        $response->assertStatus(200);
        $response->assertViewIs('pages.inventory.show');
        $response->assertViewHas('inventory');
    }

    public function test_user_can_view_inventory_edit_page()
    {
        $user = $this->createUser();
        $product = $this->createProduct();

        $inventory = Inventory::create([
            'reference_no' => 'INV-20240101-ABC123',
            'type' => 'in',
            'source' => 'Supplier A',
            'notes' => 'Pembelian bulanan',
            'inventory_date' => now(),
            'total_modal' => 100000,
        ]);

        $this->actingAs($user);

        $response = $this->get('/inventory/' . $inventory->id . '/edit');

        $response->assertStatus(200);
        $response->assertViewIs('pages.inventory.edit');
        $response->assertViewHas('inventory');
        $response->assertViewHas('products');
    }

    public function test_user_can_delete_inventory_and_reverse_stock_changes()
    {
        $user = $this->createUser();
        $product = $this->createProduct('Roti', 100);

        $this->actingAs($user);

        // Create inventory IN
        $response = $this->post('/inventory', [
            'type' => 'in',
            'source' => 'Supplier',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 50,
                ]
            ],
        ]);

        $product->refresh();
        $this->assertEquals(150, $product->stock);

        $inventory = Inventory::first();

        // Delete inventory
        $deleteResponse = $this->delete('/inventory/' . $inventory->id);

        $deleteResponse->assertRedirect('/inventory');
        $deleteResponse->assertSessionHas('success', 'Inventory berhasil dihapus');

        // Check stock was reversed
        $product->refresh();
        $this->assertEquals(100, $product->stock);
    }

    public function test_inventory_generates_unique_reference_number()
    {
        $product = $this->createProduct();

        Inventory::create([
            'reference_no' => 'INV-20240101-ABC123',
            'type' => 'in',
            'source' => 'Supplier A',
            'inventory_date' => now(),
        ]);

        Inventory::create([
            'reference_no' => 'INV-20240102-DEF456',
            'type' => 'in',
            'source' => 'Supplier B',
            'inventory_date' => now(),
        ]);

        $this->assertCount(2, Inventory::all());
        $this->assertNotEquals(
            Inventory::find(1)->reference_no,
            Inventory::find(2)->reference_no
        );
    }

    public function test_inventory_search_by_reference_no()
    {
        $user = $this->createUser();
        $product = $this->createProduct();

        Inventory::create([
            'reference_no' => 'INV-20240101-ABC123',
            'type' => 'in',
            'source' => 'Supplier A',
            'inventory_date' => now(),
        ]);

        Inventory::create([
            'reference_no' => 'INV-20240102-XYZ789',
            'type' => 'out',
            'source' => 'Pengeluaran',
            'inventory_date' => now(),
        ]);

        $this->actingAs($user);

        $response = $this->get('/inventory?search=ABC123');

        $response->assertStatus(200);
        $results = $response->viewData('inventories');
        $this->assertCount(1, $results);
    }

    public function test_inventory_with_multiple_items()
    {
        $user = $this->createUser();
        $product1 = $this->createProduct('Roti', 100);
        $product2 = $this->createProduct('Kue', 50);

        $this->actingAs($user);

        $response = $this->post('/inventory', [
            'type' => 'in',
            'source' => 'Supplier',
            'items' => [
                [
                    'product_id' => $product1->id,
                    'quantity' => 30,
                    'cost_price' => 5000,
                ],
                [
                    'product_id' => $product2->id,
                    'quantity' => 20,
                    'cost_price' => 8000,
                ]
            ],
        ]);

        $response->assertRedirect('/inventory');

        $inventory = Inventory::first();
        $this->assertEquals(2, $inventory->inventoryItems->count());
        $this->assertEquals(30 * 5000 + 20 * 8000, $inventory->total_modal);

        // Check both products' stock changed
        $product1->refresh();
        $product2->refresh();
        $this->assertEquals(130, $product1->stock);
        $this->assertEquals(70, $product2->stock);
    }
}
