<?php

namespace Database\Factories;

use App\Models\Deal;
use Illuminate\Database\Eloquent\Factories\Factory;

class DealFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Deal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'deal_type' => $this->faker->randomNumber(),
            'contract_signed_at' => $this->faker->dateTime(),
            'deal_number' => $this->faker->randomNumber(),
            'item_name' => $this->faker->text(),
            'deal_cap' => $this->faker->text(),
            'quantity' => $this->faker->dateTime(),
            'unit_price' => $this->faker->randomNumber(),
            'vat' => $this->faker->randomNumber(),
            'exclusive_text_amount' => $this->faker->randomNumber(),
            'p_p_rate' => $this->faker->randomNumber(),
            'deal_price' => $this->faker->randomNumber(),
            'p_p_vat' => $this->faker->randomNumber(),
            'vat_amount' => $this->faker->randomNumber(),
            'commission_percentage' => $this->faker->randomNumber(),
            'commission_amount' => $this->faker->randomNumber(),
            'vat_deduct_commission' => $this->faker->randomNumber(),
            'total_net_vat' => $this->faker->randomNumber(),
            'total_receivable' => $this->faker->randomNumber(),
        ];
    }
}
