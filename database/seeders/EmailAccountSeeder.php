<?php

namespace Database\Seeders;

use App\Models\EmailAccount;
use App\Models\SalesChannel;
use Illuminate\Database\Seeder;

class EmailAccountSeeder extends Seeder
{
    private static function firstOrCreate(array $array, array $array1)
    {
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        EmailAccount::firstOrCreate(['name' => 'delivery@bingbangbosh.com'], [
            'name' => 'delivery@bingbangbosh.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        EmailAccount::firstOrCreate(['name' => 'care@xstreamgym.com'], [
            'name' => 'care@xstreamgym.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        EmailAccount::firstOrCreate(['name' => 'care@bingbangbosh.com'], [
            'name' => 'care@bingbangbosh.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        EmailAccount::firstOrCreate(['name' => 'info@xstreamgym.com'], [
            'name' => 'info@xstreamgym.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        EmailAccount::firstOrCreate(['name' => 'info@bingbangbosh.com'], [
            'name' => 'info@bingbangbosh.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        EmailAccount::firstOrCreate(['name' => 'delivery@ejogga.com'], [
            'name' => 'delivery@ejogga.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        EmailAccount::firstOrCreate(['name' => 'info@ejogga.com'], [
            'name' => 'info@ejogga.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        EmailAccount::firstOrCreate(['name' => 'info@boomtekk.com'], [
            'name' => 'info@boomtekk.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        EmailAccount::firstOrCreate(['name' => 'support@bingbangbosh.com'], [
            'name' => 'support@bingbangbosh.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        EmailAccount::firstOrCreate(['name' => 'info@xstreamgymuk.com'], [
            'name' => 'info@xstreamgymuk.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        EmailAccount::firstOrCreate(['name' => 'delivery@boomtekk.com'], [
            'name' => 'delivery@boomtekk.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        EmailAccount::firstOrCreate(['name' => 'info@boomtekk.com'], [
            'name' => 'info@boomtekk.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        EmailAccount::firstOrCreate(['name' => 'alex.adams@bingbangbosh.com'], [
            'name' => 'alex.adams@bingbangbosh.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        EmailAccount::firstOrCreate(['name' => 'mariah.ellie@bingbangbosh.com'], [
            'name' => 'mariah.ellie@bingbangbosh.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        EmailAccount::firstOrCreate(['name' => 'mo.allen@bingbangbosh.com'], [
            'name' => 'mo.allen@bingbangbosh.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        EmailAccount::firstOrCreate(['name' => 'support@bingbangbosh.com'], [
            'name' => 'support@bingbangbosh.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        EmailAccount::firstOrCreate(['name' => 'alex.adams@xstreamgym.com'], [
            'name' => 'alex.adams@xstreamgym.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        EmailAccount::firstOrCreate(['name' => 'delivery@xstreamgym.com'], [
            'name' => 'delivery@xstreamgym.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        EmailAccount::firstOrCreate(['name' => 'care@xstreamgymuk.com'], [
            'name' => 'care@xstreamgymuk.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        EmailAccount::firstOrCreate(['name' => 'delivery@stockovers.co.uk'], [
            'name' => 'delivery@stockovers.co.uk',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        EmailAccount::firstOrCreate(['name' => 'info@stockovers.co.uk'], [
            'name' => 'info@stockovers.co.uk',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        EmailAccount::firstOrCreate(['name' => 'aron.adams@boomtekk.com'], [
            'name' => 'aron.adams@boomtekk.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
