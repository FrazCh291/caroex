<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ShipmentItem;

class ShipmentItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentItem::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => 1,
            'shipment_id' => 44,
            'product_id' => 9,
            'quantity_ordered' =>20,
            'quantity_delivered' =>20,
            'quantity_balance' => 20,
            'currency' => 20,
            'total_price' => 20,
            'unit_price' => 20,
        ];
    }
}
