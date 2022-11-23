<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeDealsProductsRatesFieldsNullableOnDealsProductsRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deals_products_rates', function (Blueprint $table) {
            $table->string('deal_cap')->nullable()->change();
            $table->string('market_fee_percentage_rate')->nullable()->change();
            $table->string('standard_incremental_unit_fee')->nullable()->change();
            $table->string('highlands_postage')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deals_products_rates', function (Blueprint $table) {
            //
        });
    }
}
