<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
class QuotationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->text(),
            'supplier_id' => $this->faker->numberBetween(1,10),
            'company_id' => $this->faker->numberBetween(1 ,100)
        ];
    }
}
