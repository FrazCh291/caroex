<?php

namespace Database\Seeders;

use App\Models\Lookup;
use Illuminate\Support\Str;
use League\ISO3166\ISO3166;
use App\Services\Languages;
use App\Services\Currencies;
use Illuminate\Database\Seeder;

class LookupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $countries = new ISO3166();
        $counter = 0;
        foreach ($countries->all() as $country) {
            Lookup::firstOrCreate(['slug' => $country['alpha2']], [
                'type' => 'country',
                'value' => $country['name'],
                'slug' => $country['alpha2'],
                'order' => $counter,
                'enable' => true,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
            $counter++;
        }
        Lookup::firstOrCreate(['slug' => 'england_agent'], [
            'type' => 'shipment_agent',
            'value' => 'England Agent',
            'slug' => 'england_agent',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'china_agent'], [
            'type' => 'shipment_agent',
            'value' => 'China Agent',
            'slug' => 'china_agent',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'unpaid'], [
            'type' => 'shipment_status',
            'value' => 'Unpaid',
            'slug' => 'unpaid',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'partial_paid'], [
            'type' => 'shipment_status',
            'value' => 'Partial_paid',
            'slug' => 'partial_paid',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'paid'], [
            'type' => 'shipment_status',
            'value' => 'Paid',
            'slug' => 'paid',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'delivered'], [
            'type' => 'shipment_status',
            'value' => 'Delivered',
            'slug' => 'delivered',
            'order' => 4,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'email'], [
            'type' => 'source',
            'value' => 'Email',
            'slug' => 'email',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'phone'], [
            'type' => 'source',
            'value' => 'Phone',
            'slug' => 'phone',
            'order' => 5,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'jivo'], [
            'type' => 'source',
            'value' => 'Jivo',
            'slug' => 'jivo',
            'order' => 4,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'website'], [
            'type' => 'source',
            'value' => 'Website',
            'slug' => 'website',
            'order' => 7,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'whatsapp'], [
            'type' => 'source',
            'value' => 'Whatsapp',
            'slug' => 'whatsapp',
            'order' => 8,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'facebook'], [
            'type' => 'source',
            'value' => 'Facebook',
            'slug' => 'facebook',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'twitter'], [
            'type' => 'source',
            'value' => 'Twitter',
            'slug' => 'source',
            'order' => 6,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'instagram'], [
            'type' => 'source',
            'value' => 'Instagram',
            'slug' => 'instagram',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'others'], [
            'type' => 'source',
            'value' => 'Others',
            'slug' => 'other',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'open'], [
            'type' => 'case_status',
            'value' => 'Open',
            'slug' => 'open',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'in-progress'], [
            'type' => 'case_status',
            'value' => 'In Progress',
            'slug' => 'in-progress',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'closed'], [
            'type' => 'case_status',
            'value' => 'Closed',
            'slug' => 'closed',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['type' => 'case_sparePart_status','slug' => 'case_sparepart_pending'], [
            'type' => 'case_sparePart_status',
            'value' => 'Pending',
            'slug' => 'case_sparepart_pending',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['type' => 'case_sparePart_status','slug' => 'case_sparepart_autherize'], [
            'type' => 'case_sparePart_status',
            'value' => 'Autherize',
            'slug' => 'case_sparepart_autherize',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['type' => 'case_sparePart_status','slug' => 'case_sparepart_shipped'], [
            'type' => 'case_sparePart_status',
            'value' => 'Shipped',
            'slug' => 'case_sparepart_shipped',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['type' => 'case_sparePart_status', 'slug' => 'case_sparepart_delivered'], [
            'type' => 'case_sparePart_status',
            'value' => 'Delivered',
            'slug' => 'case_sparepart_delivered',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'erp_company'], [
            'type' => 'company_type',
            'value' => 'ERP',
            'slug' => 'erp_company',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'warehouse', 'type' => 'company_type'], [
            'type' => 'company_type',
            'value' => 'Warehouse',
            'slug' => 'warehouse',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'freight_company'], [
            'type' => 'company_type',
            'value' => 'Freight',
            'slug' => 'freight_company',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'sales_channel'], [
            'type' => 'company_type',
            'value' => 'Sale Channel',
            'slug' => 'sale_channel',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'fulfilment_company'], [
            'type' => 'company_type',
            'value' => 'Fulflment Company',
            'slug' => 'fulfilment_company',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'mcrm_company'], [
            'type' => 'company_type',
            'value' => 'MCRM',
            'slug' => 'mcrm_company',
            'order' => 4,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'supplier_company'], [
            'type' => 'company_type',
            'value' => 'Supplier',
            'slug' => 'supplier_company',
            'order' => 5,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'purchaser_company'], [
            'type' => 'company_type',
            'value' => 'Purchaser',
            'slug' => 'purchaser_company',
            'order' => 6,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'ecommerce'], [
            'type' => 'types',
            'value' => 'eCommerce',
            'slug' => 'ecommerce',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'emails'], [
            'type' => 'types',
            'value' => 'Emails',
            'slug' => 'emails',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'maskateer_staff'], [
            'type' => 'types',
            'value' => 'Maskateer staff',
            'slug' => 'maskateer_staff',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'phone call'], [
            'type' => 'types',
            'value' => 'Phone Call',
            'slug' => 'phone call',
            'order' => 4,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'QMS_staff'], [
            'type' => 'types',
            'value' => 'QMS staff',
            'slug' => 'QMS_staff',
            'order' => 5,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'social_accounts'], [
            'type' => 'types',
            'value' => 'Social Accounts',
            'slug' => 'social_accounts',
            'order' => 6,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'instagram'], [
            'type' => 'providers',
            'value' => 'Instagram',
            'slug' => 'instagram',
            'order' => 7,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'status_closed'], [
            'parent_type' => 'case',
            'type' => 'status',
            'value' => 'Closed',
            'slug' => 'status_closed',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'status_in_progress'], [
            'parent_type' => 'case',
            'type' => 'status',
            'value' => 'In progress',
            'slug' => 'status_in_progress',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'status_open'], [
            'parent_type' => 'case',
            'type' => 'status',
            'value' => 'Open',
            'slug' => 'status_open',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'faulty_or_product_requiring_repair'], [
            'type' => 'return_reason',
            'value' => 'Faulty or product requiring repair',
            'slug' => 'faulty_or_product_requiring_repair',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'order_wrong_product_or_size'], [
            'type' => 'return_reason',
            'value' => 'Ordered wrong product or size',
            'slug' => 'order_wrong_product_or_size',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'received_wrong_product_or_size'], [
            'type' => 'return_reason',
            'value' => 'Received wrong product or size',
            'slug' => 'received_wrong_product_or_size',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'exchange'], [
            'type' => 'requested_action',
            'value' => 'Exchange',
            'slug' => 'exchange',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'refund'], [
            'type' => 'requested_action',
            'value' => 'Refund',
            'slug' => 'refund',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        //        Lookup::firstOrCreate(['slug' => 'resend'], [
        //            'type' => 'requested_action',
        //            'value' => 'Resend',
        //            'slug' => 'resend',
        //            'order' => 3,
        //            'enable' => true,
        //            'created_at' => date("Y-m-d H:i:s"),
        //            'updated_at' => date("Y-m-d H:i:s"),
        //        ]);

        Lookup::firstOrCreate(['slug' => 'return_status_received'], [
            'type' => 'return_status',
            'value' => 'Received',
            'slug' => 'return_status_received',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'return_status_pending'], [
            'type' => 'return_status',
            'value' => 'Pending',
            'slug' => 'return_status_pending',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'return_status_authorizes'], [
            'type' => 'return_status',
            'value' => 'Authorizes Return',
            'slug' => 'return_status_authorizes',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);


        Lookup::firstOrCreate(['slug' => 'collected'], [
            'type' => 'return_status',
            'value' => 'Collected',
            'slug' => 'collected',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);


        Lookup::firstOrCreate(['slug' => 'stock_receive_received'], [
            'type' => 'stock_receive_status',
            'value' => 'Received',
            'slug' => 'stock_receive_received',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'stock_receive_pending'], [
            'type' => 'stock_receive_status',
            'value' => 'Pending',
            'slug' => 'stock_receive_pending',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'stock_receive_partially_received'], [
            'type' => 'stock_receive_status',
            'value' => 'Partially Received',
            'slug' => 'stock_receive_partially_received',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'priority_high'], [
            'type' => 'priority',
            'value' => 'High',
            'slug' => 'priority_high',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'priority_low'], [
            'type' => 'priority',
            'value' => 'Low',
            'slug' => 'priority_low',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'priority_medium'], [
            'type' => 'priority',
            'value' => 'Medium',
            'slug' => 'priority_medium',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'collection'], [
            'type' => 'case_type',
            'value' => 'Collection',
            'slug' => 'collection',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'cancel&refund'], [
            'type' => 'case_type',
            'value' => 'Cancel & Refund',
            'slug' => 'cancel&refund',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'partialrefund'], [
            'type' => 'case_type',
            'value' => 'Partial Refund',
            'slug' => 'partialrefund',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'collection&refund'], [
            'type' => 'case_type',
            'value' => 'Collection & Refund',
            'slug' => 'collection&refund',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'collection&replacement'], [
            'type' => 'case_type',
            'value' => 'Collection & Replacement',
            'slug' => 'collection&replacement',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'spareparts'], [
            'type' => 'case_type',
            'value' => 'Spare Parts',
            'slug' => 'spareparts',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'others'], [
            'type' => 'case_type',
            'value' => 'Others',
            'slug' => 'others',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'request_received'], [
            'type' => 'stock_transfer_request',
            'value' => 'Received',
            'slug' => 'request_received',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'request_pending'], [
            'type' => 'stock_transfer_request',
            'value' => 'Pending',
            'slug' => 'request_pending',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'request_not_accepted'], [
            'type' => 'stock_transfer_request',
            'value' => 'NotAcceptedYet',
            'slug' => 'request_not_accepted',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'stock_transfer_closed'], [
            'type' => 'stock_transfer',
            'value' => 'Closed',
            'slug' => 'stock_transfer_closed',
            'order' => 4,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'stock_transfer_open'], [
            'type' => 'stock_transfer',
            'value' => 'Open',
            'slug' => 'stock_transfer_open',
            'order' => 5,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'stock_transfer_rejected'], [
            'type' => 'stock_transfer',
            'value' => 'Rejected',
            'slug' => 'stock_transfer_rejected',
            'order' => 6,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
//        Lookup::firstOrCreate(['slug' => 'purchase_order_shipped'], [
//            'type' => 'purchase_order_status',
//            'value' => 'Shipped',
//            'slug' => 'purchase_order_shipped',
//            'order' => 1,
//            'enable' => true,
//            'created_at' => date("Y-m-d H:i:s"),
//            'updated_at' => date("Y-m-d H:i:s"),
//        ]);
//        Lookup::firstOrCreate(['slug' => 'purchase_order_ordered'], [
//            'type' => 'purchase_order_status',
//            'value' => 'Ordered',
//            'slug' => 'purchase_order_ordered',
//            'order' => 2,
//            'enable' => true,
//            'created_at' => date("Y-m-d H:i:s"),
//            'updated_at' => date("Y-m-d H:i:s"),
//        ]);
//        Lookup::firstOrCreate(['slug' => 'purchase_order_pending'], [
//            'type' => 'purchase_order_status',
//            'value' => 'Pending',
//            'slug' => 'purchase_order_pending',
//            'order' => 3,
//            'enable' => true,
//            'created_at' => date("Y-m-d H:i:s"),
//            'updated_at' => date("Y-m-d H:i:s"),
//        ]);
//        Lookup::firstOrCreate(['slug' => 'purchase_order_delivered'], [
//            'type' => 'purchase_order_status',
//            'value' => 'Delivered',
//            'slug' => 'purchase_order_delivered',
//            'order' => 4,
//            'enable' => true,
//            'created_at' => date("Y-m-d H:i:s"),
//            'updated_at' => date("Y-m-d H:i:s"),
//        ]);

        Lookup::firstOrCreate(['slug' => 'call_customer'], [
            'parent_type' => 'action',
            'type' => 'communication',
            'value' => 'Call Customer',
            'slug' => 'call_customer',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'email_customer'], [
            'parent_type' => 'action',
            'type' => 'communication',
            'value' => 'Email Customer',
            'slug' => 'email_customer',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'facebook_dm_customer'], [
            'parent_type' => 'action',
            'type' => 'communication',
            'value' => 'Facebook DM Customer',
            'slug' => 'facebook_dm_customer',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'instagram_dm_customer'], [
            'parent_type' => 'action',
            'type' => 'communication',
            'value' => 'Instagram DM Customer',
            'slug' => 'instagram_dm_customer',
            'order' => 4,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'sms_customer'], [
            'parent_type' => 'action',
            'type' => 'communication',
            'value' => 'SMS customer',
            'slug' => 'sms_customer',
            'order' => 5,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'whatsapp_customer'], [
            'parent_type' => 'action',
            'type' => 'communication',
            'value' => 'Whatsapp customer',
            'slug' => 'whatsapp_customer',
            'order' => 6,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'to_do'], [
            'parent_type' => 'action',
            'type' => 'status',
            'value' => 'To do',
            'slug' => 'to_do',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'done'], [
            'parent_type' => 'action',
            'type' => 'status',
            'value' => 'Done',
            'slug' => 'done',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        //        $countries = new ISO3166();
        //        $counter = 1;
        //        foreach ($countries->all() as $country) {
        //            Lookup::firstOrCreate(['slug' => $country['alpha2']], [
        //                'type' => 'country',
        //                'value' => $country['name'] . ',' . $country['alpha3'],
        //                'slug' => $country['alpha2'],
        //                'order' => $counter,
        //                'enable' => true,
        //                'created_at' => date("Y-m-d H:i:s"),
        //                'updated_at' => date("Y-m-d H:i:s"),
        //            ]);
        //            $counter++;
        //        }

        Lookup::firstOrCreate(['slug' => 'AN'], [
            'type' => 'country',
            'value' => 'Netherlands Antilles, ANT',
            'slug' => 'AN',
            'order' => 250,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'XK'], [
            'type' => 'country',
            'value' => 'Kosovo, XKX',
            'slug' => 'XK',
            'order' => 251,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        $languages = new Languages();
        $counter = 1;
        foreach ($languages->all() as $language) {
            Lookup::firstOrCreate(['slug' => Str::slug('language ' . $language['code'], '_')], [
                'type' => 'language',
                'value' => $language['name'] . ',' . $language['code'],
                'slug' => Str::slug('language ' . $language['code'], '_'),
                'order' => $counter,
                'enable' => true,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
            $counter++;
        }

        $currencies = new Currencies();
        $counter = 1;
        foreach ($currencies->all() as $currency) {
            Lookup::firstOrCreate(['slug' => Str::slug( $currency['alpha3'])], [
                'type' => 'currency',
                'value' => $currency['name'] . ',' . $currency['alpha3'],
                'slug' => Str::slug( $currency['alpha3']),
                'order' => $counter,
                'enable' => true,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
            $counter++;
        }

        Lookup::firstOrCreate(['slug' => 'warehouse'], [
            'type' => 'fulfilment_center',
            'value' => 'QMS',
            'slug' => 'warehouse',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'maskateer'], [
            'type' => 'fulfilment_center',
            'value' => 'Maskateer',
            'slug' => 'maskateer',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'pfw_orders'], [
            'type' => 'fulfilment_type',
            'value' => 'PFW Orders',
            'slug' => 'pfw_orders',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'orders'], [
            'type' => 'fulfilment_type',
            'value' => 'Orders',
            'slug' => 'orders',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'pfw'], [
            'type' => 'fulfilment_type',
            'value' => 'PFW',
            'slug' => 'pfw',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'rm_orders'], [
            'type' => 'fulfilment_type',
            'value' => 'RM orders',
            'slug' => 'rm_orders',
            'order' => 4,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'dhl_orders'], [
            'type' => 'fulfilment_type',
            'value' => 'DHl orders',
            'slug' => 'dhl_orders',
            'order' => 5,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'nopcommerce_order'], [
            'type' => 'order_source',
            'value' => 'NopCommerce',
            'slug' => 'nopcommerce_order',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'amazon_order'], [
            'type' => 'order_source',
            'value' => 'Amazon',
            'slug' => 'amazon_order',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'ebay_order'], [
            'type' => 'order_source',
            'value' => 'Ebay',
            'slug' => 'ebay_order',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'paypal_invoice_order'], [
            'type' => 'order_source',
            'value' => 'PayPal invoice',
            'slug' => 'paypal_invoice_order',
            'order' => 4,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'other_order'], [
            'type' => 'order_source',
            'value' => 'Other',
            'slug' => 'other_order',
            'order' => 5,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'ready_to_send', 'type' => 'queued_order_reasons'], [
            'type' => 'queued_order_reasons',
            'value' => 'Ready to send',
            'slug' => 'ready_to_send',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'blocked_shipping_billing_address_mismatch', 'type' => 'queued_order_reasons'], [
            'type' => 'queued_order_reasons',
            'value' => 'Blocked: shipping/billing address mismatch',
            'slug' => 'blocked_shipping_billing_address_mismatch',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'blocked_invalid_postcode', 'type' => 'queued_order_reasons'], [
            'type' => 'queued_order_reasons',
            'value' => 'Blocked: invalid postcode',
            'slug' => 'blocked_invalid_postcode',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'blocked_out_of_stock', 'type' => 'queued_order_reasons'], [
            'type' => 'queued_order_reasons',
            'value' => 'Blocked: out of stock',
            'slug' => 'blocked_out_of_stock',
            'order' => 4,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'blocked_address_not_found', 'type' => 'queued_order_reasons'], [
            'type' => 'queued_order_reasons',
            'value' => 'Blocked: address not found',
            'slug' => 'blocked_address_not_found',
            'order' => 5,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'QMS_issue', 'type' => 'queued_order_reasons'], [
            'type' => 'queued_order_reasons',
            'value' => 'QMS issue',
            'slug' => 'QMS_issue',
            'order' => 6,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'QMS_issue_address_not_found', 'type' => 'queued_order_reasons'], [
            'type' => 'queued_order_reasons',
            'value' => 'QMS issue: address not found',
            'slug' => 'QMS_issue_address_not_found',
            'order' => 7,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'QMS_issue_out_of_stock', 'type' => 'queued_order_reasons'], [
            'type' => 'queued_order_reasons',
            'value' => 'QMS issue: out of stock',
            'slug' => 'QMS_issue_out_of_stock',
            'order' => 8,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'sent_to_QMS', 'type' => 'queued_order_reasons'], [
            'type' => 'queued_order_reasons',
            'value' => 'Sent to QMS',
            'slug' => 'sent_to_QMS',
            'order' => 9,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'blocked_more_than_20_items', 'type' => 'queued_order_reasons'], [
            'type' => 'queued_order_reasons',
            'value' => 'Blocked: more than 20 items',
            'slug' => 'blocked_more_than_20_items',
            'order' => 10,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'blocked_remote_area', 'type' => 'queued_order_reasons'], [
            'type' => 'queued_order_reasons',
            'value' => 'Blocked: remote area',
            'slug' => 'blocked_remote_area',
            'order' => 11,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'QMS_email_1', 'type' => 'fulfilment_center_emails'], [
            'type' => 'fulfilment_center_emails',
            'value' => 'emilys@quantum-mkt.co.uk',
            'slug' => 'QMS_email_1',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'QMS_email_2', 'type' => 'fulfilment_center_emails'], [
            'type' => 'fulfilment_center_emails',
            'value' => 'AlexandraN@quantum-mkt.co.uk',
            'slug' => 'QMS_email_2',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'payment_method_amazon', 'type' => 'payment_methods'], [
            'type' => 'payment_methods',
            'value' => 'Amazon',
            'slug' => 'payment_method_amazon',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'payment_method_ebay', 'type' => 'payment_methods'], [
            'type' => 'payment_methods',
            'value' => 'Ebay',
            'slug' => 'payment_method_ebay',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'payment_method_paypal', 'type' => 'payment_methods'], [
            'type' => 'payment_methods',
            'value' => 'PayPal',
            'slug' => 'payment_method_paypal',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'payment_method_card', 'type' => 'payment_method'], [
            'type' => 'payment_method',
            'value' => 'Card',
            'slug' => 'payment_method_card',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'payment_method_cash', 'type' => 'payment_method'], [
            'type' => 'payment_method',
            'value' => 'Cash',
            'slug' => 'payment_method_cash',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'payment_method_cheque', 'type' => 'payment_method'], [
            'type' => 'payment_method',
            'value' => 'Cheque',
            'slug' => 'payment_method_cheque',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'payment_method_bank', 'type' => 'payment_method'], [
            'type' => 'payment_method',
            'value' => 'Bank Transfer',
            'slug' => 'payment_method_bank',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'review_unapproved'], [
            'type' => 'review_status',
            'value' => 'Unapproved',
            'slug' => 'review_unapproved',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'review_approved'], [
            'type' => 'review_status',
            'value' => 'Approved',
            'slug' => 'review_approved',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'new'], [
            'type' => 'purchase_order_status',
            'value' => 'New',
            'slug' => 'new',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'released'], [
            'type' => 'purchase_order_status',
            'value' => 'Released',
            'slug' => 'released',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'received'], [
            'type' => 'purchase_order_status',
            'value' => 'Received',
            'slug' => 'received',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'canceled'], [
            'type' => 'purchase_order_status',
            'value' => 'Canceled',
            'slug' => 'canceled',
            'order' => 4,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'closed'], [
            'type' => 'purchase_order_status',
            'value' => 'Closed',
            'slug' => 'closed',
            'order' => 5,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'quotation_type_adult'], [
            'type' => 'quotation_type',
            'value' => 'Adult',
            'slug' => 'quotation_type_adult',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'quotation_type_alcohol and softdrink'], [
            'type' => 'quotation_type',
            'value' => 'Alcohol and Softdrink',
            'slug' => 'quotation_type_alcohol and softdrink',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'quotation_type_apparel'], [
            'type' => 'quotation_type',
            'value' => 'Apparel',
            'slug' => 'quotation_type_apparel',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'quotation_type_arts and craft'], [
            'type' => 'quotation_type',
            'value' => 'Arts and Craft',
            'slug' => 'quotation_type_arts and craft',
            'order' => 4,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'quotation_type_automative and parts'], [
            'type' => 'quotation_type',
            'value' => 'Automative and Parts',
            'slug' => 'quotation_type_automative and parts',
            'order' => 5,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'quotation_type_baby and toddler'], [
            'type' => 'quotation_type',
            'value' => 'Baby and Toddler',
            'slug' => 'quotation_type_baby and toddler',
            'order' => 6,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'quotation_type_diy'], [
            'type' => 'quotation_type',
            'value' => 'Diy',
            'slug' => 'quotation_type_diy',
            'order' => 7,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'quotation_type_fitness and sporting food'], [
            'type' => 'quotation_type',
            'value' => 'Fitness and Sporting food',
            'slug' => 'quotation_type_fitness and sporting food',
            'order' => 8,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'quotation_type_homeware'], [
            'type' => 'quotation_type',
            'value' => 'Homeware',
            'slug' => 'quotation_type_homeware',
            'order' => 9,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'quotation_type_male grooming'], [
            'type' => 'quotation_type',
            'value' => 'Male grooming',
            'slug' => 'quotation_type_male grooming',
            'order' => 10,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'quotation_type_medical'], [
            'type' => 'quotation_type',
            'value' => 'Medical',
            'slug' => 'quotation_type_medical',
            'order' => 11,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'quotation_type_other'], [
            'type' => 'quotation_type',
            'value' => 'Other',
            'slug' => 'quotation_type_other',
            'order' => 12,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'quotation_type_pet products'], [
            'type' => 'quotation_type',
            'value' => 'Pet Products',
            'slug' => 'quotation_type_pet products',
            'order' => 13,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);


        Lookup::firstOrCreate(['slug' => 'quotation_platform_ecommerce'], [
            'type' => 'quotation_platform',
            'value' => 'ecommerce',
            'slug' => 'quotation_platform_ecommerce',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'quotation_platform_amazon'], [
            'type' => 'quotation_platform',
            'value' => 'Amazon',
            'slug' => 'quotation_platform_amazon',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);


        Lookup::firstOrCreate(['slug' => 'quotation_platform_bigcommerce'], [
            'type' => 'quotation_platform',
            'value' => 'BigCommerce',
            'slug' => 'quotation_platform_bigcommerce',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'quotation_platform_shopify'], [
            'type' => 'quotation_platform',
            'value' => 'Shopify',
            'slug' => 'quotation_platform_shopify',
            'order' => 4,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'quotation_platform_square'], [
            'type' => 'quotation_platform',
            'value' => 'Square',
            'slug' => 'quotation_platform_square',
            'order' => 5,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'quotation_platform_Squarespace'], [
            'type' => 'quotation_platform',
            'value' => 'Squarespace',
            'slug' => 'quotation_platform_squarespace',
            'order' => 6,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'quotation_platform_walmart'], [
            'type' => 'quotation_platform',
            'value' => 'Walmart',
            'slug' => 'quotation_platform_walmart',
            'order' => 7,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'quotation_platform_wix'], [
            'type' => 'quotation_platform',
            'value' => 'Wix',
            'slug' => 'quotation_platform_wix',
            'order' => 8,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'quotation_platform_woocommerce'], [
            'type' => 'quotation_platform',
            'value' => 'Woocommerce',
            'slug' => 'quotation_platform_woocommerce',
            'order' => 9,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'quotation_platform_none/other'], [
            'type' => 'quotation_platform',
            'value' => 'None/Other',
            'slug' => 'quotation_platform_none/other',
            'order' => 10,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'monthly_quantity_request_1-200'], [
            'type' => 'monthly_quantity_request',
            'value' => '1-99',
            'slug' => 'monthly_quantity_request_1-200',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'monthly_quantity_request_201-400'], [
            'type' => 'monthly_quantity_request',
            'value' => '100-199',
            'slug' => 'monthly_quantity_request_201-400',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'monthly_quantity_request_401-1000'], [
            'type' => 'monthly_quantity_request',
            'value' => '200-299',
            'slug' => 'monthly_quantity_request_401-1000',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'monthly_quantity_request_1001-3000'], [
            'type' => 'monthly_quantity_request',
            'value' => '300-399',
            'slug' => 'monthly_quantity_request_1001-3000',
            'order' => 4,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'monthly_quantity_request_3001-5000'], [
            'type' => 'monthly_quantity_request',
            'value' => '400-499',
            'slug' => 'monthly_quantity_request_3001-5000',
            'order' => 5,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'monthly_quantity_request_3001-5000'], [
            'type' => 'monthly_quantity_request',
            'value' => '500-599',
            'slug' => 'monthly_quantity_request_3001-5000',
            'order' => 6,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'monthly_quantity_request_3001-5000'], [
            'type' => 'monthly_quantity_request',
            'value' => '600-699',
            'slug' => 'monthly_quantity_request_3001-5000',
            'order' => 7,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'employee_department_finance'], [
            'type' => 'employee_department',
            'value' => 'Finance',
            'slug' => 'employee_department_finance',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'item_type_aditional_cost'], [
            'type' => 'item_type',
            'value' => 'Aditional Cost',
            'slug' => 'item_type_aditional_cost',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'item_type_product'], [
            'type' => 'item_type',
            'value' => 'Product',
            'slug' => 'item_type_product',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'in_progress'], [
            'type' => 'payroll_status',
            'value' => 'In Progress',
            'slug' => 'in_progress',
            'order' => 1
        ,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'complete'], [
            'type' => 'payroll_status',
            'value' => 'Complete',
            'slug' => 'complete',
            'order' => 2
        ,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'deleted'], [
            'type' => 'payroll_status',
            'value' => 'Deleted',
            'slug' => 'deleted',
            'order' => 3
        ,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'paid_'], [
            'type' => 'Salary_status',
            'value' => 'Paid',
            'slug' => 'paid',
            'order' => 1
        ,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'un_paid' ], [
            'type' => 'Salary_status',
            'value' => 'Unpaid',
            'slug' => 'un_paid',
            'order' => 2
        ,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'partially_paid' ], [
            'type' => 'Salary_status',
            'value' => 'Partially Paid',
            'slug' => 'partially_paid',
            'order' => 3
        ,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'advance'], [
            'type' => 'reason',
            'value' => 'Advance',
            'slug' => 'advance',
            'order' => 1
        ,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'bonus' ], [
            'type' => 'reason',
            'value' => 'Bonus',
            'slug' => 'bonus',
            'order' => 2
        ,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'bonus' ], [
            'type' => 'reason',
            'value' => 'Bonus',
            'slug' => 'bonus',
            'order' => 3
        ,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'other_reason' ], [
            'type' => 'reason',
            'value' => 'Others',
            'slug' => 'other_reason',
            'order' => 4
        ,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'bank_address' ], [
            'type' => 'bank_address',
            'value' => 'Bank Al Habib Ltd, Sector Y, Phase 3, DHA
            Lahore, 54000, Pakistan',
            'slug' => 'bank_address',
            'order' => 1
        ,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

    }
}
