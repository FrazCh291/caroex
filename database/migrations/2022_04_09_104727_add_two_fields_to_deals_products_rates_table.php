<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTwoFieldsToDealsProductsRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deals_products_rates', function (Blueprint $table) {
            $table->integer('market_fee_percentage_rate')->after('total_receivable')->nullable();
            $table->float('standard_incremental_unit_fee', 10, 2)->after('market_fee_percentage_rate')->nullable();
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
            $table->dropColumn('market_fee_percentage_rate');
            $table->dropColumn('standard_incremental_unit_fee');
        });
    }
}
