<?php

namespace Database\Factories;

use App\Models\Payroll;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayrollFactory extends Factory
{
    protected $model = Payroll::class;
    /**
     * @var string
     *
     *  
     */
    public function definition()
    {
        return [
            'company_id' => 1,
            'reference_no' =>"Pay2202",
            'from' => $this->faker->date(),
            'to' => $this->faker->date(),
            'no_of_employees' => $this->faker->numberBetween(1 ,10),
            'total_paid' => $this->faker->numberBetween($min = 1000, $max = 6000),
            'total_tax' => $this->faker->numberBetween($min = 100, $max = 5000),
         
        ];
    }
}
