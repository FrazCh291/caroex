<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChannelIdToCompanyPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_payments', function (Blueprint $table) {
            $table->bigInteger('channel_id')->nullable()->after('company_id');
            $table->string('payer_ammount')->nullable();
            $table->string('notes')->nullable()->after('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_payments', function (Blueprint $table) {
            $table->dropColumn('channel_id');
            $table->dropColumn('payer_ammount');
            $table->dropColumn('notes');
        });
    }
}
