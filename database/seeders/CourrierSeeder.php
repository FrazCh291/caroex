<?php

namespace Database\Seeders;

use App\Models\Courrier;
use Illuminate\Database\Seeder;

class CourrierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        Courrier::create([
            'name' => $faker->company(),
            'warehouseBuilding_id' => $faker->numberBetween(1, 10),
            'company_id' => $faker->numberBetween(1, 10)
        ]);
    }
}
