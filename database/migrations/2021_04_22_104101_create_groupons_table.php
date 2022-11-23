<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('import_id')->nullable();
            $table->bigInteger('fulfillment_line_item_id')->nullable();
            $table->string('groupon_number')->nullable();
            $table->string('order_date')->nullable();
            $table->string('merchant_sku_item')->nullable();
            $table->string('quantity_requested')->nullable();
            $table->string('shipment_method_requested')->nullable();
            $table->string('shipment_address_name')->nullable();
            $table->string('shipment_address_street')->nullable();
            $table->string('shipment_address_street_2')->nullable();
            $table->string('shipment_address_city')->nullable();
            $table->string('shipment_address_stat')->nullable();
            $table->string('shipment_address_postal_code')->nullable();
            $table->string('shipment_address_country')->nullable();
            $table->string('gift')->nullable();
            $table->string('gift_message')->nullable();
            $table->string('quantity_shipped')->nullable();
            $table->string('shipment_carrier')->nullable();
            $table->string('shipment_method')->nullable();
            $table->string('shipment_tracking_number')->nullable();
            $table->string('ship_date')->nullable();
            $table->string('groupon_sku')->nullable();
            $table->string('custom_field_value')->nullable();
            $table->string('permalink')->nullable();
            $table->string('vendor_id')->nullable();
            $table->string('salesforce_deal_option_id')->nullable();
            $table->string('groupon_cost')->nullable();
            $table->string('billing_address_name')->nullable();
            $table->string('billing_address_street')->nullable();
            $table->string('billing_address_city')->nullable();
            $table->string('billing_address_stat')->nullable();
            $table->string('billing_address_postal_code')->nullable();
            $table->string('billing_address_country')->nullable();
            $table->string('purchase_order_number')->nullable();
            $table->string('product_weight')->nullable();
            $table->string('product_weight_unit')->nullable();
            $table->string('product_length')->nullable();
            $table->string('product_height')->nullable();
            $table->string('item_name')->nullable();
            $table->string('product_dimension_unit')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('incoterms')->nullable();
            $table->string('hts_code')->nullable();
            $table->string('pl_name')->nullable();
            $table->string('pl_warehouse_location')->nullable();
            $table->string('kitting_details')->nullable();
            $table->string('sell_price')->nullable();
            $table->string('deal_opportunity_id')->nullable();
            $table->string('shipment_strategy')->nullable();
            $table->string('fulfillment_method')->nullable();
            $table->string('country_of_origin')->nullable();
            $table->string('merchant_permalink')->nullable();
            $table->string('feature_start_date')->nullable();
            $table->string('feature_end_date')->nullable();
            $table->string('bom_sku')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groupons');
    }
}
