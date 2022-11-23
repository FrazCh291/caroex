<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealsProductsRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals_products_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deal_product_id');
            $table->string('deal_number');
            $table->string('deal_cap');
            $table->string('deal_price');
            $table->string('vat');
            $table->string('exclusive_text_amount');
            $table->string('p_p_rate');
            $table->string('p_p_vat');
            $table->string('vat_amount');
            $table->string('plateform_fee');
            $table->string('commission_amount');
            $table->string('vat_deduct_commission');
            $table->string('total_net_vat');
            $table->string('total_receivable');
            $table->string('contract_signed_at')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->boolean('is_primary')->nullable();
            $table->boolean('is_active')->nullable();
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
        Schema::dropIfExists('deals_products_rates');
    }
}
