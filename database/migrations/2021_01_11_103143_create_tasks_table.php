<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->nullable();
            $table->tinyInteger('user_id')->nullable();
            $table->string('task_id')->nullable();
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->date('submission_date')->nullable();
            $table->time('submission_time', 0)->nullable();
            $table->enum('task_type', ['Task', 'Test'])->nullable();            
            $table->enum('priority', ['High', 'Medium', 'Low'])->nullable();            
            $table->enum('revision_type', ['Original', 'Revised'])->nullable();
            $table->enum('status', ['Assigned', 'In Process...', 'Submitted', 'Resubmitted', 'In Revision','Revision Needed','Re Assigned','Tested','Completed','Supervised','Accepted'])->nullable();
            $table->enum('testable', ['Yes', 'No'])->nullable();
            $table->tinyInteger('created_by')->nullable();      
            $table->tinyInteger('satisfaction_level')->nullable()->comment('Satisfaction Table Foreign Key');
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
        Schema::dropIfExists('tasks');
    }
}
