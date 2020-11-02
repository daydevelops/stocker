<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\User;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class RetailerWithProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = Product::factory()->create();
        $retailer = Retailer::factory(['name'=>'BestBuy'])->create();
        $stock = Stock::factory([
            'product_id' => $product->id,
            'retailer_id' => $retailer->id,
            'in_stock' => false
        ])->create();

        $retailer->addStock($product, $stock);

        User::factory(['email'=>'adamday1618@gmail.com'])->create();
    }
}
