<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->nullable();
            $table->bigInteger('channel_id')->nullable();
            $table->string('smtp_outgoing_server')->nullable();
            $table->string("smtp_outgoing_port")->nullable();
            $table->string("smtp_outgoing_encryption")->nullable();
            $table->string("incoming_server")->nullable();
            $table->string("incoming_port")->nullable();
            $table->string("incoming_encryption")->nullable();
            $table->string("protocol")->nullable();
            $table->string('username')->nullable();
            $table->longText('password')->nullable();
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('email_settings');
    }
}
