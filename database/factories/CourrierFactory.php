<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CourrierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'warehouseBuilding_id' => $this->faker->numberBetween(1,10),
            'company_id' => $this->faker->numberBetween(1 ,10)
        ];
    }
}
