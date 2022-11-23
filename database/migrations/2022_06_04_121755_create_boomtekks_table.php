<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoomtekksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boomtekks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->foreignId('product_id')->nullable();
            $table->foreignId('import_id')->nullable();
            $table->integer('order_id')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('invoice_prefix')->nullable();
            $table->integer('store_id')->nullable();
            $table->string('store_name')->nullable();
            $table->string('store_url')->nullable();
            $table->integer('customer_id')->nullable();
            $table->string('customer_group')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('fax')->nullable();
            $table->string('payment_first_name')->nullable();
            $table->string('payment_last_name')->nullable();
            $table->string('payment_company')->nullable();
            $table->string('payment_address_1')->nullable();
            $table->string('payment_address_2')->nullable();
            $table->string('payment_city')->nullable();
            $table->string('payment_postcode')->nullable();
            $table->string('payment_country')->nullable();
            $table->integer('payment_country_id')->nullable();
            $table->string('payment_zone')->nullable();
            $table->integer('payment_zone_id')->nullable();
            $table->string('payment_address_format')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_code')->nullable();
            $table->string('shipping_first_name')->nullable();
            $table->string('shipping_last_name')->nullable();
            $table->string('shipping_company')->nullable();
            $table->string('shipping_address_1')->nullable();
            $table->string('shipping_address_2')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_postcode')->nullable();
            $table->string('shipping_country')->nullable();
            $table->integer('shipping_country_id')->nullable();
            $table->string('iso_code')->nullable();
            $table->string('shipping_zone')->nullable();
            $table->integer('shipping_zone_id')->nullable();
            $table->string('shipping_address_format')->nullable();
            $table->string('shipping_method')->nullable();
            $table->string('shipping_code')->nullable();
            $table->string('comment')->nullable();
            $table->double('total',9,2)->nullable();
            $table->integer('order_status_id')->nullable();
            $table->integer('affiliate_id')->nullable();
            $table->string('commission')->nullable();
            $table->integer('language_id')->nullable();
            $table->integer('currency_id')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('currency_value')->nullable();
            $table->string('ip')->nullable();
            $table->string('forwarded_ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('accept_language')->nullable();
            $table->string('item_name')->nullable();
            $table->dateTime('date_added')->nullable();
            $table->dateTime('date_modified')->nullable();
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
        Schema::dropIfExists('boomtekks');
    }
}
