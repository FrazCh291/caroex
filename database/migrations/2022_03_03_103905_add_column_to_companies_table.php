<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
             $table->boolean("is_erp")->default(false)->after("type");
            $table->boolean("is_fulfilment")->default(false)->after("is_erp");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
             $table->dropColumn('is_erp');
            $table->dropColumn('is_fulfilment');
        });
    }
}
