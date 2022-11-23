<?php

namespace Database\Seeders;

use App\Models\Quotationitem;
use Illuminate\Database\Seeder;

class QuotationItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        Quotationitem::create([
            'quotation_id' => $faker->numberBetween(1, 10),
            'product_id' => $faker->numberBetween(1, 10),
            'description' =>  $faker->paragraph,
            'quantity' => $faker->numberBetween(1, 10),
            'unit_price' => $faker->numberBetween(1, 100),
            'total_price' => $faker->numberBetween(1, 100)
        ]);
    }
}
