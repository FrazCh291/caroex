<?php

namespace Database\Seeders;

use App\Models\accounts;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        accounts::firstOrCreate(['first_name' => 'Stripe', 'last_name' => 'Account'], [
            'first_name' => 'Stripe',
            'last_name' => 'Account',
            'address' => '38 Swift Gardens',
            'city' => 'Boston',
            'state_code' => 'LINCOLNSHIRE',
            'postcode' => 'PE201EQ',
            'email' => 'khurram.azhar@gmail.com',
            'phone_no' => '07557885774',
            'account_no' => '4242424242424242',
            'date_of_birth' =>  date("Y-m-d"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        accounts::firstOrCreate(['first_name' => 'HSBC', 'last_name' => 'Account'], [
            'first_name' => 'HSBC',
            'last_name' => 'Account',
            'address' => '1 Newbery close',
            'city' => 'Colyton',
            'state_code' => 'Devon',
            'postcode' => 'EX246TJ',
            'email' => 'irfan.iqbal@gmail.com',
            'phone_no' => '07741468238',
            'account_no' => '4242424242425252',
            'date_of_birth' => date("Y-m-d"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
