<?php

namespace Database\Seeders;

use App\Models\Lookup;
use Illuminate\Database\Seeder;

class LookupStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lookup::firstOrCreate(['type' => 'order_status', 'slug' => 'pending'], [
            'type' => 'order_status',
            'value' => 'Pending',
            'slug' => 'pending',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['type' => 'order_status', 'slug' => 'shipped'], [
            'type' => 'order_status',
            'value' => 'Shipped',
            'slug' => 'shipped',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['type' => 'order_status', 'slug' => 'processing'], [
            'type' => 'order_status',
            'value' => 'Processing',
            'slug' => 'processing',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['type' => 'order_status', 'slug' => 'replacement'], [
            'type' => 'order_status',
            'value' => 'Replacement',
            'slug' => 'replacement',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['type' => 'order_status', 'slug' => 'redispatch'], [
            'type' => 'order_status',
            'value' => 'Redispatch',
            'slug' => 'redispatch',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['type' => 'order_status', 'slug' => 'collection'], [
            'type' => 'order_status',
            'value' => 'Collection',
            'slug' => 'collection',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['type' => 'order_status', 'slug' => 'completed'], [
            'type' => 'order_status',
            'value' => 'Completed',
            'slug' => 'completed',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'order_status', 'slug' => 'cancelled'], [
            'type' => 'order_status',
            'value' => 'Cancelled',
            'slug' => 'cancelled',
            'order' => 4,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'payment_status', 'slug' => 'pending'], [
            'type' => 'payment_status',
            'value' => '10',
            'slug' => 'pending',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'payment_status', 'slug' => 'authorized '], [
            'type' => 'payment_status',
            'value' => '20',
            'slug' => 'authorized',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'payment_status', 'slug' => 'paid'], [
            'type' => 'payment_status',
            'value' => '30',
            'slug' => 'paid',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'payment_status', 'slug' => 'partially_refunded'], [
            'type' => 'payment_status',
            'value' => '35',
            'slug' => 'partially_refunded',
            'order' => 4,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'payment_status', 'slug' => 'refunded'], [
            'type' => 'payment_status',
            'value' => '40',
            'slug' => 'refunded',
            'order' => 5,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'payment_status', 'slug' => 'voided'], [
            'type' => 'payment_status',
            'value' => '50',
            'slug' => 'voided',
            'order' => 6,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'shipping_status', 'slug' => 'shipping_not_required'], [
            'type' => 'shipping_status',
            'value' => '10',
            'slug' => 'shipping_not_required',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'shipping_status', 'slug' => 'not_yet_shipped'], [
            'type' => 'shipping_status',
            'value' => '20',
            'slug' => 'not_yet_shipped',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'shipping_status', 'slug' => 'partially_shipped'], [
            'type' => 'shipping_status',
            'value' => '25',
            'slug' => 'partially_shipped',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'shipping_status', 'slug' => 'shipped'], [
            'type' => 'shipping_status',
            'value' => '30',
            'slug' => 'shipped',
            'order' => 4,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'shipping_status', 'slug' => 'delivered'], [
            'type' => 'shipping_status',
            'value' => '40',
            'slug' => 'delivered',
            'order' => 5,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['type' => 'return_request_status', 'slug' => '60'], [
            'type' => 'return_request_status',
            'value' => 'Cancelled',
            'slug' => '60',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'return_request_status', 'slug' => '40'], [
            'type' => 'return_request_status',
            'value' => 'Item(s) refunded',
            'slug' => '40',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'return_request_status', 'slug' => '30'], [
            'type' => 'return_request_status',
            'value' => 'Item(s) repaired',
            'slug' => '30',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['type' => 'return_request_status', 'slug' => '0'], [
            'type' => 'return_request_status',
            'value' => 'Pending',
            'slug' => '0',
            'order' => 4,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['type' => 'return_request_status', 'slug' => '10'], [
            'type' => 'return_request_status',
            'value' => 'Received',
            'slug' => 'Received',
            'order' => 5,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['type' => 'return_request_status', 'slug' => '20'], [
            'type' => 'return_request_status',
            'value' => 'Return authorized',
            'slug' => '20',
            'order' => 6,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'return_request_status', 'slug' => '50'], [
            'type' => 'return_request_status',
            'value' => 'Request rejected',
            'slug' => '50',
            'order' => 7,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'queued_order_status', 'slug' => 'Pending'], [
            'type' => 'queued_order_status',
            'value' => 'Pending',
            'slug' => 'Pending',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'return_approval', 'slug' => 'approved'], [
            'type' => 'return_approval',
            'value' => 'Approved',
            'slug' => 'approved',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'return_approval', 'slug' => 'rejected'], [
            'type' => 'return_approval',
            'value' => 'Rejected',
            'slug' => 'rejected',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'return_approval', 'slug' => 'further_investigate'], [
            'type' => 'return_approval',
            'value' => 'Further investigate',
            'slug' => 'further_investigate',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'product_conditions', 'slug' => 'acceptable'], [
            'type' => 'product_conditions',
            'value' => 'Acceptable',
            'slug' => 'acceptable',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'product_conditions', 'slug' => 'brand_new'], [
            'type' => 'product_conditions',
            'value' => 'Brand new',
            'slug' => 'brand_new',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'product_type', 'slug' => 'product'], [
            'type' => 'product_type',
            'value' => 'Product',
            'slug' => 'product',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'product_type', 'slug' => 'spare_part'], [
            'type' => 'product_type',
            'value' => 'Spare Part',
            'slug' => 'spare_part',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'product_conditions', 'slug' => 'unacceptable'], [
            'type' => 'product_conditions',
            'value' => 'Unacceptable',
            'slug' => 'unacceptable',
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

        Lookup::firstOrCreate(['slug' => 'Replacement'], [
            'type' => 'requested_action',
            'value' => 'Replacement',
            'slug' => 'replacement',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);



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
            'value' => 'Authorizes return',
            'slug' => 'return_status_authorizes',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);


        Lookup::firstOrCreate(['type' => 'invoice_status',  'slug' => 'un_paid',], [
            'type' => 'invoice_status',
            'value' => 'Un Paid',
            'slug' => 'un_paid',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['type' => 'invoice_status', 'slug' => 'paid',], [
            'type' => 'invoice_status',
            'value' => 'Paid',
            'slug' => 'paid',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
