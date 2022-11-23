<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Feedback;
use App\Models\SalesChannel;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Feedback::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => null,
            'channel_id' => SalesChannel::factory()->create()->id,
            'customer_id' => null,
            'order_id' => null,
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'url' => null,
            'ratings' => $this->faker->numberBetween(1, 5),
            'review' => $this->faker->text(),
            'status' => 'feedback_unapproved',
            'is_active' => 1
        ];
    }
}
