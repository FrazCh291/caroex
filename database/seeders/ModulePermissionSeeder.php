<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class ModulePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $coreModule = Module::firstOrCreate(['name' => 'Cores']);

        // Permission::firstOrCreate([
        //     'action' => 'cores.index',
        //     'module_id' => $coreModule->id
        // ], [
        //     'action' => 'cores.index',
        //     'description' => 'Can view cores',
        //     'module_id' => $coreModule->id
        // ]);

        // Permission::firstOrCreate([
        //     'action' => 'cores.create',
        //     'module_id' => $coreModule->id
        // ], [
        //     'action' => 'cores.create',
        //     'description' => 'Can create cores',
        //     'module_id' => $coreModule->id
        // ]);

        // Permission::firstOrCreate([
        //     'action' => 'cores.show',
        //     'module_id' => $coreModule->id
        // ], [
        //     'action' => 'cores.show',
        //     'description' => 'Can view cores',
        //     'module_id' => $coreModule->id
        // ]);

        // Permission::firstOrCreate([
        //     'action' => 'cores.update',
        //     'module_id' => $coreModule->id
        // ], [
        //     'action' => 'cores.update',
        //     'description' => 'Can update cores',
        //     'module_id' => $coreModule->id
        // ]);
        // Permission::firstOrCreate([
        //     'action' => 'cores.destroy',
        //     'module_id' => $coreModule->id
        // ], [
        //     'action' => 'cores.destroy',
        //     'description' => 'Can destroy cores',
        //     'module_id' => $coreModule->id
        // ]);

        // $notificationsModule = Module::firstOrCreate(['name' => 'Notifications']);

        // Permission::firstOrCreate([
        //     'action' => 'notifications.index',
        //     'module_id' => $notificationsModule->id
        // ], [
        //     'action' => 'notifications.index',
        //     'description' => 'Can view notifications',
        //     'module_id' => $notificationsModule->id
        // ]);

        // Permission::firstOrCreate([
        //     'action' => 'notifications.create',
        //     'module_id' => $notificationsModule->id
        // ], [
        //     'action' => 'notifications.create',
        //     'description' => 'Can create notifications',
        //     'module_id' => $notificationsModule->id
        // ]);

        // Permission::firstOrCreate([
        //     'action' => 'notifications.show',
        //     'module_id' => $notificationsModule->id
        // ], [
        //     'action' => 'notifications.show',
        //     'description' => 'Can view notifications',
        //     'module_id' => $notificationsModule->id
        // ]);

        // Permission::firstOrCreate([
        //     'action' => 'notifications.update',
        //     'module_id' => $notificationsModule->id
        // ], [
        //     'action' => 'notifications.update',
        //     'description' => 'Can update notifications',
        //     'module_id' => $notificationsModule->id
        // ]);
        // Permission::firstOrCreate([
        //     'action' => 'notifications.destroy',
        //     'module_id' => $notificationsModule->id
        // ], [
        //     'action' => 'notifications.destroy',
        //     'description' => 'Can destroy notifications',
        //     'module_id' => $notificationsModule->id
        // ]);

        $customerServices = Module::firstOrCreate(['name' => 'Customer Services']);

        Permission::firstOrCreate([
            'action' => 'customer-services.index',
            'module_id' => $customerServices->id
        ], [
            'action' => 'customer-services.index',
            'description' => 'Can view customer services',
            'module_id' => $customerServices->id
        ]);

        Permission::firstOrCreate([
            'action' => 'customer-services.create',
            'module_id' => $customerServices->id
        ], [
            'action' => 'customer-services.create',
            'description' => 'Can create customer services',
            'module_id' => $customerServices->id
        ]);

        Permission::firstOrCreate([
            'action' => 'customer-services.show',
            'module_id' => $customerServices->id
        ], [
            'action' => 'customer-services.show',
            'description' => 'Can view customer services',
            'module_id' => $customerServices->id
        ]);

        Permission::firstOrCreate([
            'action' => 'customer-services.update',
            'module_id' => $customerServices->id
        ], [
            'action' => 'customer-services.update',
            'description' => 'Can update customer services',
            'module_id' => $customerServices->id
        ]);
        Permission::firstOrCreate([
            'action' => 'customer-services.destroy',
            'module_id' => $customerServices->id
        ], [
            'action' => 'customer-services.destroy',
            'description' => 'Can destroy customer services',
            'module_id' => $customerServices->id
        ]);

        $roleModule = Module::firstOrCreate(['name' => 'Roles']);

        Permission::firstOrCreate([
            'action' => 'roles.index',
            'module_id' => $roleModule->id
        ], [
            'action' => 'roles.index',
            'description' => 'Can view roles',
            'module_id' => $roleModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'roles.create',
            'module_id' => $roleModule->id
        ], [
            'action' => 'roles.create',
            'description' => 'Can create roles',
            'module_id' => $roleModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'roles.show',
            'module_id' => $roleModule->id
        ], [
            'action' => 'roles.show',
            'description' => 'Can view roles',
            'module_id' => $roleModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'roles.update',
            'module_id' => $roleModule->id
        ], [
            'action' => 'roles.update',
            'description' => 'Can update roles',
            'module_id' => $roleModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'roles.destroy',
            'module_id' => $roleModule->id
        ], [
            'action' => 'roles.destroy',
            'description' => 'Can destroy roles',
            'module_id' => $roleModule->id
        ]);

        $paymentModule = Module::firstOrCreate(['name' => 'Payments']);

        Permission::firstOrCreate([
            'action' => 'payments.index',
            'module_id' => $paymentModule->id
        ], [
            'action' => 'payments.index',
            'description' => 'Can view payments',
            'module_id' => $paymentModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'payments.create',
            'module_id' => $paymentModule->id
        ], [
            'action' => 'payments.create',
            'description' => 'Can create payments',
            'module_id' => $paymentModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'payments.show',
            'module_id' => $paymentModule->id
        ], [
            'action' => 'payments.show',
            'description' => 'Can view payments',
            'module_id' => $paymentModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'payments.update',
            'module_id' => $paymentModule->id
        ], [
            'action' => 'payments.update',
            'description' => 'Can update payments',
            'module_id' => $paymentModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'payments.destroy',
            'module_id' => $paymentModule->id
        ], [
            'action' => 'payments.destroy',
            'description' => 'Can destroy payments',
            'module_id' => $paymentModule->id
        ]);


        $wowcherModule = Module::firstOrCreate(['name' => 'Wowchers']);

        Permission::firstOrCreate([
            'action' => 'wowchers.index',
            'module_id' => $wowcherModule->id
        ], [
            'action' => 'wowchers.index',
            'description' => 'Can view wowcher',
            'module_id' => $wowcherModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'wowchers.create',
            'module_id' => $wowcherModule->id
        ], [
            'action' => 'wowchers.create',
            'description' => 'Can create wowcher',
            'module_id' => $wowcherModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'wowchers.show',
            'module_id' => $wowcherModule->id
        ], [
            'action' => 'wowchers.show',
            'description' => 'Can view wowcher',
            'module_id' => $wowcherModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'wowchers.update',
            'module_id' => $wowcherModule->id
        ], [
            'action' => 'wowchers.update',
            'description' => 'Can update wowcher',
            'module_id' => $wowcherModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'wowchers.destroy',
            'module_id' => $wowcherModule->id
        ], [
            'action' => 'wowchers.destroy',
            'description' => 'Can destroy wowcher',
            'module_id' => $wowcherModule->id
        ]);

        $goproopieModule = Module::firstOrCreate(['name' => 'Gogroopie']);

        Permission::firstOrCreate([
            'action' => 'gogroopie.index',
            'module_id' => $goproopieModule->id
        ], [
            'action' => 'gogroopie.index',
            'description' => 'Can view gogroopie',
            'module_id' => $goproopieModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'gogroopie.create',
            'module_id' => $goproopieModule->id
        ], [
            'action' => 'gogroopie.create',
            'description' => 'Can create gogroopie',
            'module_id' => $goproopieModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'gogroopie.show',
            'module_id' => $goproopieModule->id
        ], [
            'action' => 'gogroopie.show',
            'description' => 'Can view gogroopie',
            'module_id' => $goproopieModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'gogroopie.update',
            'module_id' => $goproopieModule->id
        ], [
            'action' => 'gogroopie.update',
            'description' => 'Can update gogroopie',
            'module_id' => $goproopieModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'gogroopie.destroy',
            'module_id' => $goproopieModule->id
        ], [
            'action' => 'gogroopie.destroy',
            'description' => 'Can destroy gogroopie',
            'module_id' => $goproopieModule->id
        ]);


        $grouponModule = Module::firstOrCreate(['name' => 'Groupon']);

        Permission::firstOrCreate([
            'action' => 'groupon.index',
            'module_id' => $grouponModule->id
        ], [
            'action' => 'groupon.index',
            'description' => 'Can view groupon',
            'module_id' => $grouponModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'groupon.create',
            'module_id' => $grouponModule->id
        ], [
            'action' => 'groupon.create',
            'description' => 'Can create groupon',
            'module_id' => $grouponModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'groupon.show',
            'module_id' => $grouponModule->id
        ], [
            'action' => 'groupon.show',
            'description' => 'Can view groupon',
            'module_id' => $grouponModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'groupon.update',
            'module_id' => $grouponModule->id
        ], [
            'action' => 'groupon.update',
            'description' => 'Can update groupon',
            'module_id' => $grouponModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'groupon.destroy',
            'module_id' => $grouponModule->id
        ], [
            'action' => 'groupon.destroy',
            'description' => 'Can destroy groupon',
            'module_id' => $grouponModule->id
        ]);

        $xstreamgyModule = Module::firstOrCreate(['name' => 'Xstreamgyms']);

        Permission::firstOrCreate([
            'action' => 'xstreamgyms.index',
            'module_id' => $xstreamgyModule->id
        ], [
            'action' => 'xstreamgyms.index',
            'description' => 'Can view xstreamgyms',
            'module_id' => $xstreamgyModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'xstreamgyms.create',
            'module_id' => $xstreamgyModule->id
        ], [
            'action' => 'xstreamgyms.create',
            'description' => 'Can create xstreamgyms',
            'module_id' => $xstreamgyModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'xstreamgyms.show',
            'module_id' => $xstreamgyModule->id
        ], [
            'action' => 'xstreamgyms.show',
            'description' => 'Can view xstreamgyms',
            'module_id' => $xstreamgyModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'xstreamgyms.update',
            'module_id' => $xstreamgyModule->id
        ], [
            'action' => 'xstreamgyms.update',
            'description' => 'Can update xstreamgyms',
            'module_id' => $xstreamgyModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'xstreamgyms.destroy',
            'module_id' => $xstreamgyModule->id
        ], [
            'action' => 'xstreamgyms.destroy',
            'description' => 'Can destroy xstreamgyms',
            'module_id' => $xstreamgyModule->id
        ]);


        $customerModule = Module::firstOrCreate(['name' => 'Customers']);

        Permission::firstOrCreate([
            'action' => 'customers.index',
            'module_id' => $customerModule->id
        ], [
            'action' => 'customers.index',
            'description' => 'Can view customers',
            'module_id' => $customerModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'customers.create',
            'module_id' => $customerModule->id
        ], [
            'action' => 'customers.create',
            'description' => 'Can create customers',
            'module_id' => $customerModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'customers.show',
            'module_id' => $customerModule->id
        ], [
            'action' => 'customers.show',
            'description' => 'Can view customers',
            'module_id' => $customerModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'customers.update',
            'module_id' => $customerModule->id
        ], [
            'action' => 'customers.update',
            'description' => 'Can update customers',
            'module_id' => $customerModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'customers.destroy',
            'module_id' => $customerModule->id
        ], [
            'action' => 'customers.destroy',
            'description' => 'Can destroy customers',
            'module_id' => $customerModule->id
        ]);


        $orderModule = Module::firstOrCreate(['name' => 'Orders']);

        Permission::firstOrCreate([
            'action' => 'orders.index',
            'module_id' => $orderModule->id
        ], [
            'action' => 'orders.index',
            'description' => 'Can view orders',
            'module_id' => $orderModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'orders.create',
            'module_id' => $orderModule->id
        ], [
            'action' => 'orders.create',
            'description' => 'Can create orders',
            'module_id' => $orderModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'orders.show',
            'module_id' => $orderModule->id
        ], [
            'action' => 'orders.show',
            'description' => 'Can view orders',
            'module_id' => $orderModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'orders.update',
            'module_id' => $orderModule->id
        ], [
            'action' => 'orders.update',
            'description' => 'Can update orders',
            'module_id' => $orderModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'orders.destroy',
            'module_id' => $orderModule->id
        ], [
            'action' => 'orders.destroy',
            'description' => 'Can destroy orders',
            'module_id' => $orderModule->id
        ]);

        $purchaseOrdersModule = Module::firstOrCreate(['name' => 'Purchase Orders']);

        Permission::firstOrCreate([
            'action' => 'purchase-orders.index',
            'module_id' => $purchaseOrdersModule->id
        ], [
            'action' => 'purchase-orders.index',
            'description' => 'Can view Purchase Orders',
            'module_id' => $purchaseOrdersModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'purchase-orders.create',
            'module_id' => $purchaseOrdersModule->id
        ], [
            'action' => 'purchase-orders.create',
            'description' => 'Can create Purchase Orders',
            'module_id' => $purchaseOrdersModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'purchase-orders.show',
            'module_id' => $purchaseOrdersModule->id
        ], [
            'action' => 'purchase-orders.show',
            'description' => 'Can view Purchase Orders',
            'module_id' => $purchaseOrdersModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'purchase-orders.update',
            'module_id' => $purchaseOrdersModule->id
        ], [
            'action' => 'purchase-orders.update',
            'description' => 'Can update Purchase Orders',
            'module_id' => $purchaseOrdersModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'purchase-orders.destroy',
            'module_id' => $purchaseOrdersModule->id
        ], [
            'action' => 'purchase-orders.destroy',
            'description' => 'Can destroy Purchase Orders',
            'module_id' => $purchaseOrdersModule->id
        ]);

        $deliveriesModule = Module::firstOrCreate(['name' => 'Deliveries']);

        Permission::firstOrCreate([
            'action' => 'deliveries.index',
            'module_id' => $deliveriesModule->id
        ], [
            'action' => 'deliveries.index',
            'description' => 'Can view deliveries',
            'module_id' => $deliveriesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'deliveries.create',
            'module_id' => $deliveriesModule->id
        ], [
            'action' => 'deliveries.create',
            'description' => 'Can create deliveries',
            'module_id' => $deliveriesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'deliveries.show',
            'module_id' => $deliveriesModule->id
        ], [
            'action' => 'deliveries.show',
            'description' => 'Can view deliveries',
            'module_id' => $deliveriesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'deliveries.update',
            'module_id' => $deliveriesModule->id
        ], [
            'action' => 'deliveries.update',
            'description' => 'Can update deliveries',
            'module_id' => $deliveriesModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'deliveries.destroy',
            'module_id' => $deliveriesModule->id
        ], [
            'action' => 'deliveries.destroy',
            'description' => 'Can destroy deliveries',
            'module_id' => $deliveriesModule->id
        ]);


        $deliveryModule = Module::firstOrCreate(['name' => 'Delivery']);

        Permission::firstOrCreate([
            'action' => 'delivery.index',
            'module_id' => $deliveryModule->id
        ], [
            'action' => 'delivery.index',
            'description' => 'Can view delivery',
            'module_id' => $deliveryModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'delivery.create',
            'module_id' => $deliveryModule->id
        ], [
            'action' => 'delivery.create',
            'description' => 'Can create delivery',
            'module_id' => $deliveryModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'delivery.show',
            'module_id' => $deliveryModule->id
        ], [
            'action' => 'delivery.show',
            'description' => 'Can view delivery',
            'module_id' => $deliveryModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'delivery.update',
            'module_id' => $deliveryModule->id
        ], [
            'action' => 'delivery.update',
            'description' => 'Can update delivery',
            'module_id' => $deliveryModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'delivery.destroy',
            'module_id' => $deliveryModule->id
        ], [
            'action' => 'delivery.destroy',
            'description' => 'Can destroy delivery',
            'module_id' => $deliveryModule->id
        ]);

        $warehousesModule = Module::firstOrCreate(['name' => 'Warehouses']);

        Permission::firstOrCreate([
            'action' => 'warehouses.index',
            'module_id' => $warehousesModule->id
        ], [
            'action' => 'warehouses.index',
            'description' => 'Can view warehouses',
            'module_id' => $warehousesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'warehouses.create',
            'module_id' => $warehousesModule->id
        ], [
            'action' => 'warehouses.create',
            'description' => 'Can create warehouses',
            'module_id' => $warehousesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'warehouses.show',
            'module_id' => $warehousesModule->id
        ], [
            'action' => 'warehouses.show',
            'description' => 'Can view warehouses',
            'module_id' => $warehousesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'warehouses.update',
            'module_id' => $warehousesModule->id
        ], [
            'action' => 'warehouses.update',
            'description' => 'Can update warehouses',
            'module_id' => $warehousesModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'warehouses.destroy',
            'module_id' => $warehousesModule->id
        ], [
            'action' => 'warehouses.destroy',
            'description' => 'Can destroy warehouses',
            'module_id' => $warehousesModule->id
        ]);

        $warehouseModule = Module::firstOrCreate(['name' => 'Warehouse']);

        Permission::firstOrCreate([
            'action' => 'warehouse.index',
            'module_id' => $warehouseModule->id
        ], [
            'action' => 'warehouse.index',
            'description' => 'Can view warehouse',
            'module_id' => $warehouseModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'warehouse.create',
            'module_id' => $warehouseModule->id
        ], [
            'action' => 'warehouse.create',
            'description' => 'Can create warehouse',
            'module_id' => $warehouseModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'warehouse.show',
            'module_id' => $warehouseModule->id
        ], [
            'action' => 'warehouse.show',
            'description' => 'Can view warehouse',
            'module_id' => $warehouseModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'warehouse.update',
            'module_id' => $warehouseModule->id
        ], [
            'action' => 'warehouse.update',
            'description' => 'Can update warehouse',
            'module_id' => $warehouseModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'warehouse.destroy',
            'module_id' => $warehouseModule->id
        ], [
            'action' => 'warehouse.destroy',
            'description' => 'Can destroy warehouse',
            'module_id' => $warehouseModule->id
        ]);

        $warehouseContainerModule = Module::firstOrCreate(['name' => 'Containers']);

        Permission::firstOrCreate([
            'action' => 'containers.index',
            'module_id' => $warehouseContainerModule->id
        ], [
            'action' => 'containers.index',
            'description' => 'Can view Containers',
            'module_id' => $warehouseContainerModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'containers.create',
            'module_id' => $warehouseContainerModule->id
        ], [
            'action' => 'containers.create',
            'description' => 'Can create Containers',
            'module_id' => $warehouseContainerModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'containers.show',
            'module_id' => $warehouseContainerModule->id
        ], [
            'action' => 'containers.show',
            'description' => 'Can view Containers',
            'module_id' => $warehouseContainerModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'containers.update',
            'module_id' => $warehouseContainerModule->id
        ], [
            'action' => 'containers.update',
            'description' => 'Can update Containers',
            'module_id' => $warehouseContainerModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'containers.destroy',
            'module_id' => $warehouseContainerModule->id
        ], [
            'action' => 'containers.destroy',
            'description' => 'Can destroy Containers',
            'module_id' => $warehouseContainerModule->id
        ]);

        $quotationModule = Module::firstOrCreate(['name' => 'Quotations']);

        Permission::firstOrCreate([
            'action' => 'quotations.index',
            'module_id' => $quotationModule->id
        ], [
            'action' => 'quotations.index',
            'description' => 'Can view Quotations',
            'module_id' => $quotationModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'quotations.create',
            'module_id' => $quotationModule->id
        ], [
            'action' => 'quotations.create',
            'description' => 'Can create Quotations',
            'module_id' => $quotationModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'quotations.show',
            'module_id' => $quotationModule->id
        ], [
            'action' => 'quotations.show',
            'description' => 'Can view Quotations',
            'module_id' => $quotationModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'quotations.update',
            'module_id' => $quotationModule->id
        ], [
            'action' => 'quotations.update',
            'description' => 'Can update Quotations',
            'module_id' => $quotationModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'quotations.destroy',
            'module_id' => $quotationModule->id
        ], [
            'action' => 'quotations.destroy',
            'description' => 'Can destroy Quotations',
            'module_id' => $quotationModule->id
        ]);

        $questionairesModule = Module::firstOrCreate(['name' => 'Questionnaires']);

        Permission::firstOrCreate([
            'action' => 'questionnaires.index',
            'module_id' => $questionairesModule->id
        ], [
            'action' => 'questionnaires.index',
            'description' => 'Can view Questionnaires',
            'module_id' => $questionairesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'questionnaires.create',
            'module_id' => $questionairesModule->id
        ], [
            'action' => 'questionnaires.create',
            'description' => 'Can create Questionnaires',
            'module_id' => $questionairesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'questionnaires.show',
            'module_id' => $questionairesModule->id
        ], [
            'action' => 'questionnaires.show',
            'description' => 'Can view Questionnaires',
            'module_id' => $questionairesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'questionnaires.update',
            'module_id' => $questionairesModule->id
        ], [
            'action' => 'questionnaires.update',
            'description' => 'Can update Questionnaires',
            'module_id' => $questionairesModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'questionnaires.destroy',
            'module_id' => $questionairesModule->id
        ], [
            'action' => 'questionnaires.destroy',
            'description' => 'Can destroy Questionnaires',
            'module_id' => $questionairesModule->id
        ]);

        $supplierModule = Module::firstOrCreate(['name' => 'Suppliers']);

        Permission::firstOrCreate([
            'action' => 'suppliers.index',
            'module_id' => $supplierModule->id
        ], [
            'action' => 'suppliers.index',
            'description' => 'Can view Suppliers',
            'module_id' => $supplierModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'suppliers.create',
            'module_id' => $supplierModule->id
        ], [
            'action' => 'suppliers.create',
            'description' => 'Can create Suppliers',
            'module_id' => $supplierModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'suppliers.show',
            'module_id' => $supplierModule->id
        ], [
            'action' => 'suppliers.show',
            'description' => 'Can view Suppliers',
            'module_id' => $supplierModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'suppliers.update',
            'module_id' => $supplierModule->id
        ], [
            'action' => 'suppliers.update',
            'description' => 'Can update Suppliers',
            'module_id' => $supplierModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'suppliers.destroy',
            'module_id' => $supplierModule->id
        ], [
            'action' => 'suppliers.destroy',
            'description' => 'Can destroy Suppliers',
            'module_id' => $supplierModule->id
        ]);

        $productModule = Module::firstOrCreate(['name' => 'Product Details']);

        Permission::firstOrCreate([
            'action' => 'product-details.index',
            'module_id' => $productModule->id
        ], [
            'action' => 'product-details.index',
            'description' => 'Can view Products',
            'module_id' => $productModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'product-details.create',
            'module_id' => $productModule->id
        ], [
            'action' => 'product-details.create',
            'description' => 'Can create Products',
            'module_id' => $productModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'product-details.show',
            'module_id' => $productModule->id
        ], [
            'action' => 'product-details.show',
            'description' => 'Can view Products',
            'module_id' => $productModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'product-details.update',
            'module_id' => $productModule->id
        ], [
            'action' => 'product-details.update',
            'description' => 'Can update Products',
            'module_id' => $productModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'product-details.destroy',
            'module_id' => $productModule->id
        ], [
            'action' => 'product-details.destroy',
            'description' => 'Can destroy Products',
            'module_id' => $productModule->id
        ]);

        $productsModule = Module::firstOrCreate(['name' => 'Products']);

        Permission::firstOrCreate([
            'action' => 'products.index',
            'module_id' => $productsModule->id
        ], [
            'action' => 'products.index',
            'description' => 'Can view products',
            'module_id' => $productsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'products.create',
            'module_id' => $productsModule->id
        ], [
            'action' => 'products.create',
            'description' => 'Can create products',
            'module_id' => $productsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'products.show',
            'module_id' => $productsModule->id
        ], [
            'action' => 'products.show',
            'description' => 'Can view products',
            'module_id' => $productsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'products.update',
            'module_id' => $productsModule->id
        ], [
            'action' => 'products.update',
            'description' => 'Can update products',
            'module_id' => $productsModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'products.destroy',
            'module_id' => $productsModule->id
        ], [
            'action' => 'products.destroy',
            'description' => 'Can destroy products',
            'module_id' => $productsModule->id
        ]);


        $productTitlesModule = Module::firstOrCreate(['name' => 'Product Titles']);

        Permission::firstOrCreate([
            'action' => 'product-titles.index',
            'module_id' => $productTitlesModule->id
        ], [
            'action' => 'product-titles.index',
            'description' => 'Can view product-titles',
            'module_id' => $productTitlesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'product-titles.create',
            'module_id' => $productTitlesModule->id
        ], [
            'action' => 'product-titles.create',
            'description' => 'Can create product-titles',
            'module_id' => $productTitlesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'product-titles.show',
            'module_id' => $productTitlesModule->id
        ], [
            'action' => 'product-titles.show',
            'description' => 'Can view product-titles',
            'module_id' => $productTitlesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'product-titles.update',
            'module_id' => $productTitlesModule->id
        ], [
            'action' => 'product-titles.update',
            'description' => 'Can update product-titles',
            'module_id' => $productTitlesModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'product-titles.destroy',
            'module_id' => $productTitlesModule->id
        ], [
            'action' => 'product-titles.destroy',
            'description' => 'Can destroy product-titles',
            'module_id' => $productTitlesModule->id
        ]);

        $reviewModule = Module::firstOrCreate(['name' => 'Reviews']);

        Permission::firstOrCreate([
            'action' => 'reviews.index',
            'module_id' => $reviewModule->id
        ], [
            'action' => 'reviews.index',
            'description' => 'Can view Reviews',
            'module_id' => $reviewModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'reviews.create',
            'module_id' => $reviewModule->id
        ], [
            'action' => 'reviews.create',
            'description' => 'Can create Reviews',
            'module_id' => $reviewModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'reviews.show',
            'module_id' => $reviewModule->id
        ], [
            'action' => 'reviews.show',
            'description' => 'Can view Reviews',
            'module_id' => $reviewModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'reviews.update',
            'module_id' => $reviewModule->id
        ], [
            'action' => 'reviews.update',
            'description' => 'Can update Reviews',
            'module_id' => $reviewModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'reviews.destroy',
            'module_id' => $reviewModule->id
        ], [
            'action' => 'reviews.destroy',
            'description' => 'Can destroy Reviews',
            'module_id' => $reviewModule->id
        ]);

        $exchangerateModule = Module::firstOrCreate(['name' => 'Exchanges Rates']);

        Permission::firstOrCreate([
            'action' => 'exchanges-rates.index',
            'module_id' => $exchangerateModule->id
        ], [
            'action' => 'exchanges-rates.index',
            'description' => 'Can view Currency Exchange',
            'module_id' => $exchangerateModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'exchanges-rates.create',
            'module_id' => $exchangerateModule->id
        ], [
            'action' => 'exchanges-rates.create',
            'description' => 'Can create Currency Exchange',
            'module_id' => $exchangerateModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'exchanges-rates.show',
            'module_id' => $exchangerateModule->id
        ], [
            'action' => 'exchanges-rates.show',
            'description' => 'Can view Currency Exchange',
            'module_id' => $exchangerateModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'exchanges-rates.update',
            'module_id' => $exchangerateModule->id
        ], [
            'action' => 'exchanges-rates.update',
            'description' => 'Can update Currency Exchange',
            'module_id' => $exchangerateModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'exchanges-rates.destroy',
            'module_id' => $exchangerateModule->id
        ], [
            'action' => 'exchanges-rates.destroy',
            'description' => 'Can destroy Currency Exchange',
            'module_id' => $exchangerateModule->id
        ]);

        //        $currencyconversionModule = Module::firstOrCreate(['name' => 'Currency Converters']);
        //
        //        Permission::firstOrCreate([
        //            'action' => 'currency-converters.index',
        //            'module_id' => $currencyconversionModule->id
        //        ], [
        //            'action' => 'currency-converters.index',
        //            'description' => 'Can view Currency Exchange',
        //            'module_id' => $currencyconversionModule->id
        //        ]);
        //
        //        Permission::firstOrCreate([
        //            'action' => 'currency-converters.create',
        //            'module_id' => $currencyconversionModule->id
        //        ], [
        //            'action' => 'currency-converters.create',
        //            'description' => 'Can create Currency Exchange',
        //            'module_id' => $currencyconversionModule->id
        //        ]);
        //
        //        Permission::firstOrCreate([
        //            'action' => 'currency-converters.show',
        //            'module_id' => $currencyconversionModule->id
        //        ], [
        //            'action' => 'currency-converters.show',
        //            'description' => 'Can view Currency Exchange',
        //            'module_id' => $currencyconversionModule->id
        //        ]);
        //
        //        Permission::firstOrCreate([
        //            'action' => 'currency-converters.update',
        //            'module_id' => $currencyconversionModule->id
        //        ], [
        //            'action' => 'currency-converters.update',
        //            'description' => 'Can update Currency Exchange',
        //            'module_id' => $currencyconversionModule->id
        //        ]);
        //        Permission::firstOrCreate([
        //            'action' => 'currency-converters.destroy',
        //            'module_id' => $currencyconversionModule->id
        //        ], [
        //            'action' => 'currency-converters.destroy',
        //            'description' => 'Can destroy Currency Exchange',
        //            'module_id' => $currencyconversionModule->id
        //        ]);

        $emailsModule = Module::firstOrCreate(['name' => 'Fetch Email']);

        Permission::firstOrCreate([
            'action' => 'fetch-email.index',
            'module_id' => $emailsModule->id
        ], [
            'action' => 'fetch-email.index',
            'description' => 'Can view Emails',
            'module_id' => $emailsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'fetch-email.create',
            'module_id' => $emailsModule->id
        ], [
            'action' => 'fetch-email.create',
            'description' => 'Can create Emails',
            'module_id' => $emailsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'fetch-email.show',
            'module_id' => $emailsModule->id
        ], [
            'action' => 'fetch-email.show',
            'description' => 'Can view Emails',
            'module_id' => $emailsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'fetch-email.update',
            'module_id' => $emailsModule->id
        ], [
            'action' => 'fetch-email.update',
            'description' => 'Can update Emails',
            'module_id' => $emailsModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'fetch-email.destroy',
            'module_id' => $emailsModule->id
        ], [
            'action' => 'fetch-email.destroy',
            'description' => 'Can destroy Emails',
            'module_id' => $emailsModule->id
        ]);

        $productstockModule = Module::firstOrCreate(['name' => 'Product Stocks']);

        Permission::firstOrCreate([
            'action' => 'product-stocks.index',
            'module_id' => $productstockModule->id
        ], [
            'action' => 'product-stocks.index',
            'description' => 'Can view Product Stock',
            'module_id' => $productstockModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'product-stocks.create',
            'module_id' => $productstockModule->id
        ], [
            'action' => 'product-stocks.create',
            'description' => 'Can create Product Stock',
            'module_id' => $productstockModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'product-stocks.show',
            'module_id' => $productstockModule->id
        ], [
            'action' => 'product-stocks.show',
            'description' => 'Can view Product Stock',
            'module_id' => $productstockModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'product-stocks.update',
            'module_id' => $productstockModule->id
        ], [
            'action' => 'product-stocks.update',
            'description' => 'Can update Product Stock',
            'module_id' => $productstockModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'product-stocks.destroy',
            'module_id' => $productstockModule->id
        ], [
            'action' => 'product-stocks.destroy',
            'description' => 'Can destroy Product Stock',
            'module_id' => $productstockModule->id
        ]);

        $productstocksModule = Module::firstOrCreate(['name' => 'Product Stock']);

        Permission::firstOrCreate([
            'action' => 'product-stock.index',
            'module_id' => $productstocksModule->id
        ], [
            'action' => 'product-stock.index',
            'description' => 'Can view Product Stock',
            'module_id' => $productstocksModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'product-stock.create',
            'module_id' => $productstocksModule->id
        ], [
            'action' => 'product-stock.create',
            'description' => 'Can create Product Stock',
            'module_id' => $productstocksModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'product-stock.show',
            'module_id' => $productstocksModule->id
        ], [
            'action' => 'product-stock.show',
            'description' => 'Can view Product Stock',
            'module_id' => $productstocksModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'product-stock.update',
            'module_id' => $productstocksModule->id
        ], [
            'action' => 'product-stock.update',
            'description' => 'Can update Product Stock',
            'module_id' => $productstocksModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'product-stock.destroy',
            'module_id' => $productstocksModule->id
        ], [
            'action' => 'product-stock.destroy',
            'description' => 'Can destroy Product Stock',
            'module_id' => $productstocksModule->id
        ]);

        $warehousestockModule = Module::firstOrCreate(['name' => 'Warehouse Stocks']);

        Permission::firstOrCreate([
            'action' => 'warehouse-stocks.index',
            'module_id' => $warehousestockModule->id
        ], [
            'action' => 'warehouse-stocks.index',
            'description' => 'Can view Warehouse Stock',
            'module_id' => $warehousestockModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'warehouse-stocks.create',
            'module_id' => $warehousestockModule->id
        ], [
            'action' => 'warehouse-stocks.create',
            'description' => 'Can create Warehouse Stock',
            'module_id' => $warehousestockModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'warehouse-stocks.show',
            'module_id' => $warehousestockModule->id
        ], [
            'action' => 'warehouse-stocks.show',
            'description' => 'Can view Warehouse Stock',
            'module_id' => $warehousestockModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'warehouse-stocks.update',
            'module_id' => $warehousestockModule->id
        ], [
            'action' => 'warehouse-stocks.update',
            'description' => 'Can update Warehouse Stock',
            'module_id' => $warehousestockModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'warehouse-stocks.destroy',
            'module_id' => $warehousestockModule->id
        ], [
            'action' => 'warehouse-stocks.destroy',
            'description' => 'Can destroy Warehouse Stock',
            'module_id' => $warehousestockModule->id
        ]);

        $stockitemsModule = Module::firstOrCreate(['name' => 'Stock Logs']);

        Permission::firstOrCreate([
            'action' => 'stock-logs.index',
            'module_id' => $stockitemsModule->id
        ], [
            'action' => 'stock-logs.index',
            'description' => 'Can view Stock',
            'module_id' => $stockitemsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'stock-logs.create',
            'module_id' => $stockitemsModule->id
        ], [
            'action' => 'stock-logs.create',
            'description' => 'Can create Stock',
            'module_id' => $stockitemsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'stock-logs.show',
            'module_id' => $stockitemsModule->id
        ], [
            'action' => 'stock-logs.show',
            'description' => 'Can view Stock',
            'module_id' => $stockitemsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'stock-logs.update',
            'module_id' => $stockitemsModule->id
        ], [
            'action' => 'stock-logs.update',
            'description' => 'Can update Stock',
            'module_id' => $stockitemsModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'stock-logs.destroy',
            'module_id' => $stockitemsModule->id
        ], [
            'action' => 'stock-logs.destroy',
            'description' => 'Can destroy Stock',
            'module_id' => $stockitemsModule->id
        ]);


        $stockLogModule = Module::firstOrCreate(['name' => 'Stock Log']);

        Permission::firstOrCreate([
            'action' => 'stock-log.index',
            'module_id' => $stockLogModule->id
        ], [
            'action' => 'stock-log.index',
            'description' => 'Can view Stock',
            'module_id' => $stockLogModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'stock-log.create',
            'module_id' => $stockLogModule->id
        ], [
            'action' => 'stock-log.create',
            'description' => 'Can create Stock',
            'module_id' => $stockLogModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'stock-log.show',
            'module_id' => $stockLogModule->id
        ], [
            'action' => 'stock-log.show',
            'description' => 'Can view Stock',
            'module_id' => $stockLogModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'stock-log.update',
            'module_id' => $stockLogModule->id
        ], [
            'action' => 'stock-log.update',
            'description' => 'Can update Stock',
            'module_id' => $stockLogModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'stock-log.destroy',
            'module_id' => $stockLogModule->id
        ], [
            'action' => 'stock-log.destroy',
            'description' => 'Can destroy Stock',
            'module_id' => $stockLogModule->id
        ]);

        $channelsModule = Module::firstOrCreate(['name' => 'Channels']);

        Permission::firstOrCreate([
            'action' => 'channels.index',
            'module_id' => $channelsModule->id
        ], [
            'action' => 'channels.index',
            'description' => 'Can view Channels',
            'module_id' => $channelsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'channels.create',
            'module_id' => $channelsModule->id
        ], [
            'action' => 'channels.create',
            'description' => 'Can create Channels',
            'module_id' => $channelsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'channels.show',
            'module_id' => $channelsModule->id
        ], [
            'action' => 'channels.show',
            'description' => 'Can view Channels',
            'module_id' => $channelsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'channels.update',
            'module_id' => $channelsModule->id
        ], [
            'action' => 'channels.update',
            'description' => 'Can update Channels',
            'module_id' => $channelsModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'channels.destroy',
            'module_id' => $channelsModule->id
        ], [
            'action' => 'channels.destroy',
            'description' => 'Can destroy Channels',
            'module_id' => $channelsModule->id
        ]);

        $dealmanagmentModule = Module::firstOrCreate(['name' => 'Deals']);

        Permission::firstOrCreate([
            'action' => 'deals.index',
            'module_id' => $dealmanagmentModule->id
        ], [
            'action' => 'deals.index',
            'description' => 'Can view Deal Management',
            'module_id' => $dealmanagmentModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'deals.create',
            'module_id' => $dealmanagmentModule->id
        ], [
            'action' => 'deals.create',
            'description' => 'Can create Deal Management',
            'module_id' => $dealmanagmentModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'deals.show',
            'module_id' => $dealmanagmentModule->id
        ], [
            'action' => 'deals.show',
            'description' => 'Can view Deal Management',
            'module_id' => $dealmanagmentModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'deals.update',
            'module_id' => $dealmanagmentModule->id
        ], [
            'action' => 'deals.update',
            'description' => 'Can update Deal Management',
            'module_id' => $dealmanagmentModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'deals.destroy',
            'module_id' => $dealmanagmentModule->id
        ], [
            'action' => 'deals.destroy',
            'description' => 'Can destroy Deal Management',
            'module_id' => $dealmanagmentModule->id
        ]);

        $casesModule = Module::firstOrCreate(['name' => 'Cases']);

        Permission::firstOrCreate([
            'action' => 'cases.index',
            'module_id' => $casesModule->id
        ], [
            'action' => 'cases.index',
            'description' => 'Can view Cases',
            'module_id' => $casesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'cases.create',
            'module_id' => $casesModule->id
        ], [
            'action' => 'cases.create',
            'description' => 'Can create Cases',
            'module_id' => $casesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'cases.show',
            'module_id' => $casesModule->id
        ], [
            'action' => 'cases.show',
            'description' => 'Can view Cases',
            'module_id' => $casesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'cases.update',
            'module_id' => $casesModule->id
        ], [
            'action' => 'cases.update',
            'description' => 'Can update Cases',
            'module_id' => $casesModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'cases.destroy',
            'module_id' => $casesModule->id
        ], [
            'action' => 'cases.destroy',
            'description' => 'Can destroy Cases',
            'module_id' => $casesModule->id
        ]);


        $caseModule = Module::firstOrCreate(['name' => 'Case']);

        Permission::firstOrCreate([
            'action' => 'case.index',
            'module_id' => $caseModule->id
        ], [
            'action' => 'case.index',
            'description' => 'Can view Case',
            'module_id' => $caseModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'case.create',
            'module_id' => $caseModule->id
        ], [
            'action' => 'case.create',
            'description' => 'Can create Case',
            'module_id' => $caseModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'case.show',
            'module_id' => $caseModule->id
        ], [
            'action' => 'case.show',
            'description' => 'Can view Case',
            'module_id' => $caseModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'case.update',
            'module_id' => $caseModule->id
        ], [
            'action' => 'case.update',
            'description' => 'Can update Case',
            'module_id' => $caseModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'case.destroy',
            'module_id' => $caseModule->id
        ], [
            'action' => 'case.destroy',
            'description' => 'Can destroy Case',
            'module_id' => $caseModule->id
        ]);

        $collectionModule = Module::firstOrCreate(['name' => 'Collections']);

        Permission::firstOrCreate([
            'action' => 'collections.index',
            'module_id' => $collectionModule->id
        ], [
            'action' => 'collections.index',
            'description' => 'Can view Collections',
            'module_id' => $collectionModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'collections.create',
            'module_id' => $collectionModule->id
        ], [
            'action' => 'collections.create',
            'description' => 'Can create Collections',
            'module_id' => $collectionModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'collections.show',
            'module_id' => $collectionModule->id
        ], [
            'action' => 'collections.show',
            'description' => 'Can view Collections',
            'module_id' => $collectionModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'collections.update',
            'module_id' => $collectionModule->id
        ], [
            'action' => 'collections.update',
            'description' => 'Can update Collections',
            'module_id' => $collectionModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'collections.destroy',
            'module_id' => $collectionModule->id
        ], [
            'action' => 'collections.destroy',
            'description' => 'Can destroy Collections',
            'module_id' => $collectionModule->id
        ]);

        // $feedbackModule = Module::firstOrCreate(['name' => 'Feedbacks']);

        // Permission::firstOrCreate([
        //     'action' => 'feedbacks.index',
        //     'module_id' => $feedbackModule->id
        // ], [
        //     'action' => 'feedbacks.index',
        //     'description' => 'Can view Feedback',
        //     'module_id' => $feedbackModule->id
        // ]);

        // Permission::firstOrCreate([
        //     'action' => 'feedbacks.create',
        //     'module_id' => $feedbackModule->id
        // ], [
        //     'action' => 'feedbacks.create',
        //     'description' => 'Can create Feedback',
        //     'module_id' => $feedbackModule->id
        // ]);

        // Permission::firstOrCreate([
        //     'action' => 'feedbacks.show',
        //     'module_id' => $feedbackModule->id
        // ], [
        //     'action' => 'feedbacks.show',
        //     'description' => 'Can view Feedback',
        //     'module_id' => $feedbackModule->id
        // ]);

        // Permission::firstOrCreate([
        //     'action' => 'feedbacks.update',
        //     'module_id' => $feedbackModule->id
        // ], [
        //     'action' => 'feedbacks.update',
        //     'description' => 'Can update Feedback',
        //     'module_id' => $feedbackModule->id
        // ]);
        // Permission::firstOrCreate([
        //     'action' => 'feedbacks.destroy',
        //     'module_id' => $feedbackModule->id
        // ], [
        //     'action' => 'feedbacks.destroy',
        //     'description' => 'Can destroy Feedback',
        //     'module_id' => $feedbackModule->id
        // ]);

        $paymentsModule = Module::firstOrCreate(['name' => 'Payments']);

        Permission::firstOrCreate([
            'action' => 'payments.index',
            'module_id' => $paymentsModule->id
        ], [
            'action' => 'payments.index',
            'description' => 'Can view Payments',
            'module_id' => $paymentsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'payments.create',
            'module_id' => $paymentsModule->id
        ], [
            'action' => 'payments.create',
            'description' => 'Can create Payments',
            'module_id' => $paymentsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'payments.show',
            'module_id' => $paymentsModule->id
        ], [
            'action' => 'payments.show',
            'description' => 'Can view Payments',
            'module_id' => $paymentsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'payments.update',
            'module_id' => $paymentsModule->id
        ], [
            'action' => 'payments.update',
            'description' => 'Can update Payments',
            'module_id' => $paymentsModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'payments.destroy',
            'module_id' => $paymentsModule->id
        ], [
            'action' => 'payments.destroy',
            'description' => 'Can destroy Payments',
            'module_id' => $paymentsModule->id
        ]);

        $paymentgatewaysModule = Module::firstOrCreate(['name' => 'Payment Gateways']);

        Permission::firstOrCreate([
            'action' => 'payment-gateways.index',
            'module_id' => $paymentgatewaysModule->id
        ], [
            'action' => 'payment-gateways.index',
            'description' => 'Can view Payment Gateways',
            'module_id' => $paymentgatewaysModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'payment-gateways.create',
            'module_id' => $paymentgatewaysModule->id
        ], [
            'action' => 'payment-gateways.create',
            'description' => 'Can create Payment Gateways',
            'module_id' => $paymentgatewaysModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'payment-gateways.show',
            'module_id' => $paymentgatewaysModule->id
        ], [
            'action' => 'payment-gateways.show',
            'description' => 'Can view Payment Gateways',
            'module_id' => $paymentgatewaysModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'payment-gateways.update',
            'module_id' => $paymentgatewaysModule->id
        ], [
            'action' => 'payment-gateways.update',
            'description' => 'Can update Payment Gateways',
            'module_id' => $paymentgatewaysModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'payment-gateways.destroy',
            'module_id' => $paymentgatewaysModule->id
        ], [
            'action' => 'payment-gateways.destroy',
            'description' => 'Can destroy Payment Gateways',
            'module_id' => $paymentgatewaysModule->id
        ]);

        $amazonsModule = Module::firstOrCreate(['name' => 'Amazons']);

        Permission::firstOrCreate([
            'action' => 'amazons.index',
            'module_id' => $amazonsModule->id
        ], [
            'action' => 'amazons.index',
            'description' => 'Can view Amazons',
            'module_id' => $amazonsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'amazons.create',
            'module_id' => $amazonsModule->id
        ], [
            'action' => 'amazons.create',
            'description' => 'Can create Amazons',
            'module_id' => $amazonsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'amazons.show',
            'module_id' => $amazonsModule->id
        ], [
            'action' => 'amazons.show',
            'description' => 'Can view Amazons',
            'module_id' => $amazonsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'amazons.update',
            'module_id' => $amazonsModule->id
        ], [
            'action' => 'amazons.update',
            'description' => 'Can update Amazons',
            'module_id' => $amazonsModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'amazons.destroy',
            'module_id' => $amazonsModule->id
        ], [
            'action' => 'amazons.destroy',
            'description' => 'Can destroy Amazons',
            'module_id' => $amazonsModule->id
        ]);

        $ejoggasModule = Module::firstOrCreate(['name' => 'Ejoggas']);

        Permission::firstOrCreate([
            'action' => 'ejoggas.index',
            'module_id' => $ejoggasModule->id
        ], [
            'action' => 'ejoggas.index',
            'description' => 'Can view Ejogga',
            'module_id' => $ejoggasModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'ejoggas.create',
            'module_id' => $ejoggasModule->id
        ], [
            'action' => 'ejoggas.create',
            'description' => 'Can create Ejogga',
            'module_id' => $ejoggasModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'ejoggas.show',
            'module_id' => $ejoggasModule->id
        ], [
            'action' => 'ejoggas.show',
            'description' => 'Can view Ejogga',
            'module_id' => $ejoggasModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'ejoggas.update',
            'module_id' => $ejoggasModule->id
        ], [
            'action' => 'ejoggas.update',
            'description' => 'Can update Ejogga',
            'module_id' => $ejoggasModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'ejoggas.destroy',
            'module_id' => $ejoggasModule->id
        ], [
            'action' => 'ejoggas.destroy',
            'description' => 'Can destroy Ejogga',
            'module_id' => $ejoggasModule->id
        ]);


        $importsModule = Module::firstOrCreate(['name' => 'Imports']);

        Permission::firstOrCreate([
            'action' => 'imports.index',
            'module_id' => $importsModule->id
        ], [
            'action' => 'imports.index',
            'description' => 'Can view Imports',
            'module_id' => $importsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'imports.create',
            'module_id' => $importsModule->id
        ], [
            'action' => 'imports.create',
            'description' => 'Can create Imports',
            'module_id' => $importsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'imports.show',
            'module_id' => $importsModule->id
        ], [
            'action' => 'imports.show',
            'description' => 'Can view Imports',
            'module_id' => $importsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'imports.update',
            'module_id' => $importsModule->id
        ], [
            'action' => 'imports.update',
            'description' => 'Can update Imports',
            'module_id' => $importsModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'imports.destroy',
            'module_id' => $importsModule->id
        ], [
            'action' => 'imports.destroy',
            'description' => 'Can destroy Imports',
            'module_id' => $importsModule->id
        ]);

        $emailSettingsModule = Module::firstOrCreate(['name' => 'Email Settings']);

        Permission::firstOrCreate([
            'action' => 'email-settings.index',
            'module_id' => $emailSettingsModule->id
        ], [
            'action' => 'email-settings.index',
            'description' => 'Can view Email Settings',
            'module_id' => $emailSettingsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'email-settings.create',
            'module_id' => $emailSettingsModule->id
        ], [
            'action' => 'email-settings.create',
            'description' => 'Can create Email Settings',
            'module_id' => $emailSettingsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'email-settings.show',
            'module_id' => $emailSettingsModule->id
        ], [
            'action' => 'email-settings.show',
            'description' => 'Can view Email Settings',
            'module_id' => $emailSettingsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'email-settings.update',
            'module_id' => $emailSettingsModule->id
        ], [
            'action' => 'email-settings.update',
            'description' => 'Can update Email Settings',
            'module_id' => $emailSettingsModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'email-settings.destroy',
            'module_id' => $emailSettingsModule->id
        ], [
            'action' => 'email-settings.destroy',
            'description' => 'Can destroy Email Settings',
            'module_id' => $emailSettingsModule->id
        ]);


        $emailSettingModule = Module::firstOrCreate(['name' => 'Email Setting']);

        Permission::firstOrCreate([
            'action' => 'email-setting.index',
            'module_id' => $emailSettingModule->id
        ], [
            'action' => 'email-setting.index',
            'description' => 'Can view Email Setting',
            'module_id' => $emailSettingModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'email-setting.create',
            'module_id' => $emailSettingModule->id
        ], [
            'action' => 'email-setting.create',
            'description' => 'Can create Email Setting',
            'module_id' => $emailSettingModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'email-setting.show',
            'module_id' => $emailSettingModule->id
        ], [
            'action' => 'email-setting.show',
            'description' => 'Can view Email Setting',
            'module_id' => $emailSettingModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'email-setting.update',
            'module_id' => $emailSettingModule->id
        ], [
            'action' => 'email-setting.update',
            'description' => 'Can update Email Setting',
            'module_id' => $emailSettingModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'email-setting.destroy',
            'module_id' => $emailSettingModule->id
        ], [
            'action' => 'email-setting.destroy',
            'description' => 'Can destroy Email Setting',
            'module_id' => $emailSettingModule->id
        ]);


        $modulesModule = Module::firstOrCreate(['name' => 'Modules']);

        Permission::firstOrCreate([
            'action' => 'modules.index',
            'module_id' => $modulesModule->id
        ], [
            'action' => 'modules.index',
            'description' => 'Can view Module',
            'module_id' => $modulesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'modules.create',
            'module_id' => $modulesModule->id
        ], [
            'action' => 'modules.create',
            'description' => 'Can create Module',
            'module_id' => $modulesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'modules.show',
            'module_id' => $modulesModule->id
        ], [
            'action' => 'modules.show',
            'description' => 'Can view Module',
            'module_id' => $modulesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'modules.update',
            'module_id' => $modulesModule->id
        ], [
            'action' => 'modules.update',
            'description' => 'Can update Module',
            'module_id' => $modulesModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'modules.destroy',
            'module_id' => $modulesModule->id
        ], [
            'action' => 'modules.destroy',
            'description' => 'Can destroy Module',
            'module_id' => $modulesModule->id
        ]);


        $packagesModule = Module::firstOrCreate(['name' => 'Packages']);

        Permission::firstOrCreate([
            'action' => 'packages.index',
            'module_id' => $packagesModule->id
        ], [
            'action' => 'packages.index',
            'description' => 'Can view Packages',
            'module_id' => $packagesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'packages.create',
            'module_id' => $packagesModule->id
        ], [
            'action' => 'packages.create',
            'description' => 'Can create Packages',
            'module_id' => $packagesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'packages.show',
            'module_id' => $packagesModule->id
        ], [
            'action' => 'packages.show',
            'description' => 'Can view Packages',
            'module_id' => $packagesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'packages.update',
            'module_id' => $packagesModule->id
        ], [
            'action' => 'packages.update',
            'description' => 'Can update Packages',
            'module_id' => $packagesModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'packages.destroy',
            'module_id' => $packagesModule->id
        ], [
            'action' => 'packages.destroy',
            'description' => 'Can destroy Packages',
            'module_id' => $packagesModule->id
        ]);

        $quotationrequestsModule = Module::firstOrCreate(['name' => 'Quotation Requests']);

        Permission::firstOrCreate([
            'action' => 'quotation-requests.index',
            'module_id' => $quotationrequestsModule->id
        ], [
            'action' => 'quotation-requests.index',
            'description' => 'Can view Packages',
            'module_id' => $quotationrequestsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'quotation-requests.create',
            'module_id' => $quotationrequestsModule->id
        ], [
            'action' => 'quotation-requests.create',
            'description' => 'Can create Packages',
            'module_id' => $quotationrequestsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'quotation-requests.show',
            'module_id' => $quotationrequestsModule->id
        ], [
            'action' => 'quotation-requests.show',
            'description' => 'Can view Packages',
            'module_id' => $quotationrequestsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'quotation-requests.update',
            'module_id' => $quotationrequestsModule->id
        ], [
            'action' => 'quotation-requests.update',
            'description' => 'Can update Packages',
            'module_id' => $quotationrequestsModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'quotation-requests.destroy',
            'module_id' => $quotationrequestsModule->id
        ], [
            'action' => 'quotation-requests.destroy',
            'description' => 'Can destroy Packages',
            'module_id' => $quotationrequestsModule->id
        ]);

        $subscriptionModule = Module::firstOrCreate(['name' => 'Subscriptions']);

        Permission::firstOrCreate([
            'action' => 'subscriptions.index',
            'module_id' => $subscriptionModule->id
        ], [
            'action' => 'subscriptions.index',
            'description' => 'Can view Subscriptions',
            'module_id' => $subscriptionModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'subscriptions.create',
            'module_id' => $subscriptionModule->id
        ], [
            'action' => 'subscriptions.create',
            'description' => 'Can create Subscriptions',
            'module_id' => $subscriptionModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'subscriptions.show',
            'module_id' => $subscriptionModule->id
        ], [
            'action' => 'subscriptions.show',
            'description' => 'Can view Subscriptions',
            'module_id' => $subscriptionModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'subscriptions.update',
            'module_id' => $subscriptionModule->id
        ], [
            'action' => 'subscriptions.update',
            'description' => 'Can update Subscriptions',
            'module_id' => $subscriptionModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'subscriptions.destroy',
            'module_id' => $subscriptionModule->id
        ], [
            'action' => 'subscriptions.destroy',
            'description' => 'Can destroy Subscriptions',
            'module_id' => $subscriptionModule->id
        ]);

        $buildingModule = Module::firstOrCreate(['name' => 'Building']);

        Permission::firstOrCreate([
            'action' => 'building.index',
            'module_id' => $buildingModule->id
        ], [
            'action' => 'building.index',
            'description' => 'Can view Building',
            'module_id' => $buildingModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'building.create',
            'module_id' => $buildingModule->id
        ], [
            'action' => 'building.create',
            'description' => 'Can create Building',
            'module_id' => $buildingModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'building.show',
            'module_id' => $buildingModule->id
        ], [
            'action' => 'building.show',
            'description' => 'Can view Building',
            'module_id' => $buildingModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'building.update',
            'module_id' => $buildingModule->id
        ], [
            'action' => 'building.update',
            'description' => 'Can update Building',
            'module_id' => $buildingModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'building.destroy',
            'module_id' => $buildingModule->id
        ], [
            'action' => 'building.destroy',
            'description' => 'Can destroy Building',
            'module_id' => $buildingModule->id
        ]);

        $calendarModule = Module::firstOrCreate(['name' => 'Calendar']);

        Permission::firstOrCreate([
            'action' => 'calendar.index',
            'module_id' => $calendarModule->id
        ], [
            'action' => 'calendar.index',
            'description' => 'Can view Calendar',
            'module_id' => $calendarModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'calendar.create',
            'module_id' => $calendarModule->id
        ], [
            'action' => 'calendar.create',
            'description' => 'Can create Calendar',
            'module_id' => $calendarModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'calendar.show',
            'module_id' => $calendarModule->id
        ], [
            'action' => 'calendar.show',
            'description' => 'Can view Calendar',
            'module_id' => $calendarModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'calendar.update',
            'module_id' => $calendarModule->id
        ], [
            'action' => 'calendar.update',
            'description' => 'Can update Calendar',
            'module_id' => $calendarModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'calendar.destroy',
            'module_id' => $calendarModule->id
        ], [
            'action' => 'calendar.destroy',
            'description' => 'Can destroy Calendar',
            'module_id' => $calendarModule->id
        ]);


        $employeesModule = Module::firstOrCreate(['name' => 'Employees']);

        Permission::firstOrCreate([
            'action' => 'employees.index',
            'module_id' => $employeesModule->id
        ], [
            'action' => 'employees.index',
            'description' => 'Can view Employees',
            'module_id' => $employeesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'employees.create',
            'module_id' => $employeesModule->id
        ], [
            'action' => 'employees.create',
            'description' => 'Can create Employees',
            'module_id' => $employeesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'employees.show',
            'module_id' => $employeesModule->id
        ], [
            'action' => 'employees.show',
            'description' => 'Can view Employees',
            'module_id' => $employeesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'employees.update',
            'module_id' => $employeesModule->id
        ], [
            'action' => 'employees.update',
            'description' => 'Can update Employees',
            'module_id' => $employeesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'employees.destroy',
            'module_id' => $employeesModule->id
        ], [
            'action' => 'employees.destroy',
            'description' => 'Can destroy Employees',
            'module_id' => $employeesModule->id
        ]);

        $attendenceModule = Module::firstOrCreate(['name' => 'Attendence']);

        Permission::firstOrCreate([
            'action' => 'attendence.index',
            'module_id' => $attendenceModule->id
        ], [
            'action' => 'attendence.index',
            'description' => 'Can view Attendence',
            'module_id' => $attendenceModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'attendence.create',
            'module_id' => $attendenceModule->id
        ], [
            'action' => 'attendence.create',
            'description' => 'Can create Attendence',
            'module_id' => $attendenceModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'attendence.show',
            'module_id' => $attendenceModule->id
        ], [
            'action' => 'attendence.show',
            'description' => 'Can view Attendence',
            'module_id' => $attendenceModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'attendence.update',
            'module_id' => $attendenceModule->id
        ], [
            'action' => 'attendence.update',
            'description' => 'Can update Attendence',
            'module_id' => $attendenceModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'attendence.destroy',
            'module_id' => $attendenceModule->id
        ], [
            'action' => 'attendence.destroy',
            'description' => 'Can destroy Attendence',
            'module_id' => $attendenceModule->id
        ]);

        $UserModule = Module::firstOrCreate(['name' => 'User']);

        Permission::firstOrCreate([
            'action' => 'user.index',
            'module_id' => $UserModule->id
        ], [
            'action' => 'user.index',
            'description' => 'Can view User',
            'module_id' => $UserModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'user.create',
            'module_id' => $UserModule->id
        ], [
            'action' => 'user.create',
            'description' => 'Can create User',
            'module_id' => $UserModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'user.show',
            'module_id' => $UserModule->id
        ], [
            'action' => 'user.show',
            'description' => 'Can view User',
            'module_id' => $UserModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'user.update',
            'module_id' => $UserModule->id
        ], [
            'action' => 'user.update',
            'description' => 'Can update User',
            'module_id' => $UserModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'user.destroy',
            'module_id' => $UserModule->id
        ], [
            'action' => 'user.destroy',
            'description' => 'Can destroy User',
            'module_id' => $UserModule->id
        ]);


        $UsersModule = Module::firstOrCreate(['name' => 'Users']);

        Permission::firstOrCreate([
            'action' => 'users.index',
            'module_id' => $UsersModule->id
        ], [
            'action' => 'users.index',
            'description' => 'Can view Users',
            'module_id' => $UsersModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'users.create',
            'module_id' => $UsersModule->id
        ], [
            'action' => 'users.create',
            'description' => 'Can create Users',
            'module_id' => $UsersModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'users.show',
            'module_id' => $UsersModule->id
        ], [
            'action' => 'users.show',
            'description' => 'Can view Users',
            'module_id' => $UsersModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'users.update',
            'module_id' => $UsersModule->id
        ], [
            'action' => 'users.update',
            'description' => 'Can update Users',
            'module_id' => $UsersModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'users.destroy',
            'module_id' => $UsersModule->id
        ], [
            'action' => 'users.destroy',
            'description' => 'Can destroy Users',
            'module_id' => $UsersModule->id
        ]);

        $ShipmentsModule = Module::firstOrCreate(['name' => 'Shipments']);

        Permission::firstOrCreate([
            'action' => 'shipments.index',
            'module_id' => $ShipmentsModule->id
        ], [
            'action' => 'shipments.index',
            'description' => 'Can view Shipments',
            'module_id' => $ShipmentsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'shipments.create',
            'module_id' => $ShipmentsModule->id
        ], [
            'action' => 'shipments.create',
            'description' => 'Can create Shipments',
            'module_id' => $ShipmentsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'shipments.show',
            'module_id' => $ShipmentsModule->id
        ], [
            'action' => 'shipments.show',
            'description' => 'Can view Shipments',
            'module_id' => $ShipmentsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'shipments.update',
            'module_id' => $ShipmentsModule->id
        ], [
            'action' => 'shipments.update',
            'description' => 'Can update Shipments',
            'module_id' => $ShipmentsModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'shipments.destroy',
            'module_id' => $ShipmentsModule->id
        ], [
            'action' => 'shipments.destroy',
            'description' => 'Can destroy Shipments',
            'module_id' => $ShipmentsModule->id
        ]);

        $warehouseShipmentsModule = Module::firstOrCreate(['name' => 'Warehouse Shipments']);

        Permission::firstOrCreate([
            'action' => 'warehouse-shipments.index',
            'module_id' => $warehouseShipmentsModule->id
        ], [
            'action' => 'warehouse-shipments.index',
            'description' => 'Can view Warehouse Shipments',
            'module_id' => $warehouseShipmentsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'warehouse-shipments.create',
            'module_id' => $warehouseShipmentsModule->id
        ], [
            'action' => 'warehouse-shipments.create',
            'description' => 'Can create Warehouse Shipments',
            'module_id' => $warehouseShipmentsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'warehouse-shipments.show',
            'module_id' => $warehouseShipmentsModule->id
        ], [
            'action' => 'warehouse-shipments.show',
            'description' => 'Can view Warehouse Shipments',
            'module_id' => $warehouseShipmentsModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'warehouse-shipments.update',
            'module_id' => $warehouseShipmentsModule->id
        ], [
            'action' => 'warehouse-shipments.update',
            'description' => 'Can update Warehouse Shipments',
            'module_id' => $warehouseShipmentsModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'warehouse-shipments.destroy',
            'module_id' => $warehouseShipmentsModule->id
        ], [
            'action' => 'warehouse-shipments.destroy',
            'description' => 'Can destroy Warehouse Shipments',
            'module_id' => $warehouseShipmentsModule->id
        ]);

        $OrderModule = Module::firstOrCreate(['name' => 'Order']);

        Permission::firstOrCreate([
            'action' => 'order.index',
            'module_id' => $OrderModule->id
        ], [
            'action' => 'order.index',
            'description' => 'Can view Order',
            'module_id' => $OrderModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'order.create',
            'module_id' => $OrderModule->id
        ], [
            'action' => 'order.create',
            'description' => 'Can create Order',
            'module_id' => $OrderModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'order.show',
            'module_id' => $OrderModule->id
        ], [
            'action' => 'order.show',
            'description' => 'Can view Order',
            'module_id' => $OrderModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'order.update',
            'module_id' => $OrderModule->id
        ], [
            'action' => 'order.update',
            'description' => 'Can update Order',
            'module_id' => $OrderModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'order.destroy',
            'module_id' => $OrderModule->id
        ], [
            'action' => 'order.destroy',
            'description' => 'Can destroy Order',
            'module_id' => $OrderModule->id
        ]);

        $companiesModule = Module::firstOrCreate(['name' => 'Companies']);

        Permission::firstOrCreate([
            'action' => 'companies.index',
            'module_id' => $companiesModule->id
        ], [
            'action' => 'companies.index',
            'description' => 'Can view Companies',
            'module_id' => $companiesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'companies.create',
            'module_id' => $companiesModule->id
        ], [
            'action' => 'companies.create',
            'description' => 'Can create Companies',
            'module_id' => $companiesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'companies.show',
            'module_id' => $companiesModule->id
        ], [
            'action' => 'companies.show',
            'description' => 'Can view Companies',
            'module_id' => $companiesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'companies.update',
            'module_id' => $companiesModule->id
        ], [
            'action' => 'companies.update',
            'description' => 'Can update Companies',
            'module_id' => $companiesModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'companies.destroy',
            'module_id' => $companiesModule->id
        ], [
            'action' => 'companies.destroy',
            'description' => 'Can destroy Companies',
            'module_id' => $companiesModule->id
        ]);


        $companysModule = Module::firstOrCreate(['name' => 'Companys']);

        Permission::firstOrCreate([
            'action' => 'companys.index',
            'module_id' => $companysModule->id
        ], [
            'action' => 'companys.index',
            'description' => 'Can view Companys',
            'module_id' => $companysModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'companys.create',
            'module_id' => $companysModule->id
        ], [
            'action' => 'companys.create',
            'description' => 'Can create Companys',
            'module_id' => $companysModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'companys.show',
            'module_id' => $companysModule->id
        ], [
            'action' => 'companys.show',
            'description' => 'Can view Companys',
            'module_id' => $companysModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'companys.update',
            'module_id' => $companysModule->id
        ], [
            'action' => 'companys.update',
            'description' => 'Can update Companys',
            'module_id' => $companysModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'companys.destroy',
            'module_id' => $companysModule->id
        ], [
            'action' => 'companys.destroy',
            'description' => 'Can destroy Companys',
            'module_id' => $companysModule->id
        ]);


        $companyModule = Module::firstOrCreate(['name' => 'Company']);

        Permission::firstOrCreate([
            'action' => 'company.index',
            'module_id' => $companyModule->id
        ], [
            'action' => 'company.index',
            'description' => 'Can view Company',
            'module_id' => $companyModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'company.create',
            'module_id' => $companyModule->id
        ], [
            'action' => 'company.create',
            'description' => 'Can create Company',
            'module_id' => $companyModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'company.show',
            'module_id' => $companyModule->id
        ], [
            'action' => 'company.show',
            'description' => 'Can view Company',
            'module_id' => $companyModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'company.update',
            'module_id' => $companyModule->id
        ], [
            'action' => 'company.update',
            'description' => 'Can update Company',
            'module_id' => $companyModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'company.destroy',
            'module_id' => $companyModule->id
        ], [
            'action' => 'company.destroy',
            'description' => 'Can destroy Company',
            'module_id' => $companyModule->id
        ]);

        $invoicesModule = Module::firstOrCreate(['name' => 'Invoices']);

        Permission::firstOrCreate([
            'action' => 'invoices.index',
            'module_id' => $invoicesModule->id
        ], [
            'action' => 'invoices.index',
            'description' => 'Can view Invoices',
            'module_id' => $invoicesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'invoices.create',
            'module_id' => $invoicesModule->id
        ], [
            'action' => 'invoices.create',
            'description' => 'Can create Invoices',
            'module_id' => $invoicesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'invoices.show',
            'module_id' => $invoicesModule->id
        ], [
            'action' => 'invoices.show',
            'description' => 'Can view Invoices',
            'module_id' => $invoicesModule->id
        ]);

        Permission::firstOrCreate([
            'action' => 'invoices.update',
            'module_id' => $invoicesModule->id
        ], [
            'action' => 'invoices.update',
            'description' => 'Can update Invoices',
            'module_id' => $invoicesModule->id
        ]);
        Permission::firstOrCreate([
            'action' => 'invoices.destroy',
            'module_id' => $invoicesModule->id
        ], [
            'action' => 'invoices.destroy',
            'description' => 'Can destroy Invoices',
            'module_id' => $invoicesModule->id
        ]);

    }
}
