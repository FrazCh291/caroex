<?php

namespace Database\Factories;

use App\Models\Bay;
use Illuminate\Database\Eloquent\Factories\Factory;

class LevelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $bays = Bay::pluck('id')->toArray();
        $name = 'S' . $this->faker->numberBetween(1, 9);
        $height = $this->faker->numberBetween(1, 9);
        $length = $this->faker->numberBetween(1, 9);
        $width = $this->faker->numberBetween(1, 9);
        $volume = $height * $length * $width;


        return [
            'bay_id' =>  $this->faker->randomElement($bays),
            'company_id' => 1,
            'name' => $name,
            'code' => $name,
            'height' => $height,
            'length' => $length,
            'width' => $width,
            'volume' => $volume,
            'max_weight' => $this->faker->numberBetween(22, 54),
            'is_occupied' => false
        ];
    }
}
