<?php

namespace Database\Factories;
use App\Models\WarehouseContainer;

use Illuminate\Database\Eloquent\Factories\Factory;

class WarehouseContainerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = WarehouseContainer::class;

    public function definition()
    {
        return [
            
            'company_id' => $this->faker->randomNumber(),
            'container_no' => $this->faker->randomNumber(),
            'container_ordered_at' => $this->faker->date(),
            'deleted_at' => $this->faker->dateTime(),
        ];
    }
}
