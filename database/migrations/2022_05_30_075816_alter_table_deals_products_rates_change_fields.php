<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableDealsProductsRatesChangeFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deals_products_rates', function (Blueprint $table) {
            if (Config::get('database')['default'] === 'mysql'){
                $table->decimal('deal_price', 9, 2)->change();
                $table->integer('deal_cap')->change();
                $table->decimal('vat', 9, 2)->change();
                $table->decimal('exclusive_text_amount', 9, 2)->change();
                $table->decimal('standard_postage', 9, 2)->change();
                $table->decimal('highlands_postage', 9, 2)->change();
                $table->decimal('p_p_vat', 9, 2)->change();
                $table->decimal('vat_amount', 9, 2)->change();
                $table->decimal('plateform_fee', 9, 2)->change();
                $table->decimal('commission_amount', 9, 2)->change();
                $table->decimal('vat_deduct_commission', 9, 2)->change();
                $table->decimal('total_net_vat', 9, 2)->change();
                $table->decimal('total_receivable', 9, 2)->change();
                $table->decimal('market_fee_percentage_rate', 9, 2)->change();
                $table->decimal('standard_incremental_unit_fee', 9, 2)->change();
            } else if (Config::get('database')['default'] === 'pgsql') {
                DB::statement('ALTER TABLE deals_products_rates ALTER COLUMN
                  deal_cap TYPE integer USING (trim(deal_cap))::integer');
                DB::statement('ALTER TABLE deals_products_rates ALTER COLUMN
                  deal_price TYPE integer USING (trim(deal_price))::decimal');
                DB::statement('ALTER TABLE deals_products_rates ALTER COLUMN
                  vat TYPE integer USING (trim(vat))::decimal');
                DB::statement('ALTER TABLE deals_products_rates ALTER COLUMN
                  exclusive_text_amount TYPE integer USING (trim(exclusive_text_amount))::decimal');
                DB::statement('ALTER TABLE deals_products_rates ALTER COLUMN
                  standard_postage TYPE integer USING (trim(standard_postage))::decimal');
                DB::statement('ALTER TABLE deals_products_rates ALTER COLUMN
                  highlands_postage TYPE integer USING (trim(highlands_postage))::decimal');
                DB::statement('ALTER TABLE deals_products_rates ALTER COLUMN
                  p_p_vat TYPE integer USING (trim(p_p_vat))::decimal');
                DB::statement('ALTER TABLE deals_products_rates ALTER COLUMN
                  vat_amount TYPE integer USING (trim(vat_amount))::decimal');
                DB::statement('ALTER TABLE deals_products_rates ALTER COLUMN
                  plateform_fee TYPE integer USING (trim(plateform_fee))::decimal');
                DB::statement('ALTER TABLE deals_products_rates ALTER COLUMN
                  commission_amount TYPE integer USING (trim(commission_amount))::decimal');
                DB::statement('ALTER TABLE deals_products_rates ALTER COLUMN
                  vat_deduct_commission TYPE integer USING (trim(vat_deduct_commission))::decimal');
                DB::statement('ALTER TABLE deals_products_rates ALTER COLUMN
                  total_net_vat TYPE integer USING (trim(total_net_vat))::decimal');
                DB::statement('ALTER TABLE deals_products_rates ALTER COLUMN
                  total_receivable TYPE integer USING (trim(total_receivable))::decimal');
                DB::statement('ALTER TABLE deals_products_rates ALTER COLUMN
                  market_fee_percentage_rate TYPE integer USING (trim(market_fee_percentage_rate))::decimal');
                DB::statement('ALTER TABLE deals_products_rates ALTER COLUMN
                  standard_incremental_unit_fee TYPE integer USING (trim(standard_incremental_unit_fee))::decimal');
            }
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
            $table->string('deal_price');
            $table->string('deal_cap');
            $table->string('vat');
            $table->string('exclusive_text_amount');
            $table->string('standard_postage');
            $table->string('highlands_postage');
            $table->string('p_p_vat');
            $table->string('vat_amount');
            $table->string('plateform_fee');
            $table->string('commission_amount');
            $table->string('vat_deduct_commission');
            $table->string('total_net_vat');
            $table->string('total_receivable');
            $table->string('market_fee_percentage_rate');
            $table->string('standard_incremental_unit_fee');
        });
    }
}
