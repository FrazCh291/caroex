<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_id');
            $table->bigInteger('company_id');
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->text('cnic')->nullable();
            $table->string('department')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_status')->default(0);
            $table->string('image_cnic')->nullable();
            $table->string('gender')->nullable();
            $table->text('linkedin_account')->nullable();
            $table->text('fb_account')->nullable();
            $table->text('github_account')->nullable();
            $table->text('image_cnic_1')->nullable();
            $table->text('designation')->nullable();
            $table->decimal('total_salary',15,2)->nullable();
            $table->integer('total_working_days')->nullable();
            $table->date('starting_date')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
