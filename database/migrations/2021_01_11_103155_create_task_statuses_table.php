<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('task_id')->nullable();                       
            $table->text('note')->nullable();
            $table->enum('status', ['Assigned', 'In Process...', 'Submitted', 'Resubmitted', 'In Revision','Revision Needed','Re Assigned','Tested','Completed','Supervised','Accepted'])->nullable();
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
        Schema::dropIfExists('task_statuses');
    }
}
