<?php

namespace Database\Seeders;

use App\Models\Quotation;
use Illuminate\Support\Facades\DB;
use Psy\Util\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class QuotationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        Quotation::create([
            'supplier_id' => $faker->numberBetween(1, 10),
            'company_id' => $faker->numberBetween(1, 10),
            'description' =>  $faker->paragraph
        ]);
    }
}
