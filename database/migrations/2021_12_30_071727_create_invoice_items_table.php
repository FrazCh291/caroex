<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('invoice_id');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('item_name')->nullable();
            $table->integer('carton')->nullable();
            $table->integer('quantity');
            $table->string('currency')->nullable();
            $table->integer('total_quantity')->nullable();
            $table->float('unit_price');
            $table->float('total_price')->nullable();
            $table->float('total')->nullable();
            $table->float('vat')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
}
