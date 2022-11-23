<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CourrierAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address_1' => $this->faker->name(),
            'address_2' => $this->faker->name(),
            'town' => $this->faker->name(),
            'city' => $this->faker->name(),
            'county' => $this->faker->name(),
            'postcode' => $this->faker->numberBetween(1 ,100),
            'country' => $this->faker->name(),
        ];
    }
}
