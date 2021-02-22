<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyEmployeeActivityDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_employee_activity_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_activity_id')->nullable();
            $table->time('action_time')->nullable();
            $table->enum('status', ['DESK_OPEN', 'DESK_CLOSE', 'ON_DESK', 'OFF_DESK'])->nullable();
            $table->text('note')->nullable();
            $table->text('user_agent')->nullable();
            $table->ipAddress('user_ip')->nullable();
            $table->bigInteger('created_by')->nullable();
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
        Schema::dropIfExists('daily_employee_activity_details');
    }
}
