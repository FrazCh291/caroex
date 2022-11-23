<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade');
            $table->unsignedInteger('supplier_id')->nullable();
            $table->unsignedInteger('customer_id')->nullable();
            $table->unsignedInteger('ship_from_address_id')->nullable();
            $table->unsignedInteger('ship_to_address_id')->nullable();
            $table->morphs('invoiceable');
            $table->string('invoice_number')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('purchase_filling_ref')->nullable();
            $table->string('currency')->nullable();
            $table->float('tax')->nullable();
            $table->float('conversion_rate')->nullable();
            $table->float('balance')->nullable();
            $table->float('total')->nullable();
            $table->float('sub_total')->nullable();
            $table->float('vat')->nullable();
            $table->float('discount_total')->nullable();
            $table->float('shipping_cost')->nullable();
            $table->float('amount')->nullable();
            $table->float('amount_paid')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('status')->nullable();
            $table->string('notes')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->date('invoice_date')->nullable();
            $table->boolean('is_sent')->default(0);
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
        Schema::dropIfExists('invoices');
    }
}
