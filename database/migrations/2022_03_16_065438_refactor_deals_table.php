<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->dropForeign('deals_product_id_foreign');
            $table->dropColumn('product_id');
            $table->dropColumn('deal_cap');
            $table->dropColumn('unit_price');
            $table->dropColumn('vat');
            $table->dropColumn('exclusive_text_amount');
            $table->dropColumn('p_p_rate');
            $table->dropColumn('deal_price');
            $table->dropColumn('p_p_vat');
            $table->dropColumn('vat_amount');
            $table->dropColumn('commission_percentage');
            $table->dropColumn('commission_amount');
            $table->dropColumn('vat_deduct_commission');
            $table->dropColumn('total_net_vat');
            $table->dropColumn('total_receivable');
            $table->dropColumn('item_quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->string('deal_cap');
            $table->string('unit_price');
            $table->string('vat');
            $table->string('exclusive_text_amount');
            $table->string('p_p_rate');
            $table->string('deal_price');
            $table->string('p_p_vat');
            $table->string('vat_amount');
            $table->string('commission_percentage');
            $table->string('commission_amount');
            $table->string('vat_deduct_commission');
            $table->string('total_net_vat');
            $table->string('total_receivable');
            $table->string('item_quantity');
        });
    }
}
