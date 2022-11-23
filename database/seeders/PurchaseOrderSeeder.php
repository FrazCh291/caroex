<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $purchaser_company = Company::create([
            'name' => 'Purchaser ABC',
            'contact_name' => 'Purchaser Abc',
            'parent_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'email' => 'abc@purchse.co.uk',
            'phone' => '+44 6521 852 149',
            'type' => 'purchaser_company',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        $purchaser_company->addresses()->create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'address_1' => 'Office#56',
            'address_2' => null,
            'town' => 'Cantt',
            'city' => 'Lahore',
            'county' => null,
            'postcode' => '54810',
            'country' => 'Pakistan',
        ]);

        $supplier_company = Company::create([
            'name' => 'Supplier STV',
            'contact_name' => 'Supplier Stv',
            'parent_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'email' => 'stv@supplier.co.uk',
            'phone' => '+44 6521 852 150',
            'type' => 'supplier_company',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        $supplier_company->addresses()->create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'address_1' => 'Building#120',
            'address_2' => 'Building#540',
            'town' => 'Acton',
            'city' => 'Liverpool',
            'county' => null,
            'postcode' => '0151',
            'country' => 'UK',
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'saas_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'supplier_id' => $supplier_company->id,
            'customer_id' =>  $purchaser_company->id,
            'purchase_order_number' => "PO123",
            'currency' => "62",
            'conversion_rate' => 1.34,
            'sub_total' => 252.00,
            'vat' => 2.00,
            'total' => 254.00,
            'purchase_filling_ref' => "John",
            'status' => "new",
            'order_date' => date("Y-m-d"),
            'deleted_at' => null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        PurchaseOrderItem::create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'purchase_order_id' => $purchaseOrder->id,
            'product_id' =>  1,
            'currency' => "62",
            'unit_price' => 12.00,
            'quantity' => 21,
            'total' => 252.00,
            'item_type' => 'item_type_product',
            'deleted_at' => null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        $purchaseOrder=PurchaseOrder::create([
            'saas_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'supplier_id' => $supplier_company->id,
            'customer_id' =>  $purchaser_company->id,
            'purchase_order_number' => "PO456",
            'currency' => "61",
            'conversion_rate' => 8.56,
            'sub_total' => 152.00,
            'vat' => 2.00,
            'total' => 154.00,
            'purchase_filling_ref' => "John",
            'status' => "released",
            'order_date' => date("Y-m-d"),
            'deleted_at' => null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        PurchaseOrderItem::create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'purchase_order_id' => $purchaseOrder->id,
            'product_id' =>  2,
            'currency' => "61",
            'unit_price' => 5.00,
            'quantity' => 10,
            'total' => 50.00,
            'item_type' => 'item_type_product',
            'deleted_at' => null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        $purchaseOrder=PurchaseOrder::create([
            'saas_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'supplier_id' => $supplier_company->id,
            'customer_id' =>  $purchaser_company->id,
            'purchase_order_number' => "PO789",
            'currency' => "61",
            'conversion_rate' => 8.56,
            'sub_total' => 52.00,
            'vat' => 2.00,
            'total' => 54.00,
            'purchase_filling_ref' => "John",
            'status' => "received",
            'order_date' => date("Y-m-d"),
            'deleted_at' => null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        PurchaseOrderItem::create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'purchase_order_id' => $purchaseOrder->id,
            'product_id' =>  3,
            'currency' => "61",
            'unit_price' => 2.00,
            'quantity' => 100,
            'total' => 200.00,
            'item_type' => 'item_type_product',
            'deleted_at' => null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        $purchaseOrder=PurchaseOrder::create([
            'saas_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'supplier_id' => $supplier_company->id,
            'customer_id' =>  $purchaser_company->id,
            'purchase_order_number' => "PO321",
            'currency' => "61",
            'conversion_rate' => 8.56,
            'sub_total' => 200.00,
            'vat' => 1.2,
            'total' => 201.20,
            'purchase_filling_ref' => "John",
            'status' => "canceled",
            'order_date' => date("Y-m-d"),
            'deleted_at' => null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        PurchaseOrderItem::create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'purchase_order_id' => $purchaseOrder->id,
            'product_id' =>  4,
            'currency' => "61",
            'unit_price' => 50.00,
            'quantity' => 10,
            'total' => 500.00,
            'item_type' => 'item_type_product',
            'deleted_at' => null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        $purchaseOrder=PurchaseOrder::create([
            'saas_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'supplier_id' => $supplier_company->id,
            'customer_id' =>  $purchaser_company->id,
            'purchase_order_number' => "PO654",
            'currency' => "62",
            'conversion_rate' => 1.34,
            'sub_total' => 225.00,
            'vat' => 1.5,
            'total' => 226.50,
            'purchase_filling_ref' => "John",
            'status' => "canceled",
            'order_date' => date("Y-m-d"),
            'deleted_at' => null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        PurchaseOrderItem::create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'purchase_order_id' => $purchaseOrder->id,
            'product_id' =>  5,
            'currency' => "61",
            'unit_price' => 100.00,
            'quantity' => 100,
            'total' => 10000.00,
            'item_type' => 'item_type_product',
            'deleted_at' => null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        $purchaseOrder=PurchaseOrder::create([
            'saas_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'supplier_id' => $supplier_company->id,
            'customer_id' =>  $purchaser_company->id,
            'purchase_order_number' => "PO987",
            'currency' => "62",
            'conversion_rate' => 1.34,
            'sub_total' => 252.00,
            'vat' => 2.00,
            'total' => 254.00,
            'purchase_filling_ref' => "John",
            'status' => "new",
            'order_date' => date("Y-m-d"),
            'deleted_at' => null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        PurchaseOrderItem::create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'purchase_order_id' => $purchaseOrder->id,
            'product_id' =>  null,
            'currency' => null,
            'unit_price' => null,
            'quantity' => null,
            'total' => 252.00,
            'item_type' => 'item_type_aditional_cost',
            'deleted_at' => null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        $purchaseOrder=PurchaseOrder::create([
            'saas_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'supplier_id' => $supplier_company->id,
            'customer_id' =>  $purchaser_company->id,
            'purchase_order_number' => "PO741",
            'currency' => "61",
            'conversion_rate' => 8.56,
            'sub_total' => 152.00,
            'vat' => 2.00,
            'total' => 154.00,
            'purchase_filling_ref' => "John",
            'status' => "released",
            'order_date' => date("Y-m-d"),
            'deleted_at' => null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        PurchaseOrderItem::create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'purchase_order_id' => $purchaseOrder->id,
            'product_id' =>  null,
            'currency' => null,
            'unit_price' => null,
            'quantity' => null,
            'total' => 50.00,
            'item_type' => 'item_type_aditional_cost',
            'deleted_at' => null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        $purchaseOrder=PurchaseOrder::create([
            'saas_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'supplier_id' => $supplier_company->id,
            'customer_id' =>  $purchaser_company->id,
            'purchase_order_number' => "PO852",
            'currency' => "61",
            'conversion_rate' => 8.56,
            'sub_total' => 52.00,
            'vat' => 2.00,
            'total' => 54.00,
            'purchase_filling_ref' => "John",
            'status' => "received",
            'order_date' => date("Y-m-d"),
            'deleted_at' => null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        PurchaseOrderItem::create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'purchase_order_id' => $purchaseOrder->id,
            'product_id' =>  null,
            'currency' => null,
            'unit_price' => null,
            'quantity' => null,
            'total' => 200.00,
            'item_type' => 'item_type_aditional_cost',
            'deleted_at' => null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        $purchaseOrder=PurchaseOrder::create([
            'saas_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'supplier_id' => $supplier_company->id,
            'customer_id' =>  $purchaser_company->id,
            'purchase_order_number' => "PO963",
            'currency' => "61",
            'conversion_rate' => 8.56,
            'sub_total' => 200.00,
            'vat' => 1.2,
            'total' => 201.20,
            'purchase_filling_ref' => "John",
            'status' => "canceled",
            'order_date' => date("Y-m-d"),
            'deleted_at' => null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        PurchaseOrderItem::create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'purchase_order_id' => $purchaseOrder->id,
            'product_id' =>  null,
            'currency' => null,
            'unit_price' => null,
            'quantity' => null,
            'total' => 500.00,
            'item_type' => 'item_type_aditional_cost',
            'deleted_at' => null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        $purchaseOrder=PurchaseOrder::create([
            'saas_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'supplier_id' => $supplier_company->id,
            'customer_id' =>  $purchaser_company->id,
            'purchase_order_number' => "PO951",
            'currency' => "62",
            'conversion_rate' => 1.34,
            'sub_total' => 225.00,
            'vat' => 1.5,
            'total' => 226.50,
            'purchase_filling_ref' => "John",
            'status' => "canceled",
            'order_date' => date("Y-m-d"),
            'deleted_at' => null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        PurchaseOrderItem::create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'purchase_order_id' => $purchaseOrder->id,
            'product_id' =>  null,
            'currency' => null,
            'unit_price' => null,
            'quantity' => null,
            'total' => 10000.00,
            'item_type' => 'item_type_aditional_cost',
            'deleted_at' => null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
