<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class QuotationRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->string(),
            'last_name' => $this->faker->string(),
            'email' => $this->faker->string(),
            'phone' => $this->faker->string(),
            'company' => $this->faker->string(),
            'message' => $this->faker->text(),
            'platform' => $this->faker->string(),
            'shipment_month' => $this->faker->string()
        ];
    }
}
