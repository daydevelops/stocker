<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class TrackCommandTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_tracks_a_product()
    {
        //given
        // we have a product that is in stock
        $product = Product::factory()->create();

        $this->assertFalse($product->inStock());
        // add produuct stock
        $retailer = Retailer::factory(['name'=>'bestbuy'])->create();
        $stock = Stock::factory([
            'product_id' => $product->id,
            'retailer_id' => $retailer->id,
            'in_stock' => false
        ])->create();

        $retailer->addStock($product, $stock);
        $this->assertFalse($stock->fresh()->in_stock);

        //when
        // I trigger the artisan command assuming the stock is available now
        Http::fake(function () {
            return [
                'available' => true,
                'price' => 1234
            ];
        });
        $this->artisan('track');

        //then
        // the stock details should be refreshed
        $this->assertTrue($stock->fresh()->in_stock);
    }
}
