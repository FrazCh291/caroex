<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('discount_type_id')->nullable();
            $table->bigInteger('discount_limitation_id')->default(0);
            $table->string('name')->nullable();
            $table->float('discount_amount')->nullable();
            $table->string('discount_type')->nullable();
            $table->boolean('use_percentage')->default(0);
            $table->float('maximum_discount_amount')->nullable();
            $table->float('discount_percentage')->default(0.00);
            $table->string('requires_coupon_code')->default(0);
            $table->string('coupon_code')->nullable();
            $table->integer('limitation_times')->default(1);
            $table->string('maximum_discounted_quantity')->nullable();
            $table->boolean('is_cumulative')->default(0);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
