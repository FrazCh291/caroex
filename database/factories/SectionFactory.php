<?php

namespace Database\Factories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $buildings = Building::pluck('id')->toArray();
        $name = 'S' . $this->faker->numberBetween(1, 9);
        $height = $this->faker->numberBetween(1, 9);
        $length = $this->faker->numberBetween(1, 9);
        $width = $this->faker->numberBetween(1, 9);
        $volume = $height * $length * $width;

        return [
            'building_id' => $this->faker->randomElement($buildings),
            'company_id' => 1,
            'name' => $name,
            'code' => $name,
            'height' => $height,
            'length' => $length,
            'width' => $width,
            'volume' => $volume,
            'is_occupied' => false,
            'is_active' => true
        ];
    }
}
