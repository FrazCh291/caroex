<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropShippmentItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('shippment_items');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('shippment_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->bigInteger('freight_forwarder_id');
            $table->bigInteger('shippment_id');
            $table->text('item_name');
            $table->integer('carton');
            $table->integer('qty_ctn');
            $table->integer('total_qty');
            $table->decimal('unit_price', 10,2);
            $table->softDeletes();
            $table->timestamps();
        });
    }
}
