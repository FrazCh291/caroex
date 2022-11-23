<?php

namespace Database\Seeders;

use App\Models\Deal;
use Illuminate\Database\Seeder;

class DealTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Deal::firstOrCreate(['deal_number' => '18810988'], [
            'deal_name' => 'Golden Tool',
            'deal_number' => '18810988',
        ]);
        Deal::firstOrCreate(['deal_number' => '18825978'], [
            'deal_name' => 'B3',
            'deal_number' => '18825978',
        ]);
    }
}
