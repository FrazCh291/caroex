<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'shipping_method' => $this->faker->name(),
            'sku' => $this->faker->name(),
            'color' => $this->faker->colorName(),
            'image' => $this->faker->name(),
            'price' => $this->faker->numberBetween($min = 100, $max = 9999),
            'stock' => $this->faker->boolean(),
            'xstreamgym_name' => $this->faker->realText(10),
            'gogropie_name' => $this->faker->realText(10),
            'wowchers_name' => $this->faker->realText(10),
            'groupon_name' => $this->faker->realText(10),
            'description' => $this->faker->realText(10),
            'categories' => $this->faker->realText(10),
            'upc' => $this->faker->numberBetween($min = 10000000000000, $max = 99999999999999),
            'ean' => $this->faker->numberBetween($min = 10000000000000, $max = 99999999999999),
            'jan' => $this->faker->numberBetween($min = 10000000000000, $max = 99999999999999),
            'isbn' => $this->faker->numberBetween($min = 10000000000000, $max = 99999999999999),
            'mpn' => $this->faker->numberBetween($min = 10000000000000, $max = 99999999999999),
            'location' => $this->faker->city(),
            // 'quantity' => $this->faker->numberBetween($min = 1, $max = 999),
            'model' => $this->faker->realText(10),
            'supplier_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'date_available' => "2021-08-05",
            'weight' => $this->faker->numberBetween($min = 10, $max = 999),
            'weight_unit' => "kg",
            'length' => $this->faker->numberBetween($min = 10, $max = 999),
            'width' => $this->faker->numberBetween($min = 10, $max = 999),
            'height' => $this->faker->numberBetween($min = 10, $max = 999),
            'length_unit' => "cm",
            'status' => "enabled",
            'seo_keyword' => $this->faker->realText(10),
            'meta_description' => $this->faker->text(),
            'meta_keywords' => $this->faker->realText(10),
            'tags' => $this->faker->realText(10),
            'subtract' => $this->faker->numberBetween($min = 10, $max = 999),
            'minimum' => $this->faker->numberBetween($min = 10, $max = 999)
        ];
    }
}
