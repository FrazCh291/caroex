<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTwoFieldsInDeliveryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_items', function (Blueprint $table) {
            $table->string('delivery_type')->after('delivery_method')->nullable();
            $table->boolean('is_collected')->after('delivery_type')->default(0);
            $table->string('collection_failed_reason')->after('is_collected')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_items', function (Blueprint $table) {
            $table->dropColumn('delivery_type');
            $table->dropColumn('is_collected');
            $table->dropColumn('collection_failed_reason');
        });
    }
}
