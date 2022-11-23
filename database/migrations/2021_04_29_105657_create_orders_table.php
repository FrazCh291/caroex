<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('import_id')->nullable();
            $table->unsignedBigInteger('channel_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('vendor_id')->nullable();
            $table->string('saleforce_deal_option_id')->nullable();
            $table->bigInteger('deal_id')->nullable();
            $table->string('order_number')->nullable();
            $table->string('order_date')->nullable();
            $table->string('shipping_customer_name')->nullable();
            $table->string('shipping_email')->nullable();
            $table->string('shipping_address_1')->nullable();
            $table->string('shipping_address_2')->nullable();
            $table->string('shipping_address_town')->nullable();
            $table->string('shipping_address_county')->nullable();
            $table->string('shipping_address_city')->nullable();
            $table->string('shipping_address_postcode')->nullable();
            $table->string('shipping_country')->nullable();
            $table->string('shipping_address_phone')->nullable();
            $table->string('product_option')->nullable();
            $table->string('short_name')->nullable();
            $table->text('description')->nullable();
            $table->longText('product_name')->nullable();
            $table->string('sku')->nullable();
            $table->string('birthday')->nullable();
            $table->string('marketing_permalink')->nullable();
            $table->string('dispatch_method')->nullable();
            $table->string('order_status')->nullable();
            $table->text('customer_note')->nullable();
            $table->string('billing_customer_name')->nullable();
            $table->string('billing_company')->nullable();
            $table->string('house_number')->nullable();
            $table->text('billing_address_1_2')->nullable();
            $table->text('billing_address_1')->nullable();
            $table->text('billing_address_2')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_postcode')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('marketing_permission')->nullable();

            $table->string('payment_method_type')->nullable();
            $table->decimal('cart_discount_amount', 10, 2)->nullable();
            $table->decimal('order_subtotal_amount', 10, 2)->nullable();
            $table->decimal('order_shipping_amount', 10, 2)->nullable();
            $table->decimal('order_refund_amount', 10, 2)->nullable();
            $table->decimal('order_total_amount', 10, 2)->nullable();
            $table->decimal('order_total_tax_amount', 10, 2)->nullable();
            $table->string('purchase_order_number')->nullable();
            $table->string('item')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_price')->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('discount_amount_tax', 10, 2)->nullable();
            $table->string('merchant_sku_item')->nullable();
            $table->boolean('gift')->nullable();
            $table->string('gift_message')->nullable();
            $table->string('coupon_code')->nullable();
            $table->integer('quantity_request')->nullable();
            $table->string('shipment_carrier')->nullable();
            $table->string('shipment_tracking_number')->nullable();
            $table->string('ship_date')->nullable();
            $table->string('groupon_sku')->nullable();
            $table->string('permalink')->nullable();
            $table->decimal('item_cost', 10, 2)->nullable();
            $table->string('type_of_package_1')->nullable();
            $table->string('type_of_package_2')->nullable();
            $table->string('no_of_packages_1')->nullable();
            $table->string('no_of_packages_2')->nullable();
            $table->string('product_weight')->nullable();
            $table->string('product_width')->nullable();
            $table->string('product_weight_unit')->nullable();
            $table->string('product_length')->nullable();
            $table->string('product_height')->nullable();
            $table->string('product_dimension_unit')->nullable();
            $table->string('incoterms')->nullable();
            $table->string('hts_code')->nullable();
            $table->string('pl_name')->nullable();
            $table->string('pl_warehouse_location')->nullable();
            $table->string('kettting_details')->nullable();
            $table->string('deal_opportunity_id')->nullable();
            $table->string('shipping_strategy')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
