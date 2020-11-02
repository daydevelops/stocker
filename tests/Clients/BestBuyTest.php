<?php

namespace Tests\Unit;

use App\Models\Stock;
use App\Models\Retailer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BestBuyTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_tracks_a_product() {
        //given
        // we have a product that is in stock
        
        $product = Product::factory()->create();
        $retailer = Retailer::factory(['name'=>'BestBuy'])->create();
        $stock = Stock::factory([
            'product_id' => $product->id,
            'retailer_id' => $retailer->id,
            'in_stock' => false,
            'sku' => 6359222,
            'price' => 99999,
            'url' => 'https://www.bestbuy.com/site/lenovo-ideapad-1-14-laptop-amd-a6-series-4gb-memory-amd-radeon-r4-64gb-emmc-flash-memory-platinum-gray/6359222.p?skuId=6359222'
        ])->create();

        $retailer->addStock($product, $stock);
        User::factory(['email'=>'adamday1618@gmail.com'])->create();
        $this->artisan('track')->expectsOutput('All Done!');

        $this->assertFalse(Stock::first()->price == 99999);
    }
}
