<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Package;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CompanySubscription extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companyId = Company::updateOrCreate(['name' => 'Alfa Mohuha'])->id;

        $package = Package::updateOrCreate(['name' => 'Pro']);

        $userOwner = User::updateOrCreate([
            'email' => 'mohsin.shah@alfamohuha.com',
        ]);

        $userAdmin = User::updateOrCreate([
            'email' => 'hassanrazashah@outlook.com',
        ]);

        Subscription::updateOrCreate([
            'company_id' => $companyId,
            'package_id' => $package->id,
        ], [
            'user_id' => $userOwner->id,
            'company_id' => $companyId,
            'package_id' => $package->id,
            'is_active' => 1,
            'auto_renew' => 1,
            'started_at' => now(),
        ]);
        $package_modules = $package->modules()->get();
        $userOwner->role->permissions()->detach();
        $userAdmin->role->permissions()->detach();
        foreach ($package_modules as $package_module) {
            $permissionIds = $package_module->permissions()->get()->pluck('id')->toArray();
            $userOwner->role->permissions()->attach($permissionIds);
        }
        $warehousesIndex = Permission::where('action', 'warehouses.index')->first();
        $warehousesCreate = Permission::where('action', 'warehouses.create')->first();
        $warehousesShow = Permission::where('action', 'warehouses.show')->first();
        $warehousesUpdate = Permission::where('action', 'warehouses.update')->first();
        $warehousesdestroy = Permission::where('action', 'warehouses.destroy')->first();

        $customersIndex = Permission::where('action', 'customers.index')->first();
        $customersCreate = Permission::where('action', 'customers.create')->first();
        $customersShow = Permission::where('action', 'customers.show')->first();
        $customersUpdate = Permission::where('action', 'customers.update')->first();
        $customersdestroy = Permission::where('action', 'customers.destroy')->first();

        $suppliersIndex = Permission::where('action', 'suppliers.index')->first();
        $suppliersCreate = Permission::where('action', 'suppliers.create')->first();
        $suppliersShow = Permission::where('action', 'suppliers.show')->first();
        $suppliersUpdate = Permission::where('action', 'suppliers.update')->first();
        $suppliersdestroy = Permission::where('action', 'suppliers.destroy')->first();

        $warehouseIndex = Permission::where('action', 'warehouse.index')->first();
        $warehouseCreate = Permission::where('action', 'warehouse.create')->first();
        $warehouseShow = Permission::where('action', 'warehouse.show')->first();
        $warehouseUpdate = Permission::where('action', 'warehouse.update')->first();
        $warehousedestroy = Permission::where('action', 'warehouse.destroy')->first();

        $paymentGatewaysIndex = Permission::where('action', 'payment-gateways.index')->first();
        $paymentGatewaysShow = Permission::where('action', 'payment-gateways.create')->first();
        $paymentGatewaysCreate = Permission::where('action', 'payment-gateways.show')->first();
        $paymentGatewaysUpdate = Permission::where('action', 'payment-gateways.update')->first();
        $paymentGatewaysdestroy = Permission::where('action', 'payment-gateways.destroy')->first();

        $emailSettingsIndex = Permission::where('action', 'email-settings.index')->first();
        $emailSettingsCreate = Permission::where('action', 'email-settings.create')->first();
        $emailSettingsShow = Permission::where('action', 'email-settings.show')->first();
        $emailSettingsUpdate = Permission::where('action', 'email-settings.update')->first();
        $emailSettingsdestroy = Permission::where('action', 'email-settings.destroy')->first();

        $companiesIndex = Permission::where('action', 'companies.index')->first();
        $companiesCreate = Permission::where('action', 'companies.create')->first();
        $companiesShow = Permission::where('action', 'companies.show')->first();
        $companiesUpdate = Permission::where('action', 'companies.update')->first();
        $companiesdestroy = Permission::where('action', 'companies.destroy')->first();

        $containersIndex = Permission::where('action', 'containers.index')->first();
        $containersCreate = Permission::where('action', 'containers.create')->first();
        $containersShow = Permission::where('action', 'containers.show')->first();
        $containersUpdate = Permission::where('action', 'containers.update')->first();
        $containersdestroy = Permission::where('action', 'containers.destroy')->first();

        $rolesIndex = Permission::where('action', 'roles.index')->first();
        $rolesCreate = Permission::where('action', 'roles.create')->first();
        $rolesShow = Permission::where('action', 'roles.show')->first();
        $rolesUpdate = Permission::where('action', 'roles.update')->first();
        $rolesdestroy = Permission::where('action', 'roles.destroy')->first();

        $userIndex = Permission::where('action', 'user.index')->first();
        $userCreate = Permission::where('action', 'user.create')->first();
        $userShow = Permission::where('action', 'user.show')->first();
        $userUpdate = Permission::where('action', 'user.update')->first();
        $userdestroy = Permission::where('action', 'user.destroy')->first();

        $attendenceIndex = Permission::where('action', 'attendence.index')->first();
        $attendenceCreate = Permission::where('action', 'attendence.create')->first();
        $attendenceShow = Permission::where('action', 'attendence.show')->first();
        $attendenceUpdate = Permission::where('action', 'attendence.update')->first();
        $attendencedestroy = Permission::where('action', 'attendence.destroy')->first();

        $employeesIndex = Permission::where('action', 'employees.index')->first();
        $employeesCreate = Permission::where('action', 'employees.create')->first();
        $employeesShow = Permission::where('action', 'employees.show')->first();
        $employeesUpdate = Permission::where('action', 'employees.update')->first();
        $employeesdestroy = Permission::where('action', 'employees.destroy')->first();

        $usersIndex = Permission::where('action', 'users.index')->first();
        $usersCreate = Permission::where('action', 'users.create')->first();
        $usersShow = Permission::where('action', 'users.show')->first();
        $usersUpdate = Permission::where('action', 'users.update')->first();
        $usersdestroy = Permission::where('action', 'users.destroy')->first();

        $exchangesRatesIndex = Permission::where('action', 'exchanges-rates.index')->first();
        $exchangesRatesCreate = Permission::where('action', 'exchanges-rates.create')->first();
        $exchangesRatesShow = Permission::where('action', 'exchanges-rates.show')->first();
        $exchangesRatesUpdate = Permission::where('action', 'exchanges-rates.update')->first();
        $exchangesRatesdestroy = Permission::where('action', 'exchanges-rates.destroy')->first();

        $channelsIndex = Permission::where('action', 'channels.index')->first();
        $channelsCreate = Permission::where('action', 'channels.create')->first();
        $channelsShow = Permission::where('action', 'channels.show')->first();
        $channelsUpdate = Permission::where('action', 'channels.update')->first();
        $channelsdestroy = Permission::where('action', 'channels.destroy')->first();

        $dealsIndex = Permission::where('action', 'deals.index')->first();
        $dealsCreate = Permission::where('action', 'deals.create')->first();
        $dealsShow = Permission::where('action', 'deals.show')->first();
        $dealsUpdate = Permission::where('action', 'deals.update')->first();
        $dealsdestroy = Permission::where('action', 'deals.destroy')->first();

        $invoicesIndex = Permission::where('action', 'invoices.index')->first();
        $invoicesCreate = Permission::where('action', 'invoices.create')->first();
        $invoicesShow = Permission::where('action', 'invoices.show')->first();
        $invoicesUpdate = Permission::where('action', 'invoices.update')->first();
        $invoicesdestroy = Permission::where('action', 'invoices.destroy')->first();

        $ordersIndex = Permission::where('action', 'orders.index')->first();
        $ordersCreate = Permission::where('action', 'orders.create')->first();
        $ordersShow = Permission::where('action', 'orders.show')->first();
        $ordersUpdate = Permission::where('action', 'orders.update')->first();
        $ordersdestroy = Permission::where('action', 'orders.destroy')->first();

        $deliveriesIndex = Permission::where('action', 'deliveries.index')->first();
        $deliveriesCreate = Permission::where('action', 'deliveries.create')->first();
        $deliveriesShow = Permission::where('action', 'deliveries.show')->first();
        $deliveriesUpdate = Permission::where('action', 'deliveries.update')->first();
        $deliveriesdestroy = Permission::where('action', 'deliveries.destroy')->first();

        $deliveryIndex = Permission::where('action', 'delivery.index')->first();
        $deliveryCreate = Permission::where('action', 'delivery.create')->first();
        $deliveryShow = Permission::where('action', 'delivery.show')->first();
        $deliveryUpdate = Permission::where('action', 'delivery.update')->first();
        $deliverydestroy = Permission::where('action', 'delivery.destroy')->first();

        $stocksLogIndex = Permission::where('action', 'stock-logs.index')->first();
        $stocksLogCreate = Permission::where('action', 'stock-logs.create')->first();
        $stocksLogShow = Permission::where('action', 'stock-logs.show')->first();
        $stocksLogUpdate = Permission::where('action', 'stock-logs.update')->first();
        $stocksLogdestroy = Permission::where('action', 'stock-logs.destroy')->first();

        $wowcherIndex = Permission::where('action', 'wowchers.index')->first();
        $wowcherCreate = Permission::where('action', 'wowchers.create')->first();
        $wowcherShow = Permission::where('action', 'wowchers.show')->first();
        $wowcherUpdate = Permission::where('action', 'wowchers.update')->first();
        $wowcherdestroy = Permission::where('action', 'wowchers.destroy')->first();

        $ejoggasIndex = Permission::where('action', 'ejoggas.index')->first();
        $ejoggasCreate = Permission::where('action', 'ejoggas.create')->first();
        $ejoggasShow = Permission::where('action', 'ejoggas.show')->first();
        $ejoggasUpdate = Permission::where('action', 'ejoggas.update')->first();
        $ejoggasdestroy = Permission::where('action', 'ejoggas.destroy')->first();

        $amazonsIndex = Permission::where('action', 'amazons.index')->first();
        $amazonsCreate = Permission::where('action', 'amazons.create')->first();
        $amazonsShow = Permission::where('action', 'amazons.show')->first();
        $amazonsUpdate = Permission::where('action', 'amazons.update')->first();
        $amazonsdestroy = Permission::where('action', 'amazons.destroy')->first();

        $grouponsIndex = Permission::where('action', 'groupon.index')->first();
        $grouponsCreate = Permission::where('action', 'groupon.create')->first();
        $grouponsShow = Permission::where('action', 'groupon.show')->first();
        $grouponsUpdate = Permission::where('action', 'groupon.update')->first();
        $grouponsdestroy = Permission::where('action', 'groupon.destroy')->first();

        $xstreamgymsIndex = Permission::where('action', 'xstreamgyms.index')->first();
        $xstreamgymsCreate = Permission::where('action', 'xstreamgyms.create')->first();
        $xstreamgymsShow = Permission::where('action', 'xstreamgyms.show')->first();
        $xstreamgymsUpdate = Permission::where('action', 'xstreamgyms.update')->first();
        $xstreamgymsdestroy = Permission::where('action', 'xstreamgyms.destroy')->first();

        $gogroopiesIndex = Permission::where('action', 'gogroopie.index')->first();
        $gogroopiesCreate = Permission::where('action', 'gogroopie.create')->first();
        $gogroopiesShow = Permission::where('action', 'gogroopie.show')->first();
        $gogroopiesUpdate = Permission::where('action', 'gogroopie.update')->first();
        $gogroopiesdestroy = Permission::where('action', 'gogroopie.destroy')->first();

        $stockLogIndex = Permission::where('action', 'stock-log.index')->first();
        $stockLogCreate = Permission::where('action', 'stock-log.create')->first();
        $stockLogShow = Permission::where('action', 'stock-log.show')->first();
        $stockLogUpdate = Permission::where('action', 'stock-log.update')->first();
        $stockLogdestroy = Permission::where('action', 'stock-log.destroy')->first();

        $productTilesIndex = Permission::where('action', 'products.index')->first();
        $productTilesCreate = Permission::where('action', 'products.create')->first();
        $productTilesShow = Permission::where('action', 'products.show')->first();
        $productTilesUpdate = Permission::where('action', 'products.update')->first();
        $productTilesdestroy = Permission::where('action', 'products.destroy')->first();

        $productStockIndex = Permission::where('action', 'product-stock.index')->first();
        $productStockCreate = Permission::where('action', 'product-stock.create')->first();
        $productStockShow = Permission::where('action', 'product-stock.show')->first();
        $productStockUpdate = Permission::where('action', 'product-stock.update')->first();
        $productStockdestroy = Permission::where('action', 'product-stock.destroy')->first();

        $importsIndex = Permission::where('action', 'imports.index')->first();
        $importsCreate = Permission::where('action', 'imports.create')->first();
        $importsShow = Permission::where('action', 'imports.show')->first();
        $importsUpdate = Permission::where('action', 'imports.update')->first();
        $importsdestroy = Permission::where('action', 'imports.destroy')->first();

        $paymentsIndex = Permission::where('action', 'payments.index')->first();
        $paymentsCreate = Permission::where('action', 'payments.create')->first();
        $paymentsShow = Permission::where('action', 'payments.show')->first();
        $paymentsUpdate = Permission::where('action', 'payments.update')->first();
        $paymentsdestroy = Permission::where('action', 'payments.destroy')->first();

        $productDetailsIndex = Permission::where('action', 'product-details.index')->first();
        $productDetailsCreate = Permission::where('action', 'product-details.create')->first();
        $productDetailsShow = Permission::where('action', 'product-details.show')->first();
        $productDetailsUpdate = Permission::where('action', 'product-details.update')->first();
        $productDetailsdestroy = Permission::where('action', 'product-details.destroy')->first();

        $casesIndex = Permission::where('action', 'cases.index')->first();
        $casesCreate = Permission::where('action', 'cases.create')->first();
        $casesShow = Permission::where('action', 'cases.show')->first();
        $casesUpdate = Permission::where('action', 'cases.update')->first();
        $casesdestroy = Permission::where('action', 'cases.destroy')->first();

        $caseIndex = Permission::where('action', 'case.index')->first();
        $caseCreate = Permission::where('action', 'case.create')->first();
        $caseShow = Permission::where('action', 'case.show')->first();
        $caseUpdate = Permission::where('action', 'case.update')->first();
        $casedestroy = Permission::where('action', 'case.destroy')->first();

        $shipmentsIndex = Permission::where('action', 'shipments.index')->first();
        $shipmentsCreate = Permission::where('action', 'shipments.create')->first();
        $shipmentsShow = Permission::where('action', 'shipments.show')->first();
        $shipmentsUpdate = Permission::where('action', 'shipments.update')->first();
        $shipmentsdestroy = Permission::where('action', 'shipments.destroy')->first();

        $fetchEmailIndex = Permission::where('action', 'fetch-email.index')->first();
        $fetchEmailCreate = Permission::where('action', 'fetch-email.create')->first();
        $fetchEmailShow = Permission::where('action', 'fetch-email.show')->first();
        $fetchEmailUpdate = Permission::where('action', 'fetch-email.update')->first();
        $fetchEmaildestroy = Permission::where('action', 'fetch-email.destroy')->first();

        $buildingIndex = Permission::where('action', 'building.index')->first();
        $buildingCreate = Permission::where('action', 'building.create')->first();
        $buildingShow = Permission::where('action', 'building.show')->first();
        $buildingUpdate = Permission::where('action', 'building.update')->first();
        $buildingdestroy = Permission::where('action', 'building.destroy')->first();

        $calendarIndex = Permission::where('action', 'calendar.index')->first();
        $calendarCreate = Permission::where('action', 'calendar.create')->first();
        $calendarShow = Permission::where('action', 'calendar.show')->first();
        $calendarUpdate = Permission::where('action', 'calendar.update')->first();
        $calendardestroy = Permission::where('action', 'calendar.destroy')->first();

        $warehouseShipmentsIndex = Permission::where('action', 'warehouse-shipments.index')->first();
        $warehouseShipmentsCreate = Permission::where('action', 'warehouse-shipments.create')->first();
        $warehouseShipmentsShow = Permission::where('action', 'warehouse-shipments.show')->first();
        $warehouseShipmentsUpdate = Permission::where('action', 'warehouse-shipments.update')->first();
        $warehouseShipmentsdestroy = Permission::where('action', 'warehouse-shipments.destroy')->first();

        $purchaseOrdersIndex = Permission::where('action', 'purchase-orders.index')->first();
        $purchaseOrdersCreate = Permission::where('action', 'purchase-orders.create')->first();
        $purchaseOrdersShow = Permission::where('action', 'purchase-orders.show')->first();
        $purchaseOrdersUpdate = Permission::where('action', 'purchase-orders.update')->first();
        $purchaseOrdersdestroy = Permission::where('action', 'purchase-orders.destroy')->first();

        $fulfilmentOrdersIndex = Permission::where('action', 'order.index')->first();
        $fulfilmentOrdersCreate = Permission::where('action', 'order.create')->first();
        $fulfilmentOrdersShow = Permission::where('action', 'order.show')->first();
        $fulfilmentOrdersUpdate = Permission::where('action', 'order.update')->first();
        $fulfilmentOrdersdestroy = Permission::where('action', 'order.destroy')->first();

        $reviewsIndex = Permission::where('action', 'reviews.index')->first();
        $reviewsCreate = Permission::where('action', 'reviews.create')->first();
        $reviewsShow = Permission::where('action', 'reviews.show')->first();
        $reviewsUpdate = Permission::where('action', 'reviews.update')->first();
        $reviewsdestroy = Permission::where('action', 'reviews.destroy')->first();


//   <<--Erp Admin-->>
        $erpAdminrRole = Role::where('slug', 'erp_admin')->first();
        // Orders
        $erpAdminrRole->permissions()->sync([$ordersIndex->id, $ordersCreate->id, $ordersShow->id, $ordersUpdate->id,
            $ordersdestroy->id, $shipmentsIndex->id, $shipmentsCreate->id, $shipmentsShow->id, $shipmentsUpdate->id,
            $shipmentsdestroy->id, $wowcherIndex->id, $wowcherCreate->id, $wowcherShow->id, $wowcherUpdate->id, $wowcherdestroy->id,
            $ejoggasIndex->id, $ejoggasCreate->id, $ejoggasShow->id, $ejoggasUpdate->id, $ejoggasdestroy->id, $amazonsIndex->id,
            $amazonsCreate->id, $amazonsShow->id, $amazonsUpdate->id, $amazonsdestroy->id, $grouponsIndex->id, $grouponsCreate->id,
            $grouponsShow->id, $grouponsUpdate->id, $grouponsdestroy->id, $xstreamgymsIndex->id, $xstreamgymsCreate->id, $xstreamgymsShow->id,
            $xstreamgymsUpdate->id, $xstreamgymsdestroy->id, $gogroopiesIndex->id, $gogroopiesCreate->id, $gogroopiesShow->id, $gogroopiesUpdate->id,
            $gogroopiesdestroy->id, $deliveriesIndex->id, $deliveriesCreate->id, $deliveriesShow->id, $deliveriesUpdate->id, $deliveriesdestroy->id,
            $warehousesIndex->id, $warehousesCreate->id, $warehousesShow->id, $warehousesUpdate->id, $warehousesdestroy->id, $customersIndex->id,
            $customersCreate->id, $customersShow->id, $customersUpdate->id, $customersdestroy->id, $stocksLogIndex->id, $stocksLogCreate->id,
            $stocksLogShow->id, $stocksLogUpdate->id, $stocksLogdestroy->id, $reviewsIndex->id, $reviewsCreate->id, $reviewsShow->id,
            $reviewsUpdate->id, $reviewsdestroy->id, $productTilesIndex->id, $productTilesCreate->id, $productTilesShow->id,
            $productTilesUpdate->id, $productTilesdestroy->id, $importsIndex->id, $importsCreate->id, $importsShow->id, $importsUpdate->id,
            $importsdestroy->id, $productDetailsIndex->id, $productDetailsCreate->id, $productDetailsShow->id, $productDetailsUpdate->id,
            $productDetailsdestroy->id, $suppliersIndex->id, $suppliersCreate->id, $suppliersShow->id, $suppliersUpdate->id,
            $suppliersdestroy->id, $emailSettingsIndex->id, $emailSettingsCreate->id, $emailSettingsShow->id, $emailSettingsUpdate->id,
            $emailSettingsdestroy->id, $companiesIndex->id, $companiesCreate->id, $companiesShow->id, $companiesUpdate->id, $companiesdestroy->id,
            $rolesIndex->id, $rolesCreate->id, $rolesShow->id, $rolesUpdate->id, $rolesdestroy->id, $userIndex->id, $userCreate->id,
            $userShow->id, $userUpdate->id, $userdestroy->id, $exchangesRatesIndex->id, $exchangesRatesCreate->id, $exchangesRatesShow->id,
            $exchangesRatesUpdate->id, $exchangesRatesdestroy->id, $channelsIndex->id, $channelsCreate->id, $channelsShow->id,
            $channelsUpdate->id, $channelsdestroy->id, $paymentGatewaysIndex->id, $paymentGatewaysShow->id, $paymentGatewaysCreate->id,
            $paymentGatewaysUpdate->id, $paymentGatewaysdestroy->id, $dealsIndex->id, $dealsCreate->id, $dealsShow->id,
            $dealsUpdate->id, $dealsdestroy->id, $invoicesIndex->id, $invoicesCreate->id, $invoicesShow->id, $invoicesUpdate->id,
            $invoicesdestroy->id, $companiesIndex->id, $companiesCreate->id, $companiesShow->id, $companiesUpdate->id,
            $companiesdestroy->id, $casesIndex->id, $casesCreate->id, $casesShow->id, $casesUpdate->id, $casesdestroy->id,
            $fetchEmailIndex->id, $fetchEmailCreate->id, $fetchEmailShow->id, $fetchEmailUpdate->id, $fetchEmaildestroy->id,
            $purchaseOrdersIndex->id, $purchaseOrdersCreate->id, $purchaseOrdersShow->id, $purchaseOrdersUpdate->id,$purchaseOrdersdestroy->id]);


//        $erpAdminrRole->permissions()->attach($ordersCreate->id,);
//        $erpAdminrRole->permissions()->attach($ordersShow->id,);
//        $erpAdminrRole->permissions()->attach($ordersUpdate->id,);
//        $erpAdminrRole->permissions()->attach($ordersdestroy->id,);
//        // Shipments
//        $erpAdminrRole->permissions()->attach($shipmentsIndex->id,);
//        $erpAdminrRole->permissions()->attach($shipmentsCreate->id,);
//        $erpAdminrRole->permissions()->attach($shipmentsShow->id,);
//        $erpAdminrRole->permissions()->attach($shipmentsUpdate->id,);
//        $erpAdminrRole->permissions()->attach($shipmentsdestroy->id,);
//        // Wowcher
//        $erpAdminrRole->permissions()->attach($wowcherIndex->id,);
//        $erpAdminrRole->permissions()->attach($wowcherCreate->id,);
//        $erpAdminrRole->permissions()->attach($wowcherShow->id,);
//        $erpAdminrRole->permissions()->attach($wowcherUpdate->id,);
//        $erpAdminrRole->permissions()->attach($wowcherdestroy->id,);
//        // Ejogga
//        $erpAdminrRole->permissions()->attach($ejoggasIndex->id,);
//        $erpAdminrRole->permissions()->attach($ejoggasCreate->id,);
//        $erpAdminrRole->permissions()->attach($ejoggasShow->id,);
//        $erpAdminrRole->permissions()->attach($ejoggasUpdate->id,);
//        $erpAdminrRole->permissions()->attach($ejoggasdestroy->id,);
//        // Amazon
//        $erpAdminrRole->permissions()->attach($amazonsIndex->id,);
//        $erpAdminrRole->permissions()->attach($amazonsCreate->id,);
//        $erpAdminrRole->permissions()->attach($amazonsShow->id,);
//        $erpAdminrRole->permissions()->attach($amazonsUpdate->id,);
//        $erpAdminrRole->permissions()->attach($amazonsdestroy->id,);
//        // Groupon
//        $erpAdminrRole->permissions()->attach($grouponsIndex->id,);
//        $erpAdminrRole->permissions()->attach($grouponsCreate->id,);
//        $erpAdminrRole->permissions()->attach($grouponsShow->id,);
//        $erpAdminrRole->permissions()->attach($grouponsUpdate->id,);
//        $erpAdminrRole->permissions()->attach($grouponsdestroy->id,);
//        // Xstreamgym
//        $erpAdminrRole->permissions()->attach($xstreamgymsIndex->id,);
//        $erpAdminrRole->permissions()->attach($xstreamgymsCreate->id,);
//        $erpAdminrRole->permissions()->attach($xstreamgymsShow->id,);
//        $erpAdminrRole->permissions()->attach($xstreamgymsUpdate->id,);
//        $erpAdminrRole->permissions()->attach($xstreamgymsdestroy->id,);
//        // Gogroopie
//        $erpAdminrRole->permissions()->attach($gogroopiesIndex->id,);
//        $erpAdminrRole->permissions()->attach($gogroopiesCreate->id,);
//        $erpAdminrRole->permissions()->attach($gogroopiesShow->id,);
//        $erpAdminrRole->permissions()->attach($gogroopiesUpdate->id,);
//        $erpAdminrRole->permissions()->attach($gogroopiesdestroy->id,);
//        // Deliveries
//        $erpAdminrRole->permissions()->attach($deliveriesIndex->id,);
//        $erpAdminrRole->permissions()->attach($deliveriesCreate->id,);
//        $erpAdminrRole->permissions()->attach($deliveriesShow->id,);
//        $erpAdminrRole->permissions()->attach($deliveriesUpdate->id,);
//        $erpAdminrRole->permissions()->attach($deliveriesdestroy->id,);
//        // Warehouses
//        $erpAdminrRole->permissions()->attach($warehousesIndex->id,);
//        $erpAdminrRole->permissions()->attach($warehousesCreate->id,);
//        $erpAdminrRole->permissions()->attach($warehousesShow->id,);
//        $erpAdminrRole->permissions()->attach($warehousesUpdate->id,);
//        $erpAdminrRole->permissions()->attach($warehousesdestroy->id,);
//        // Customers
//        $erpAdminrRole->permissions()->attach($customersIndex->id,);
//        $erpAdminrRole->permissions()->attach($customersCreate->id,);
//        $erpAdminrRole->permissions()->attach($customersShow->id,);
//        $erpAdminrRole->permissions()->attach($customersUpdate->id,);
//        $erpAdminrRole->permissions()->attach($customersdestroy->id,);
//        // Stock Logs
//        $erpAdminrRole->permissions()->attach($stocksLogIndex->id,);
//        $erpAdminrRole->permissions()->attach($stocksLogCreate->id,);
//        $erpAdminrRole->permissions()->attach($stocksLogShow->id,);
//        $erpAdminrRole->permissions()->attach($stocksLogUpdate->id,);
//        $erpAdminrRole->permissions()->attach($stocksLogdestroy->id,);
//        // Reviews
//        $erpAdminrRole->permissions()->attach($reviewsIndex->id,);
//        $erpAdminrRole->permissions()->attach($reviewsCreate->id,);
//        $erpAdminrRole->permissions()->attach($reviewsShow->id,);
//        $erpAdminrRole->permissions()->attach($reviewsUpdate->id,);
//        $erpAdminrRole->permissions()->attach($reviewsdestroy->id,);
//        // Product Titles
//        $erpAdminrRole->permissions()->attach($productTilesIndex->id,);
//        $erpAdminrRole->permissions()->attach($productTilesCreate->id,);
//        $erpAdminrRole->permissions()->attach($productTilesShow->id,);
//        $erpAdminrRole->permissions()->attach($productTilesUpdate->id,);
//        $erpAdminrRole->permissions()->attach($productTilesdestroy->id,);
//        // Imports
//        $erpAdminrRole->permissions()->attach($importsIndex->id,);
//        $erpAdminrRole->permissions()->attach($importsCreate->id,);
//        $erpAdminrRole->permissions()->attach($importsShow->id,);
//        $erpAdminrRole->permissions()->attach($importsUpdate->id,);
//        $erpAdminrRole->permissions()->attach($importsdestroy->id,);
//        // Product Details
//        $erpAdminrRole->permissions()->attach($productDetailsIndex->id,);
//        $erpAdminrRole->permissions()->attach($productDetailsCreate->id,);
//        $erpAdminrRole->permissions()->attach($productDetailsShow->id,);
//        $erpAdminrRole->permissions()->attach($productDetailsUpdate->id,);
//        $erpAdminrRole->permissions()->attach($productDetailsdestroy->id,);
//        // Supplier
//        $erpAdminrRole->permissions()->attach($suppliersIndex->id,);
//        $erpAdminrRole->permissions()->attach($suppliersCreate->id,);
//        $erpAdminrRole->permissions()->attach($suppliersShow->id,);
//        $erpAdminrRole->permissions()->attach($suppliersUpdate->id,);
//        $erpAdminrRole->permissions()->attach($suppliersdestroy->id,);
//      //  Email Setting
//        $erpAdminrRole->permissions()->attach($emailSettingsIndex->id,);
//        $erpAdminrRole->permissions()->attach($emailSettingsCreate->id,);
//        $erpAdminrRole->permissions()->attach($emailSettingsShow->id,);
//        $erpAdminrRole->permissions()->attach($emailSettingsUpdate->id,);
//        $erpAdminrRole->permissions()->attach($emailSettingsdestroy->id,);
//     //  Companies
//        $erpAdminrRole->permissions()->attach($companiesIndex->id,);
//        $erpAdminrRole->permissions()->attach($companiesCreate->id,);
//        $erpAdminrRole->permissions()->attach($companiesShow->id,);
//        $erpAdminrRole->permissions()->attach($companiesUpdate->id,);
//        $erpAdminrRole->permissions()->attach($companiesdestroy->id,);
//     //  Roles
//        $erpAdminrRole->permissions()->attach($rolesIndex->id,);
//        $erpAdminrRole->permissions()->attach($rolesCreate->id,);
//        $erpAdminrRole->permissions()->attach($rolesShow->id,);
//        $erpAdminrRole->permissions()->attach($rolesUpdate->id,);
//        $erpAdminrRole->permissions()->attach($rolesdestroy->id,);
//     //  User
//        $erpAdminrRole->permissions()->attach($userIndex->id,);
//        $erpAdminrRole->permissions()->attach($userCreate->id,);
//        $erpAdminrRole->permissions()->attach($userShow->id,);
//        $erpAdminrRole->permissions()->attach($userUpdate->id,);
//        $erpAdminrRole->permissions()->attach($userdestroy->id,);
//     //  Exchange Rate
//        $erpAdminrRole->permissions()->attach($exchangesRatesIndex->id,);
//        $erpAdminrRole->permissions()->attach($exchangesRatesCreate->id,);
//        $erpAdminrRole->permissions()->attach($exchangesRatesShow->id,);
//        $erpAdminrRole->permissions()->attach($exchangesRatesUpdate->id,);
//        $erpAdminrRole->permissions()->attach($exchangesRatesdestroy->id,);
//     //  Channels
//        $erpAdminrRole->permissions()->attach($channelsIndex->id,);
//        $erpAdminrRole->permissions()->attach($channelsCreate->id,);
//        $erpAdminrRole->permissions()->attach($channelsShow->id,);
//        $erpAdminrRole->permissions()->attach($channelsUpdate->id,);
//        $erpAdminrRole->permissions()->attach($channelsdestroy->id,);
//     //  Payment Gateways
//        $erpAdminrRole->permissions()->attach($paymentGatewaysIndex->id,);
//        $erpAdminrRole->permissions()->attach($paymentGatewaysShow->id,);
//        $erpAdminrRole->permissions()->attach($paymentGatewaysCreate->id,);
//        $erpAdminrRole->permissions()->attach($paymentGatewaysUpdate->id,);
//        $erpAdminrRole->permissions()->attach($paymentGatewaysdestroy->id,);
//        // Deals
//        $erpAdminrRole->permissions()->attach($dealsIndex->id,);
//        $erpAdminrRole->permissions()->attach($dealsCreate->id,);
//        $erpAdminrRole->permissions()->attach($dealsShow->id,);
//        $erpAdminrRole->permissions()->attach($dealsUpdate->id,);
//        $erpAdminrRole->permissions()->attach($dealsdestroy->id,);
//        // Invoices
//        $erpAdminrRole->permissions()->attach($invoicesIndex->id,);
//        $erpAdminrRole->permissions()->attach($invoicesCreate->id,);
//        $erpAdminrRole->permissions()->attach($invoicesShow->id,);
//        $erpAdminrRole->permissions()->attach($invoicesUpdate->id,);
//        $erpAdminrRole->permissions()->attach($invoicesdestroy->id,);
//        // Company
//        $erpAdminrRole->permissions()->attach($companiesIndex->id,);
//        $erpAdminrRole->permissions()->attach($companiesCreate->id,);
//        $erpAdminrRole->permissions()->attach($companiesShow->id,);
//        $erpAdminrRole->permissions()->attach($companiesUpdate->id,);
//        $erpAdminrRole->permissions()->attach($companiesdestroy->id,);
//        //  Cases
//        $erpAdminrRole->permissions()->attach($casesIndex->id,);
//        $erpAdminrRole->permissions()->attach($casesCreate->id,);
//        $erpAdminrRole->permissions()->attach($casesShow->id,);
//        $erpAdminrRole->permissions()->attach($casesUpdate->id,);
//        $erpAdminrRole->permissions()->attach($casesdestroy->id,);
//        //  Fetch Email
//        $erpAdminrRole->permissions()->attach($fetchEmailIndex->id,);
//        $erpAdminrRole->permissions()->attach($fetchEmailCreate->id,);
//        $erpAdminrRole->permissions()->attach($fetchEmailShow->id,);
//        $erpAdminrRole->permissions()->attach($fetchEmailUpdate->id,);
//        $erpAdminrRole->permissions()->attach($fetchEmaildestroy->id,);
//        //  Purchase Orders
//        $erpAdminrRole->permissions()->attach($purchaseOrdersIndex->id,);
//        $erpAdminrRole->permissions()->attach($purchaseOrdersCreate->id,);
//        $erpAdminrRole->permissions()->attach($purchaseOrdersShow->id,);
//        $erpAdminrRole->permissions()->attach($purchaseOrdersUpdate->id,);
//        $erpAdminrRole->permissions()->attach($purchaseOrdersdestroy->id,);

//   <<--Erp Finance-->>
        $erpFinancerRole = Role::where('slug', 'erp_finance')->first();

        // Deals
        $erpFinancerRole->permissions()->sync([$dealsIndex->id, $dealsCreate->id, $dealsShow->id, $dealsUpdate->id,
            $dealsdestroy->id, $shipmentsIndex->id, $shipmentsCreate->id, $shipmentsShow->id, $shipmentsUpdate->id,
            $shipmentsdestroy->id, $purchaseOrdersIndex->id, $purchaseOrdersCreate->id, $purchaseOrdersShow->id,
            $purchaseOrdersUpdate->id, $purchaseOrdersdestroy->id, $invoicesIndex->id, $invoicesCreate->id, $invoicesShow->id,
            $invoicesUpdate->id, $invoicesdestroy->id, $paymentsIndex->id, $paymentsCreate->id, $paymentsShow->id,
            $paymentsUpdate->id, $paymentsdestroy->id, $companiesIndex->id, $companiesCreate->id, $companiesShow->id,
            $companiesUpdate->id, $companiesdestroy->id,]);


//        $erpFinancerRole->permissions()->attach($dealsCreate->id,);
//        $erpFinancerRole->permissions()->attach($dealsShow->id,);
//        $erpFinancerRole->permissions()->attach($dealsUpdate->id,);
//        $erpFinancerRole->permissions()->attach($dealsdestroy->id,);
//        // Shipments
//        $erpFinancerRole->permissions()->attach($shipmentsIndex->id,);
//        $erpFinancerRole->permissions()->attach($shipmentsCreate->id,);
//        $erpFinancerRole->permissions()->attach($shipmentsShow->id,);
//        $erpFinancerRole->permissions()->attach($shipmentsUpdate->id,);
//        $erpFinancerRole->permissions()->attach($shipmentsdestroy->id,);
//        // Purchase Orders
//        $erpFinancerRole->permissions()->attach($purchaseOrdersIndex->id,);
//        $erpFinancerRole->permissions()->attach($purchaseOrdersCreate->id,);
//        $erpFinancerRole->permissions()->attach($purchaseOrdersShow->id,);
//        $erpFinancerRole->permissions()->attach($purchaseOrdersUpdate->id,);
//        $erpFinancerRole->permissions()->attach($purchaseOrdersdestroy->id,);
//        // Invoices
//        $erpFinancerRole->permissions()->attach($invoicesIndex->id,);
//        $erpFinancerRole->permissions()->attach($invoicesCreate->id,);
//        $erpFinancerRole->permissions()->attach($invoicesShow->id,);
//        $erpFinancerRole->permissions()->attach($invoicesUpdate->id,);
//        $erpFinancerRole->permissions()->attach($invoicesdestroy->id,);
//        // Payments
//        $erpFinancerRole->permissions()->attach($paymentsIndex->id,);
//        $erpFinancerRole->permissions()->attach($paymentsCreate->id,);
//        $erpFinancerRole->permissions()->attach($paymentsShow->id,);
//        $erpFinancerRole->permissions()->attach($paymentsUpdate->id,);
//        $erpFinancerRole->permissions()->attach($paymentsdestroy->id,);
//        // Company
//        $erpFinancerRole->permissions()->attach($companiesIndex->id,);
//        $erpFinancerRole->permissions()->attach($companiesCreate->id,);
//        $erpFinancerRole->permissions()->attach($companiesShow->id,);
//        $erpFinancerRole->permissions()->attach($companiesUpdate->id,);
//        $erpFinancerRole->permissions()->attach($companiesdestroy->id,);
//   <<--Erp Deliveries-->>
        $erpDeliveriesRole = Role::where('slug', 'erp_deliveries')->first();
        // Orders
        $erpDeliveriesRole->permissions()->sync([$ordersIndex->id, $ordersCreate->id, $ordersShow->id, $ordersUpdate->id,
            $ordersdestroy->id, $wowcherIndex->id, $wowcherCreate->id, $wowcherShow->id, $wowcherUpdate->id, $wowcherdestroy->id,
            $ejoggasIndex->id, $ejoggasCreate->id, $ejoggasShow->id, $ejoggasUpdate->id, $ejoggasdestroy->id, $amazonsIndex->id,
            $amazonsCreate->id, $amazonsShow->id, $amazonsUpdate->id, $amazonsdestroy->id, $grouponsIndex->id, $grouponsCreate->id,
            $grouponsShow->id, $grouponsUpdate->id, $grouponsdestroy->id, $xstreamgymsIndex->id, $xstreamgymsCreate->id,
            $xstreamgymsShow->id, $xstreamgymsUpdate->id, $xstreamgymsdestroy->id, $gogroopiesIndex->id, $gogroopiesCreate->id,
            $gogroopiesShow->id, $gogroopiesUpdate->id, $gogroopiesdestroy->id, $customersIndex->id, $customersCreate->id,
            $customersShow->id, $customersUpdate->id, $customersdestroy->id, $deliveriesIndex->id, $deliveriesCreate->id,
            $deliveriesShow->id, $deliveriesUpdate->id, $deliveriesdestroy->id, $stocksLogIndex->id, $stocksLogCreate->id,
            $stocksLogShow->id, $stocksLogUpdate->id, $stocksLogdestroy->id, $productTilesIndex->id, $productTilesCreate->id,
            $productTilesShow->id, $productTilesUpdate->id, $productTilesdestroy->id, $importsIndex->id, $importsCreate->id,
            $importsShow->id, $importsUpdate->id, $importsdestroy->id,]);

//        $erpDeliveriesRole->permissions()->attach($ordersCreate->id,);
//        $erpDeliveriesRole->permissions()->attach($ordersShow->id,);
//        $erpDeliveriesRole->permissions()->attach($ordersUpdate->id,);
//        $erpDeliveriesRole->permissions()->attach($ordersdestroy->id,);
//        // Wowcher
//        $erpDeliveriesRole->permissions()->attach($wowcherIndex->id,);
//        $erpDeliveriesRole->permissions()->attach($wowcherCreate->id,);
//        $erpDeliveriesRole->permissions()->attach($wowcherShow->id,);
//        $erpDeliveriesRole->permissions()->attach($wowcherUpdate->id,);
//        $erpDeliveriesRole->permissions()->attach($wowcherdestroy->id,);
//        // Ejogga
//        $erpDeliveriesRole->permissions()->attach($ejoggasIndex->id,);
//        $erpDeliveriesRole->permissions()->attach($ejoggasCreate->id,);
//        $erpDeliveriesRole->permissions()->attach($ejoggasShow->id,);
//        $erpDeliveriesRole->permissions()->attach($ejoggasUpdate->id,);
//        $erpDeliveriesRole->permissions()->attach($ejoggasdestroy->id,);
//        // Amazon
//        $erpDeliveriesRole->permissions()->attach($amazonsIndex->id,);
//        $erpDeliveriesRole->permissions()->attach($amazonsCreate->id,);
//        $erpDeliveriesRole->permissions()->attach($amazonsShow->id,);
//        $erpDeliveriesRole->permissions()->attach($amazonsUpdate->id,);
//        $erpDeliveriesRole->permissions()->attach($amazonsdestroy->id,);
//        // Groupon
//        $erpDeliveriesRole->permissions()->attach($grouponsIndex->id,);
//        $erpDeliveriesRole->permissions()->attach($grouponsCreate->id,);
//        $erpDeliveriesRole->permissions()->attach($grouponsShow->id,);
//        $erpDeliveriesRole->permissions()->attach($grouponsUpdate->id,);
//        $erpDeliveriesRole->permissions()->attach($grouponsdestroy->id,);
//        // Xstreamgym
//        $erpDeliveriesRole->permissions()->attach($xstreamgymsIndex->id,);
//        $erpDeliveriesRole->permissions()->attach($xstreamgymsCreate->id,);
//        $erpDeliveriesRole->permissions()->attach($xstreamgymsShow->id,);
//        $erpDeliveriesRole->permissions()->attach($xstreamgymsUpdate->id,);
//        $erpDeliveriesRole->permissions()->attach($xstreamgymsdestroy->id,);
//        // Gogroopie
//        $erpDeliveriesRole->permissions()->attach($gogroopiesIndex->id,);
//        $erpDeliveriesRole->permissions()->attach($gogroopiesCreate->id,);
//        $erpDeliveriesRole->permissions()->attach($gogroopiesShow->id,);
//        $erpDeliveriesRole->permissions()->attach($gogroopiesUpdate->id,);
//        $erpDeliveriesRole->permissions()->attach($gogroopiesdestroy->id,);
//
//        // Customers
//        $erpDeliveriesRole->permissions()->attach($customersIndex->id,);
//        $erpDeliveriesRole->permissions()->attach($customersCreate->id,);
//        $erpDeliveriesRole->permissions()->attach($customersShow->id,);
//        $erpDeliveriesRole->permissions()->attach($customersUpdate->id,);
//        $erpDeliveriesRole->permissions()->attach($customersdestroy->id,);
//        // Deliveries
//        $erpDeliveriesRole->permissions()->attach($deliveriesIndex->id,);
//        $erpDeliveriesRole->permissions()->attach($deliveriesCreate->id,);
//        $erpDeliveriesRole->permissions()->attach($deliveriesShow->id,);
//        $erpDeliveriesRole->permissions()->attach($deliveriesUpdate->id,);
//        $erpDeliveriesRole->permissions()->attach($deliveriesdestroy->id,);
//        // Stock Logs
//        $erpDeliveriesRole->permissions()->attach($stocksLogIndex->id,);
//        $erpDeliveriesRole->permissions()->attach($stocksLogCreate->id,);
//        $erpDeliveriesRole->permissions()->attach($stocksLogShow->id,);
//        $erpDeliveriesRole->permissions()->attach($stocksLogUpdate->id,);
//        $erpDeliveriesRole->permissions()->attach($stocksLogdestroy->id,);
//        // Product Titles
//        $erpDeliveriesRole->permissions()->attach($productTilesIndex->id,);
//        $erpDeliveriesRole->permissions()->attach($productTilesCreate->id,);
//        $erpDeliveriesRole->permissions()->attach($productTilesShow->id,);
//        $erpDeliveriesRole->permissions()->attach($productTilesUpdate->id,);
//        $erpDeliveriesRole->permissions()->attach($productTilesdestroy->id,);
//        // Imports
//        $erpDeliveriesRole->permissions()->attach($importsIndex->id,);
//        $erpDeliveriesRole->permissions()->attach($importsCreate->id,);
//        $erpDeliveriesRole->permissions()->attach($importsShow->id,);
//        $erpDeliveriesRole->permissions()->attach($importsUpdate->id,);
//        $erpDeliveriesRole->permissions()->attach($importsdestroy->id,);
//        // Product Details
//        $erpDeliveriesRole->permissions()->attach($productDetailsIndex->id);
//        $erpDeliveriesRole->permissions()->attach($productDetailsCreate->id);
//        $erpDeliveriesRole->permissions()->attach($productDetailsShow->id);
//        $erpDeliveriesRole->permissions()->attach($productDetailsUpdate->id);
//        $erpDeliveriesRole->permissions()->attach($productDetailsdestroy->id);

//   <<--Erp CSR Admin-->>
        $erpCsrAdminRole = Role::where('slug', 'erp_csr_admin')->first();
        // Orders
        $erpCsrAdminRole->permissions()->sync([$ordersIndex->id, $ordersCreate->id, $ordersShow->id, $ordersUpdate->id,
            $ordersdestroy->id, $wowcherIndex->id, $wowcherCreate->id, $wowcherShow->id, $wowcherUpdate->id, $wowcherdestroy->id,
            $ejoggasIndex->id, $ejoggasCreate->id, $ejoggasShow->id, $ejoggasUpdate->id, $ejoggasdestroy->id, $amazonsIndex->id,
            $amazonsCreate->id, $amazonsShow->id, $amazonsUpdate->id, $amazonsdestroy->id, $grouponsIndex->id, $grouponsCreate->id,
            $grouponsShow->id, $grouponsUpdate->id, $grouponsdestroy->id, $xstreamgymsIndex->id, $xstreamgymsCreate->id,
            $xstreamgymsShow->id, $xstreamgymsUpdate->id, $xstreamgymsdestroy->id, $gogroopiesIndex->id, $gogroopiesCreate->id,
            $gogroopiesShow->id, $gogroopiesUpdate->id, $gogroopiesdestroy->id, $customersIndex->id, $customersCreate->id,
            $customersShow->id, $customersUpdate->id, $customersdestroy->id, $emailSettingsIndex->id, $emailSettingsCreate->id,
            $emailSettingsShow->id, $emailSettingsUpdate->id, $emailSettingsdestroy->id, $casesIndex->id, $casesCreate->id,
            $casesShow->id, $casesUpdate->id, $casesdestroy->id, $fetchEmailIndex->id, $fetchEmailCreate->id, $fetchEmailShow->id,
            $fetchEmailUpdate->id, $fetchEmaildestroy->id,]);



//        $erpCsrAdminRole->permissions()->attach($ordersCreate->id,);
//        $erpCsrAdminRole->permissions()->attach($ordersShow->id,);
//        $erpCsrAdminRole->permissions()->attach($ordersUpdate->id,);
//        $erpCsrAdminRole->permissions()->attach($ordersdestroy->id,);
//        // Wowcher
//        $erpCsrAdminRole->permissions()->attach($wowcherIndex->id,);
//        $erpCsrAdminRole->permissions()->attach($wowcherCreate->id,);
//        $erpCsrAdminRole->permissions()->attach($wowcherShow->id,);
//        $erpCsrAdminRole->permissions()->attach($wowcherUpdate->id,);
//        $erpCsrAdminRole->permissions()->attach($wowcherdestroy->id,);
//        // Ejogga
//        $erpCsrAdminRole->permissions()->attach($ejoggasIndex->id,);
//        $erpCsrAdminRole->permissions()->attach($ejoggasCreate->id,);
//        $erpCsrAdminRole->permissions()->attach($ejoggasShow->id,);
//        $erpCsrAdminRole->permissions()->attach($ejoggasUpdate->id,);
//        $erpCsrAdminRole->permissions()->attach($ejoggasdestroy->id,);
//        // Amazon
//        $erpCsrAdminRole->permissions()->attach($amazonsIndex->id,);
//        $erpCsrAdminRole->permissions()->attach($amazonsCreate->id,);
//        $erpCsrAdminRole->permissions()->attach($amazonsShow->id,);
//        $erpCsrAdminRole->permissions()->attach($amazonsUpdate->id,);
//        $erpCsrAdminRole->permissions()->attach($amazonsdestroy->id,);
//        // Groupon
//        $erpCsrAdminRole->permissions()->attach($grouponsIndex->id,);
//        $erpCsrAdminRole->permissions()->attach($grouponsCreate->id,);
//        $erpCsrAdminRole->permissions()->attach($grouponsShow->id,);
//        $erpCsrAdminRole->permissions()->attach($grouponsUpdate->id,);
//        $erpCsrAdminRole->permissions()->attach($grouponsdestroy->id,);
//        // Xstreamgym
//        $erpCsrAdminRole->permissions()->attach($xstreamgymsIndex->id,);
//        $erpCsrAdminRole->permissions()->attach($xstreamgymsCreate->id,);
//        $erpCsrAdminRole->permissions()->attach($xstreamgymsShow->id,);
//        $erpCsrAdminRole->permissions()->attach($xstreamgymsUpdate->id,);
//        $erpCsrAdminRole->permissions()->attach($xstreamgymsdestroy->id,);
//        // Gogroopie
//        $erpCsrAdminRole->permissions()->attach($gogroopiesIndex->id,);
//        $erpCsrAdminRole->permissions()->attach($gogroopiesCreate->id,);
//        $erpCsrAdminRole->permissions()->attach($gogroopiesShow->id,);
//        $erpCsrAdminRole->permissions()->attach($gogroopiesUpdate->id,);
//        $erpCsrAdminRole->permissions()->attach($gogroopiesdestroy->id,);
//
//        // Customers
//        $erpCsrAdminRole->permissions()->attach($customersIndex->id,);
//        $erpCsrAdminRole->permissions()->attach($customersCreate->id,);
//        $erpCsrAdminRole->permissions()->attach($customersShow->id,);
//        $erpCsrAdminRole->permissions()->attach($customersUpdate->id,);
//        $erpCsrAdminRole->permissions()->attach($customersdestroy->id,);
//        //  Email Setting
//        $erpCsrAdminRole->permissions()->attach($emailSettingsIndex->id,);
//        $erpCsrAdminRole->permissions()->attach($emailSettingsCreate->id,);
//        $erpCsrAdminRole->permissions()->attach($emailSettingsShow->id,);
//        $erpCsrAdminRole->permissions()->attach($emailSettingsUpdate->id,);
//        $erpCsrAdminRole->permissions()->attach($emailSettingsdestroy->id,);
//        //  Cases
//        $erpCsrAdminRole->permissions()->attach($casesIndex->id,);
//        $erpCsrAdminRole->permissions()->attach($casesCreate->id,);
//        $erpCsrAdminRole->permissions()->attach($casesShow->id,);
//        $erpCsrAdminRole->permissions()->attach($casesUpdate->id,);
//        $erpCsrAdminRole->permissions()->attach($casesdestroy->id,);
//        //  Fetch Email
//        $erpCsrAdminRole->permissions()->attach($fetchEmailIndex->id,);
//        $erpCsrAdminRole->permissions()->attach($fetchEmailCreate->id,);
//        $erpCsrAdminRole->permissions()->attach($fetchEmailShow->id,);
//        $erpCsrAdminRole->permissions()->attach($fetchEmailUpdate->id,);
//        $erpCsrAdminRole->permissions()->attach($fetchEmaildestroy->id,);

        //   <<--Erp CSR-->>
        $erpCsrRole = Role::where('slug', 'erp_csr')->first();
        // Orders
        $erpCsrRole->permissions()->sync([$ordersIndex->id, $ordersCreate->id, $ordersShow->id, $ordersUpdate->id,
            $ordersdestroy->id, $wowcherIndex->id, $wowcherCreate->id, $wowcherShow->id, $wowcherUpdate->id, $wowcherdestroy->id,
            $ejoggasIndex->id, $ejoggasCreate->id, $ejoggasShow->id, $ejoggasUpdate->id, $ejoggasdestroy->id, $amazonsIndex->id,
            $amazonsCreate->id, $amazonsShow->id, $amazonsUpdate->id, $amazonsdestroy->id, $grouponsIndex->id, $grouponsCreate->id,
            $grouponsShow->id, $grouponsUpdate->id, $grouponsdestroy->id, $xstreamgymsIndex->id, $xstreamgymsCreate->id, $xstreamgymsShow->id,
            $xstreamgymsUpdate->id, $xstreamgymsdestroy->id, $gogroopiesIndex->id, $gogroopiesCreate->id, $gogroopiesShow->id,
            $gogroopiesUpdate->id, $gogroopiesdestroy->id, $casesIndex->id, $casesCreate->id, $casesShow->id, $casesUpdate->id,
            $casesdestroy->id, $fetchEmailIndex->id, $fetchEmailCreate->id, $fetchEmailShow->id, $fetchEmailUpdate->id,
            $fetchEmaildestroy->id,]);

//        $erpCsrRole->permissions()->attach($ordersCreate->id,);
//        $erpCsrRole->permissions()->attach($ordersShow->id,);
//        $erpCsrRole->permissions()->attach($ordersUpdate->id,);
//        $erpCsrRole->permissions()->attach($ordersdestroy->id,);
//        // Wowcher
//        $erpCsrRole->permissions()->attach($wowcherIndex->id,);
//        $erpCsrRole->permissions()->attach($wowcherCreate->id,);
//        $erpCsrRole->permissions()->attach($wowcherShow->id,);
//        $erpCsrRole->permissions()->attach($wowcherUpdate->id,);
//        $erpCsrRole->permissions()->attach($wowcherdestroy->id,);
//        // Ejogga
//        $erpCsrRole->permissions()->attach($ejoggasIndex->id,);
//        $erpCsrRole->permissions()->attach($ejoggasCreate->id,);
//        $erpCsrRole->permissions()->attach($ejoggasShow->id,);
//        $erpCsrRole->permissions()->attach($ejoggasUpdate->id,);
//        $erpCsrRole->permissions()->attach($ejoggasdestroy->id,);
//        // Amazon
//        $erpCsrRole->permissions()->attach($amazonsIndex->id,);
//        $erpCsrRole->permissions()->attach($amazonsCreate->id,);
//        $erpCsrRole->permissions()->attach($amazonsShow->id,);
//        $erpCsrRole->permissions()->attach($amazonsUpdate->id,);
//        $erpCsrRole->permissions()->attach($amazonsdestroy->id,);
//        // Groupon
//        $erpCsrRole->permissions()->attach($grouponsIndex->id,);
//        $erpCsrRole->permissions()->attach($grouponsCreate->id,);
//        $erpCsrRole->permissions()->attach($grouponsShow->id,);
//        $erpCsrRole->permissions()->attach($grouponsUpdate->id,);
//        $erpCsrRole->permissions()->attach($grouponsdestroy->id,);
//        // Xstreamgym
//        $erpCsrRole->permissions()->attach($xstreamgymsIndex->id,);
//        $erpCsrRole->permissions()->attach($xstreamgymsCreate->id,);
//        $erpCsrRole->permissions()->attach($xstreamgymsShow->id,);
//        $erpCsrRole->permissions()->attach($xstreamgymsUpdate->id,);
//        $erpCsrRole->permissions()->attach($xstreamgymsdestroy->id,);
//        // Gogroopie
//        $erpCsrRole->permissions()->attach($gogroopiesIndex->id,);
//        $erpCsrRole->permissions()->attach($gogroopiesCreate->id,);
//        $erpCsrRole->permissions()->attach($gogroopiesShow->id,);
//        $erpCsrRole->permissions()->attach($gogroopiesUpdate->id,);
//        $erpCsrRole->permissions()->attach($gogroopiesdestroy->id,);
//        //  Cases
//        $erpCsrRole->permissions()->attach($casesIndex->id,);
//        $erpCsrRole->permissions()->attach($casesCreate->id,);
//        $erpCsrRole->permissions()->attach($casesShow->id,);
//        $erpCsrRole->permissions()->attach($casesUpdate->id,);
//        $erpCsrRole->permissions()->attach($casesdestroy->id,);
//        //  Fetch Email
//        $erpCsrRole->permissions()->attach($fetchEmailIndex->id,);
//        $erpCsrRole->permissions()->attach($fetchEmailCreate->id,);
//        $erpCsrRole->permissions()->attach($fetchEmailShow->id,);
//        $erpCsrRole->permissions()->attach($fetchEmailUpdate->id,);
//        $erpCsrRole->permissions()->attach($fetchEmaildestroy->id,);
//   <<--Erp Hr-->>
        $erpHrRole = Role::where('slug', 'erp_hr')->first();

        //  Attendence
        $erpHrRole->permissions()->sync([$attendenceIndex->id, $attendenceCreate->id, $attendenceShow->id, $attendenceUpdate->id,
            $attendencedestroy->id, $employeesIndex->id, $employeesCreate->id, $employeesShow->id, $employeesUpdate->id,
            $employeesdestroy->id,]);

//        $erpHrRole->permissions()->attach($attendenceCreate->id,);
//        $erpHrRole->permissions()->attach($attendenceShow->id,);
//        $erpHrRole->permissions()->attach($attendenceUpdate->id,);
//        $erpHrRole->permissions()->attach($attendencedestroy->id,);
//        //  Employee
//        $erpHrRole->permissions()->attach($employeesIndex->id,);
//        $erpHrRole->permissions()->attach($employeesCreate->id,);
//        $erpHrRole->permissions()->attach($employeesShow->id,);
//        $erpHrRole->permissions()->attach($employeesUpdate->id,);
//        $erpHrRole->permissions()->attach($employeesdestroy->id,);

//   <<--Fulfilment Owner-->>
        $fulfilmentOwnerRole = Role::where('slug', 'fulfilment_owner')->first();
        //  Building
        $fulfilmentOwnerRole->permissions()->sync([$buildingIndex->id, $buildingCreate->id, $buildingShow->id,
            $buildingUpdate->id, $buildingdestroy->id, $containersIndex->id, $containersCreate->id, $containersShow->id,
            $containersUpdate->id, $containersdestroy->id, $calendarIndex->id, $calendarCreate->id, $calendarShow->id,
            $calendarUpdate->id, $calendardestroy->id, $fulfilmentOrdersIndex->id, $fulfilmentOrdersCreate->id,
            $fulfilmentOrdersShow->id, $fulfilmentOrdersUpdate->id, $fulfilmentOrdersdestroy->id, $warehouseShipmentsIndex->id,
            $warehouseShipmentsCreate->id, $warehouseShipmentsShow->id, $warehouseShipmentsUpdate->id, $warehouseShipmentsdestroy->id,
            $stockLogIndex->id, $stockLogCreate->id, $stockLogShow->id, $stockLogUpdate->id, $stockLogdestroy->id, $productStockIndex->id,
            $productStockCreate->id, $productStockShow->id, $productStockUpdate->id, $productStockdestroy->id, $deliveryIndex->id,
            $deliveryCreate->id, $deliveryShow->id, $deliveryUpdate->id, $deliverydestroy->id,]);

//        $fulfilmentOwnerRole->permissions()->attach($buildingCreate->id,);
//        $fulfilmentOwnerRole->permissions()->attach($buildingShow->id,);
//        $fulfilmentOwnerRole->permissions()->attach($buildingUpdate->id,);
//        $fulfilmentOwnerRole->permissions()->attach($buildingdestroy->id,);
//        //  Containers
//        $fulfilmentOwnerRole->permissions()->attach($containersIndex->id,);
//        $fulfilmentOwnerRole->permissions()->attach($containersCreate->id,);
//        $fulfilmentOwnerRole->permissions()->attach($containersShow->id,);
//        $fulfilmentOwnerRole->permissions()->attach($containersUpdate->id,);
//        $fulfilmentOwnerRole->permissions()->attach($containersdestroy->id,);
//        //  Calendar
//        $fulfilmentOwnerRole->permissions()->attach($calendarIndex->id,);
//        $fulfilmentOwnerRole->permissions()->attach($calendarCreate->id,);
//        $fulfilmentOwnerRole->permissions()->attach($calendarShow->id,);
//        $fulfilmentOwnerRole->permissions()->attach($calendarUpdate->id,);
//        $fulfilmentOwnerRole->permissions()->attach($calendardestroy->id,);
//        //  Fulfilment Order
//        $fulfilmentOwnerRole->permissions()->attach($fulfilmentOrdersIndex->id,);
//        $fulfilmentOwnerRole->permissions()->attach($fulfilmentOrdersCreate->id,);
//        $fulfilmentOwnerRole->permissions()->attach($fulfilmentOrdersShow->id,);
//        $fulfilmentOwnerRole->permissions()->attach($fulfilmentOrdersUpdate->id,);
//        $fulfilmentOwnerRole->permissions()->attach($fulfilmentOrdersdestroy->id,);
//        //  Warehouse Shipment
//        $fulfilmentOwnerRole->permissions()->attach($warehouseShipmentsIndex->id,);
//        $fulfilmentOwnerRole->permissions()->attach($warehouseShipmentsCreate->id,);
//        $fulfilmentOwnerRole->permissions()->attach($warehouseShipmentsShow->id,);
//        $fulfilmentOwnerRole->permissions()->attach($warehouseShipmentsUpdate->id,);
//        $fulfilmentOwnerRole->permissions()->attach($warehouseShipmentsdestroy->id,);
//        //  Stock Log
//        $fulfilmentOwnerRole->permissions()->attach($stockLogIndex->id,);
//        $fulfilmentOwnerRole->permissions()->attach($stockLogCreate->id,);
//        $fulfilmentOwnerRole->permissions()->attach($stockLogShow->id,);
//        $fulfilmentOwnerRole->permissions()->attach($stockLogUpdate->id,);
//        $fulfilmentOwnerRole->permissions()->attach($stockLogdestroy->id,);
//        //  Product Stock
//        $fulfilmentOwnerRole->permissions()->attach($productStockIndex->id,);
//        $fulfilmentOwnerRole->permissions()->attach($productStockCreate->id,);
//        $fulfilmentOwnerRole->permissions()->attach($productStockShow->id,);
//        $fulfilmentOwnerRole->permissions()->attach($productStockUpdate->id,);
//        $fulfilmentOwnerRole->permissions()->attach($productStockdestroy->id,);
//        // Fulfilment delivry
//        $fulfilmentOwnerRole->permissions()->attach($deliveryIndex->id,);
//        $fulfilmentOwnerRole->permissions()->attach($deliveryCreate->id,);
//        $fulfilmentOwnerRole->permissions()->attach($deliveryShow->id,);
//        $fulfilmentOwnerRole->permissions()->attach($deliveryUpdate->id,);
//        $fulfilmentOwnerRole->permissions()->attach($deliverydestroy->id,);

//        //WareHouse
//        $fulfilmentOwnerRole->permissions()->attach($warehouseIndex->id);
//        $fulfilmentOwnerRole->permissions()->attach($warehouseCreate->id);
//        $fulfilmentOwnerRole->permissions()->attach($warehouseShow->id);
//        $fulfilmentOwnerRole->permissions()->attach($warehouseUpdate->id);
//        //  User
//        $fulfilmentOwnerRole->permissions()->attach($usersIndex->id);
//        $fulfilmentOwnerRole->permissions()->attach($usersCreate->id);
//        $fulfilmentOwnerRole->permissions()->attach($usersShow->id);
//        $fulfilmentOwnerRole->permissions()->attach($usersUpdate->id);
//        $fulfilmentOwnerRole->permissions()->attach($usersdestroy->id);
//        // Deliveries
//        $fulfilmentOwnerRole->permissions()->attach($deliveryIndex->id);
//        $fulfilmentOwnerRole->permissions()->attach($deliveryCreate->id);
//        $fulfilmentOwnerRole->permissions()->attach($deliveryShow->id);
//        $fulfilmentOwnerRole->permissions()->attach($deliveryUpdate->id);
//        $fulfilmentOwnerRole->permissions()->attach($deliverydestroy->id);

//
//        $ownerRole->permissions()->attach($paymentGatewaysIndex->id);
//        $ownerRole->permissions()->attach($paymentGatewaysCreate->id);
//        $ownerRole->permissions()->attach($paymentGatewaysUpdate->id);
//        $ownerRole->permissions()->attach($paymentGatewaysdestroy->id);

//        $ownerRole = Role::where('slug', 'warehouse_user')->first();
//        $warehousesIndex = Permission::updateOrCreate(['action'=> 'warehouses.index']);
//        $ownerRole->permissions()->attach($warehousesIndex->id);
//        $warehousesCreate = Permission::updateOrCreate(['action'=> 'warehouses.create']);
//        $ownerRole->permissions()->attach($warehousesCreate->id);
//        $warehousesUpdate = Permission::updateOrCreate(['action'=> 'warehouses.update']);
//        $ownerRole->permissions()->attach($warehousesUpdate->id);
//        $warehousesdestroy = Permission::updateOrCreate(['action'=> 'warehouses.destroy']);
//        $ownerRole->permissions()->attach($warehousesdestroy->id);


        //   <<--Fulfilment Admin-->>
        $fulfilmentAdminRole = Role::where('slug', 'fulfilment_admin')->first();
        //  Building
        $fulfilmentAdminRole->permissions()->sync([$buildingIndex->id, $buildingCreate->id, $buildingShow->id,
            $buildingUpdate->id, $buildingdestroy->id, $containersIndex->id, $containersCreate->id, $containersShow->id,
            $containersUpdate->id, $containersdestroy->id, $calendarIndex->id, $calendarCreate->id, $calendarShow->id,
            $calendarUpdate->id, $calendardestroy->id, $fulfilmentOrdersIndex->id, $fulfilmentOrdersCreate->id,
            $fulfilmentOrdersShow->id, $fulfilmentOrdersUpdate->id, $fulfilmentOrdersdestroy->id, $warehouseShipmentsIndex->id,
            $warehouseShipmentsCreate->id, $warehouseShipmentsShow->id, $warehouseShipmentsUpdate->id, $warehouseShipmentsdestroy->id,
            $stockLogIndex->id, $stockLogCreate->id, $stockLogShow->id, $stockLogUpdate->id, $stockLogdestroy->id,
            $productStockIndex->id, $productStockCreate->id, $productStockShow->id, $productStockUpdate->id, $productStockdestroy->id,
            $deliveryIndex->id, $deliveryCreate->id, $deliveryShow->id, $deliveryUpdate->id, $deliverydestroy->id]);

//        $fulfilmentAdminRole->permissions()->attach($buildingCreate->id,);
//        $fulfilmentAdminRole->permissions()->attach($buildingShow->id,);
//        $fulfilmentAdminRole->permissions()->attach($buildingUpdate->id,);
//        $fulfilmentAdminRole->permissions()->attach($buildingdestroy->id,);
//        //  Containers
//        $fulfilmentAdminRole->permissions()->attach($containersIndex->id,);
//        $fulfilmentAdminRole->permissions()->attach($containersCreate->id,);
//        $fulfilmentAdminRole->permissions()->attach($containersShow->id,);
//        $fulfilmentAdminRole->permissions()->attach($containersUpdate->id,);
//        $fulfilmentAdminRole->permissions()->attach($containersdestroy->id,);
//        //  Calendar
//        $fulfilmentAdminRole->permissions()->attach($calendarIndex->id,);
//        $fulfilmentAdminRole->permissions()->attach($calendarCreate->id,);
//        $fulfilmentAdminRole->permissions()->attach($calendarShow->id,);
//        $fulfilmentAdminRole->permissions()->attach($calendarUpdate->id,);
//        $fulfilmentAdminRole->permissions()->attach($calendardestroy->id,);
//        //  Fulfilment Order
//        $fulfilmentAdminRole->permissions()->attach($fulfilmentOrdersIndex->id,);
//        $fulfilmentAdminRole->permissions()->attach($fulfilmentOrdersCreate->id,);
//        $fulfilmentAdminRole->permissions()->attach($fulfilmentOrdersShow->id,);
//        $fulfilmentAdminRole->permissions()->attach($fulfilmentOrdersUpdate->id,);
//        $fulfilmentAdminRole->permissions()->attach($fulfilmentOrdersdestroy->id,);
//        //  Warehouse Shipment
//        $fulfilmentAdminRole->permissions()->attach($warehouseShipmentsIndex->id,);
//        $fulfilmentAdminRole->permissions()->attach($warehouseShipmentsCreate->id,);
//        $fulfilmentAdminRole->permissions()->attach($warehouseShipmentsShow->id,);
//        $fulfilmentAdminRole->permissions()->attach($warehouseShipmentsUpdate->id,);
//        $fulfilmentAdminRole->permissions()->attach($warehouseShipmentsdestroy->id,);
//        //  Stock Log
//        $fulfilmentAdminRole->permissions()->attach($stockLogIndex->id,);
//        $fulfilmentAdminRole->permissions()->attach($stockLogCreate->id,);
//        $fulfilmentAdminRole->permissions()->attach($stockLogShow->id,);
//        $fulfilmentAdminRole->permissions()->attach($stockLogUpdate->id,);
//        $fulfilmentAdminRole->permissions()->attach($stockLogdestroy->id,);
//        //  Product Stock
//        $fulfilmentAdminRole->permissions()->attach($productStockIndex->id,);
//        $fulfilmentAdminRole->permissions()->attach($productStockCreate->id,);
//        $fulfilmentAdminRole->permissions()->attach($productStockShow->id,);
//        $fulfilmentAdminRole->permissions()->attach($productStockUpdate->id,);
//        $fulfilmentAdminRole->permissions()->attach($productStockdestroy->id,);
//        // Fulfilment delivry
//        $fulfilmentAdminRole->permissions()->attach($deliveryIndex->id,);
//        $fulfilmentAdminRole->permissions()->attach($deliveryCreate->id,);
//        $fulfilmentAdminRole->permissions()->attach($deliveryShow->id,);
//        $fulfilmentAdminRole->permissions()->attach($deliveryUpdate->id,);
//        $fulfilmentAdminRole->permissions()->attach($deliverydestroy->id,);


        //   <<--Fulfilment User-->>
        $fulfilmentUSerRole = Role::where('slug', 'fulfilment_user')->first();

        $fulfilmentUSerRole->permissions()->sync([$deliveriesIndex->id, $deliveriesCreate->id, $deliveriesShow->id,
            $deliveriesUpdate->id, $deliveriesdestroy->id, $buildingIndex->id, $buildingCreate->id, $buildingShow->id,
            $buildingUpdate->id, $buildingdestroy->id, $containersIndex->id, $containersCreate->id, $containersShow->id,
            $containersUpdate->id, $containersdestroy->id, $fulfilmentOrdersIndex->id, $fulfilmentOrdersCreate->id, $fulfilmentOrdersShow->id,
            $fulfilmentOrdersUpdate->id, $fulfilmentOrdersdestroy->id, $warehouseShipmentsIndex->id, $warehouseShipmentsCreate->id,
            $warehouseShipmentsShow->id, $warehouseShipmentsUpdate->id, $warehouseShipmentsdestroy->id, $calendarIndex->id,
            $calendarCreate->id, $calendarShow->id, $calendarUpdate->id,$calendardestroy->id, $stockLogIndex->id,
            $stockLogCreate->id, $stockLogShow->id, $stockLogUpdate->id, $stockLogdestroy->id, $deliveryIndex->id,
            $deliveryCreate->id, $deliveryShow->id, $deliveryUpdate->id, $deliverydestroy->id]);

//        $fulfilmentUSerRole->permissions()->attach($deliveriesCreate->id,);
//        $fulfilmentUSerRole->permissions()->attach($deliveriesShow->id,);
//        $fulfilmentUSerRole->permissions()->attach($deliveriesUpdate->id,);
//        $fulfilmentUSerRole->permissions()->attach($deliveriesdestroy->id,);
//        //  Building
//        $fulfilmentUSerRole->permissions()->attach($buildingIndex->id,);
//        $fulfilmentUSerRole->permissions()->attach($buildingCreate->id,);
//        $fulfilmentUSerRole->permissions()->attach($buildingShow->id,);
//        $fulfilmentUSerRole->permissions()->attach($buildingUpdate->id,);
//        $fulfilmentUSerRole->permissions()->attach($buildingdestroy->id,);
//        //  Containers
//        $fulfilmentUSerRole->permissions()->attach($containersIndex->id,);
//        $fulfilmentUSerRole->permissions()->attach($containersCreate->id,);
//        $fulfilmentUSerRole->permissions()->attach($containersShow->id,);
//        $fulfilmentUSerRole->permissions()->attach($containersUpdate->id,);
//        $fulfilmentUSerRole->permissions()->attach($containersdestroy->id,);
//        //  Fulfilment Order
//        $fulfilmentUSerRole->permissions()->attach($fulfilmentOrdersIndex->id,);
//        $fulfilmentUSerRole->permissions()->attach($fulfilmentOrdersCreate->id,);
//        $fulfilmentUSerRole->permissions()->attach($fulfilmentOrdersShow->id,);
//        $fulfilmentUSerRole->permissions()->attach($fulfilmentOrdersUpdate->id,);
//        $fulfilmentUSerRole->permissions()->attach($fulfilmentOrdersdestroy->id,);
//        //  Warehouse Shipment
//        $fulfilmentUSerRole->permissions()->attach($warehouseShipmentsIndex->id,);
//        $fulfilmentUSerRole->permissions()->attach($warehouseShipmentsCreate->id,);
//        $fulfilmentUSerRole->permissions()->attach($warehouseShipmentsShow->id,);
//        $fulfilmentUSerRole->permissions()->attach($warehouseShipmentsUpdate->id,);
//        $fulfilmentUSerRole->permissions()->attach($warehouseShipmentsdestroy->id,);
//        //  Calendar
//        $fulfilmentUSerRole->permissions()->attach($calendarIndex->id,);
//        $fulfilmentUSerRole->permissions()->attach($calendarCreate->id,);
//        $fulfilmentUSerRole->permissions()->attach($calendarShow->id,);
//        $fulfilmentUSerRole->permissions()->attach($calendarUpdate->id,);
//        $fulfilmentUSerRole->permissions()->attach($calendardestroy->id,);
//        //  Stock Log
//        $fulfilmentUSerRole->permissions()->attach($stockLogIndex->id,);
//        $fulfilmentUSerRole->permissions()->attach($stockLogCreate->id,);
//        $fulfilmentUSerRole->permissions()->attach($stockLogShow->id,);
//        $fulfilmentUSerRole->permissions()->attach($stockLogUpdate->id,);
//        $fulfilmentUSerRole->permissions()->attach($stockLogdestroy->id,);
//        // Fulfilment delivry
//        $fulfilmentUSerRole->permissions()->attach($deliveryIndex->id,);
//        $fulfilmentUSerRole->permissions()->attach($deliveryCreate->id,);
//        $fulfilmentUSerRole->permissions()->attach($deliveryShow->id,);
//        $fulfilmentUSerRole->permissions()->attach($deliveryUpdate->id,);
//        $fulfilmentUSerRole->permissions()->attach($deliverydestroy->id,);
//

//        $fulfilmentUSerRole->permissions()->attach($warehouseIndex->id);
//        $fulfilmentUSerRole->permissions()->attach($warehouseCreate->id);
//        $fulfilmentUSerRole->permissions()->attach($warehouseShow->id);
//        $fulfilmentUSerRole->permissions()->attach($warehouseUpdate->id);

    }
}
