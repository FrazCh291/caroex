<?php

namespace Database\Factories;

use App\Models\Stock;
use App\Models\Product;
use App\Models\Warehouse;
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
            'product_id' => Product::factory()->create()->id,
            'warehouse_id' => Warehouse::factory()->create()->id,
            'quantity' => $this->faker->numberBetween($min = 100, $max = 9999)
        ];
    }
}
