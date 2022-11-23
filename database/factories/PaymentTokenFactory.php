<?php

namespace Database\Factories;

use App\Models\PaymentToken;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentTokenFactory extends Factory
{

    protected $model = PaymentToken::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'gateway_id'=>$this->faker->numberBetween($min = 1, $max = 10),
            'user_id'=>$this->faker->numberBetween($min = 1, $max = 10),
            'token'=>$this->faker->name(),
            'type'=>$this->faker->name(),
            'is_default'=>$this->faker->boolean,
        ];
    }
}
