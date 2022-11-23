<?php

namespace Database\Factories;
use App\Models\Collection;


use Illuminate\Database\Eloquent\Factories\Factory;

class CollectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
protected $model = Collection::class;


    public function definition()
    {
        return [
            'customer_id' => $this->faker->randomNumber(),
            'case_id' => 1,
            'request_type' => $this->faker->word(),
            'tracking_number' => $this->faker->randomNumber(),
            'return_status' => $this->faker->word(),
            'refunded_at' => $this->faker->dateTime(),
            'return_at' => $this->faker->dateTime(),
            'received_at' => $this->faker->dateTime(),
            'replacement_status' => $this->faker->word(),
        ];
    }
}
