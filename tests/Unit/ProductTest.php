<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_checks_stock_for_a_product() {
        
        $this->seed(RetailerWithProductSeeder::class);
        
        $this->assertFalse(Product::first()->inStock());
        Stock::first()->update(['in_stock'=>true]);
        $this->assertTrue(Product::first()->inStock());
        
    }
}
