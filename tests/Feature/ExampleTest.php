<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_checks_stock_for_a_product() {
        
        $product = Product::factory()->create();
        
        $this->assertFalse($product->inStock());
        // add produuct stock
        $retailer = Retailer::factory()->create();
        $stock = Stock::factory([
            'product_id' => $product->id,
            'retailer_id' => $retailer->id,
            'in_stock' => true
        ])->create();
        
        $retailer->addStock($product,$stock);
        
        $this->assertTrue($product->inStock());
        
    }
}
