<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnsMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returns_media', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->nullable();
            $table->unsignedBigInteger('return_id');
            $table->string('parcel_side_1')->nullable();
            $table->string('parcel_side_2')->nullable();
            $table->string('exchange_form')->nullable();
            $table->string('p1_image')->nullable();
            $table->string('p2_image')->nullable();
            $table->string('p3_image')->nullable();
            $table->string('p4_image')->nullable();
            $table->string('p5_image')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('return_id')->references('id')->on('returns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('returns_media');
    }
}
