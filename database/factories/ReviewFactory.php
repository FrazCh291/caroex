<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

     /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
            'comment' => $this->facker->text(),
            'rating' => $this->faker->numberBetween($min = 1, $max = 5)
        ];
    }
}
