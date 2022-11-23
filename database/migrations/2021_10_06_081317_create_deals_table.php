<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('channel_name')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('deal_number')->nullable();
            $table->string('deal_type')->nullable();
            $table->string('deal_cap')->nullable();
            $table->string('unit_price')->nullable();
            $table->string('vat')->nullable();
            $table->string('exclusive_text_amount')->nullable();
            $table->string('p_p_rate')->nullable();
            $table->string('deal_price')->nullable();
            $table->string('p_p_vat')->nullable();
            $table->string('vat_amount')->nullable();
            $table->string('commission_percentage')->nullable();
            $table->string('commission_amount')->nullable();
            $table->string('vat_deduct_commission')->nullable();
            $table->string('total_net_vat')->nullable();
            $table->string('total_receivable')->nullable();
            $table->string('contract_signed_at')->nullable();
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
        Schema::dropIfExists('deals');
    }
}
