<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXstreamgymsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xstreamgyms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('import_id')->nullable();
            $table->string('order_number')->nullable();
            $table->string('order_status')->nullable();
            $table->timestamp('order_date')->nullable();
            $table->text('customer_note')->nullable();
            $table->text('billing_first_name')->nullable();
            $table->string('billing_last_name')->nullable();
            $table->string('billing_company')->nullable();
            $table->text('billing_address_1_2')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state_code')->nullable();
            $table->string('billing_postcode')->nullable();
            $table->string('billing_country_code')->nullable();
            $table->string('billing_email')->nullable();
            $table->string('billing_phone')->nullable();
            $table->string('shipping_first_name')->nullable();
            $table->string('shipping_last_name')->nullable();
            $table->string('shipping_address_1_2')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state_code')->nullable();
            $table->string('shipping_postcode')->nullable();
            $table->string('shipping_country_code')->nullable();
            $table->string('payment_method_title')->nullable();
            $table->decimal('cart_discount_amount',10,2)->nullable();
            $table->decimal('order_subtotal_amount',10,2)->nullable();
            $table->string('shipping_method_title')->nullable();
            $table->decimal('order_shipping_amount',10,2)->nullable();
            $table->decimal('order_refund_amount',10,2)->nullable();
            $table->decimal('order_total_amount',10,2)->nullable();
            $table->decimal('order_total_tax_amount',10,2)->nullable();
            $table->string('sku')->nullable();
            $table->string('item')->nullable();
            $table->string('item_name')->nullable();
            $table->string('quantity')->nullable();
            $table->decimal('item_cost',10,2)->nullable();
            $table->string('coupon_code')->nullable();
            $table->decimal('discount_amount',10,2)->nullable();
            $table->decimal('discount_amount_tax',10,2)->nullable();
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
        Schema::dropIfExists('xstreamgyms');
    }
}
