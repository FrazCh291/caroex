<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterIsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->boolean('is_admin')->change()->default(false)->after('two_factor_recovery_codes');
            $table->boolean('is_super')->change()->default(false)->after('is_admin');
            $table->boolean('is_billing')->change()->default(false)->after('is_super');
            $table->boolean('is_owner')->change()->default(false)->after('is_billing');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
//            $table->dropColumn('is_admin');
//            $table->dropColumn('is_super');
//            $table->dropColumn('is_billing');
//            $table->dropColumn('is_owner');
        });
    }
}
