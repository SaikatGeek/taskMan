<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReAssignTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('re_assign_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('orginal_id')->nullable();
            $table->string('last_id')->nullable();
            $table->string('revised_id')->nullable();
            $table->tinyInteger('created_by')->nullable();       
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
        Schema::dropIfExists('re_assign_tasks');
    }
}
