y<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('shipping_method')->nullable();
            $table->string('sku')->nullable();
            $table->string('color')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->boolean('stock')->nullable();
            $table->text('xstreamgym_name')->nullable();
            $table->text('gogropie_name')->nullable();
            $table->text('wowchers_name')->nullable();
            $table->text('groupon_name')->nullable();
            $table->text('description')->nullable();
            $table->string('categories')->nullable();
            $table->string('upc')->nullable();
            $table->string('ean')->nullable();
            $table->string('jan')->nullable();
            $table->string('isbn')->nullable();
            $table->string('mpn')->nullable();
            $table->string('location')->nullable();
            $table->string('model')->nullable();
            $table->unsignedInteger('supplier_id')->nullable();
            $table->string('date_available')->default(\Carbon\Carbon::now()->format('Y-m-d'));
            $table->double('weight')->nullable();
            $table->string('weight_unit')->nullable();
            $table->double('length')->nullable();
            $table->double('width')->nullable();
            $table->double('height')->nullable();
            $table->string('length_unit')->nullable();
            $table->string('status')->default('enabled');
            $table->string('seo_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('tags')->nullable();
            $table->string('subtract')->nullable();
            $table->integer('minimum')->nullable();
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
        Schema::dropIfExists('products');
    }
}
