<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class QuotationitemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quotation_id' => $this->faker->numberBetween(1 ,100),
            'product_id' => $this->faker->numberBetween(1,10),
            'company_id' => $this->faker->numberBetween(1 ,100),
            'description' => $this->faker->text(),
            'quantity' => $this->faker->numberBetween(1,100),
            'unit_Price' => $this->faker->numberBetween(0, 100),
            'total_price' => $this->faker->numberBetween(0, 100)
        ];
    }
}
