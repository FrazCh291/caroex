<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamePPRateColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deals_products_rates', function (Blueprint $table) {
            $table->renameColumn('p_p_rate', 'standard_postage');
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
            $table->renameColumn('standard_postage', 'p_p_rate');
        });
    }
}
