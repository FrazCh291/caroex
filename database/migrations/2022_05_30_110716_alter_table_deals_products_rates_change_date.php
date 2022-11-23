<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableDealsProductsRatesChangeDate extends Migration
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
                $table->date('start_date')->change();
                $table->date('end_date')->change();
            } else if (Config::get('database')['default'] === 'pgsql'){
                DB::statement('ALTER TABLE deals_products_rates ALTER COLUMN
                  start_date TYPE date USING (trim(start_date))::date');
                DB::statement('ALTER TABLE deals_products_rates ALTER COLUMN
                  end_date TYPE date USING (trim(end_date))::date');
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
                $table->string('start_date');
                $table->string('end_date');
        });
    }
}
