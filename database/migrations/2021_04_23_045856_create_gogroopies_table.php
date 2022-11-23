<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGogroopiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gogroopies', function (Blueprint $table) {

            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('import_id')->nullable();
            $table->bigInteger('deal_id')->nullable();
            $table->string('product')->nullable();
            $table->string('voucher_code')->nullable();
            $table->string('full_name')->nullable();
            $table->string('email')->nullable();
            $table->string('house')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('postcode')->nullable();
            $table->string('redeem_date')->nullable();
            $table->string('deal_option')->nullable();
            $table->string('phone')->nullable();
            $table->string('price_option')->nullable();
            $table->string('sku')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('import_id')->references('id')->on('imports')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gogroopies');
    }
}
