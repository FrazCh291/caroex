<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $alfaMohuha =  Company::updateOrCreate(['name' => 'Alfa Mohuha'],[
            'contact_name' => 'Mohsin Shah',
            'email' => 'mohsin.shah@alfamohuha.com',
            'phone' => '+92 320 845 4892',
            'type' => 'erp_company',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Company::updateOrCreate(['name' => 'Boomerz'],[
            'contact_name' => 'Ali Abbas',
            'email' => 'ali.abbas@boomerz.co.uk',
            'phone' => '+44 7763 533 909',
            'type' => 'fulfilment_company',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Company::updateOrCreate(['name' => 'Supplier XYS'],[
            'contact_name' => 'Supplier Xys',
            'parent_id' => $alfaMohuha->id,
            'email' => 'xyz.abcs@boomerz.co.uk',
            'phone' => '+44 6521 852 147',
            'type' => 'supplier_company',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
