<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class KategoriTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(): User
    {
        $role = Role::create([
            'name' => 'Admin',
            'permissions' => [
                'kategori.viewAny',
                'kategori.create',
                'kategori.update',
                'kategori.delete',
            ],
        ]);

        return User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
            'role_id' => $role->id,
        ]);
    }

    public function test_user_can_view_category_index()
    {
        $user = $this->createUser();

        Category::create([
            'name' => 'Makanan',
            'description' => 'Kategori makanan',
        ]);

        Category::create([
            'name' => 'Minuman',
            'description' => 'Kategori minuman',
        ]);

        $this->actingAs($user);

        $response = $this->get('/kategori');

        $response->assertStatus(200);
        $response->assertViewIs('pages.kategori.index');
        $response->assertViewHas('categories');
    }

    public function test_user_can_create_category()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $response = $this->post('/kategori', [
            'name' => 'Elektronik',
            'description' => 'Kategori elektronik',
        ]);

        $response->assertRedirect('/kategori');
        $response->assertSessionHas('success', 'Kategori berhasil ditambahkan');

        $this->assertDatabaseHas('categories', [
            'name' => 'Elektronik',
            'description' => 'Kategori elektronik',
        ]);
    }

    public function test_category_validation_fails_with_missing_name()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $response = $this->post('/kategori', [
            'description' => 'Kategori tanpa nama',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_category_validation_fails_with_long_name()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $response = $this->post('/kategori', [
            'name' => str_repeat('a', 256),
            'description' => 'Kategori dengan nama terlalu panjang',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_user_can_view_category_edit_page_with_products()
    {
        $user = $this->createUser();

        $category = Category::create([
            'name' => 'Makanan',
            'description' => 'Kategori makanan',
        ]);

        Product::create([
            'name' => 'Roti',
            'description' => 'Roti enak',
            'sku' => 'SKU001',
            'barcode' => '123456789',
            'price' => 5000,
            'cost_price' => 3000,
            'stock' => 10,
            'category_id' => $category->id,
        ]);

        Product::create([
            'name' => 'Kue',
            'description' => 'Kue lezat',
            'sku' => 'SKU002',
            'barcode' => '987654321',
            'price' => 8000,
            'cost_price' => 5000,
            'stock' => 15,
            'category_id' => $category->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/kategori/' . $category->id . '/edit');

        $response->assertStatus(200);
        $response->assertViewIs('pages.kategori.edit');
        $response->assertViewHas('kategori');
        $response->assertViewHas('products');
    }

    public function test_user_can_update_category()
    {
        $user = $this->createUser();

        $category = Category::create([
            'name' => 'Makanan Lama',
            'description' => 'Lama',
        ]);

        $this->actingAs($user);

        $response = $this->put('/kategori/' . $category->id, [
            'name' => 'Makanan Baru',
            'description' => 'Kategori makanan yang sudah diupdate',
        ]);

        $response->assertRedirect('/kategori');
        $response->assertSessionHas('success', 'Kategori berhasil diupdate');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Makanan Baru',
            'description' => 'Kategori makanan yang sudah diupdate',
        ]);
    }

    public function test_user_can_soft_delete_category()
    {
        $user = $this->createUser();

        $category = Category::create([
            'name' => 'Makanan',
            'description' => 'Kategori makanan',
        ]);

        $this->actingAs($user);

        $response = $this->delete('/kategori/' . $category->id);

        $response->assertRedirect('/kategori');
        $response->assertSessionHas('success', 'Kategori berhasil dihapus');

        $this->assertSoftDeleted('categories', [
            'id' => $category->id,
        ]);
    }

    public function test_category_index_paginates_results()
    {
        $user = $this->createUser();

        // Create 15 categories
        for ($i = 1; $i <= 15; $i++) {
            Category::create([
                'name' => 'Kategori ' . $i,
                'description' => 'Deskripsi kategori ' . $i,
            ]);
        }

        $this->actingAs($user);

        $response = $this->get('/kategori?per_page=10');

        $response->assertStatus(200);
        $response->assertViewIs('pages.kategori.index');
        // Should get first 10 items
        $this->assertCount(10, $response->viewData('categories')->items());
    }

    public function test_category_can_have_multiple_products()
    {
        $category = Category::create([
            'name' => 'Makanan',
            'description' => 'Kategori makanan',
        ]);

        $product1 = Product::create([
            'name' => 'Roti',
            'description' => 'Roti enak',
            'sku' => 'SKU001',
            'barcode' => '123456789',
            'price' => 5000,
            'cost_price' => 3000,
            'stock' => 10,
            'category_id' => $category->id,
        ]);

        $product2 = Product::create([
            'name' => 'Kue',
            'description' => 'Kue lezat',
            'sku' => 'SKU002',
            'barcode' => '987654321',
            'price' => 8000,
            'cost_price' => 5000,
            'stock' => 15,
            'category_id' => $category->id,
        ]);

        $this->assertCount(2, $category->products);
        $this->assertTrue($category->products->contains($product1));
        $this->assertTrue($category->products->contains($product2));
    }
}
