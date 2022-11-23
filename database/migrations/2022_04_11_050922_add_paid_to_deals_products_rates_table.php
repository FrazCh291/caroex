<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidToDealsProductsRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deals_products_rates', function (Blueprint $table) {
            $table->string('highlands_postage')->after('standard_postage');
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
            $table->dropColumn('highlands_postage');
        });
    }
}
