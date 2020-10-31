<?php

namespace Tests\Feature;

use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use App\Models\Product;

class TrackCommandTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_tracks_a_product()
    {
        //given
        // we have a product that is in stock
        $this->seed(RetailerWithProductSeeder::class);
        $this->assertFalse(Product::first()->inStock());

        //when
        // I trigger the artisan command assuming the stock is available now
        Http::fake(function () {
            return ['available' => true,'price' => 1234];
        });
        $this->artisan('track')->expectsOutput('All Done!');

        //then
        // the stock details should be refreshed
        $this->assertTrue(Product::first()->inStock());
    }
}
