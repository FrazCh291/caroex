<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreignId('invoice_id')->nullable();
            $table->unsignedBigInteger('payee_account_id')->nullable();
            $table->unsignedBigInteger('payer_account_id')->nullable();
            $table->unsignedBigInteger('payee_currency_id')->nullable();
            $table->unsignedBigInteger('payer_currency_id')->nullable();
            $table->unsignedBigInteger('payment_method')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('description')->nullable();
            $table->string('type')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_no')->nullable();
            $table->float('conversion_rate_rmb')->nullable();
            $table->float('conversion_rate_usd')->nullable();
            $table->string('payment_reference')->nullable();
            $table->double('total_usd')->nullable();
            $table->double('total_rmb')->nullable();
            $table->double('total_gbp')->nullable();
            $table->double('amount')->nullable();
            $table->double('payee_total')->nullable();
            $table->date('payment_date')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('company_payments');
    }
}
