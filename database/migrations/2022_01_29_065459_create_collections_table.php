<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->nullable();
            $table->bigInteger('company_id')->nullable();
            $table->string('request_type')->nullable();
            $table->unsignedBigInteger('case_id')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('return_status')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->date('return_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->string('replacement_status')->nullable();
            $table->text('staff_note')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('case_id')->references('id')->on('cases');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collections');
    }
}
