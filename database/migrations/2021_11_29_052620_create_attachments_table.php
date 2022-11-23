<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->text('attachment_id')->nullable();
            $table->unsignedBigInteger('email_id')->nullable();
            $table->string('name')->nullable();
            $table->string('content_id')->nullable();
            $table->string('content_type')->nullable();
            $table->boolean('is_inline')->default(0);
            $table->string('content_location')->nullable();
            $table->string('url')->nullable();
            $table->integer('size')->nullable();
            $table->timestamps();

//            $table->foreign('email_id')->references('id')->on('emails')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachments');
    }
}
