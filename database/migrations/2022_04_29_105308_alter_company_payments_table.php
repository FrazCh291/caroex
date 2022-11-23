<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCompanyPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_payments', function (Blueprint $table) {
            $table->string('payer_currency_id')->change();
            $table->string('payee_currency_id')->change();
            $table->string('payment_method')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_payments', function (Blueprint $table) {
            //
        });
    }
}
