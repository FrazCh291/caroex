<?php

namespace Database\Factories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coupon::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'discount_type_id' => $this->faker->randomNumber(),
            'discount_limitation_id' => $this->faker->numberBetween(1,20),
            'name' => $this->faker->word(),
            'discount_amount' => $this->faker->numberBetween($min = 1500, $max = 6000),
            'discount_type' => $this->faker->word(),
            'use_percentage' => $this->faker->boolean(),
            'maximum_discount_amount' => $this->faker->numberBetween($min = 1500, $max = 6000),
            'discount_percentage' => $this->faker->numberBetween(1,99),
            'requires_coupon_code' => $this->faker->randomNumber(),
            'coupon_code' => $this->faker->randomNumber(),
            'limitation_times' => $this->faker->randomNumber(),
            'maximum_discounted_quantity' => $this->faker->numberBetween(1,5),
            'is_cumulative' => $this->faker->boolean(),
            'start_date' => $this->faker->dateTime(),
            'end_date' => $this->faker->dateTime(),
        ];
    }
}
