<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->nullable();
            $table->bigInteger('case_id')->nullable();
            $table->bigInteger('new_product_id')->nullable();
            $table->bigInteger('order_id');
            $table->bigInteger('order_product_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('product_condition')->nullable();
            $table->string('request_type')->nullable();
            $table->date('date')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('approved_status')->nullable();
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
        Schema::dropIfExists('case_items');
    }
}
