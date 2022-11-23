<?php

namespace Database\Factories;

use App\Models\Level;
use Illuminate\Database\Eloquent\Factories\Factory;

class BinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $levels = Level::pluck('id')->toArray();
        $name = 'B' . $this->faker->numberBetween(1, 9);
        $height = $this->faker->numberBetween(1, 9);
        $length = $this->faker->numberBetween(1, 9);
        $width = $this->faker->numberBetween(1, 9);
        $volume = $height * $length * $width;

        return [
            'level_id' =>  $this->faker->randomElement($levels),
            'company_id' => 1,
            'name' => $name,
            'code' => $name,
            'height' => $height,
            'length' => $length,
            'width' => $width,
            'volume' => $volume,
            'is_occupied' => false
        ];
    }
}
