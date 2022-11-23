<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Returns;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReturnsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Returns::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'customer_id' => $this->faker->randomNumber(),
            'request_type' => $this->faker->word(),
            'tracking_number' => $this->faker->randomNumber(),
            'return_status' => $this->faker->word(),
            'refunded_at' => $this->faker->dateTime(),
            'return_at' => $this->faker->dateTime(),
            'received_at' => $this->faker->dateTime(),
            'replacement_status' => $this->faker->word(),
            'description' => $this->faker->text(),
        ];
    }
}
