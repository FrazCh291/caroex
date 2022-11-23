<?php

namespace Database\Seeders;

use App\Models\Lookup;
use Illuminate\Database\Seeder;

class EmailSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lookup::firstOrCreate(['type' => 'order_status', 'slug' => 'pending'], [
            'company_id' => '',
            'channel_id' => '',
            'host' => '',
            'username' => 1,
            'password' => '',
            'port' => '',
            'encryption' => '',
            'status' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
