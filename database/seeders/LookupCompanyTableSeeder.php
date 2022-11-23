<?php

namespace Database\Seeders;

use App\Models\Lookup;
use Illuminate\Database\Seeder;

class LookupCompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lookup::firstOrCreate(['slug' => 'freight_receiver_company'], [
            'type' => 'company_type',
            'value' => 'Freight Receiver Company',
            'slug' => 'freight_receiver_company',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'freight_sender_company'], [
            'type' => 'company_type',
            'value' => 'Freight Sender Company',
            'slug' => 'freight_sender_company',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
