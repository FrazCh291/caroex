<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterInBaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bays', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('code')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bays', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('code')->after('name');
        });
    }
}
