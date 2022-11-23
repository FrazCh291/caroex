<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Salary;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalaryFactory extends Factory
{
    protected $model = Salary::class;
    /**
     * @var string
     *
     * @return array
     * 
     */
    public function definition()
    {
        $payrollId = Payroll::inRandomOrder()->value('id');
        // $employeeID = Employee::orderBy('id','desc')->first()->pluck('employee_id');
        $employeeID = Employee::inRandomOrder()->value('id');
        return [
            'company_id' => 1,
            'payroll_id' => $payrollId,
            'employee_id' => $employeeID,
            'date' => $this->faker->date(),
            'basic_salary' => $this->faker->numberBetween($min = 1000, $max = 1000000),
            'total_addition' => $this->faker->numberBetween($min = 100, $max = 500000),
            'total_detuction' => $this->faker->numberBetween($min = 100, $max = 500000),
            'net_total' => $this->faker->numberBetween($min = 100, $max = 500000),
            'status' => $this->faker->boolean,
       
        ];
    }
}
