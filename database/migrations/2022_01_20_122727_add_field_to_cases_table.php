<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->string('case_number')->after('order_id')->nullable();
            $table->string('source')->after('case_number')->nullable();
            $table->string('source_other')->after('source')->nullable();
            $table->string('type_other')->after('type')->nullable();
            $table->string('status')->after('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->dropColumn('case_number');
            $table->dropColumn('source');
            $table->dropColumn('source_other');
            $table->dropColumn('type_other');
            $table->dropColumn('status');
        });
    }
}
