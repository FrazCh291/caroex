<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Shipment;
use Illuminate\Database\Seeder;

class InvoiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ShipmentTableSeeder::class);

        $shipment = Shipment::first();
        $invoice = $shipment->invoices()->create([
            'company_id' => null,
            'supplier_id' => null,
            'customer_id' =>  null,
            'ship_from_address_id' => null,
            'ship_to_address_id' => null,
            'invoice_number' =>null,
            'deal_number' => null,
            'reference_number' => null,
            'purchase_filling_ref' => null,
            'currency' => null,
            'tax' => null,
            'conversion_rate' => null,
            'balance' => null,
            'total' => null,
            'sub_total' => null,
            'vat' => null,
            'discount_total' => null,
            'shipping_cost' => null,
            'amount' => null,
            'amount_paid' => null,
            'transaction_id' => null,
            'status' => null,
            'notes' => null,
            'due_date' => null,
            'invoice_date' => null,
            'is_sent' => false,
            'is_sale' => null,
        ]);

        InvoiceItem::create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'invoice_id' => $invoice->id,
            'product_id' => null,
            'item_name' => null,
            'carton' => null,
            'quantity' => 10,
            'currency' => null,
            'total_quantity' => null,
            'unit_price' => 2,
            'total_price' => null,
            'total' => null,
            'vat' => null
        ]);

        $invoice = $shipment->invoices()->create([
            'company_id' => null,
            'supplier_id' => null,
            'customer_id' =>  null,
            'ship_from_address_id' => null,
            'ship_to_address_id' => null,
            'invoiceable_type' => "App\Models\Shipment",
            'invoiceable_id' => Shipment::first()->id,
            'invoice_number' =>null,
            'deal_number' => null,
            'reference_number' => null,
            'purchase_filling_ref' => null,
            'currency' => null,
            'tax' => null,
            'conversion_rate' => null,
            'balance' => null,
            'total' => null,
            'sub_total' => null,
            'vat' => null,
            'discount_total' => null,
            'shipping_cost' => null,
            'amount' => null,
            'amount_paid' => null,
            'transaction_id' => null,
            'status' => null,
            'notes' => null,
            'due_date' => null,
            'invoice_date' => null,
            'is_sent' => false,
            'is_sale' => null,
        ]);

        InvoiceItem::create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'invoice_id' => $invoice->id,
            'product_id' => null,
            'item_name' => null,
            'carton' => null,
            'quantity' => 8,
            'currency' => null,
            'total_quantity' => null,
            'unit_price' => 3,
            'total_price' => null,
            'total' => null,
            'vat' => null
        ]);

        $invoice = $shipment->invoices()->create([
            'company_id' => null,
            'supplier_id' => null,
            'customer_id' =>  null,
            'ship_from_address_id' => null,
            'ship_to_address_id' => null,
            'invoiceable_type' => "App\Models\Shipment",
            'invoiceable_id' => Shipment::first()->id,
            'invoice_number' =>null,
            'deal_number' => null,
            'reference_number' => null,
            'purchase_filling_ref' => null,
            'currency' => null,
            'tax' => null,
            'conversion_rate' => null,
            'balance' => null,
            'total' => null,
            'sub_total' => null,
            'vat' => null,
            'discount_total' => null,
            'shipping_cost' => null,
            'amount' => null,
            'amount_paid' => null,
            'transaction_id' => null,
            'status' => null,
            'notes' => null,
            'due_date' => null,
            'invoice_date' => null,
            'is_sent' => false,
            'is_sale' => null,
        ]);

        InvoiceItem::create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'invoice_id' => $invoice->id,
            'product_id' => null,
            'item_name' => null,
            'carton' => null,
            'quantity' => 6,
            'currency' => null,
            'total_quantity' => null,
            'unit_price' => 4,
            'total_price' => null,
            'total' => null,
            'vat' => null
        ]);

        $invoice = $shipment->invoices()->create([
            'company_id' => null,
            'supplier_id' => null,
            'customer_id' =>  null,
            'ship_from_address_id' => null,
            'ship_to_address_id' => null,
            'invoiceable_type' => "App\Models\Shipment",
            'invoiceable_id' => Shipment::first()->id,
            'invoice_number' =>null,
            'deal_number' => null,
            'reference_number' => null,
            'purchase_filling_ref' => null,
            'currency' => null,
            'tax' => null,
            'conversion_rate' => null,
            'balance' => null,
            'total' => null,
            'sub_total' => null,
            'vat' => null,
            'discount_total' => null,
            'shipping_cost' => null,
            'amount' => null,
            'amount_paid' => null,
            'transaction_id' => null,
            'status' => null,
            'notes' => null,
            'due_date' => null,
            'invoice_date' => null,
            'is_sent' => false,
            'is_sale' => null,
        ]);

        InvoiceItem::create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'invoice_id' => $invoice->id,
            'product_id' => null,
            'item_name' => null,
            'carton' => null,
            'quantity' => 4,
            'currency' => null,
            'total_quantity' => null,
            'unit_price' => 5,
            'total_price' => null,
            'total' => null,
            'vat' => null
        ]);

        $invoice =$shipment->invoices()->create([
            'company_id' => null,
            'supplier_id' => null,
            'customer_id' =>  null,
            'ship_from_address_id' => null,
            'ship_to_address_id' => null,
            'invoiceable_type' => "App\Models\Shipment",
            'invoiceable_id' => Shipment::first()->id,
            'invoice_number' =>null,
            'deal_number' => null,
            'reference_number' => null,
            'purchase_filling_ref' => null,
            'currency' => null,
            'tax' => null,
            'conversion_rate' => null,
            'balance' => null,
            'total' => null,
            'sub_total' => null,
            'vat' => null,
            'discount_total' => null,
            'shipping_cost' => null,
            'amount' => null,
            'amount_paid' => null,
            'transaction_id' => null,
            'status' => null,
            'notes' => null,
            'due_date' => null,
            'invoice_date' => null,
            'is_sent' => false,
            'is_sale' => null,
        ]);

        InvoiceItem::create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'invoice_id' => $invoice->id,
            'product_id' => null,
            'item_name' => null,
            'carton' => null,
            'quantity' => 2,
            'currency' => null,
            'total_quantity' => null,
            'unit_price' => 6,
            'total_price' => null,
            'total' => null,
            'vat' => null
        ]);

        $invoice = $shipment->invoices()->create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'supplier_id' => Company::where('type', 'supplier_company')->first()->id,
            'customer_id' =>  Company::where('type', 'purchaser_company')->first()->id,
            'ship_from_address_id' => null,
            'ship_to_address_id' => null,
            'invoiceable_type' => "App\Models\Shipment",
            'invoiceable_id' => Shipment::first()->id,
            'invoice_number' => "IN123",
            'deal_number' => "DN123",
            'reference_number' => "RN123",
            'purchase_filling_ref' => "John",
            'currency' => "61",
            'tax' => 1.2,
            'conversion_rate' => 1.36,
            'balance' => 5,
            'total' => 10,
            'sub_total' => 10,
            'vat' => 1.2,
            'discount_total' => 0,
            'shipping_cost' => 1,
            'amount' => 11,
            'amount_paid' => 6,
            'transaction_id' => "TR123",
            'status' => "un_paid",
            'notes' => "123",
            'due_date' => date("Y-m-d H:i:s"),
            'invoice_date' => date("Y-m-d"),
            'is_sent' => true,
            'is_sale' => true,
        ]);

        InvoiceItem::create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'invoice_id' => $invoice->id,
            'product_id' => 1,
            'item_name' => "A6 Basic",
            'carton' => 1,
            'quantity' => 10,
            'currency' => "61",
            'total_quantity' => 10,
            'unit_price' => 2,
            'total_price' => 20,
            'total' => 20.1,
            'vat' => 1.1
        ]);

        $invoice = $shipment->invoices()->create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'supplier_id' => Company::where('type', 'supplier_company')->first()->id,
            'customer_id' =>  Company::where('type', 'purchaser_company')->first()->id,
            'ship_from_address_id' => null,
            'ship_to_address_id' => null,
            'invoiceable_type' => "App\Models\Shipment",
            'invoiceable_id' => Shipment::first()->id,
            'invoice_number' => "IN456",
            'deal_number' => "DN456",
            'reference_number' => "RN456",
            'purchase_filling_ref' => "John",
            'currency' => "61",
            'tax' => 1.2,
            'conversion_rate' => 1.36,
            'balance' => 5,
            'total' => 10,
            'sub_total' => 10,
            'vat' => 1.2,
            'discount_total' => 0,
            'shipping_cost' => 1,
            'amount' => 11,
            'amount_paid' => 6,
            'transaction_id' => "TR456",
            'status' => "un_paid",
            'notes' => "456",
            'due_date' => date("Y-m-d H:i:s"),
            'invoice_date' => date("Y-m-d"),
            'is_sent' => false,
            'is_sale' => false,
        ]);

        InvoiceItem::create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'invoice_id' => $invoice->id,
            'product_id' => 2,
            'item_name' => "A6 Multi",
            'carton' => 1,
            'quantity' => 10,
            'currency' => "61",
            'total_quantity' => 10,
            'unit_price' => 2,
            'total_price' => 20,
            'total' => 20.1,
            'vat' => 1.1
        ]);

        $invoice = $shipment->invoices()->create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'supplier_id' => Company::where('type', 'supplier_company')->first()->id,
            'customer_id' =>  Company::where('type', 'purchaser_company')->first()->id,
            'ship_from_address_id' => null,
            'ship_to_address_id' => null,
            'invoiceable_type' => "App\Models\Shipment",
            'invoiceable_id' => Shipment::first()->id,
            'invoice_number' => "IN789",
            'deal_number' => "DN789",
            'reference_number' => "RN789",
            'purchase_filling_ref' => "John",
            'currency' => "61",
            'tax' => 1.2,
            'conversion_rate' => 1.36,
            'balance' => 5,
            'total' => 10,
            'sub_total' => 10,
            'vat' => 1.2,
            'discount_total' => 0,
            'shipping_cost' => 1,
            'amount' => 11,
            'amount_paid' => 6,
            'transaction_id' => "TR789",
            'status' => "paid",
            'notes' => "789",
            'due_date' => date("Y-m-d H:i:s"),
            'invoice_date' => date("Y-m-d"),
            'is_sent' => false,
            'is_sale' => false,
        ]);

        InvoiceItem::create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'invoice_id' => $invoice->id,
            'product_id' => 3,
            'item_name' => "E Bayyaka",
            'carton' => 1,
            'quantity' => 10,
            'currency' => "61",
            'total_quantity' => 10,
            'unit_price' => 2,
            'total_price' => 20,
            'total' => 20.1,
            'vat' => 1.1
        ]);

        $invoice = $shipment->invoices()->create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'supplier_id' => Company::where('type', 'supplier_company')->first()->id,
            'customer_id' =>  Company::where('type', 'purchaser_company')->first()->id,
            'ship_from_address_id' => null,
            'ship_to_address_id' => null,
            'invoiceable_type' => "App\Models\Shipment",
            'invoiceable_id' => Shipment::first()->id,
            'invoice_number' => "IN951",
            'deal_number' => "DN951",
            'reference_number' => "RN951",
            'purchase_filling_ref' => "John",
            'currency' => "61",
            'tax' => 1.2,
            'conversion_rate' => 1.36,
            'balance' => 5,
            'total' => 10,
            'sub_total' => 10,
            'vat' => 1.2,
            'discount_total' => 0,
            'shipping_cost' => 1,
            'amount' => 11,
            'amount_paid' => 6,
            'transaction_id' => "TR951",
            'status' => "paid",
            'notes' => "951",
            'due_date' => date("Y-m-d H:i:s"),
            'invoice_date' => date("Y-m-d"),
            'is_sent' => false,
            'is_sale' => false,
        ]);

        InvoiceItem::create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'invoice_id' => $invoice->id,
            'product_id' => 4,
            'item_name' => "X2 Black",
            'carton' => 1,
            'quantity' => 10,
            'currency' => "61",
            'total_quantity' => 10,
            'unit_price' => 2,
            'total_price' => 20,
            'total' => 20.1,
            'vat' => 1.1
        ]);

        $invoice = $shipment->invoices()->create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'supplier_id' => Company::where('type', 'supplier_company')->first()->id,
            'customer_id' =>  Company::where('type', 'purchaser_company')->first()->id,
            'ship_from_address_id' => null,
            'ship_to_address_id' => null,
            'invoiceable_type' => "App\Models\Shipment",
            'invoiceable_id' => Shipment::first()->id,
            'invoice_number' => "IN753",
            'deal_number' => "DN753",
            'reference_number' => "RN753",
            'purchase_filling_ref' => "John",
            'currency' => "61",
            'tax' => 1.2,
            'conversion_rate' => 1.36,
            'balance' => 5,
            'total' => 10,
            'sub_total' => 10,
            'vat' => 1.2,
            'discount_total' => 0,
            'shipping_cost' => 1,
            'amount' => 11,
            'amount_paid' => 6,
            'transaction_id' => "TR753",
            'status' => "paid",
            'notes' => "753",
            'due_date' => date("Y-m-d H:i:s"),
            'invoice_date' => date("Y-m-d"),
            'is_sent' => true,
            'is_sale' => true,
        ]);

        InvoiceItem::create([
            'company_id' => Company::where('name', 'Alfa Mohuha')->where('contact_name','Mohsin Shah')->where('email','mohsin.shah@alfamohuha.com')->first()->id,
            'invoice_id' => $invoice->id,
            'product_id' => 5,
            'item_name' => "X2 Red",
            'carton' => 1,
            'quantity' => 10,
            'currency' => "61",
            'total_quantity' => 10,
            'unit_price' => 2,
            'total_price' => 20,
            'total' => 20.1,
            'vat' => 1.1
        ]);
    }
}
