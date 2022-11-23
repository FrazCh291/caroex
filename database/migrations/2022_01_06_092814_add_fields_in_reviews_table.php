<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable()->change();
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->unsignedBigInteger('order_id')->after('user_id')->nullable();
            $table->unsignedBigInteger('customer_id')->after('order_id')->nullable();
            $table->unsignedBigInteger('channel_id')->after('customer_id');
            $table->string('name')->after('channel_id')->nullable();
            $table->string('email')->after('name')->nullable();
            $table->string('url')->after('comment')->nullable();
            $table->string('status')->after('url')->default('review_unapproved');
            $table->string('is_active')->after('status')->default(false);
            $table->timestamp('last_sent_at')->after('is_active')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('order_id');
            $table->dropColumn('customer_id');
            $table->dropColumn('channel_id');
            $table->dropColumn('name');
            $table->dropColumn('email');
            $table->dropColumn('url');
            $table->dropColumn('status');
            $table->dropColumn('is_active');
            $table->dropColumn('last_sent_at');
        });
    }
}
