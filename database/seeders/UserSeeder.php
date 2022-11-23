<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companyId = Company::updateOrCreate(['name' => 'Alfa Mohuha'])->id;

        $superUserRoleId = Role::updateOrCreate(['slug' => 'super_user'])->id;
        $erpOwnerRoleId = Role::updateOrCreate(['slug' => 'erp_owner'])->id;
        $erpAdminRoleId = Role::updateOrCreate(['slug' => 'erp_admin'])->id;
        $erpFinanceRoleId = Role::updateOrCreate(['slug' => 'erp_finance'])->id;
        $erpDeliveriesRoleId = Role::updateOrCreate(['slug' => 'erp_deliveries'])->id;
        $erpHrRoleId = Role::updateOrCreate(['slug' => 'erp_hr'])->id;
        $erpCsrRoleId = Role::updateOrCreate(['slug' => 'erp_csr'])->id;
        $erpScmRoleId = Role::updateOrCreate(['slug' => 'erp_scm'])->id;
        $erpCsrAdminRoleId = Role::updateOrCreate(['slug' => 'erp_csr_admin'])->id;
        $fulfilmentOwnerRoleId = Role::updateOrCreate(['slug' => 'fulfilment_owner'])->id;
        $fulfilmentAdminRoleId = Role::updateOrCreate(['slug' => 'fulfilment_admin'])->id;
//        $fulfilmentManagerRoleId = Role::where('slug' , 'fulfilment_manager')->first();
//        $fulfilmentUserRoleId = Role::where('slug' , 'fulfilment_user')->first();
//        $fulfilmentFinanceRoleId = Role::where('slug' , 'fulfilment_finance')->first();
//        $fulfilmentHrRoleId = Role::where('slug' , 'fulfilment_hr')->first();
//        $fulfilmentCsrRoleId = Role::where('slug' , 'fulfilment_csr')->first();
//        $csrRoleId = Role::firstOrCreate(['role' => 'CSR'])->id;
//        $deliveryRoleId = Role::firstOrCreate(['role' => 'Deliveries'])->id;
//        $financeRoleId = Role::firstOrCreate(['role' => 'Finance'])->id;
//        $hrRoleId = Role::firstOrCreate(['role' => 'HR'])->id;
//        $gmRoleId = Role::firstOrCreate(['role' => 'General Manager'])->id;
//        $adminRoleId = Role::firstOrCreate(['role' => 'Admin'])->id;


        User::updateOrCreate([
            'email' => 'irfan.iqbal@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $superUserRoleId,
            'name' => 'Irfan Iqbal',
            'email' => 'irfan.iqbal@alfamohuha.com',
            'is_super' => 1,
            'is_owner' => 0,
            'is_admin' => 1,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'shoaib.ahmad@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $superUserRoleId,
            'name' => 'Shoaib Ahmad',
            'email' => 'shoaib.ahmad@alfamohuha.com',
            'is_super' => 1,
            'is_owner' => 0,
            'is_admin' => 1,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'mohsin.shah@gmail.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $superUserRoleId,
            'name' => 'Mohsin Shah',
            'email' => 'mohsin.shah@gmail.com',
            'is_super' => 1,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);

        User::updateOrCreate([
            'email' => 'hassanrazashah@outlook.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpAdminRoleId,
            'name' => 'Hassan Shah',
            'email' => 'hassanrazashah@outlook.com',
            'is_super' => 0,
            'is_owner' => 1,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'mohsin.shah@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpOwnerRoleId,
            'name' => 'Mohsin Shah',
            'email' => 'mohsin.shah@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 1,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'aqeel.akram@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpCsrAdminRoleId,
            'name' => 'Aqeel Akram',
            'email' => 'aqeel.akram@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'waleed.hassan@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpCsrRoleId,
            'name' => 'Waleed Hassan',
            'email' => 'waleed.hassan@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'kaneez.fatima@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpCsrRoleId,
            'name' => 'Kaneez Fatima',
            'email' => 'kaneez.fatima@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);

        User::updateOrCreate([
            'email' => 'farah.fayyaz@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpCsrRoleId,
            'name' => 'Farah Fayyaz',
            'email' => 'farah.fayyaz@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);

        User::updateOrCreate([
            'email' => 'ayesha.imran@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpCsrRoleId,
            'name' => 'Ayesha Imran',
            'email' => 'ayesha.imran@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'mehak.ejaz@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpDeliveriesRoleId,
            'name' => 'Mehak Ejaz',
            'email' => 'mehak.ejaz@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'imran.raza@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpFinanceRoleId,
            'name' => 'Imran Raza',
            'email' => 'imran.raza@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'maria.muzammil@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpFinanceRoleId,
            'name' => 'Maria Muzammil',
            'email' => 'maria.muzammil@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'gohar.raza@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpHrRoleId,
            'name' => 'Gohar Raza',
            'email' => 'gohar.raza@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'aqsa.nasrullah@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpHrRoleId,
            'name' => 'Aqsa Nasrullah',
            'email' => 'aqsa.nasrullah@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'mohsin.shah@istarz.co.uk',
        ], [
            'company_id' => $companyId,
            'role_id' => $fulfilmentOwnerRoleId,
            'name' => 'Mohsin Shah',
            'email' => 'mohsin.shah@istarz.co.uk',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'ali.abbas@boomerz.co.uk',
        ], [
            'company_id' => $companyId,
            'role_id' => $fulfilmentAdminRoleId,
            'name' => 'Ali Abbas',
            'email' => 'ali.abbas@boomerz.co.uk',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'hassan.shah@boomerz.co.uk',
        ], [
            'company_id' => $companyId,
            'role_id' => $fulfilmentAdminRoleId,
            'name' => 'Hassan Shah',
            'email' => 'hassan.shah@boomerz.co.uk',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);

        User::updateOrCreate([
            'email' => 'kat.bono@boomerz.co.uk',
        ], [
            'company_id' => $companyId,
            'role_id' => $fulfilmentAdminRoleId,
            'name' => 'Kat Bono',
            'email' => 'kat.bono@boomerz.co.uk',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'erpScm@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpScmRoleId,
            'name' => 'ERP SCM',
            'email' => 'erpScm@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'erpHR@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpHrRoleId,
            'name' => 'ERP HR',
            'email' => 'erpHR@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'erpFinance@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpFinanceRoleId,
            'name' => 'ERP Finance',
            'email' => 'erpFinance@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'erpDelivery@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpDeliveriesRoleId,
            'name' => 'ERP Delivery',
            'email' => 'erpDelivery@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'erpCsrAdmin@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpCsrAdminRoleId,
            'name' => 'ERP CSR Admin',
            'email' => 'erpCsrAdmin@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'erp.crm@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpCsrRoleId,
            'name' => 'ERP CRM',
            'email' => 'erp.crm@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'erpAdmin@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpAdminRoleId,
            'name' => 'ERP Admin',
            'email' => 'erpAdmin@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);

        User::updateOrCreate([
            'email' => 'irfan.iqbal@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $superUserRoleId,
            'name' => 'Irfan Iqbal',
            'email' => 'irfan.iqbal@alfamohuha.com',
            'is_super' => 1,
            'is_owner' => 0,
            'is_admin' => 1,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);

        User::updateOrCreate([
            'email' => 'mohsin.shah@gmail.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $superUserRoleId,
            'name' => 'Mohsin Shah',
            'email' => 'mohsin.shah@gmail.com',
            'is_super' => 1,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);

        User::updateOrCreate([
            'email' => 'hassanrazashah@outlook.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpAdminRoleId,
            'name' => 'Hassan Shah',
            'email' => 'hassanrazashah@outlook.com',
            'is_super' => 0,
            'is_owner' => 1,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'mohsin.shah@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpOwnerRoleId,
            'name' => 'Mohsin Shah',
            'email' => 'mohsin.shah@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 1,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);

        User::updateOrCreate([
            'email' => 'hassan.shah@boomerz.co.uk',
        ], [
            'company_id' => $companyId,
            'role_id' => $fulfilmentAdminRoleId,
            'name' => 'Hassan Shah',
            'email' => 'hassan.shah@boomerz.co.uk',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);


        User::updateOrCreate([
            'email' => 'superUser@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $superUserRoleId,
            'name' => 'Super User',
            'email' => 'superUser@alfamohuha.com',
            'is_super' => 1,
            'is_owner' => 0,
            'is_admin' => 1,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'erpAdmin@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpAdminRoleId,
            'name' => 'Erp Admin',
            'email' => 'erpAdmin@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 1,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'erpOwner@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpOwnerRoleId,
            'name' => 'Erp Owner',
            'email' => 'erpOwner@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 1,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'erpCsrAdmin@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpCsrAdminRoleId,
            'name' => 'Erp Csr Admin',
            'email' => 'erpCsrAdmin@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'erpCsrDelivery@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpDeliveriesRoleId,
            'name' => 'rp Csr Delivery',
            'email' => 'erpCsrDelivery@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);

        User::updateOrCreate([
            'email' => 'erpCsr@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpCsrRoleId,
            'name' => 'rp Csr',
            'email' => 'erpCsr@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'erpFinance@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpFinanceRoleId,
            'name' => 'Erp Finance',
            'email' => 'erpFinance@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);

        User::updateOrCreate([
            'email' => 'erpHr@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $erpHrRoleId,
            'name' => 'Erp Hr',
            'email' => 'erpHr@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'fulfilmentOwner@istarz.co.uk',
        ], [
            'company_id' => $companyId,
            'role_id' => $fulfilmentOwnerRoleId,
            'name' => 'Fulfilment Owner',
            'email' => 'fulfilmentOwner@istarz.co.uk',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);
        User::updateOrCreate([
            'email' => 'fulfilmentAdmin@boomerz.co.uk',
        ], [
            'company_id' => $companyId,
            'role_id' => $fulfilmentAdminRoleId,
            'name' => 'Fulfilment Admin',
            'email' => 'fulfilmentAdmin@boomerz.co.uk',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);

        User::updateOrCreate([
            'email' => 'fulfilmentAdmin@alfamohuha.com',
        ], [
            'company_id' => $companyId,
            'role_id' => $fulfilmentAdminRoleId,
            'name' => 'fulfilmentAdmin',
            'email' => 'fulfilmentAdmin@alfamohuha.com',
            'is_super' => 0,
            'is_owner' => 0,
            'is_admin' => 0,
            'is_billing' => 0,
            'password' => Hash::make('password')
        ]);


    }




}
