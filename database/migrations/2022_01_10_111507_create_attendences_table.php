<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->integer('employee_number')->nullable();
            $table->string('name')->nullable();
            $table->string('timetable')->nullable();
            $table->date('date')->nullable();
            $table->time('on_duty_at')->nullable();
            $table->time('off_duty_at')->nullable();
            $table->time('clock_in_at')->nullable();
            $table->time('clock_out_at')->nullable();
            $table->integer('late_minutes')->nullable();
            $table->integer('early_minutes')->nullable();
            $table->boolean('is_absent')->nullable();
            $table->integer('overtime_minutes')->nullable();
            $table->integer('work_time_minutes')->nullable();
            $table->boolean('is_check_in_required')->nullable();
            $table->boolean('is_check_out_required')->nullable();
            $table->string('department')->nullable();
            $table->decimal('normal_days', 10, 2)->nullable();
            $table->boolean('is_weekend')->nullable();
            $table->boolean('is_holiday')->nullable();
            $table->integer('attendance_minutes')->nullable();
            $table->decimal('normal_days_over_time', 10, 2)->nullable();
            $table->decimal('weekend_over_time', 10, 2)->nullable();
            $table->decimal('holiday_over_time', 10, 2)->nullable();
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
        Schema::dropIfExists('attendences');
    }
}
