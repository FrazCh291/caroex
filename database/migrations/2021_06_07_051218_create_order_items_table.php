<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->nullable();
            $table->string('product_id')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->text('product_name')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('item_cost')->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('discount_amount')->nullable();
            $table->string('discount_amount_tax')->nullable();
            $table->string('return_status')->nullable();
            $table->string('order_date')->nullable();
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
        Schema::dropIfExists('order_items');
    }
}
