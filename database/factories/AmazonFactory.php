<?php

namespace Database\Factories;

use App\Models\Amazon;
use App\Models\Product;
use App\Models\Import;
use Illuminate\Database\Eloquent\Factories\Factory;

class AmazonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Amazon::class;

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
            'order_id' => $this->faker->randomNumber(),
            'customer_name' => $this->faker->name(),
            'postal_address_1' => $this->faker->streetAddress(),
            'postal_address_2' => $this->faker->streetAddress(),
            'postal_address_3' => $this->faker->city(),
            'postal_address_4' => $this->faker->state(),
            'post_code' => $this->faker->postcode(),
            'item_name' => $this->faker->name(),
            'order_item_id' => $this->faker->numberBetween($min = 10000000000000, $max = 99999999999999),
            'sku' => $sku,
            'asin' => $this->faker->numberBetween($min = 10000000000000, $max = 99999999999999),
            'dispatch_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'reason_for_late_dispatch' => $this->faker->realText($maxNbChars = 200, $indexSize = 2),
            'freight_company' => $this->faker->company(),
            'tracking_number' => $this->faker->numberBetween($min = 1000000000000000, $max = 9999999999999999),
            'notes' => $this->faker->realText($maxNbChars = 200, $indexSize = 2)
        ];
    }
}
