<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFielsDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->string('deal_title')->nullable()->after('deal_number');
            $table->string('account_manager')->nullable()->after('deal_title');
            $table->string('category')->nullable()->after('account_manager');
            $table->string('subcategory')->nullable()->after('category');
            $table->string('start_date')->nullable()->after('subcategory');
            $table->string('gross_revenue')->nullable()->after('start_date');
            $table->string('redeemed_units')->nullable()->after('gross_revenue');
            $table->string('refunded_units')->nullable()->after('redeemed_units');
            $table->string('refund_rate')->nullable()->after('refunded_units');
            $table->string('auv')->nullable()->after('refund_rate');
            $table->string('signed_by_supplier_name')->nullable()->after('auv');
            $table->string('signed_by_customer_name')->nullable()->after('signed_by_supplier_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->dropColumn('deal_title');
            $table->dropColumn('account_manager');
            $table->dropColumn('category');
            $table->dropColumn('subcategory');
            $table->dropColumn('start_date');
            $table->dropColumn('gross_revenue');
            $table->dropColumn('redeemed_units');
            $table->dropColumn('refunded_units');
            $table->dropColumn('refund_rate');
            $table->dropColumn('auv');
            $table->dropColumn('signed_by_supplier_name');
            $table->dropColumn('signed_by_customer_name');
        });
    }
}
