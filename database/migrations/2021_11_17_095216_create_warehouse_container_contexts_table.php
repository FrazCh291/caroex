<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseContainerContextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_container_contexts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('warehouse_container_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('product_id');
            $table->string('bill_of_lading_no');
            $table->integer('quantity');
            $table->integer('ctn')->default(0);
            $table->decimal('unit_price',10,2)->default(0);
            $table->decimal('total_amount',10,2)->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_container_contexts');
    }
}
