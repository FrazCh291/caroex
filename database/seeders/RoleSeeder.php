<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Company;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companyId = Company::updateOrCreate(['name' => 'Alfa Mohuha'])->id;

        Role::updateOrCreate([
            'slug' => 'super_user',
        ], [
            'company_id' => $companyId,
            'slug' => 'super_user',
            'role' => 'Super User',
            'order' => 1,
            'status' => 1,
        ]);

        Role::updateOrCreate([
            'slug' => 'erp_csm',
        ], [
            'company_id' => $companyId,
            'slug' => 'erp_csm',
            'role' => 'Erp Csm',
            'order' => 1,
            'status' => 1,
        ]);

        Role::updateOrCreate([
            'slug' => 'erp_crm',
        ], [
            'company_id' => $companyId,
            'slug' => 'erp_crm',
            'role' => 'Erp Crm',
            'order' => 1,
            'status' => 1,
        ]);

        Role::updateOrCreate([
            'slug' => 'erp_owner',
        ], [
            'company_id' => $companyId,
            'slug' => 'erp_owner',
            'role' => 'ERP Owner',
            'order' => 2,
            'status' => 1,
        ]);

        Role::updateOrCreate([
            'slug' => 'erp_admin',
        ], [
            'company_id' => $companyId,
            'slug' => 'erp_admin',
            'role' => 'ERP Admin',
            'order' => 3,
            'status' => 1,
        ]);

        Role::updateOrCreate([
            'slug' => 'erp_finance',
        ], [
            'company_id' => $companyId,
            'slug' => 'erp_finance',
            'role' => 'ERP Finance',
            'order' => 4,
            'status' => 1,
        ]);

        Role::updateOrCreate([
            'slug' => 'erp_deliveries',
        ], [
            'company_id' => $companyId,
            'slug' => 'erp_deliveries',
            'role' => 'ERP Deliveries',
            'order' => 5,
            'status' => 1,
        ]);

        Role::updateOrCreate([
            'slug' => 'erp_hr',
        ], [
            'company_id' => $companyId,
            'slug' => 'erp_hr',
            'role' => 'ERP HR',
            'order' => 6,
            'status' => 1,
        ]);

        Role::updateOrCreate([
            'slug' => 'erp_csr_admin',
        ], [
            'company_id' => $companyId,
            'slug' => 'erp_csr_admin',
            'role' => 'ERP CSR Admin',
            'order' => 7,
            'status' => 1,
        ]);

        Role::updateOrCreate([
            'slug' => 'erp_csr',
        ], [
            'company_id' => $companyId,
            'slug' => 'erp_csr',
            'role' => 'ERP CSR',
            'order' => 7,
            'status' => 1,
        ]);

        Role::updateOrCreate([
            'slug' => 'fulfilment_owner',
        ], [
            'company_id' => $companyId,
            'role' => 'Fulfilment Owner',
            'order' => 8,
            'status' => 1,
        ]);

        Role::updateOrCreate([
            'slug' => 'fulfilment_admin',
        ], [
            'company_id' => $companyId,
            'slug' => 'fulfilment_admin',
            'role' => 'Fulfilment Admin',
            'order' => 9,
            'status' => 1,
        ]);

        Role::updateOrCreate([
            'slug' => 'fulfilment_manager',
        ], [
            'company_id' => $companyId,
            'slug' => 'fulfilment_manager',
            'role' => 'Fulfilment Manager',
            'order' => 10,
            'status' => 1,
        ]);

        Role::updateOrCreate([
            'slug' => 'fulfilment_user',
        ], [
            'company_id' => $companyId,
            'slug' => 'fulfilment_user',
            'role' => 'Fulfilment User',
            'order' => 11,
            'status' => 1,
        ]);

        Role::updateOrCreate([
            'slug' => 'fulfilment_finance',
        ], [
            'company_id' => $companyId,
            'slug' => 'fulfilment_finance',
            'role' => 'Fulfilment Finance',
            'order' => 12,
            'status' => 1,
        ]);

        Role::updateOrCreate([
            'slug' => 'fulfilment_hr',
        ], [
            'company_id' => $companyId,
            'slug' => 'fulfilment_hr',
            'role' => 'Fulfilment HR',
            'order' => 13,
            'status' => 1,
        ]);

        Role::updateOrCreate([
            'slug' => 'fulfilment_csr',
        ], [
            'company_id' => $companyId,
            'slug' => 'fulfilment_csr',
            'role' => 'Fulfilment CSR',
            'order' => 14,
            'status' => 1,
        ]);
        Role::updateOrCreate([
            'slug' => 'erp_scm',
        ], [
            'company_id' => $companyId,
            'slug' => 'erp_scm',
            'role' => 'Erp Scm',
            'order' => 14,
            'status' => 1,
        ]);
//        $ownerRole = Role::where('slug','owner')->first();
//
//        $warehousesIndex = Permission::where('action','warehouses.index')->first();
//
//        $ownerRole->permissions()->attach($warehousesIndex->id);
//        $warehousesCreate = Permission::where('action','warehouses.create')->first();
//        $ownerRole->permissions()->attach($warehousesCreate->id);
//        $warehousesUpdate = Permission::where('action','warehouses.update')->first();
//        $ownerRole->permissions()->attach($warehousesUpdate->id);
//        $warehousesdestroy = Permission::where('action','warehouses.destroy')->first();
//        $ownerRole->permissions()->attach($warehousesdestroy->id);

//
//        Role::firstOrCreate([
//            'slug' => 'admin',
//        ], [
//            'company_id' => $companyId,
//            'role' => 'Admin',
//            'order' => 2,
//        ]);
//        Role::firstOrCreate([
//            'slug' => 'finance',
//        ], [
//            'company_id' => $companyId,
//            'role' => 'Finance',
//            'order' => 3,
//        ]);

//        $ownerRole = Role::where('slug','owner')->first();
//
//        $warehousesIndex = Permission::where('action','warehouses.index')->first();
//
//        $ownerRole->permissions()->attach($warehousesIndex->id);
//        $warehousesCreate = Permission::where('action','warehouses.create')->first();
//        $ownerRole->permissions()->attach($warehousesCreate->id);
//        $warehousesUpdate = Permission::where('action','warehouses.update')->first();
//        $ownerRole->permissions()->attach($warehousesUpdate->id);
//        $warehousesdestroy = Permission::where('action','warehouses.destroy')->first();
//        $ownerRole->permissions()->attach($warehousesdestroy->id);

//        Role::firstOrCreate([
//            'slug' => 'deliveries',
//        ], [
//            'company_id' => $companyId,
//            'role' => 'Deliveries',
//            'order' => 4,
//        ]);
//        Role::firstOrCreate([
//            'slug' => 'csr',
//        ], [
//            'company_id' => $companyId,
//            'role' => 'CSR',
//            'order' => 5,
//        ]);
//        Role::firstOrCreate([
//            'slug' => 'warehouse_manager',
//        ], [
//            'company_id' => $companyId,
//            'role' => 'Warehouse Manager',
//            'order' => 6,
//        ]);
//        Role::firstOrCreate([
//            'slug' => 'warehouse_user',
//        ], [
//            'company_id' => $companyId,
//            'role' => 'Warehouse User',
//            'order' => 7,
//        ]);
//        Role::firstOrCreate([
//            'slug' => 'hr',
//        ], [
//            'role' => 'HR',
//            'order' => 8,
//        ]);
//        Role::firstOrCreate([
//            'slug' => 'gm',
//        ], [
//            'role' => 'General Manager',
//            'order' => 9,
//        ]);
//
//        Role::updateOrCreate([
//            'slug' => 'fulfilment_admin',
//            'company_id' => $companyId,
//        ], [
//            'company_id' => $companyId,
//            'role' => 'Fulfilment Admin',
//            'order' => 6,
//        ]);

//        $ownerRole = Role::where('slug','fulfilment_admin')->first();
//        $warehousesIndex = Permission::where('action','warehouses.index')->first();
//        $ownerRole->permissions()->attach($warehousesIndex->id);
//        $warehousesCreate = Permission::where('action','warehouses.create')->first();
//        $ownerRole->permissions()->attach($warehousesCreate->id);
//        $warehousesUpdate = Permission::where('action','warehouses.update')->first();
//        $ownerRole->permissions()->attach($warehousesUpdate->id);
//        $warehousesdestroy = Permission::where('action','warehouses.destroy')->first();
//        $ownerRole->permissions()->attach($warehousesdestroy->id);
    }
}


//
//        $ownerRole = Role::firstOrCreate(['company_id' => $company->id, 'role' => 'Owner', 'order' => 1, 'status' => 1, 'slug' => 'owner']);
//
//        Role::firstOrCreate(['company_id' => $company->id, 'role' => 'Manager', 'order' => 1, 'status' => 1, 'slug' => 'manager']);
//        Role::firstOrCreate(['company_id' => $company->id, 'role' => 'Finance Manager', 'order' => 1, 'status' => 1, 'slug' => 'finance_manager']);
//        Role::firstOrCreate(['company_id' => $company->id, 'role' => 'User', 'order' => 1, 'status' => 1, 'slug' => 'user']);
//
//        $user = User::firstOrCreate(['email' => 'john@acme.com'],
//
//            [
//                'email' => 'john@acme.com',
//                'password' => bcrypt('12345678'),
//                'role_id' => $ownerRole->id,
//                'is_admin' => 1,
//                'company_id' => $company->id,
//                'is_super' => false,
//                'name' => 'John Doe'
//            ]);
