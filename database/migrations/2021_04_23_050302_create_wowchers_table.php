<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWowchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wowchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('import_id')->nullable();
            $table->bigInteger('deal_id')->nullable();
            $table->string('redeemed_at')->nullable();
            $table->string('wowcher_code')->nullable();
            $table->string('deal_title')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('house_number')->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('postcode')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('birthday')->nullable();
            $table->string('marketing_permission')->nullable();
            $table->string('product_name')->nullable();
            $table->string('product_options')->nullable();
            $table->string('sku')->nullable();
            $table->string('despatch_method')->nullable();
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
        Schema::dropIfExists('wowchers');
    }
}
