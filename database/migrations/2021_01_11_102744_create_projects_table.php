<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_id')->nullable();
            $table->string('title')->nullable();
            $table->string('client_name')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('image')->nullable();
            $table->date('deadline')->nullable();
            $table->enum('status', ['Opened', 'Pre Production', 'In Production', 'Queued for Testing', 'On Test', 'Tested', 'Supervised', 'Documented', 'Completed', 'Delivered', 'Deployed', 'Under Maintenance', 'In Revision'] );
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
        Schema::dropIfExists('projects');
    }
}
