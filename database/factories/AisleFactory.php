<?php

namespace Database\Factories;

use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

class AisleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $sections = Section::pluck('id')->toArray();
        $name = 'A' . $this->faker->numberBetween(1, 9);
        $height = $this->faker->numberBetween(1, 9);
        $length = $this->faker->numberBetween(1, 9);
        $width = $this->faker->numberBetween(1, 9);
        $volume = $height * $length * $width;

        return [
            'section_id' => $this->faker->randomElement($sections),
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
