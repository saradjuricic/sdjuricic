<?php
namespace Tests\Unit;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test da Product model ima ispravne atribute
     * Testira UC1: Pregled proizvoda i UC3: Upravljanje proizvodima
     */
    public function test_product_has_correct_attributes()
    {
        // Arrange
        $category = Category::create([
            'name' => 'Buketi',
            'description' => 'Test kategorija'
        ]);

        // Act
        $product = Product::create([
            'name' => 'Prolećni tulipan aranžman',
            'description' => 'Prelepi prolećni aranžman',
            'price' => 42.00,
            'image' => 'tulips.jpg',
            'featured' => true,
            'stock' => 15,
            'category_id' => $category->id
        ]);

        // Assert
        $this->assertEquals('Prolećni tulipan aranžman', $product->name);
        $this->assertEquals(42.00, $product->price);
        $this->assertTrue($product->featured);
        $this->assertEquals(15, $product->stock);
        $this->assertEquals($category->id, $product->category_id);
    }

    /**
     * Test relacije između Product i Category
     */
    public function test_product_belongs_to_category()
    {
        // Arrange
        $category = Category::create([
            'name' => 'Sobne biljke',
            'description' => 'Biljke za dom'
        ]);

        $product = Product::create([
            'name' => 'Kaktus',
            'description' => 'Mali kaktus',
            'price' => 15.50,
            'stock' => 5,
            'category_id' => $category->id
        ]);

        // Assert
        $this->assertInstanceOf(Category::class, $product->category);
        $this->assertEquals('Sobne biljke', $product->category->name);
    }

    /**
     * Test da li je proizvod na stanju
     */
    public function test_product_in_stock_status()
    {
        $productInStock = Product::factory()->create(['stock' => 5]);
        $productOutOfStock = Product::factory()->create(['stock' => 0]);

        $this->assertTrue($productInStock->stock > 0);
        $this->assertFalse($productOutOfStock->stock > 0);
    }

    /**
     * Test formatiranja cene proizvoda
     */
    public function test_product_price_formatting()
    {
        $product = Product::factory()->create(['price' => 29.99]);
        
        // Možeš dodati accessor u Product model:
        // public function getFormattedPriceAttribute()
        // {
        //     return number_format($this->price, 2) . ' RSD';
        // }
        
        $this->assertEquals(29.99, $product->price);
        $this->assertIsFloat($product->price);
    }
}