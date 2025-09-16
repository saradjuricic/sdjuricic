<?php
namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_order_successfully()
    {
        // Arrange - pripremi test podatke
        $user = User::factory()->create([
            'name' => 'Ana Marković',
            'email' => 'ana@example.com',
            'role' => 'user'
        ]);

        $category = Category::create([
            'name' => 'Buketi',
            'description' => 'Prekrasni buketi'
        ]);

        $product = Product::create([
            'name' => 'Red Rose Bouquet',
            'description' => 'Prelepi buket crvenih ruža',
            'price' => 29.99,
            'stock' => 10,
            'category_id' => $category->id
        ]);

        // Act - izvrši akciju (kreira narudžbinu)
        $this->actingAs($user);
        
        $response = $this->post('/orders', [
            'products' => [
                [
                    'id' => $product->id,
                    'quantity' => 1
                ]
            ]
        ]);

        // Assert - proveri rezultate
        $response->assertStatus(302); // redirect nakon uspešne narudžbine
        
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total' => 29.99,
            'status' => 'pending'
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 29.99
        ]);

        // Proveri da li su zalihe smanjene
        $product->refresh();
        $this->assertEquals(9, $product->stock);
    }

    public function test_order_cannot_be_created_without_products()
    {
        $user = User::factory()->create();
        
        $this->actingAs($user);
        
        $response = $this->post('/orders', [
            'products' => []
        ]);

        $response->assertStatus(422); // validation error
        $this->assertDatabaseMissing('orders', [
            'user_id' => $user->id
        ]);
    }
}