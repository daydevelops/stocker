<?php

namespace Tests\Feature;

use App\Models\History;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ProductHistoryTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_records_history_when_stock_is_tracked() {
        // given we have stock that can be tracked
        $this->seed(RetailerWithProductSeeder::class);

        // when we track the stock
        Http::fake(function () {
            return ['onlineAvailability' => true,'salePrice' => 1234];
        });

        $this->assertEquals(0,History::count());
        $this->artisan('track');
        $this->assertEquals(1,History::count());
    }
}
