<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $retailer = Retailer::create(['name' => 'BestBuy']);
        $product = Product::create(['name' => 'laptop']);
        $retailer->addStock($product, \App\Models\Stock::create([
            'product_id' => $product->id,
            'retailer_id' => $retailer->id,
            'price' => 999900,
            'sku' => 6359222,
            'url' => 'test',
            'in_stock' => true
        ]));
    }
}
