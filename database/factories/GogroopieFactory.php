<?php

namespace Database\Factories;

use App\Models\Gogroopie;
use Illuminate\Database\Eloquent\Factories\Factory;

class GogroopieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Gogroopie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'product_id' => $this->faker->randomNumber(),
            'deal_id' => $this->faker->randomNumber(),
            'voucher_code' => $this->faker->randomNumber(),
            'full_name' => $this->faker->name,
            'email' => $this->faker->email,
            'house' => $this->faker->streetAddress,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'post_code' => $this->faker->postcode,
            'phone' => $this->faker->phoneNumber,
            'price_option' => $this->faker->text(),
        ];
    }
}
