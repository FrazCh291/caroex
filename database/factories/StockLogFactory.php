<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use App\Models\StockLog;
use App\Models\Supplier;
use App\Models\OrderItem;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StockLog::class;

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
            'supplier_id' =>Supplier::factory()->create()->id,
            'order_item_id' => 1,
            'user_id' => User::factory()->create()->id,
            'quantity' => $this->faker->numberBetween($min = 100, $max = 9999)
        ];
    }
}

