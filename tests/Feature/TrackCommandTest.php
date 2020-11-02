<?php

namespace Tests\Feature;

use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use App\Notifications\NewStockAvailable;
use Illuminate\Support\Facades\Notification;

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
            return ['onlineAvailability' => true,'salePrice' => 1234];
        });
        $this->artisan('track')->expectsOutput('All Done!');

        //then
        // the stock details should be refreshed
        $this->assertTrue(Product::first()->inStock());
    }

    /** @test */
    public function a_user_is_notified_if_the_stock_changes() {
        $this->seed(RetailerWithProductSeeder::class);
        Http::fake(function () {
            return ['onlineAvailability' => true,'salePrice' => 1234];
        });
        Notification::fake();

        $this->artisan('track')->expectsOutput('All Done!');
        Notification::assertSentTo(User::first(), NewStockAvailable::class);
    }

    /** @test */
    public function a_user_is_not_notified_if_the_stock_is_unchanged() {
        $this->seed(RetailerWithProductSeeder::class);
        Http::fake(function () {
            $stock = Stock::first();
            return ['onlineAvailability' => $stock->in_stock,'salePrice' => $stock->price];
        });
        Notification::fake();

        $this->artisan('track')->expectsOutput('All Done!');
        Notification::assertNothingSent();
    }
}
