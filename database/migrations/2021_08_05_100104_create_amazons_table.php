<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('import_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('order_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('postal_address_1')->nullable();
            $table->string('postal_address_2')->nullable();
            $table->string('postal_address_3')->nullable();
            $table->string('postal_address_4')->nullable();
            $table->string('ship_city')->nullable();
            $table->string('ship_country')->nullable();
            $table->string('ship_state')->nullable();
            $table->string('post_code')->nullable();
            $table->longText('item_name')->nullable();
            $table->string('asin')->nullable();
            $table->string('order_item_id')->nullable();
            $table->string('sku')->nullable();
            $table->integer('quantity')->nullable();
            $table->dateTime('order_date')->nullable();
            $table->dateTime('dispatch_date')->nullable();
            $table->longText('reason_for_late_dispatch')->nullable();
            $table->string('freight_company')->nullable();
            $table->string('tracking_number')->nullable();
            $table->longText('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('import_id')->references('id')->on('imports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amazons');
    }
}
