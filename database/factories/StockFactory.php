<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Stock::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'price'=>rand(1,50),
            'sku'=>rand(1000000,100000000000),
            'url'=>$this->faker->url,
            'in_stock' => $this->faker->boolean,
            'product_id' => Product::factory(),
            'retailer_id' => Retailer::factory()
        ];
    }
}
