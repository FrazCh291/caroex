<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealsProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deal_id')->constrained()->nullable();
            $table->unsignedBigInteger('product_id')->constrained();
            $table->string('deal_number')->nullable();
            $table->string('product_title')->nullable();
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
        Schema::dropIfExists('deals_products');
    }
}
