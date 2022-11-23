<?php

namespace Database\Seeders;

use App\Models\SalesChannel;
use Illuminate\Database\Seeder;

class  DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CompanySeeder::class);
        $this->call(LookupCurrencySeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(ModulePermissionSeeder::class);
        $this->call(PackageSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ChannelTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(SettingTableSeeder::class);
        $this->call(LookupTableSeeder::class);
        $this->call(LookupStatusSeeder::class);
        $this->call(AccountSeeder::class);
        $this->call(CompanySubscription::class);
        $this->call(ProductTitleTableSeeder::class);
        $this->call(BuildingTableSeeder::class);
        $this->call(QuotationSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(QuestionnaireSeeder::class);
//       $this->call(QuotationitemSeeder::class);
//       $this->call(QuotationItemSeeder::class);
        $this->call(EmailAccountSeeder::class);
        $this->call(LookupCompanyTableSeeder::class);
    }
}
