<?php

namespace Tests\Unit;

use App\Models\Stock;
use App\Models\Retailer;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_throws_exception_for_untrackable_client()
    {
        $this->seed(RetailerWithProductSeeder::class);
        Retailer::first()->update(['name' => 'foobar']);
        $this->expectException(\Exception::class);
        Stock::first()->track();
    }
}
