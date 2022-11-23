<?php

namespace Database\Factories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

class BuildingFactory extends Factory
{

    protected $model = Building::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = 'B' . $this->faker->numberBetween(1, 9);
        $height = $this->faker->numberBetween(1, 9);
        $length = $this->faker->numberBetween(1, 9);
        $width = $this->faker->numberBetween(1, 9);
        $volume = $height * $length * $width;

        return [
            'name' => $name,
            'code' => $name,
            'company_id' => 1,
            'phone' => $this->faker->phoneNumber(),
            'address_1' => $this->faker->sentence($nbWords = 3, $variableNbWords = true),
            'address_2' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
            'city' => $this->faker->city(),
            'state' => $this->faker->city(),
            'country' => $this->faker->country(),
            'zip_code' => $this->faker->numberBetween(22225, 54444),
            'length' => $length,
            'width' => $width,
            'height' => $height,
            'volume' => $volume,
            'is_occupied' => false,
        ];
    }
}
