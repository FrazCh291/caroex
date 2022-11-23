<?php

namespace Database\Seeders;

use App\Models\Lookup;
use Illuminate\Database\Seeder;

class LookupCurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lookup::updateOrCreate([
            'type' => 'type_currency',
            'slug' => 'currency_cny'
        ],[
            'type' => 'type_currency',
            'value' => '¥-CNY',
            'slug' => 'currency_cny',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::updateOrCreate(['type' => 'type_currency',
            'slug' => 'currency_gbp'],
            [
            'type' => 'type_currency',
            'value' => '£-GBP',
            'slug' => 'currency_gbp',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::updateOrCreate(['type' => 'type_currency',
            'slug' => 'currency_usd'],
            [
            'type' => 'type_currency',
            'value' => '$-USD',
            'slug' => 'currency_usd',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
