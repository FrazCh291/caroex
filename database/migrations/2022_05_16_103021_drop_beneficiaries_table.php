<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropBeneficiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('beneficiaries');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('bank_name');
            $table->string('swift');
            $table->string('beneficiary_name');
            $table->text('beneficiary_account_number');
            $table->text('address1')->nullable();
            $table->text('address2')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
}
