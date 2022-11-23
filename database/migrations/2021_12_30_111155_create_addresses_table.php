<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->morphs('addressable');
            $table->text('address_1');
            $table->text('address_2')->nullable();
            $table->text('town')->nullable();
            $table->text('city')->nullable();
            $table->text('county')->nullable();
            $table->string('postcode')->nullable();
            $table->text('country')->nullable();
            $table->string('vat')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_billing')->default(false);
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(false);
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
        Schema::dropIfExists('addresses');
    }
}
