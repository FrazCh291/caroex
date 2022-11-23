<?php

namespace Database\Factories;

use App\Models\Ejogga;
use App\Models\Import;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class EjoggaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ejogga::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $sku = $this->faker->lexify('???') . "-" . $this->faker->lexify('???') . "-" . $this->faker->lexify('???');
        return [
            'product_id' => function () {
                return Product::factory()->create()->id;
            },
            'import_id' => function () {
                return Import::factory()->create()->id;
            },
            'order_status' => $this->faker->name(),
            'order_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'customer_note' => $this->faker->name(),
            'billing_first_name' => $this->faker->firstName(),
            'billing_last_name' => $this->faker->lastName(),
            'billing_company' => $this->faker->name(),
            'billing_address_1_2' => $this->faker->streetAddress(),
            'billing_city' => $this->faker->city(),
            'billing_state_code' => $this->faker->state(),
            'billing_postcode' => $this->faker->postcode(),
            'billing_country_code' => $this->faker->countryCode(),
            'billing_email' => $this->faker->safeEmail(),
            'billing_phone' => $this->faker->e164PhoneNumber(),
            'shipping_first_name' => $this->faker->firstName(),
            'shipping_last_name' => $this->faker->lastName(),
            'shipping_address_1_2' => $this->faker->streetAddress(),
            'shipping_city' => $this->faker->city(),
            'shipping_state_code' => $this->faker->state(),
            'shipping_postcode' => $this->faker->postcode(),
            'shipping_country_code' => $this->faker->countryCode(),
            'payment_method_title' => $this->faker->name(),
            'cart_discount_amount' => $this->faker->numberBetween($min = 100, $max = 9999),
            'order_subtotal_amount' => $this->faker->numberBetween($min = 100, $max = 9999),
            'shipping_method_title' => $this->faker->name(),
            'order_shipping_amount' => $this->faker->numberBetween($min = 100, $max = 9999),
            'order_refund_amount' => $this->faker->numberBetween($min = 100, $max = 9999),
            'order_total_amount' => $this->faker->numberBetween($min = 100, $max = 9999),
            'order_total_tax_amount' => $this->faker->numberBetween($min = 100, $max = 9999),
            'sku' => $sku,
            'item' => $this->faker->name(),
            'item_name' => $this->faker->name(),
            'quantity' => $this->faker->numberBetween($min = 100, $max = 9999),
            'item_cost' => $this->faker->numberBetween($min = 100, $max = 9999),
            'coupon_code' => $this->faker->name(),
            'discount_amount' => $this->faker->numberBetween($min = 100, $max = 9999),
            'discount_amount_tax' => $this->faker->numberBetween($min = 100, $max = 9999),
        ];
    }
}
