<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companyId = Company::updateOrCreate(['name' => 'Alfa Mohuha'])->id;
        Setting::firstOrCreate(['slug' => 'account_number'], [
            'company_id' => $companyId,
            'type' => 'account',
            'slug' => 'account_number',
            'name' => 'Account Number',
            'value' => '01491555',
            'enable' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        Setting::firstOrCreate(['slug' => 'account_branch_code'], [
            'company_id' => $companyId,
            'type' => 'account',
            'slug' => 'account_branch_code',
            'name' => 'Account Branch Code',
            'value' => '001',
            'enable' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        Setting::firstOrCreate(['slug' => 'p1'], [
            'company_id' => $companyId,
            'type' => 'service_type',
            'slug' => 'p1',
            'name' => 'Service Type',
            'value' => 'P1',
            'enable' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        Setting::firstOrCreate(['slug' => 'surcharge'], [
            'company_id' => $companyId,
            'type' => 'charges',
            'slug' => 'surcharge',
            'name' => 'Surcharge',
            'value' => 0,
            'enable' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        Setting::firstOrCreate(['slug' => 'building'], [
            'company_id' => $companyId,
            'type' => 'progessbar',
            'slug' => 'low',
            'name' => 'building',
            'value' => '#1fa335',
            'enable' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        Setting::firstOrCreate(['slug' => 'building'], [
            'company_id' => $companyId,
            'type' => 'progessbar',
            'slug' => 'medium',
            'name' => 'building',
            'value' => '#f4984e',
            'enable' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        Setting::firstOrCreate(['slug' => 'building'], [
            'company_id' => $companyId,
            'type' => 'progessbar',
            'slug' => 'high',
            'name' => 'building',
            'value' => '#cd1313',
            'enable' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        Setting::firstOrCreate(['slug' => 'gogroopie-api-token'], [
            'company_id' => $companyId,
            'type' => 'channel',
            'slug' => 'gogroopie-api-token',
            'name' => 'Gogroopie API Token',
            'value' => Hash::make(Str::random(30)),
            'enable' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        Setting::firstOrCreate(['slug' => 'groupon-api-token'], [
            'company_id' => $companyId,
            'type' => 'channel',
            'slug' => 'groupon-api-token',
            'name' => 'Groupon API Token',
            'value' => Hash::make(Str::random(30)),
            'enable' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        Setting::firstOrCreate(['slug' => 'wowcher-api-token'], [
            'company_id' => $companyId,
            'type' => 'channel',
            'slug' => 'wowcher-api-token',
            'name' => 'Wowcher API Token',
            'value' => Hash::make(Str::random(30)),
            'enable' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        Setting::firstOrCreate(['slug' => 'xstream-gym-api-token'], [
            'company_id' => $companyId,
            'type' => 'channel',
            'slug' => 'xstream-gym-api-token',
            'name' => 'Xstream Gym API Token',
            'value' => Hash::make(Str::random(30)),
            'enable' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        Setting::firstOrCreate(['slug' => 'amazon-api-token'], [
            'company_id' => $companyId,
            'type' => 'channel',
            'slug' => 'amazon-api-token',
            'name' => 'Amazon API Token',
            'value' => Hash::make(Str::random(30)),
            'enable' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        Setting::firstOrCreate(['slug' => 'ejogga-api-token'], [
            'company_id' => $companyId,
            'type' => 'channel',
            'slug' => 'ejogga-api-token',
            'name' => 'Ejogga API Token',
            'value' => Hash::make(Str::random(30)),
            'enable' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        Setting::firstOrCreate(['slug' => 'tracking-api-token'], [
            'company_id' => $companyId,
            'type' => 'channel',
            'slug' => 'tracking-api-token',
            'name' => 'Tracking API Token',
            'value' => Hash::make(Str::random(30)),
            'enable' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        Setting::firstOrCreate(['slug' => 'boomtekk-api-token'], [
            'company_id' => $companyId,
            'type' => 'channel',
            'slug' => 'boomtekk-api-token',
            'name' => 'Boomtekk API Token',
            'value' => Hash::make(Str::random(30)),
            'enable' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        Setting::firstOrCreate(['slug' => 'tracking_email_notification'], [
            'company_id' => $companyId,
            'type' => 'tracking_email_notification',
            'slug' => 'tracking_email_notification',
            'name' => 'Tracking Email Notification',
            'value' => 0,
            'enable' => false,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
