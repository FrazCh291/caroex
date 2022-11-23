<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnValueInActivityLogsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('activity_logs_details', 'value'))
        {
            Schema::table('activity_logs_details', function (Blueprint $table)
            {
                $table->dropColumn('value');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasColumn('activity_logs_details', 'value'))
        {
            Schema::table('activity_logs_details', function (Blueprint $table) {
                $table->text('value')->after('details')->nullable(false);
            });
        }
    }
}
