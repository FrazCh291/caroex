<?php

namespace Database\Factories;

use App\Models\PaymentTokenMeta;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentTokenMetaFactory extends Factory
{
    protected $model = PaymentTokenMeta::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'payment_token_id' =>$this->faker->numberBetween($min = 1,$max = 10),
            'meta_key'=>$this->faker->name(),
            'meta_value'=>$this->faker->numberBetween($min = 1,$max = 10),
        ];
    }
}
