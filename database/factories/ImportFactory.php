<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Import;
use App\Models\SalesChannel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Import::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'channel_id' => function () {
                return SalesChannel::factory()->create()->id;
            },
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'file_name' => "public/storage/" . $this->faker->numberBetween($min = 10000000000000, $max = 99999999999999),
            'file_size' => $this->faker->numberBetween($min = 1000000, $max = 99999999999999),
            'number_of_rows' => $this->faker->randomNumber(),
        ];
    }
}
